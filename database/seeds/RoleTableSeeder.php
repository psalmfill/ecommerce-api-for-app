<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin','user'];

        foreach($roles as $role){
            $newRole = new Role();
            $newRole->name = $role;
            $newRole->slug = $role;
            $newRole->save();
        }
    }
}
