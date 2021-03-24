<?php

namespace App\Exceptions;

use Exception;

class DeleteException extends Exception
{
    // 独自に作成した例外クラス
    // php artisan make:exception DeleteException というcommandで作成できる
    
    public function __construct(Request $request, array $message)
    {
        $this->request = $request;
        // 複数のバリデーションエラー時には , で区切る
        $this->message = implode(',', $message);
    }

    // レスポンスとして返したい内容を設定している
    public function render()
    {
        return response()->json(
            $this->message,
            422
        );
    }
}
