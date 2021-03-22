<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
           $table->bigIncrements('photo_id'); // データ型を合わせる
            // このbigIncrementsメソッドは、自動インクリメントUNSIGNED BIGINT（主キー）に相当する列を作成します。
            // だから、従テーブルのemployeesでは、unsignedBigIntegerメソッドを使ってください
            
            // 変更あり！！ここでは、Blob型は書かないでください
            // $table->binary('photo_data')->nullable();

            $table->string('mime_type')->nullable();
            $table->timestamps();        
        });

        
        // 推奨されないわけです。大きすぎて無理  登録するときには、小さい画像にしてください
        // ここで　書いてくださいMEDIUMBLOB　じゃないと、保存できないからです
        DB::statement("ALTER TABLE photos ADD photo_data MEDIUMBLOB");
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
