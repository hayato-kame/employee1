<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Photo;

class EmployeesController extends Controller
{
// EmployeesControllerを作る前に、親のDepartmentController と、PhotoController　から作ります

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

        $action = $request->action;
        $f_message = ''; // フラッシュメッセージを
        
        switch($action) {
            case "add": 
            
                $employee = new Employee();

                $photo = new Photo();

                // dd($request->all());

                // $request->image 
                // 画像アップロードしてきたものを、ここで、photoテーブルに保存する
                // base64エンコードに変換
                $data = base64_encode($request->image);
                // dd($data);
               
                // dd($request->image);
                
                // 画像タイプの確認
                $path = pathinfo($request->image);
                // dd($pathinfo);
                // mimeタイプの確認
                // dd( $path['extension']);
                
                $param = [
                    'photo_data' => $data,
                    'mime_type' =>  $path['extension'],
                ];
               
                $photo->fill($param)->save();
                // ここまで来るってことは、成功してるってこと
                $f_message = "登録に成功しました";
               
                 break;

            case "edit": 
                // 編集の処理 
                $employee = Employee::find($request->employee_id);
                $photo = Photo::find($request->photo_id);

 
                

                

                // dd($request->all());

                // $request->image 
                // 画像アップロードしてきたものを、ここで、photoテーブルに保存する
                // base64エンコードに変換
                $data = base64_encode($request->image);
                // dd($data);
               
                // dd($request->image);
                
                // 画像タイプの確認
                $path = pathinfo($request->image);
                // dd($pathinfo);
                // mimeタイプの確認
                // dd( $path['extension']);
                
                $param = [
                    'photo_data' => $data,
                    'mime_type' =>  $path['extension'],
                ];
               
                $photo->fill($param)->save();
                // ここまで来るってことは、成功してるってこと
                $f_message = "登録に成功しました";
               

                // dd($request->all());

                // $request->image 
                // 画像アップロードしてきたものを、ここで、photoテーブルに保存する
                // base64エンコードに変換
                $data = base64_encode($request->image);
                // dd($data);
               
                // dd($request->image);
                
                // 画像タイプの確認
                $path = pathinfo($request->image);
                // dd($pathinfo);
                // mimeタイプの確認
                // dd( $path['extension']);
                
                $param = [
                    'photo_data' => $data,
                    'mime_type' =>  $path['extension'],
                ];
               
                $photo->fill($param)->save();
                // ここまで来るってことは、成功してるってこと
                $f_message = "登録に成功しました";
               

               
                break;

            }
            return redirect('/employees')->with('flash_message', $f_message);

    }

}
