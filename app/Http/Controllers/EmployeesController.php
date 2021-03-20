<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        // 注意 プライマリーキーのフィールド名は 'employee_id' だから、 'id'と指定するとエラー
        $employees = Employee::orderBy('employee_id', 'desc')->simplePaginate(5);
        return view('employees.index', ['employees' => $employees]);
    }

    public function empGet(Request $request)
    {

    }

}
