<?php

namespace App\Http\Controllers;

use App\Exceptions\DeleteException;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;

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

            // case "delete": 
            //     // 削除の処理
            //     break;

            // case "cancel": 
            //     // キャンセルの処理
            //     break;
            }
    }


    public function depPost(Request $request)
    { 
        $action = $request->action;
        
        $f_message = ''; // フラッシュメッセージを
        
        //  新規で送信ボタンを押したときは $request->department_id には 自動採番 の番号が入ってます
        
        switch($action) {
            case "add": 
                //新規作成の処理
                $department = new Department();
                $this->validate($request, Department::$rules, Department::$messages);
               // 部署IDを作成する
               $last = DB::table('departments')->orderBy('department_id', 'desc')->first();
               $resultStrId = "D01";  // 初期値
               if (isset($last)) {
                   $strId = $last->department_id;  //文字列を取得
                    // 数字の部分を取得して数値に変換して １を足す
                   $num = intval(substr($strId, -2, )) + 1 ;
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
              $department = Department::find($request->department_id);
            //   $department->delete();

              // フラッシュメッセージ設定 成功時
              $f_message = '部署名を削除しました';

              try {
                // 外部キー制約でオプションが->onDelete('restrict')　をつけているので、
                // もし、削除しようとした部署名に、所属する社員がいたら、削除禁止にしていますので、
                // 所属する社員がいたら Illuminate\Database\QueryException が発生します
                  $department->delete();
              } catch (QueryException $e) {
                //  削除できないエラーメッセージを届けるようにします。
                $f_message = 'この部署は、所属する社員がいるので、削除できませんでした';
                return redirect('/departments')->with([ 'flash_message' => $f_message ]);  // return　で即終了して呼び出し元へ戻ります
              }

              break;

          case "cancel": 
              // キャンセルの処理 部署一覧ページへ移るだけ
              break;
      }
    //   ridirect($to)->with($key, $val)はsession($to)->flash($key, $value);と等価
    //   flashやwithの引数を連想配列にして複数指定可。
    //   return redirect('/departments')->with('flash_message', $f_message);
      return redirect('/departments')->with([ 'flash_message' => $f_message ]);
    }
}