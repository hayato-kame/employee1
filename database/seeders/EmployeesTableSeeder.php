<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use DateTime;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 注意　子テーブル側なので、親テーブルphotosに、同じ数だけデータが必要です。
        // データの整合性を保つ外部キーは、
// 子テーブルを登録する時に親テーブルにキーが存在するかチェックして、子テーブルにテテナシ子状態のデータが登録されるのを排除する機能です。

        $param = [
            'employee_id' => 'EMP0001',
            'name' => '山田　太郎',
            'age' => 35,
            'gender' => '男',
            'photo_id' => 1,
            'zip_number' => '100-0001',
            'pref' => '東京都',
            'address1' => '千代田区',
            'address2' => '千代田',
            'address3' => 'ちよだ',
            'department_id' => 'D01',
            'hire_date' => '2000-11-11',
            'retire_date' => null,
        ];
        $employee = new Employee();
        $employee->fill($param)->save();

        $param = [
            'employee_id' => 'EMP0002',
            'name' => '日本 花子',
            'age' => 27,
            'gender' => '女',
            'photo_id' => 2,
            'zip_number' => '330-0841',
            'pref' => '埼玉県',
            'address1' => 'さいたま市',
            'address2' => '大宮区',
            'address3' => '東町',
            'department_id' => 'D03',
            'hire_date' => '1999-01-01',
            'retire_date' => '2003-03-03',
        ];
        $employee = new Employee();
        $employee->fill($param)->save();


        $param = [
            'employee_id' => 'EMP0003',
            'name' => '東京 次郎',
            'age' => 41,
            'gender' => '男',
            'photo_id' => 3,
            'zip_number' => '251-0013',
            'pref' => '神奈川県',
            'address1' => '川崎市',
            'address2' => '麻生区',
            'address3' => '王禅寺',
            'department_id' => 'D03',
            'hire_date' => '1998-12-12',
            'retire_date' => null,
        ];
        $employee = new Employee();
        $employee->fill($param)->save();


        // 9人分作成追加  合計12人作ったから、ここは子テーブルだから、
        // 親テーブルのphotos にも、12データ無いと、親テーブル photos の id に その番号 が登録されていない、って怒られます。

        $fnames = ["伊藤", "山本", "中村", "小林"];
        $gnames = ["三郎", "四郎", "友子"]; 
        $prefArray = ["東京都", "千葉県", "茨城県", "神奈川県"];
        $departmentIdArray = ["D01", "D02", "D03"];

        
        
        // 注意 シングルクオーテーションで囲んだ文字列の中で変数を記述しても変数展開は行われません
        // $i = 1  から始めてます 0から始めていませんので注意！剰余算で使ってるから
        for($i = 1; $i <= 9; $i++) {
            // 文字列型でいい
            $str_employee_id = sprintf("EMP%04d", ($i + 3) );
            
            // ループの度に、ランダムな数の１か２を取得する
            // $randomInt = random_int(1 , 2);
            //  === で厳密な比較にしてください
            // $gender = $randomInt === 1 ? '男' : '女';
            if ($gnames[$i % 3] === 2 ) {
                $gender = '女';
            } else {
                $gender = '男';
            }


            // 文字列でいい string型
            $str_zip_number = sprintf("%03d", $i*100 ) . '-' . sprintf("%03d", $i*1000 );
            
            // string型にすること こちらでもいいかもしれない
            // $str_zip_number = sprintf("%03d-%04d", $i*100 , $i*1000 );

            $randomAddress = $this->getRandomHiragana(5);

            $date = new DateTime();
            $date = date_format($date, 'Y-m-d');
            
            DB::table('employees')->insert([
                'employee_id' => $str_employee_id,
                'name' => "{$fnames[$i % 4]}" . " " . "{$gnames[$i % 3]}" ,
                'age' => random_int(18 , 101),
                'gender' => $gender,
                'photo_id' => $i + 3,   // 子テーブルの外部キーフィールドに入れてはだめ
                'zip_number' =>   $str_zip_number,
                'pref' => "{$prefArray[$i % 4]}",
                'address1' => $randomAddress,
                'address2' => $randomAddress,
                'address3' => $randomAddress,
                'department_id' => "{$departmentIdArray[$i % 3]}",
                // 'email' => 'aaa' . $i . '@example.com',
                // 'password' => Hash::make('password'. $i),
              

                'hire_date' => $date,
                'retire_date' => $date,
                ]);
            }
            
            
        }
        //ひらがな - ランダム文字列
    public function getRandomHiragana($length = 5) {
        $hiragana = ["ぁ","あ","ぃ","い","ぅ","う","ぇ","え","ぉ","お",
            "か","が","き","ぎ","く","ぐ","け","げ","こ","ご",
            "さ","ざ","し","じ","す","ず","せ","ぜ","そ","ぞ",
            "た","だ","ち","ぢ","っ","つ","づ","て","で","と","ど",
            "な","に","ぬ","ね","の","は","ば","ぱ",
            "ひ","び","ぴ","ふ","ぶ","ぷ","へ","べ","ぺ","ほ","ぼ","ぽ",
            "ま","み","む","め","も","ゃ","や","ゅ","ゆ","ょ","よ",
            "ら","り","る","れ","ろ","ゎ","わ","ゐ","ゑ","を","ん"];
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $hiragana[rand(0, count($hiragana) - 1)];
        }
        return $r_str;
    }
    }
