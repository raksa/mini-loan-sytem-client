<?php

namespace App\Components\CoreComponent\Modules\Repayment;

use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepaymentPolicy
{
    use HandlesAuthorization;

    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new Role();
    }

    public function view(User $user)
    {
        return $this->roleModel->can($user, 'view');
    }
    public function create(User $user)
    {
        return false;
    }
    public function update(User $user, Repayment $repayment)
    {
        return $this->roleModel->can($user, 'update');
    }
    public function delete(User $user, Repayment $repayment)
    {
        return false;
    }
    public function restore(User $user, Repayment $repayment)
    {
        return false;
    }
    public function forceDelete(User $user, Repayment $repayment)
    {
        return false;
    }
    public function pay(User $user, Repayment $repayment)
    {
        return $repayment->is_paid && $this->roleModel->can($user, 'pay');
    }
}
