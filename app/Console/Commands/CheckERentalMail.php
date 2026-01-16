<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Services\ERental\ERentalService;
use Illuminate\Support\Facades\Log;

class CheckERentalMail extends Command
{
    /**
     * コマンド名（ターミナルで実行する際の名前）
     */
    protected $signature = 'erental:check-mail';

    /**
     * コマンドの説明
     */
    protected $description = 'Eレンタルの予約メールを確認して取り込みます';

    public function __construct(
        private ERentalService $service
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('メールサーバーに接続しています...');

        try {
            // .envの設定を使って接続
            $client = Client::account('default');
            $client->connect();

            // 受信トレイを取得
            $folder = $client->getFolder('INBOX');

            // 「未読」かつ「件名や本文に特定の文字が含まれる」メールを検索
            // ※ Eレンタルの送信元アドレスが決まっているなら ->from('reservation@e-rental.info') などを追加推奨
            $messages = $folder->query()
                ->unseen() // 未読のみ
                ->text('【ｅレンタル】でレンタル予約を受け付けました。 ') // 本文検索（誤検知防止のため調整してください）
                ->get();

            $this->info($messages->count() . ' 件の未読メールが見つかりました。');

            foreach ($messages as $message) {
                $subject = $message->getSubject();
                $this->info("処理中: {$subject}");

                // メール本文（テキスト形式）を取得
                $body = $message->getTextBody();

                try {
                    // サービスを使って解析・保存
                    $reservation = $this->service->importFromMailBody($body);

                    // 必要に応じて本予約テーブルへの反映もここで行うなら:
                    // $this->service->syncToMainTable($reservation);

                    $this->info(" -> 取込成功: ID {$reservation->id}");

                    // 処理成功したら「既読」フラグを立てる（次回取得しないように）
                    $message->setFlag('Seen');
                } catch (\Exception $e) {
                    $this->error(" -> 取込失敗: " . $e->getMessage());
                    Log::error("Eレンタル取込エラー: {$subject}", ['error' => $e->getMessage()]);

                    // エラーの場合は既読にしない（次回再トライ）か、
                    // 別フォルダに移動するなどの運用検討が必要です。
                }
            }

            $this->info('完了しました。');
        } catch (\Exception $e) {
            $this->error('接続エラー: ' . $e->getMessage());
            Log::error('IMAP接続エラー', ['error' => $e->getMessage()]);
        }
    }
}
