<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->first_name = 'App';
        $admin->last_name = 'Admin';
        $admin->email = 'admin@myapp.com';
        $admin->username = 'Admin';
        $admin->password = bcrypt('password');
        if ($admin->save()) {
            $role = Role::where('name', 'like', 'admin%')->first();
            $admin->roles()->attach($role->id);
        }
    }
}
