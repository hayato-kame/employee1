<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentsController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        return view('departments.index', ['departments' => $departments]);
    }

    public function dep_get(Request $request)
    {
        // 新規作成の時にはモデルのインスタンスを作って送ります（中身は空初期状態)
        $department = new Department();
    $action = $request->action;
    // 新規で送信ボタンを押したときは、リクエストパラメータでは、部署IDは渡ってこない null が入ってる
    $department_id = $request->department_id;
    $department_name = $request->department_name;

        switch($action) {
            case "add": 
                 //新規作成の処理
                 break;
            case "edit": 
                // 編集の処理
                break;

            case "delete": 
                // 削除の処理
                break;

            case "cancel": 
                // キャンセルの処理
                break;
        }
        $data = [
            'department' => $department,
            'action' =>$action,
        ];

        return view('departments.dep_get', $data);
    }

    public function dep_post(Request $request)
    {

    }
}