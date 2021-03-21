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
        
        $action = $request->action;
        
        switch($action) {
            case "add": 
                // 新規作成の時にはモデルのインスタンスを作って送ります（中身は空初期状態)
                $employee = new Employee();
                 return view('employees.emp_get',
                 ['employee' => $employee, 'action' => $action]);
                 break;

            case "edit": 
                // 編集の処理 
                $employee = Employee::find($request->employee_id);
                return view('employees.emp_get', 
                [ 'employee' => $employee , 'action' => $action]);
                break;

            }
    }

    public function empPost(Request $request)
    {

    }

}
