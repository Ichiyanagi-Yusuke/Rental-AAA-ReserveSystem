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
                CONCAT('sys_', id) COLLATE utf8mb4_unicode_ci AS id,
                'system' COLLATE utf8mb4_unicode_ci AS source,
                id AS original_id,
                CAST(id AS CHAR) COLLATE utf8mb4_unicode_ci AS reservation_number,
                resort_id,
                visit_date,
                visit_time,
                CONCAT(rep_last_name, ' ', rep_first_name) COLLATE utf8mb4_unicode_ci AS rep_name,
                CONCAT(rep_last_name_kana, ' ', rep_first_name_kana) COLLATE utf8mb4_unicode_ci AS rep_kana,
                phone COLLATE utf8mb4_unicode_ci AS phone,
                email COLLATE utf8mb4_unicode_ci AS email,
                
                -- ステータス系フラグ
                is_needs_confirmation,
                is_cancel_needs_confirmation,
                is_comment_checked,
                note COLLATE utf8mb4_unicode_ci AS note,
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
            -- WHERE deleted_at IS NULL -- 論理削除済みも含める

            UNION ALL

            -- 2. Eレンタルの予約
            SELECT
                CONCAT('ext_', id) COLLATE utf8mb4_unicode_ci AS id,
                'external' COLLATE utf8mb4_unicode_ci AS source,
                id AS original_id,
                -- reservation_number が数値型の場合に備えてCASTし、Collationを適用
                CAST(reservation_number AS CHAR) COLLATE utf8mb4_unicode_ci AS reservation_number,
                1 AS resort_id, -- デフォルト値
                visit_date,
                visit_time,
                rep_name COLLATE utf8mb4_unicode_ci,
                rep_kana COLLATE utf8mb4_unicode_ci,
                phone COLLATE utf8mb4_unicode_ci,
                email_pc COLLATE utf8mb4_unicode_ci AS email,
                
                -- Eレンタルにはまだ以下のフラグ機能がないため、0(False)またはコメントを割り当て
                0 AS is_needs_confirmation,
                0 AS is_cancel_needs_confirmation,
                is_comment_checked,
                comment COLLATE utf8mb4_unicode_ci AS note, -- comment を note として扱う
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
