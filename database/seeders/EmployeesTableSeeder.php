<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'employee_id' => 'EMP0001',
            'name' => '山田　太郎',
            'age' => 35,
            'gender' => '男',
            'photo_id' => 1,
            'zip_number' => 100-1000,
            'pref' => '東京都',
            'address' => '千代田区',
            'department_id' => 'D01',
            'hire_date' => '2000-11-11',
            'retire_date' => null,
        ];
        $employee = new Employee();
        $employee->fill($param)->save();

        $param = [
            'employee_id' => 'EMP0002',
            'name' => '日本 花子',
            'age' => 27,
            'gender' => '女',
            'photo_id' => 2,
            'zip_number' => 200-2000,
            'pref' => '埼玉県',
            'address' => 'さいたま市',
            'department_id' => 'D03',
            'hire_date' => '1999-01-01',
            'retire_date' => '2003-03-03',
        ];
        $employee = new Employee();
        $employee->fill($param)->save();


        $param = [
            'employee_id' => 'EMP0003',
            'name' => '東京 次郎',
            'age' => 41,
            'gender' => '男',
            'photo_id' => 3,
            'zip_number' => 300-3000,
            'pref' => '神奈川県',
            'address' => '川崎市',
            'department_id' => 'D03',
            'hire_date' => '1998-12-12',
            'retire_date' => null,
        ];
        $employee = new Employee();
        $employee->fill($param)->save();


    }
}
