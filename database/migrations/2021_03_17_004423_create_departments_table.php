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
            $table->string('department_id', 20)->primary(); // 文字列の部署名
            
            // こちらから見たら、沢山の従業員と関連するから複数形でかく??
            $table->string('employees_id');   // データ型を合わせる

            $table->string('department_name', 20);
            $table->timestamps();

            // 外部キー制約
            $table->foreign('employees_id')->references('employee_id')->on('employees');
            
            
            // 外部キー制約 データ型を合わせないとエラー  
            // 文字列型で合わせないとだめだから、
            // これは　中間テーブルの書き方にしないとだめだね
            
            $table->foreign('department_id')->references('department_id')->on('employees');
            
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
