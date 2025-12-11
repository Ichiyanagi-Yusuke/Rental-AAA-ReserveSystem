<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約キャンセル完了</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow text-center">
        <h1 class="text-xl font-bold mb-4">キャンセル完了</h1>
        <p class="mb-6">ご予約の取り消しが完了しました。<br>確認メールを送信しました。</p>

        <a href="{{ route('home') }}" class="text-blue-500 hover:underline">トップページへ戻る</a>
    </div>
</body>

</html>
