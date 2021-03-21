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
    
    protected $fillable = ['photo_data', 'mime_type'];
    protected $guarded = ['photo_id', 'mime_type' , 'photo_data'];  // 自動採番 後から変更もしない

  
    // hasOne設定　こっちが主テーブルです
    public function employee()  //単数形のメソッドにする一人の人との関係を持ってるから
    {
        // return $this->hasOne('App\Models\Employee');
        return $this->hasOne(Employee::class, 'employee_id'); // 第二引数外部キー
    }

    // バリデーションのルール 'file' アップロードされたファイルであること
    // 'image'  画像ファイルであること  mimes  MIMEタイプ指定
    public static $rules = [
        'photo_data' => [ 'nullable','file', 'image', 'mimes:jpeg, png, jpg' ],
    ];

    // エラーメッセージ
    public static $messages = [
        'photo_data.file' => '画像ファイルを選んでください',
        'photo_data.image' => '画像ファイルを選んでください',
        'photo_data.mimes' => '画像ファイルは、jpeg png jpg のいずれかにして下さい',
        
    ];

}
