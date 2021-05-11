<?php

namespace Modules\CMS\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use Modules\CMS\Transformers\Post;


class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user) 
    {
        return $user->can('user.list');
    }

    public function update(User $user, Post $post) 
    {
        return true;
    }    
}
