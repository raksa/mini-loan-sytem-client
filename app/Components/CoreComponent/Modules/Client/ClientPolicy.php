<?php

namespace App\Components\CoreComponent\Modules\Client;

use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new Role();
    }

    public function before(User $user, $ability)
    {
        if ($user->is_administrator) {
            return true;
        }
    }
    public function view(User $user)
    {
        return $this->roleModel->can($user, 'view');
    }
    public function create(User $user)
    {
        return $this->roleModel->can($user, 'create');
    }
    public function update(User $user, Client $client)
    {
        return $this->roleModel->can($user, 'update');
    }
    public function delete(User $user, Client $client)
    {
        return $this->roleModel->can($user, 'delete');
    }
    public function restore(User $user, Client $client)
    {
        return $this->roleModel->can($user, 'restore');
    }
    public function forceDelete(User $user, Client $client)
    {
        return $this->roleModel->can($user, 'forceDelete');
    }
}
