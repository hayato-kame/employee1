<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::all();
        return view('employees.index', ['employees' => $employees]);
    }

    public function empGet(Request $request)
    {

    }

}
