<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;


class Department extends Model
{
    use HasFactory;

    //timestamps利用しないときはこう書く
    public $timestamps = false;

    //primaryKeyの変更
    protected $primaryKey = "department_id";

//     Eloquentでは主キーがオートインクリメントで増加する整数値であるとデフォルトで設定されています。
// そのため、オートインクリメントまたは整数値ではない値を主キーを使う場合は$incrementingプロパティをfalseに設定します。
     /**
     * IDが自動増分されるか
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = ["department_id", "department_name"];
    protected $guarded = ["department_id"];

    //利用上は部署テーブルが社員テーブルの親ということになるでしょう。
    // つまり、部署の下に社員が存在しているという関係です
    // 部署にはたくさんの社員がいる(部署 hasMany 社員の関係)
    // 社員はどこか１つの部署に所属している(社員 belongsTo 部署）

    // hasMany設定　こっちが主テーブルです
    public function employees()  // 複数形のメソッドにする
    {
        // return $this->hasMany('App\Models\Employee');
        return $this->hasMany(Employee::class, 'employee_id');
    }

    // バリデーションのルール
    public static $rules = [
        'department_name' => 'required',
    ];

    // エラーメッセージ
    public static $messages = [
        'department_name.required' => '部署名は必ず入れてください',
    ];


}
