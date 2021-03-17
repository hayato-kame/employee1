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
             //主キー

            $table->increments('photo_id');  // employees（主テーブル） 外部キーのカラム
            // incrementsメソッドは、UNSIGNED INTEGER主キーとして自動インクリメントの同等の列を作成します。
           
            // データ型を合わせる
            $table->string('employee_id');  // 関連するのは単数形だから単数形で書く
           
            $table->binary('photo_data');
            $table->string('mime');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');

            // 外部キー制約  従テーブル側で書く　データ型を合わせる
            // 参照される側のテーブルの項目はPRIMARY KEYでなくてはならない
            // このテーブルのphoto_idカラムと employeesテーブルのphoto_idカラムと関連づけてる ->onDelete('cascade')

            
            // これは中間てーぶるの書き方にしないとダメ

            $table->foreign('photo_id')->references('photo_id')->on('employees')->onDelete('cascade');
            
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
