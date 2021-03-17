<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            
            // カラム名の命名規則はスネークケースかつ単数形
            // 主キーが文字列のID
            $table->string('employee_id', 30); // 文字列の番号
            
            
            $table->string('name', 50);
            $table->integer('age'); //integerの第二引数には入れないでください！
            
            $table->string('gender', 1);  // 文字長を1に指定 　男  か　女
            
            $table->unsignedInteger('photo_id');  // photos（従テーブル） 
            // photos（従テーブル） と型を合わせてください
            // photos（従テーブル）の  incrementsメソッドは、UNSIGNED INTEGER主キーとして自動インクリメントの同等の列を作成します。     
            $table->string('zip_number' ,20);
            $table->string('pref', 20);
            $table->string('address', 100);

            // 部署テーブルの従テーブルだから ひとつの部署にに属するから単数形で書く データ型きちんと合わせる
            $table->string('department_id');  //　departments（従テーブル)文字列型のID
            $table->datetime('join_date');
            $table->datetime('retire_date');
            $table->timestamps();
            // 写真テーブルの主テーブルです 部署テーブルの従テーブルです
            // 参照される側のテーブルの項目はPRIMARY KEYでなくてはならない
            $table->primary(['employee_id', 'photo_id']);  

             // 外部キー制約 従テーブル側に書く
             $table->foreign('department_id')->references('department_id')->on('departments');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
