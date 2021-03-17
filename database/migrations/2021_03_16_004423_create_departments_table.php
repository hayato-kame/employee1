<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) { // テーブル名は複数形の小文字
            // カラム名の命名規則はスネークケースかつ単数形
           // 主キーが文字列
           // 従業員テーブルから見たらこっちが主テーブルです  
         // 参照される側のテーブルの項目はPRIMARY KEYでなくてはならない
            $table->string('department_id', 20)->primary(); // 文字列の部署名

            $table->string('department_name', 20);
            // timestampsを利用しないことにする
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
