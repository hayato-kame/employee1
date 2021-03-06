<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// index show destroy のみ createアクションやstoreアクションはjetstreamで実装されてるので不要です
// ここでは作成しませんが、ユーザが自分の名前を編集するアクション（edit, update)や退会アクション（destroy)を作っても問題ありませんし、さらにユーザの登録情報（年齢や自己紹介など）を充実（usersテーブルのカラム追加）させても良いでしょう。これらはUsersControllerに実装すれば実現可能


//  ルートに制限 ['only' => ['index', 'show', 'edit', 'update', 'destroy']

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(8);
        return view('users.index', [ 'users' => $users]);
    }

    // create   storeアクションは jetstreamで実装されてるので不要

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // デバック関数  dd()
        // dd($id);

        // $user = User::find($id);
        // これでもいい
        $user = Auth::user();
        return view('users.show', [ 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();  // 引数いらない
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $param = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        $user = User::find($id);
        $user->fill($param)->save();
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users');
    }
}
