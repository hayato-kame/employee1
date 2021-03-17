<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Photo extends Model
{
    use HasFactory;

    //primaryKeyの変更
    protected $primaryKey = 'photo_id';
    
    protected $fillable = [];
    protected $guarded = [];

  
    // hasOne設定　こっちが主テーブルです
    public function employee()  //単数形のメソッドにする一人の人との関係を持ってるから
    {
        // return $this->hasOne('App\Models\Employee');
        return $this->hasOne(Employee::class, 'employee_id'); // 第二引数外部キー
    }

}
