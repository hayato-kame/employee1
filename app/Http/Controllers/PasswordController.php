<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
// ごっそりRegisterController からコピーしてきた
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Validator;

class PasswordController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // passwordは見せないから、対応するビューはいらないから　ユーザアカウント修正の手順とはここが違う
        // リダイレクトさせるにはredirect関数にパスを指定する方法
        return redirect('users.show'); // 誘導してる
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        return view('password.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request) {
    //     //現在のパスワードが正しいかを調べる
    //     if(!(Hash::check($request->get('current_password'), \Auth::user()->password))) {
    //         return redirect()->back()->with('flash_message', '現在のパスワードが間違っています。');
    //     }

    //     //現在のパスワードと新しいパスワードが違っているかを調べる
    //     if(strcmp($request->get('current_password'), $request->get('password')) == 0) {
    //         return redirect()->back()->with('flash_message', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
    //     }

    //     //パスワードのバリデーション。新しいパスワードは8文字以上、password_confirmationフィールドの値と一致しているかどうか。
    //     $validated_data = $request->validate([
    //         'current_password' => 'required',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     //パスワードを変更
    //     $user = \Auth::user();
    //     $user->password = bcrypt($request->get('password'));
    //     $user->save();

    //     return redirect('accounts/:id')->with('flash_message', 'パスワードを変更しました。');
    // }
    public function update(Request $request, $id)
    {
        $user = Auth::user();

         // 自分のハッシュされたパスワード 
         $current_password = Auth::user()->password;

        // usersテーブルのpasswordカラムについて、なにも更新せずに、更新ボタンを押しても、通るように
        // 　自分のpasswordはチェック対象外にしたい
        // 「email != $myEmail」のレコードに対して、一意チェックを行う 
        //  Rule::unique('users', 'password')->whereNot('password', $current_password)
        $request->validate([
        'password' => 
        [Rule::unique('users', 'password')->whereNot('password', $current_password), 'required', 'string', 'min:8', 'confirmed'],
        ]);

        if(Hash::check($request->password, $current_password)){
            // idで探すのではなくて認証ユーザをさがす
            $user = Auth::user();
            $user->password = $request->password;
            $user->save();
            $request->session()->flash('flash_message', 'パスワード変更が完了しました');
        return redirect('users/:id');  // return viewは使わないでください
        }else {
            $request->session()->flash('flash_message', 'パスワード変更できませんでした');
        return redirect('users/:id');  // return viewは使わないでください
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
