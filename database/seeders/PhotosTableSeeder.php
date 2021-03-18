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
         for ($i = 0; $i < 3; $i++) {
             $param = [
                 'photo_data' => null,
                 'mime_type' => null,
             ];
             $photo = new Photo();
             $photo->fill($param)->save();
         }

    }
}
