<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    const GENDER = ['male','female','other'];
    const GENDER_DEFAULT = 'other';
    const FLAG_ACTIVE = 1;
    const FLAG_INACTIVE = 0;
    const FLAG_FROZEN = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'username', 'email', 'password', 'phone','flag','gender','firstname','lastname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

        'password', 'remember_token','email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];


    public $appends = [
        
        'flag_label'
    ];

    /**
     * Set password attribute
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    public static function getFlags()
    {
        return  [
            'active'=> self::FLAG_ACTIVE,
            'inactive'=> self::FLAG_INACTIVE,
            'frozen' => self::FLAG_FROZEN 
        ];
    }

    public static function getFlagValue($label)
    {
        $flags = self::getFlags();
        return $flags[$label] ?? null;
    }

    public function getFlagLabelAttribute() 
    {
        $fliped = array_flip(self::getFlags());
        return $fliped[$this->flag];
    }

    public  function isActive()
    {
        return $this->getAttribute('flag') === self::FLAG_ACTIVE;
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('flag', self::FLAG_ACTIVE);
    }

    public function isRoot()
    {
        return $this->getAttribute('username') === config('admin.username');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * Login with email/username/mobile
     *
     * @param $identifier
     * @return mixed
     */
    public function findForPassport($identifier) {

        return $this->orWhere('email', $identifier)->orWhere('username', $identifier)->orWhere('mobile',$identifier)->first();
    }

}
