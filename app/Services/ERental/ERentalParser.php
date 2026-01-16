<?php

namespace App\Services\ERental;

use Carbon\Carbon;

class ERentalParser
{
    /**
     * 新フォーマットのメール本文を解析して構造化データを返す
     */
    public function parse(string $mailBody): array
    {
        return [
            'header' => $this->parseHeader($mailBody),
            'details' => $this->parseDetails($mailBody),
        ];
    }

    private function parseHeader(string $body): array
    {
        $data = [];
        $s = '[\s　]*';

        if (preg_match('/予約番号：' . $s . '(\d+)/u', $body, $m)) {
            $data['reservation_number'] = $m[1];
        }

        if (preg_match('/予約受付日時：' . $s . '(.+?)[\r\n]/u', $body, $m)) {
            $data['reception_at'] = $this->parseDateString($m[1]);
        }

        if (preg_match('/受取予定日時：' . $s . '(.+?)[\r\n]/u', $body, $m)) {
            $dtStr = str_replace('頃', '', trim($m[1]));
            $carbon = $this->parseDateString($dtStr);
            if ($carbon) {
                $data['visit_date'] = $carbon->format('Y-m-d');
                $data['visit_time'] = $carbon->format('H:i:s');
            }
        }

        if (preg_match('/レンタル期間：' . $s . '(\d+)' . $s . '日間/u', $body, $m)) {
            $data['rental_days'] = (int)$m[1];
        }

        if (preg_match('/申込代表者名：' . $s . '(.+?)' . $s . '様' . $s . '（(.+?)）/u', $body, $m)) {
            $data['rep_name'] = trim($m[1]);
            $data['rep_kana'] = trim($m[2]);
        }

        if (preg_match('/住所：' . $s . '(.+?)[\r\n]/u', $body, $m)) {
            $data['address'] = trim($m[1]);
        }

        if (preg_match('/電話番号：' . $s . '([\d\-]+)/u', $body, $m)) {
            $data['phone'] = $m[1];
        }

        if (preg_match('/メールアドレス：' . $s . '([a-zA-Z0-9@\._\-\+]+)/u', $body, $m)) {
            $data['email_pc'] = trim($m[1]);
        }

        if (preg_match('/備考：(.*?)(?=\n-{10,}|$)/s', $body, $m)) {
            $data['comment'] = trim($m[1]);
        }

        if (preg_match('/レンタル料金合計（税込）：' . $s . '￥([\d,]+)/u', $body, $m)) {
            $data['total_price'] = (int)str_replace(',', '', $m[1]);
        }

        if (preg_match_all('/【\d+人目】/u', $body, $matches)) {
            $data['number_of_people'] = count($matches[0]);
        } else {
            $data['number_of_people'] = 1;
        }

        return $data;
    }

    private function parseDetails(string $body): array
    {
        $details = [];
        $s = '[\s　]*';

        // 区切り線でブロック分割
        $blocks = preg_split('/-{10,}/', $body);

        foreach ($blocks as $block) {
            if (!preg_match('/【\d+人目】/', $block)) {
                continue;
            }

            $item = [];

            // -----------------------------------------------------
            // 各属性の抽出（ブロック全体から正規表現で探す）
            // -----------------------------------------------------
            if (preg_match('/お名前：' . $s . '(.+?)[\s　\r\n]/u', $block, $m)) {
                // 名前はお名前：の直後から、空白か改行が来るまでを取得
                $item['guest_name'] = trim($m[1]);
            }

            if (preg_match('/性別：' . $s . '(.+?)' . $s . '(?:年齢|体重|$)/u', $block, $m)) {
                $item['gender'] = trim($m[1]);
            }

            if (preg_match('/年齢：' . $s . '(\d+)歳/u', $block, $m)) {
                $item['age'] = (int)$m[1];
            }

            if (preg_match('/体重：' . $s . '(\d+)kg/u', $block, $m)) {
                $item['weight'] = (int)$m[1];
            }

            if (preg_match('/身長：' . $s . '(\d+)cm/u', $block, $m)) {
                $item['height'] = (int)$m[1];
            }

            if (preg_match('/足のサイズ：' . $s . '([\d\.]+)cm/u', $block, $m)) {
                $item['foot_size'] = (float)$m[1];
            }

            if (preg_match('/スタンス：' . $s . '(.+?)[\r\n]/u', $block, $m)) {
                $item['stance'] = trim($m[1]);
            }

            // -----------------------------------------------------
            // 行ごとの解析（アイテムテキストと小計の分離）
            // -----------------------------------------------------
            $lines = preg_split('/\r\n|\r|\n/', trim($block));
            $itemLines = [];

            foreach ($lines as $line) {
                // 行の前後の空白（全角含む）を除去
                $line = preg_replace('/^[\s　]+|[\s　]+$/u', '', $line);

                if ($line === '') continue;
                if (str_contains($line, '【')) continue; // ヘッダー行スキップ

                // ★小計の抽出処理 (ここを変更)
                // 行の中に「小計 … ￥xxxx」があれば金額を抜き出し、その部分だけを行から削除する
                if (preg_match('/小計' . $s . '…' . $s . '￥([\d,]+)/u', $line, $m)) {
                    $item['subtotal_price'] = (int)str_replace(',', '', $m[1]);

                    // 小計部分を空文字に置換して消す
                    $line = preg_replace('/小計' . $s . '…' . $s . '￥[\d,]+/u', '', $line);
                    // 再度トリム
                    $line = preg_replace('/^[\s　]+|[\s　]+$/u', '', $line);
                }

                // 残った行が属性行であればスキップ
                // 「お名前：」や「性別：」などが残っている行はアイテムではない
                if (
                    preg_match('/^(お名前：|氏名：)/u', $line) ||
                    preg_match('/(性別：|年齢：|身長：|体重：|足のサイズ：|スタンス：)/u', $line) ||
                    preg_match('/様' . $s . '性別：/u', $line) // 「様 性別：」のようなパターンも除外
                ) {
                    continue;
                }

                // 空になっていなければ、それはアイテム情報とみなす
                if ($line !== '') {
                    $itemLines[] = $line;
                }
            }

            $item['items_text'] = implode("\n", $itemLines);

            if (!empty($item['guest_name'])) {
                $details[] = $item;
            }
        }

        return $details;
    }

    private function parseDateString(string $dateStr): ?Carbon
    {
        try {
            $str = str_replace(['年', '月', '日', '時', '分'], ['-', '-', ' ', ':', ''], trim($dateStr));
            return Carbon::parse($str);
        } catch (\Exception $e) {
            return null;
        }
    }
}
