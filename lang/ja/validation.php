<?php

return [

    'required' => ':attribute は必須項目です。',
    'string'   => ':attribute は文字列で入力してください。',
    'integer'  => ':attribute は整数で入力してください。',
    'min' => [
        'numeric' => ':attribute は :min 以上を入力してください。',
        'integer' => ':attribute は :min 以上を入力してください。',
    ],
    'max' => [
        'string' => ':attribute は :max 文字以内で入力してください。',
    ],
    'boolean' => ':attribute の値が正しくありません。',
    'unique'  => 'この :attribute は既に使用されています。',

    // グローバルに使っても違和感ないものだけを書く
    'attributes' => [
        'name'     => '名称',          // 汎用的な「名称」にしておく
        'email'    => 'メールアドレス',
        'password' => 'パスワード',
        // ※ リゾート専用の日本語はここでは書かない
    ],

];
