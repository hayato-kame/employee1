<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // 複合PKの これでsaveメソッドで更新処理が可能になりました。調べたらHasCompositePrimaryKey トレイトを使用すれば大丈夫なようだ
    // HasCompositePrimaryKey トレイトの使用
   // まずはComposerでインストール。composer require mopo922/laravel-treats
// インストールが完了したら、Modelファイルでインポート。これでsaveメソッドで更新処理が可能になりました。
    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;

//primaryKeyの変更
    protected $primaryKey = ["employee_id", "photo_id"];


    //利用上は部署テーブルが社員テーブルの親ということになるでしょう。
    // つまり、部署の下に社員が存在しているという関係です
    // 部署にはたくさんの社員がいる(部署 hasMany 社員の関係)
    // 社員はどこか１つの部署に所属している(社員 belongsTo 部署）
    // belongsTo設定  こっちが従テーブルです
    public function department()  // 単数形のメソッドにする
    {
        return $this->belongsTo('App\Models\Department');
    }


    // 利用上は 社員テーブル が 写真テーブル の親ということになるでしょう。
    // つまり、社員の下に写真が存在しているという関係です
    // 社員はたくさんの写真をもってる  (社員 hasMany 写真の関係)
    // 写真はどこか１つの社員に所属している  (写真 belongsTo 社員）

    // hasMany設定　こっちが主テーブルです
    public function photos()  // 複数形のメソッドにする
    {
        return $this->hasMany('App\Models\Photo');
    }


}
