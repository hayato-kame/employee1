<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotosController extends Controller
{
    // データベースからの表示をするコントローラ

    public function show(Request $request)
    {
        $action = $request->action;
        
        switch($action) {
            case "add": 
            // 新規作成ページを表示する時は、そもそも、アップロードしてある写真を、
            // 取ってきたりできないから、新規の時にはスルーする
                 return view('employees.emp_get',['action' => $action]);
                 break;

            case "edit": 
                // 編集の処理 photo_id からphotoインスタンスを検索してくる
                $photo = Employee::find($request->photo_id);
                return view('employees.emp_get', 
                [ 'photo' => $photo , 'action' => $action]);
                break;

            }

    }

    public function post(Request $request)
    {
       
        $photo_id = $request->photo_id;
        $action = $request->action;
        $f_message = ''; // フラッシュメッセージを

        switch($action) {
            case "add": 
                  //新規作成の処理
                 $photo = new Photo();
                 $this->validate($request, Photo::$rules, Photo::$messages);

                 
                 
             
                 break;
  
            case "edit": 
                // 編集の処理
                // 変換をする 修正の場合サイズが0(つまり選択しなかった)の時もありうる
			InputStream is = null;
			try {
				is = part.getInputStream(); // 画像ストリームの取得  画像ファイルを読み込んでバイト配列取得
			} catch (IOException e) {
				e.printStackTrace();
			}
			byte[] photoData = readAll(is); // ファイルデータ読み込んで  byte型の配列に格納して返すreadAllメソッド

           
            



            switch (action) {
                case "add": // 設定(新規)ボタンをクリック  新規では、写真は必ず登録される、として
                    // アップロードした写真データを  photoテーブル  に新規登録
                    int lastPhotoId = photoDAO.photoDataAdd(photoData, contentType); // byte型の配列のファイルデータを新規登録して、photoIdを返す
                    if (lastPhotoId == 0) { // 失敗
                        msg = "データベースへの更新に失敗しました";
                        title = "失敗";
                    } else { // photoテーブルの処理が成功したら、employeeテーブル  にも登録することができる
                        EmployeeBean empBean = new EmployeeBean();
                        empBean.setEmployeeId(employeeId);
                        empBean.setName(name);
                        empBean.setAge(age);
                        empBean.setGender(gender);
                        empBean.setPhotoId(lastPhotoId); // 新規登録した写真IDをセット int型
                        empBean.setZipNumber(zipNumber);
                        empBean.setPref(pref);
                        empBean.setAddress(address);
                        empBean.setDepartmentId(getDepartmentId); // 検索した部署IDをここでセット
                        empBean.setDepartment(department);
                        empBean.setJoiningDate(joiningDate);
                        empBean.setResignationDate(resignationDate);
    
                        // employeeテーブル登録
                        boolean result = employeeDAO.add(empBean);
                        if (!result) {
                            msg = "データベースへの更新に失敗しました"; // result.jsp で表示
                            title = "失敗"; // result.jsp で表示
                        }
                    }
                    break;
    
                case "retouch":
                    // 編集の時の photoIdは  リクエストパラメータを取得して使う
                    // 画像選択があったとき
                    // getpart()メソッドで取得してきた画像データphotoData に変更・更新する
                    if (partSize > 0) { // もし、画像が選択されてたら、先にphotoテーブル更新処理をする
                        boolean result = photoDAO.update(photoData, contentType, photoId);
                        if (!result) { //  失敗
                            msg = "データベースへの更新に失敗しました";
                            title = "失敗";
                        } else { // photoテーブル更新が成功したら、 employeeテーブル にも編集•更新する
                            // リクエストパラメータで渡ってきた値をセット
                            EmployeeBean empBean = new EmployeeBean();
                            empBean.setEmployeeId(employeeId);  // 変更後のID
                            empBean.setName(name);
                            empBean.setAge(age);
                            empBean.setGender(gender);
                            empBean.setPhotoId(photoId);  // 編集ではパラメータから取れる
                            empBean.setZipNumber(zipNumber);
                            empBean.setPref(pref);
                            empBean.setAddress(address);
                            empBean.setDepartmentId(getDepartmentId);
                            empBean.setDepartment(department);
                            empBean.setJoiningDate(joiningDate);
                            empBean.setResignationDate(resignationDate);
                            //  employeeテーブル 編集•更新
                            result = employeeDAO.update(empBean, beforeEmployeeId); //第2引数は 変更前のid ( beforeEmployeeId )をセット
                            if (!result) { //  失敗
                                msg = "データベースへの更新に失敗しました";
                                title = "失敗";
                            }
                        }
                    }
                    // 画像選択は無かったとき  photoテーブルは何もしない
                    if (partSize == 0) {
                        // リクエストパラメータで渡ってきた値をセットして  employeeテーブルだけ更新
                        EmployeeBean empBean = new EmployeeBean();
                        empBean.setEmployeeId(employeeId); // 変更後のID
                        empBean.setName(name);
                        empBean.setAge(age);
                        empBean.setGender(gender);
                        empBean.setPhotoId(photoId);
                        empBean.setZipNumber(zipNumber);
                        empBean.setPref(pref);
                        empBean.setAddress(address);
                        empBean.setDepartmentId(getDepartmentId);
                        empBean.setDepartment(department);
                        empBean.setJoiningDate(joiningDate);
                        empBean.setResignationDate(resignationDate);
                        //  employeeテーブル 編集•更新
                        boolean result = employeeDAO.update(empBean, beforeEmployeeId); //第2引数は 変更前のid ( beforeEmployeeId )をセット
                        if (!result) { //  失敗
                            msg = "データベースへの更新に失敗しました";
                            title = "失敗";
                        }
                    }
                }








                break;
  
        }
        
        return redirect('/employees')->with('flash_message', $f_message);
  


    }

}
