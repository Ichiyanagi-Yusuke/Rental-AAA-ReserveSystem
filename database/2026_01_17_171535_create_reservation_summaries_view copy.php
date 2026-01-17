<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW reservation_summaries AS
            
            -- 1. 既存システムの予約
            SELECT
                CONCAT('sys_', id) AS id,
                'system' AS source,
                id AS original_id,
                resort_id,
                visit_date,
                visit_time,
                CONCAT(rep_last_name, ' ', rep_first_name) AS rep_name,
                CONCAT(rep_last_name_kana, ' ', rep_first_name_kana) AS rep_kana,
                phone,
                email,
                
                -- ステータス系フラグ
                is_needs_confirmation,
                is_cancel_needs_confirmation,
                is_comment_checked,
                note,
                deleted_at,

                -- 利用者コメント確認待ちがあるか判定 (サブクエリ)
                (SELECT COUNT(*) FROM reservation_details 
                 WHERE reservation_details.reservation_id = reservations.id 
                 AND reservation_details.note IS NOT NULL 
                 AND reservation_details.note != ''
                 AND reservation_details.is_comment_checked = 0
                 AND reservation_details.deleted_at IS NULL
                ) > 0 AS has_guest_comment_issue,
                
                -- 人数
                (SELECT COUNT(*) FROM reservation_details 
                 WHERE reservation_details.reservation_id = reservations.id 
                 AND reservation_details.deleted_at IS NULL
                ) AS number_of_people,
                
                created_at
            FROM reservations
            -- WHERE deleted_at IS NULL  <-- 削除して、論理削除済みも取得できるようにする

            UNION ALL

            -- 2. Eレンタルの予約
            SELECT
                CONCAT('ext_', id) AS id,
                'external' AS source,
                id AS original_id,
                1 AS resort_id, -- デフォルト値
                visit_date,
                visit_time,
                rep_name,
                rep_kana,
                phone,
                email_pc AS email,
                
                -- Eレンタルにはまだ以下のフラグ機能がないため、0(False)またはコメントを割り当て
                0 AS is_needs_confirmation,
                0 AS is_cancel_needs_confirmation,
                is_comment_checked,
                comment AS note, -- comment を note として扱う
                deleted_at,
                
                0 AS has_guest_comment_issue, -- Eレンタルは一旦対象外
                
                number_of_people,
                created_at
            FROM e_rental_reservations
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS reservation_summaries");
    }
};
