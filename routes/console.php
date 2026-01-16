<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule; // 追加

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Eレンタルのメールチェックを10分ごとに実行
// (必要に応じて ->hourly() や ->everyMinute() に変更可能です)
Schedule::command('erental:check-mail')
    // ->everyTenMinutes()
    ->everyMinute()
    ->withoutOverlapping(); // 前回の処理が終わっていなければ実行しない（重複防止）