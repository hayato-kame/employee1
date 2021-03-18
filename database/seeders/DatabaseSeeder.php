<?php

namespace Database\Seeders;

use App\Models\Department;
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
        // \App\Models\User::factory(10)->create();
        $this->call( [ UsersTableSeeder::class]);
    
        $this->call([ DepartmentsTableSeeder::class]); // 主テーブルから呼び出すこと
        $this->call([ PhotosTableSeeder::class]);   // 主テーブル
        $this->call([ EmployeesTableSeeder::class]);   // 従テーブル
    
    }
}
