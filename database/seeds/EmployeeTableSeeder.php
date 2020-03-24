<?php

use App\Employee;
use App\User;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::truncate(); //to avoid duplicates if run more than one.
        Employee::truncate(); //to avoid duplicates if run more than one.

        User::create([
            'name' => 'phillip',
            'email' => 'phillip@vimigo.my',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'jess',
            'email' => 'jess@vimigo.my',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'delilah',
            'email' => 'delilah@vimigo.my',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'syafiq',
            'email' => 'syafiq@vimigo.my',
            'password' => bcrypt('password'),
        ]);

        factory(Employee::class, 50)->create(); //will make 100 fake employees
    }
}
