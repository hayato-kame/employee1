<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

// index show のみ createアクションやstoreアクションはjetstreamで実装されてるので不要です
// ここでは作成しませんが、ユーザが自分の名前を編集するアクション（edit, update)や退会アクション（destroy)を作っても問題ありませんし、さらにユーザの登録情報（年齢や自己紹介など）を充実（usersテーブルのカラム追加）させても良いでしょう。これらはUsersControllerに実装すれば実現可能

class UsersController extends Controller
{
    public function index() {
        $users = User::orderBy('id', 'desc')->paginate(5);
        return view('users.index', [ 'users' => $users]);
    }

    
}
