<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Photo;


class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 注意  親テーブルなので、子テーブルと同じだけのデータが必要です。なので、12 です
         for ($i = 0; $i < 12; $i++) {  // 子テーブルのデータ数のループ回数にする
             $param = [
                 'photo_data' => null,
                 'mime_type' => null,
             ];
             $photo = new Photo();
             $photo->fill($param)->save();
         }

    }
}
