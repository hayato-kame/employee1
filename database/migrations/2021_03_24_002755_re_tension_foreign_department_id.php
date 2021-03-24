<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReTensionForeignDepartmentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // すでに解除した外部キー制約を、もう一度付け直す ->onDelete('restrict') をつけたかった
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('restrict');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // up() とは逆の内容を書けばいい
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_department_id_foreign');
          });
    }
}
