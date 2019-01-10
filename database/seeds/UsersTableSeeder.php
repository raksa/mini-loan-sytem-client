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

        $roles = [
            'subscriber',
            'contributor',
            'author',
            'editor',
        ];
        foreach ($roleModel->toOption() as $roleId => $roleName) {
            if ($roleModel->isAdministrator($roleId)) {
                continue;
            }
            $user = new User();
            $user->fill([
                'role' => $roleId,
                'name' => $roleName,
                'email' => "$roleId@local",
                'password' => bcrypt('123456'),
            ]);
            $user->email_verified_at = now();
            $user->save();
        }
    }
}
