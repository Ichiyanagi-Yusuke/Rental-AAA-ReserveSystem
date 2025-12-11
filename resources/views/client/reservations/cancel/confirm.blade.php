<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約キャンセルの確認</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4 text-red-600">予約キャンセルの確認</h1>

        <p class="mb-4">以下のご予約を取り消しますか？<br>この操作は取り消せません。</p>

        <div class="bg-gray-50 p-4 rounded mb-6 text-sm">
            <p><strong>予約番号:</strong> {{ $reservation->id }}</p>
            <p><strong>氏名:</strong> {{ $reservation->rep_last_name }} {{ $reservation->rep_first_name }} 様</p>
            <p><strong>来店日:</strong> {{ $reservation->visit_date->format('Y年m月d日') }}</p>
            <p><strong>時間:</strong> {{ $reservation->visit_time->format('H:i') }}</p>
            <p><strong>ゲレンデ:</strong> {{ $reservation->resort->name }}</p>
        </div>

        <form action="{{ route('client.reservation.cancel.destroy', ['token' => $reservation->token]) }}" method="POST">
            @csrf
            <div class="flex justify-between">
                <a href="{{ route('home') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    戻る
                </a>
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    onclick="return confirm('本当にキャンセルしますか？');">
                    予約をキャンセルする
                </button>
            </div>
        </form>
    </div>
</body>

</html>
