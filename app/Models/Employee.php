<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use  App\Models\Photo;

class Employee extends Model
{
    use HasFactory;

    
    //primaryKeyの変更
    protected $primaryKey = "employee_id";
    
    protected $fillable = ['employee_id', 'name', 'age', 'gender', 'photo_id', 'zip_number' ,'pref', 'address',
    'department_id', 'hire_date', 'retire_date'];
    
    protected $guarded = ['employee_id', 'retire_date'];
    
    
    //利用上は部署テーブルが社員テーブルの親ということになる。
    // つまり、部署の下に社員が存在しているという関係です
    // 部署にはたくさんの社員がいる(部署 hasMany 社員の関係)
    // 社員はどこか１つの部署に所属している(社員 belongsTo 部署）
    // belongsTo設定  こっちが従テーブルです
    public function department()  // 単数形のメソッドにする
    {
        // return $this->belongsTo('App\Models\Department');
        return $this->belongsTo(Department::class,'department_id');
    }
    
    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_id');
    }
    
}
