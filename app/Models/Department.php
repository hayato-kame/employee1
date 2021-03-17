<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
    use HasFactory;

    //timestamps利用しないときはこう書く
    public $timestamps = false;

    //primaryKeyの変更
    protected $primaryKey = "department_id";

    //利用上は部署テーブルが社員テーブルの親ということになるでしょう。
    // つまり、部署の下に社員が存在しているという関係です
    // 部署にはたくさんの社員がいる(部署 hasMany 社員の関係)
    // 社員はどこか１つの部署に所属している(社員 belongsTo 部署）

    // hasMany設定　こっちが主テーブルです
    public function employees()  // 複数形のメソッドにする
    {
        return $this->hasMany('App\Models\Employee');
    }


}
