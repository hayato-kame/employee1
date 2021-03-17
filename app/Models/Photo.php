<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    //primaryKeyの変更
    protected $primaryKey = 'photo_id';
    

    // 利用上は 社員テーブル が 写真テーブル の親ということになるでしょう。
    // つまり、社員の下に写真が存在しているという関係です
    // 社員はたくさんの写真をもってる  (社員 hasMany 写真の関係)
    // 写真は誰か一人の社員に所属している  (写真 belongsTo 社員）

    //belongsTo設定 こっちが従テーブル
    public function employee()  // 単数形のメソッドにする
    {
        return $this->belongsTo('App\Models\Employee');
    }


}
