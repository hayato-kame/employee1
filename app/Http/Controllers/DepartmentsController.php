<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        return view('departments.index', ['departments' => $departments]);
    }

    public function depGet(Request $request)
    {
        $action = $request->action;
        
        switch($action) {
            case "add": 
                // 新規作成の時にはモデルのインスタンスを作って送ります（中身は空初期状態)
                $department = new Department();
                 return view('departments.dep_get',
                 ['department' => $department, 'action' => $action]);
                 break;

            case "edit": 
                // 編集の処理 $request->department_id  $request->department_name hiddenで送られてる
                $department = Department::find($request->department_id);
                return view('departments.dep_get', 
                [ 'department' => $department , 'action' => $action]);
                break;

            case "delete": 
                // 削除の処理
                break;

            case "cancel": 
                // キャンセルの処理
                break;
            }
    }


    public function depPost(Request $request)
    { 
        $department = new Department();
        $action = $request->action;

        $f_message = ''; // フラッシュメッセージを

        //  新規で送信ボタンを押したときは $request->department_id には null が入ってます
      
      switch($action) {
          case "add": 
                //新規作成の処理
                $this->validate($request, Department::$rules, Department::$messages);
               // 部署IDを作成する
               $last = DB::table('departments')->orderBy('department_id', 'desc')->first();
               $resultStrId = "D01";  // 初期値
               if (isset($last)) {
                   $strId = $last->department_id;  //文字列を取得
                    // 最後の一番目を取得して数値に変換して １を足す
                   $num = intval(substr($strId, -1)) + 1 ;  // 最後の一番目を取得して数値に変換
                   // 文字列のフォーマット 部署IDができた
                   $resultStrId = sprintf("D%02d", $num);
               } 
               // もし $last が null だったら、初期値をセットする
               // ここで、インスタンスのプロパティに作成した部署IDをセット
              $department->department_id = $resultStrId;
              // 部署名プロパティにもセット
              $department->department_name = $request->department_name;
              $department->save();
              // フラッシュメッセージ設定
              $f_message = 'データ新規保存しました';
               break;

          case "edit": 
              // 編集の処理
              $this->validate($request, Department::$rules, Department::$messages);
              $department = Department::find($request->department_id);
              $department->department_name = $request->department_name;
              $department->save();
               // フラッシュメッセージ設定
                $f_message = '部署名を変更しました';
              break;

          case "delete": 
              // 削除の処理
              Department::find($request->department_id)->delete();
             // フラッシュメッセージ設定
             $f_message = '部署名を削除しました';
              break;

          case "cancel": 
              // キャンセルの処理 部署一覧ページへ移るだけ
              break;
      }
      
      return redirect('/departments')->with('flash_message', $f_message);;
    }
}