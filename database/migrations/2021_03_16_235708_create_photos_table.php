<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            // カラム名の命名規則はスネークケースかつ単数形
             // 主テーブルでプライマリーキー設定してあって、自動で番号を振るから、
             // こっち従テーブルでは、自動採番しないようにする
            $table->unsignedInteger('photo_id')->primary();  //  外部キーのカラム こっち従テーブル
            // incrementsメソッドは、UNSIGNED INTEGER主キーとして自動インクリメントの同等の列を作成します。
           // だから、主テーブルのphoto_idのデータ型は、unsignedInteger

            // データ型を合わせる  従テーブル側に書く
            $table->string('employee_id');  // 関連するのは単数形だからフィールド名は単数形で書く
           
            $table->binary('photo_data');
            $table->string('mime');
            $table->timestamps();

            // 外部キー制約は、データの整合性のために

           
            // 外部キー制約  従テーブル側で書く　データ型を合わせる
            // 参照される側のテーブルの項目はPRIMARY KEYでなくてはならない
            // このテーブルのphoto_idカラムと employeesテーブルのphoto_idカラムと関連づけてる
            //  ->onDelete('cascade') をつけたらだめ　写真を変更するかもしれないから　写真だけを削除できるようにする
            
            $table->foreign('employee_id')->references('employee_id')->on('employees');
            $table->foreign('photo_id')->references('photo_id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
