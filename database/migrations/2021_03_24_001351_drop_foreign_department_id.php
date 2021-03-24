<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignDepartmentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // すでに付いている外部キー制約を解除したい
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_department_id_foreign');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // up() とは　逆の内容を書く
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('department_id')->references('department_id')->on('departments');
          });
    }
}
