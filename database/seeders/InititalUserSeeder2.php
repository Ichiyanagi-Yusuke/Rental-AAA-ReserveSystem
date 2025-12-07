<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'システム管理者',
                'email' => 'admin@rental-aaa.jp',
                'password' => 'Ma4dQryibbam',
                'role' => 0,
            ],
            [
                'name' => '一柳 優介',
                'email' => 'y.ichiyanagi@rental-aaa.jp',
                'password' => '486MNePdNcnJ',
                'role' => 0,
            ],
            [
                'name' => '山下 謙吾',
                'email' => 'yamashita.kengo@rental-aaa.jp',
                'password' => 'f9HgabNh7uLC',
                'role' => 1,
            ],
            [
                'name' => '出口 友二郎',
                'email' => 'y.deguchi@rental-aaa.jp',
                'password' => 'YyXpiQMgSt4A',
                'role' => 1,
            ],
            [
                'name' => '山下 優貴',
                'email' => 'y.yuki@rental-aaa.jp',
                'password' => 'KLiRmhYdzQ8w',
                'role' => 1,
            ],
            [
                'name' => '山下 沙代菜',
                'email' => 'y.sayona@rental-aaa.jp',
                'password' => 'a3LrDWUWKkFi',
                'role' => 2,
            ],
            [
                'name' => '山下 萌結',
                'email' => 'y.moyu@rental-aaa.jp',
                'password' => 'tYLzUCimhMCH',
                'role' => 2,
            ],
            [
                'name' => '山下 大誠',
                'email' => 'y.taisei@rental-aaa.jp',
                'password' => 'kibUrS95iMy2',
                'role' => 2,
            ],
            [
                'name' => '山下 あやの',
                'email' => 'y.ayano@rental-aaa.jp',
                'password' => 'CAPWdsKzn4jz',
                'role' => 2,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']], // メールアドレスで一意
                [
                    'name'     => $data['name'],
                    'password' => Hash::make($data['password']), // ★必ずハッシュ化
                    'role'     => $data['role'],
                ]
            );
        }

    }
}
