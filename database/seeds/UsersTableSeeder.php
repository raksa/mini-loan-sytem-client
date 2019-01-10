<?php
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

/*
 * Author: Raksa Eng
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleModel = new Role();
        $user = new User();
        $user->fill([
            'role' => $roleModel->administrator['id'],
            'name' => 'raksa',
            'email' => 'eng.raksa@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        $user->email_verified_at = now();
        $user->save();

        foreach ($roleModel->toOption() as $roleId => $role) {
            if ($roleModel->isAdministrator($roleId)) {
                continue;
            }
            $user = new User();
            $user->fill([
                'role' => $roleId,
                'name' => $role['name'],
                'email' => "$roleId@local",
                'password' => bcrypt('123456'),
            ]);
            $user->email_verified_at = now();
            $user->save();
        }
    }
}
