<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new Role();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getIsSubscriberAttribute($roleId)
    {
        return $this->roleModel->isSubscriber($this->role);
    }
    public function getIsContributorAttribute($roleId)
    {
        return $this->roleModel->isContributor($this->role);
    }
    public function getIsAuthorAttribute($roleId)
    {
        return $this->roleModel->isAuthor($this->role);
    }
    public function getIsEditorAttribute($roleId)
    {
        return $this->roleModel->isEditor($this->role);
    }
    public function getIsAdministratorAttribute($roleId)
    {
        return $this->roleModel->isAdministrator($this->role);
    }
}
