<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Photo;
use App\Models\Department;

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
                $departments = Department::all(); // セレクトボックスに一覧が必要$departmentsはコレクション
                // dd($departments->all());
                $depArray = $departments->all();
                // dd($depArray[0]->department_name);
                $dep_name = []; //配列の初期化 キーが　D01 値が 総務部 の連想配列にしたい
                foreach($depArray as $dep){
                    // [] にキーを指定して、連想配列を作成できます！！
                    $dep_name[$dep->department_id] = $dep->department_name;  // 注意[]を入れないと、ただの上書きになってしまいます
                }
                // 注意ややこしいことに、配列変数をデバックするときには[]を入れてはいけません
                // dd($dep_name);  
                
                $employee = new Employee();
                
                 return view('employees.emp_get',
                 [
                    'photo' => $photo ,
                    'dep_name' => $dep_name, // 連想配列を送ります キーがD01 値が総務部などの
                    'employee' => $employee, 
                    'action' => $action
                 ]);
                 break;

            case "edit": 
                // getでアクセスされたときに、写真表示しないといけない
                // 編集の処理 
                $departments = Department::all(); // セレクトボックスに一覧が必要$departmentsはコレクション
                // dd($departments->all());
                $depArray = $departments->all();
                // dd($depArray[0]->department_name);
                $dep_name = []; //配列の初期化 キーが　D01 値が 総務部 の連想配列にしたい
                foreach($depArray as $dep){
                    // [] にキーを指定して、連想配列を作成できます！！
                    $dep_name[$dep->department_id] = $dep->department_name;  // 注意[]を入れないと、ただの上書きになってしまいます
                }
                // 注意ややこしいことに、配列変数をデバックするときには[]を入れてはいけません
                // dd($dep_name);  
                $employee = Employee::find($request->employee_id);
                // dd($employee->photo->mime_type);
                // dd($employee->photo->photo_data);
                // 最初はphotoがnull
                // dd($photo); 

                return view('employees.emp_get', 
                [ 
                    'image' => $employee->photo->photo_data,
                    'dep_name' => $dep_name,
                    'employee' => $employee ,
                    'action' => $action,
                    'photo_id' => $employee->photo_id]);
                break;

            }
    }

    public function empPost(Request $request)
    {

        $action = $request->action;
        $f_message = ''; // フラッシュメッセージを
        
        switch($action) {
            case "add": 
            
                $photo = new Photo();// 親テーブルを先に
                $employee = new Employee(); // 従テーブル（子テーブル）
                // もし、写真をアップロードしてきたら、photosテーブルに登録する
                // photo_data mime_type は nullableだから if に囲む
                //POSTされた画像ファイルデータ取得しbase64でエンコードする
                if ($request->photo_data){ 
                    $photo_data = base64_encode(file_get_contents($request->photo_data->getRealPath()));
                    $this->validate($request, Photo::$rules, Photo::$messages );
                    // dd($request->photo_data);
                    
                    // 画像タイプの確認
                    $path = pathinfo($request->photo_data);
                    // dd($pathinfo);
                    // mimeタイプの確認
                    // dd( $path['extension']);
                    
                    $param = [
                        'photo_data' =>$photo_data,
                        'mime_type' =>  $path['extension'],
                    ];
                    
                    $photo->fill($param)->save();       
                }
                // つづいて子テーブルemployees
                // dd($request->gender);
                // dd($request->zip_number);
                // dd($request->pref);
                // dd($request->address1);
                // dd($request->department_id);
                // dd($request->hire_date);
                // dd($request->retire_date);
                $employee->name = $request->name;
                $employee->age = $request->age;
                $employee->gender = $request->gender;
                $employee->zip_number = $request->zip_number;
                $employee->pref = $request->pref;
                $employee->address1 = $request->address1;
                $employee->address2 = $request->address2;
                $employee->address3 = $request->address3;
                $employee->department_id = $request->department_id;
                $employee->hire_date = $request->hire_date;
                $employee->retire_date = $request->retire_date;
                $employee->save();
           
                $f_message = "登録に成功しました";
               
                 break;

                //  編集の時には、表示の処理もある
            case "edit": 
                // 編集の処理  上書き
                $employee = Employee::find($request->employee_id);
                $photo = Photo::find($request->photo_id);
                //先に親テーブルphotosに保存
                // dd($request->all());

                // $request->image 
                // 画像アップロードしてきたものを、ここで、photoテーブルに保存する
                // base64エンコードに変換 バイナリーデータになってる

                // $data = base64_encode($request->image);
                // dd($data);

                //POSTされた画像ファイルデータ取得しbase64でエンコードする
                if ($request->photo_data){ // 画像変更編集しない場合もあるから
                    $photo_data = base64_encode(file_get_contents($request->photo_data->getRealPath()));
                                   $this->validate($request, Photo::$rules, Photo::$messages );
                                    // dd($request->image);
                                    
                                    // 画像タイプの確認
                                    $path = pathinfo($request->photo_data);
                                    // dd($pathinfo);
                                    // mimeタイプの確認
                                    // dd( $path['extension']);
                                    
                                    $param = [
                                        // 'photo_data' => $data,
                                        // 試してみる
                                        'photo_data' =>$photo_data,
                                        'mime_type' =>  $path['extension'],
                                    ];
                                   
                                    $photo->fill($param)->save();
                                    // ここまで来るってことは、成功してるってこと
                                    // 続いて子テーブル
                                    // $employee->photo_id = $request->photo_id;
                                    // $employee->save();
                }

                $f_message = "登録に成功しました";
                             
                break;
            }
            return redirect('/employees')->with('flash_message', $f_message);

    }

}
