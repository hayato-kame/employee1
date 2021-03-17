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
            // 参照される側のテーブルの項目はPRIMARY KEYでなくてはならない
           // こっちが主テーブルで、employeesが従テーブル
           $table->increments('id'); //you save this id in other tables  データ型を合わせる
            // incrementsメソッドは、UNSIGNED INTEGER主キーとして自動インクリメントの同等の列を作成します。
           
            $table->binary('photo_data');
            $table->string('mime_type')->nullable();
            $table->timestamps();
            
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
