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

            $table->string('employee_id', 30)->primary(); // 文字列の番号
                        
            $table->string('name', 50);
            $table->integer('age'); //integerの第二引数には入れないでください！
            // 入れたら、プライマリーキーとして登録されてしまいます。第二引数が0以外になると、true になってしまう, 第二引数のデフォルト値は、falseなので、
            // trueになると、おかしくなりますので
            $table->string('gender', 1); // 文字長を1に指定 　男  か　女
            
            $table->unsignedBigInteger('photo_id');  // 外部キーのフィールド
            // photos（主テーブル） と型を合わせてください
            //このunsignedBigIntegerメソッドは、UNSIGNED BIGINT同等の列を作成します。
            // photos（主テーブル）の  incrementsメソッドは、UNSIGNED INTEGER主キーとして自動インクリメントの同等の列を作成します。     
            $table->string('zip_number' ,20);
            $table->string('pref', 20);
            $table->string('address1', 100);
            $table->string('address2', 100);
            $table->string('address3', 100);

            // 部署テーブルの従テーブルだから ひとつの部署にに属するから単数形で書く データ型きちんと合わせる
            $table->string('department_id');  //　外部キーのフィールドdepartments文字列型
            $table->datetime('hire_date'); // 入社日
            $table->datetime('retire_date')->nullable(); // 退社日
            $table->timestamps();
            // 写真テーブルの従テーブルです 
            // 部署テーブルの従テーブルです
             // 外部キー制約 従テーブル側に書く
             $table->foreign('department_id')->references('department_id')->on('departments');


   // この後マイグレーションファイルを作って、一旦リレーションを無くした。
   // それから、再度マイグレーションファイルを作って、
   // リレーションの ->onDelete('cascade')  をつけた　これは、
        // 親テーブルのデータ一行分を削除すると、関連する子テーブルがあっても、
        // エラーにならないで、関連する子テーブルのデータも一緒に消去できるようになるというもの
        // ですから、親テーブルを削除するだけで、関連する子テーブルのデータも一行分削除できている
             $table->foreign('photo_id')->references('photo_id')->on('photos');
           
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
