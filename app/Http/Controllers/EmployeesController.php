<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Photo;
use App\Models\Department;
use DB;
use App\Http\Requests\EmployeeFormRequest;
use Illuminate\Support\Facades\Log;

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
                // 編集のページはgetでアクセスされたときに、写真表示しないといけない
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
                    'photo_data' => $employee->photo->photo_data,
                    'dep_name' => $dep_name,
                    'employee' => $employee ,
                    'action' => $action,
                    'photo_id' => $employee->photo_id]);
                break;
            }
    }

    public function empPost(EmployeeFormRequest $request)
    {
        $action = $request->action;
        $f_message = ''; // フラッシュメッセージを
        
        switch($action) {
            case "add": // 新規登録 親テーブルから            
                $photo = new Photo();// 親テーブルを先に
                $employee = new Employee(); // 従テーブル（子テーブル）
                // もし、写真をアップロードしてきたら、先に主テーブルのphotosテーブルに登録する
                // photo_data mime_type は nullableだから
                //もし、POSTされた画像ファイルデータがあれば取得しbase64でエンコードする
                if (isset($request->photo_data)){ 
                    $photo_data = base64_encode(file_get_contents($request->photo_data->getRealPath()));
                    
                    // 今回は、フォームリクエストを使ってバリデーションするので
                    // $this->validate($request, Photo::$rules, Photo::$messages );
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
                } else {  // アップロードしてこなくても、photo_id はデータベースに登録しないと、
                    // 子テーブルが作れないから
                    $param = [
                        'photo_data' => null,
                        'mime_type' => null,
                    ];
                     // ddでデバックすると、trueになってる
                        // dd($photo->save());
                        $photo->save();
                }

                // つづいて子テーブルemployees
                // バリデーションは、フォームリクエストで行う
                // $this->validate($request, Employee::$rules, Employee::$messages);
                
                // dd($request->gender);
                // dd($request->zip_number);
                // dd($request->pref);
                // dd($request->address1);
                // dd($request->department_id);
                // dd($request->hire_date);
                // dd($request->retire_date);

                // 社員IDを作る
                $last = DB::table('employees')->orderBy('employee_id', 'desc')->first();
                $resultStrId = "EMP0001";  // 初期値
                if (isset($last)) {
                    $strId = $last->employee_id;  //文字列を取得
                     // 数字の部分を取得して数値に変換して １を足す
                    $num = intval(substr($strId, -4)) + 1 ;
                    // 文字列のフォーマット 部署IDができた
                    $resultStrId = sprintf("EMP%04d", $num);
                } 
                // もし $last が null だったら、初期値をセットする
                // ここで、インスタンスのプロパティに作成した従業員IDをセット
                $employee->employee_id = $resultStrId;

                $employee->name = $request->name;
                $employee->age = $request->age;
                $employee->gender = $request->gender;
                // ここがポイント
                $employee->photo_id = $photo->photo_id;

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
               
            case "edit": 
                // 編集の処理  上書き 親テーブルから
                $photo = Photo::find($request->photo_id);
                $employee = Employee::find($request->employee_id);
                //先に親テーブルphotosに保存
                // dd($request->all());

                // もし、画像アップロードしてきたら、先に、主テーブルのphotosテーブルに保存する

                //もし、POSTされた画像ファイルデータがあれば取得しbase64でエンコードする
                if ($request->photo_data){ // 画像変更編集しない場合もあるから
                    $photo_data = base64_encode(file_get_contents($request->photo_data->getRealPath()));
                                //    $this->validate($request, Photo::$rules, Photo::$messages );
                                    // dd($request->image);
                                    
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
                                    // ここまで来るってことは、主テーブルphotos成功してるってこと
                }
                // 続けて、従テーブルのemployeesテーブル操作する
                // バリデーション
                // $this->validate($request, Employee::$rules, Employee::$messages);

                // 社員ID 以外を上書き保存する
                $employee->name = $request->name;
                $employee->age = $request->age;
                $employee->gender = $request->gender;
                // ここがポイント 写真を差し替えているかもしれないので、差し替えてなくてもする
                $employee->photo_id = $photo->photo_id;

                $employee->zip_number = $request->zip_number;
                $employee->pref = $request->pref;
                $employee->address1 = $request->address1;
                $employee->address2 = $request->address2;
                $employee->address3 = $request->address3;
                $employee->department_id = $request->department_id;
                $employee->hire_date = $request->hire_date;
                $employee->retire_date = $request->retire_date;
                $employee->save();
                // ここまで来るってことは、エラーがなかったということ

                $f_message = "登録に成功しました";                             
                break;
            }
           
            return redirect('/employees')->with('flash_message', $f_message);

    }

    public function delete(Request $request)
    {
        // dd($request->photo_id);
        // dd($request->employee_id);
        // リレーションの ->onDelete('cascade')  をつけた　これは、
        // 親テーブルのデータ一行分を削除すると、関連する子テーブルがあっても、
        // エラーにならないで、関連する子テーブルのデータも一緒に消去できるようになるというもの
        // ですから、親テーブルを削除するだけで、関連する子テーブルのデータも一行分削除できている
        $employee = Employee::find($request->employee_id);
        // dd($employee->photo->photo_id);
        $photo = Photo::find($employee->photo->photo_id);
        // dd($photo->photo_id);
        //  dd($photo->delete());

        // 削除の処理は親テーブルだけで良し
        $photo->delete();
      
        $f_message = "削除しました";
        return redirect('/employees')->with('flash_message', $f_message);
    }

    public function find(Request $request)
    {
        $departments = Department::all(); // セレクトボックスに一覧が必要$departmentsはコレクション
        // dd($departments->all());
        $depArray = $departments->all();
        // dd($depArray[0]->department_name);
        $dep_name = []; //配列の初期化   キーが　D01   値が 総務部  などの連想配列にしたい
        foreach($depArray as $dep){
            // [] にキーを指定して、連想配列を作成できます！！
            $dep_name[$dep->department_id] = $dep->department_name;  // 注意[]を入れないと、ただの上書きになってしまいます
        }
        // 注意、配列変数をデバックするときには[]を入れてはいけません
        // dd($dep_name);
        
        // $unselected = ['D00' => '未選択'];
        // マージする
        // $mergeDep = array_merge($unselected , $dep_name);
        // dd($mergeDep);  
        $employees = []; // 空の配列
        $result = '';      
        return view( 'employees.find', [ 'result' => $result, 'dep_name' => $dep_name , 'employees' => $employees]);
    }
    public function search(Request $request)
    {

        $departments = Department::all(); // セレクトボックスに一覧が必要$departmentsはコレクション
        // dd($departments->all());
        $depArray = $departments->all();
        // dd($depArray[0]->department_name);
        $dep_name = []; //配列の初期化   キーが　D01   値が 総務部  などの連想配列にしたい
        foreach($depArray as $dep){
            // [] にキーを指定して、連想配列を作成できます！！
            $dep_name[$dep->department_id] = $dep->department_name;  // 注意[]を入れないと、ただの上書きになってしまいます
        }
        // 注意、配列変数をデバックするときには[]を入れてはいけません
        // dd($dep_name);
        
        // $unselected = ['D00' => '未選択'];
        // マージする
        // $mergeDep = array_merge($unselected , $dep_name);


        $dep_id = $request->department_id;
        $emp_id = $request->employee_id;
        $word = $request->word;
        // 未選択ならnull
        // dd($dep_id);
        // dd($emp_id);
        // dd($word);
        // $employees = Employee::where('department_id', $dep_id)->get();
        $result = '';
        // if($dep_id == null && $emp_id == null　&& $word == null){
            if (empty($dep_id) && empty($emp_id) && empty($word)){
            $result = '何か入力してください';
            $employees = [];
           return view('employees.find', ['result' => $result, 'dep_name' => $dep_name ,'employees' => $employees]);
           // return が実行されていたら、以降に書いてあるのは実行されない
        }else {
            $employees = Employee::search($dep_id, $emp_id, $word)->get();
            if (count($employees) > 0){
                $result = '検索結果です';

            } else {
                $result = '0件でした';
            }
        }

        // dd($employees);
        // $employees = Employee::depIdSearch($dep_id)->empIdSearch($emp_id)->nameSearch($word)->get();
        // セッションに $request->session()->put('employees', $employees) と同じ意味です
    //    return redirect('/employees')->with(['employees'=> $employees]);
    return view('employees.find', ['result' => $result, 'dep_name' => $dep_name ,'employees' => $employees]);
    }

    public function postCSV(Request $request)
    {
        // 出力データ
        $employees = Employee::all();
        // dd($employees);
        // 出力のための
        $head = [ "社員ID","名前","年齢","性別","写真ID","住所","部署ID","入社日","退社日" ];

        // 書き込み用ファイルを開く
        $file = fopen('test.csv', 'w');
        // dd($file);
        if($file){
            // 見出しの書き込み
            mb_convert_variables('SJIS', 'UTF-8', $head);
            fputcsv($file, $head);
            //  データの書き込み
            foreach ($employees->toArray() as $employee){
                // dd($employee);
                mb_convert_variables('SJIS', 'UTF-8', $employee);
                fputcsv($file, $employee);
            }
        }
        fclose($file);  // ファイルを閉じる

        // HTTPヘッダ
        header("Content-Type: application/octet-stream");
        header('Content-Length: '.filesize('test.csv'));
        header('Content-Disposition: attachment; filename=test.csv');
        readfile('test.csv');
        // publicの下にtest.csvというCSVファイルが作成されている
        return redirect('/employees');
    }

}
