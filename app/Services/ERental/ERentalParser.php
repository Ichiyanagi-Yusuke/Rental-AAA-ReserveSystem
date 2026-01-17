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
        $s = '[\s　]*'; // 空白文字（全角・半角・改行マッチ用ではない）

        // 区切り線でブロック分割
        $blocks = preg_split('/-{10,}/', $body);

        foreach ($blocks as $block) {
            // 【N人目】が含まれないブロックは無視
            if (!preg_match('/【\d+人目】/', $block)) {
                continue;
            }

            $item = [];

            // =========================================================
            // 1. 小計 (Subtotal) を先にブロック全体から抜き出す
            // =========================================================
            // "s"修飾子をつけることで、途中に改行があってもマッチするようにします
            if (preg_match('/小計.*?￥([\d,]+)/us', $block, $m)) {
                $item['subtotal_price'] = (int)str_replace(',', '', $m[1]);

                // 抜き出した小計部分をブロックから削除する
                // (置換して消すことで、後続のアイテム判定処理に混ざらないようにする)
                $block = str_replace($m[0], '', $block);
            }

            // =========================================================
            // 2. 各属性の抽出
            // =========================================================
            if (preg_match('/お名前：' . $s . '(.+?)[\s　\r\n]/u', $block, $m)) {
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

            // =========================================================
            // 3. アイテム行の解析
            // =========================================================

            // 全角スペースを改行に変換して、アイテムを分離しやすくする
            $block = str_replace('　', "\n", $block);

            // 改行で分割して配列化
            $lines = preg_split('/\r\n|\r|\n/', $block);
            $itemLines = [];

            foreach ($lines as $line) {
                // 前後の空白除去
                $line = preg_replace('/^[\s　]+|[\s　]+$/u', '', $line);

                // 空行やヘッダー行はスキップ
                if ($line === '' || str_contains($line, '【')) {
                    continue;
                }

                // 属性行（お名前、性別など）を強力に除外
                if (
                    preg_match('/^(お名前：|氏名：)/u', $line) ||
                    preg_match('/(性別：|年齢：|身長：|体重：|足のサイズ：|スタンス：)/u', $line) ||
                    // 「様」だけの行、または「様」で始まる行を除外
                    $line === '様' ||
                    preg_match('/^様[\s　]*$/u', $line)
                ) {
                    continue;
                }

                // 小計はすでにステップ1で除去済みなので、ここには残っていないはずだが、
                // 万が一「小計」という文字単体だけ残っていた場合のためにチェック
                if (str_contains($line, '小計')) {
                    continue;
                }

                // ここまで残ったものはアイテムとみなす
                $itemLines[] = $line;
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
