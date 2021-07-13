<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        //ADD PERMISSIONS
        \App\Permission::create(
            [
                'id' =>1,
                'description' => 'Can create/update/delete User',
                'permission_code' => 'user_crud',
                'created_by'=>1,
                'updated_by'=>1
            ]);
        \App\Permission::create(
            [
                'id' =>2,
                'description' => 'Can create/update/delete Expense Category',
                'permission_code' => 'expense_category_crud',
                'created_by'=>1,
                'updated_by'=>1
            ]);
        \App\Permission::create(
            [
                'id' =>3,
                'description' => 'Can create/update/delete Expense',
                'permission_code' => 'expense_crud',
                'created_by'=>1,
                'updated_by'=>1
            ]);
        \App\Permission::create(
            [
                'id' =>4,
                'description' => 'Can create/update/delete Role',
                'permission_code' => 'role_crud',
                'created_by'=>1,
                'updated_by'=>1
            ]);

        //ADD ADMINISTRATOR ROLE
        $admin_role = \App\Role::create(
            [
                'id' => 1,
                'name' => 'Admin',
                'description' => 'Administrator account',
                'created_by'=>1,
                'updated_by'=>1
            ]);
        $admin_role->permissions()->sync([1,2,3,4]); // array of permission ids

        $user_role = \App\Role::create(
            [
                'id' => 2,
                'name' => 'User',
                'description' => 'User account',
                'created_by'=>1,
                'updated_by'=>1
            ]);
        $user_role->permissions()->sync([3]); // array of permission ids


        //ADD ADMIN USER AS DEFAULT
        \App\User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => bcrypt('secret'),
                'role_id' => 1,
                'created_by'=>1,
                'updated_by'=>1
            ]);
        \App\User::create(
            [
                'name' => 'User',
                'email' => 'user@email.com',
                'password' => bcrypt('secret'),
                'role_id' => 2,
                'created_by'=>1,
                'updated_by'=>1
            ]);



    }
}
