<?php

namespace App\Components\CoreComponent\Modules\Client;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;
    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }
    public function view(User $user)
    {
        return true;
    }
    public function create(User $user)
    {
        return true;
    }
    public function update(User $user, Client $client)
    {
        return true;
    }
    public function delete(User $user, Client $client)
    {
        return true;
    }
    public function restore(User $user, Client $client)
    {
        return true;
    }
    public function forceDelete(User $user, Client $client)
    {
        return true;
    }
}
