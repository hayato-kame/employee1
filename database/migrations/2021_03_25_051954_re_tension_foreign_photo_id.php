<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReTensionForeignPhotoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // すでに解除した外部キー制約を、もう一度付け直す->onDelete('cascade') をつけたかった
        //   photos親テーブルの写真データを消すと、紐づいているemployees子テーブルのemployeeのデーターも同時に消すようにする
        Schema::table('employees', function (Blueprint $table) {
        $table->foreign('photo_id')->references('photo_id')->on('photos')->onDelete('cascade');
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
        //  dropForeign('子テーブル名_外部キー制約をつけたフィールド名_foreign') と書く
        Schema::table('employees', function (Blueprint $table) {
        $table->dropForeign('employees_photo_id_foreign');
          });
    }
}
