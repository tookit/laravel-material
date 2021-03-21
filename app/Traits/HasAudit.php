<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


trait HasAudit
{
    /**
     * Boot the audit trait for a model.
     *
     * @return void
     */
    protected static function bootHasAudit()
    {
        static::creating(function (Model $model) {
            if (! $model->created_by) {
                $model->created_by = $this->getAuthenticatedUserId();
            }
            if (! $model->updated_by) {
                $model->updated_by = $this->getAuthenticatedUserId();
            }
        });

        static::updating(function (Model $model) {
            if (! $model->isDirty('updated_by')) {
                $model->updated_by = $this->getAuthenticatedUserId();
            }
        });
    }

    protected function getAuthenticatedUserId()
    {
        return auth()->check() ? auth()->id() : 0;
    }    

    /**
     * Get user model who created the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getCreatedByColumn());
    }

    /**
     * Get column name for created by.
     *
     * @return string
     */
    protected function getCreatedByColumn()
    {
        return 'created_by';
    }

    /**
     * Get user model who updated the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getUpdatedByColumn());
    }

    /**
     * Get column name for updated by.
     *
     * @return string
     */
    protected function getUpdatedByColumn()
    {
        return 'updated_by';
    }

    /**
     * Get created by user full name.
     *
     * @return string
     */
    public function getCreatedByNameAttribute()
    {
        if ($this->{$this->getCreatedByColumn()}) {
            return $this->creator->username;
        }

        return '';
    }

    /**
     * Get Laravel's user class instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getUserInstance()
    {
        $class = config('auth.providers.users.model', \App\Models\User::class);

        return new $class;
    }

    /**
     * Get updated by user full name.
     *
     * @return string
     */
    public function getUpdatedByNameAttribute()
    {
        if ($this->{$this->getUpdatedByColumn()}) {
            return $this->updater->username;
        }

        return '';
    }

    /**
     * Query scope to limit results to own records.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwned(Builder $query)
    {
        return $query->where($this->getQualifiedUserIdColumn(), auth()->id());
    }

    /**
     * Get qualified column name for user id.
     *
     * @return string
     */
    public function getQualifiedUserIdColumn()
    {
        return $this->getTable() . '.' . $this->getUserInstance()->getKey();
    }
}