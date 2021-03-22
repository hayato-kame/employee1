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
                $photo = new Photo();  // 親テーブルからさきに作るから
                $employee = new Employee();
                 return view('employees.emp_get',
                 ['photo' => $photo ,'employee' => $employee, 'action' => $action]);
                 break;

            case "edit": 
                // getでアクセスされたときに、写真表示しないといけない
                // 編集の処理 
                
                $employee = Employee::find($request->employee_id);
                // dd($employee->photo->mime_type);
                // dd($employee->photo->photo_data);
                // 最初はphotoがnull
                // dd($photo); 

                return view('employees.emp_get', 
                [ 'image' => $employee->photo->photo_data, 'employee' => $employee , 'action' => $action, 'photo_id' => $employee->photo_id]);
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
                
                // バイナリーデータと、mime  
                $param = [
                    'photo_data' => $data,
                    'mime_type' =>  $path['extension'],
                ];
               
                $photo->fill($param)->save();
                // ここまで来るってことは、成功してるってこと
                $f_message = "登録に成功しました";
               
                 break;

                //  編集の時には、表示の処理もある
            case "edit": 
                // 編集の処理  上書き
                $employee = Employee::find($request->employee_id);
                $photo = Photo::find($request->photo_id);
                //先に親テーブルに保存
                // dd($request->all());

                // $request->image 
                // 画像アップロードしてきたものを、ここで、photoテーブルに保存する
                // base64エンコードに変換

                $data = base64_encode($request->image);
                // dd($data);

                //POSTされた画像ファイルデータ取得しbase64でエンコードする
                if ($request->image){ // 画像編集しない場合もあるから
                    $image = base64_encode(file_get_contents($request->image->getRealPath()));
                                   
                                    // dd($request->image);
                                    
                                    // 画像タイプの確認
                                    $path = pathinfo($request->image);
                                    // dd($pathinfo);
                                    // mimeタイプの確認
                                    // dd( $path['extension']);
                                    
                                    $param = [
                                        // 'photo_data' => $data,
                                        // 試してみる
                                        'photo_data' =>$image,
                                        'mime_type' =>  $path['extension'],
                                    ];
                                   
                                    $photo->fill($param)->save();
                                    // ここまで来るってことは、成功してるってこと
                                    // 続いて子テーブル
                                    $employee->photo_id = $request->photo_id;
                                    $employee->save();
                }




                $f_message = "登録に成功しました";
               

               
               

               
                break;

            }
            return redirect('/employees')->with('flash_message', $f_message);

    }

}
