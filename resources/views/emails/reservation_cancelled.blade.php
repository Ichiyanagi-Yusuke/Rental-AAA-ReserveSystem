<!DOCTYPE html>
<html lang="ja">

<body>
    <p>{{ $reservation->rep_last_name }} {{ $reservation->rep_first_name }} 様</p>
    <p>レンタルトリプルエーです。</p>
    <p>以下のご予約のキャンセルを承りました。</p>
    <hr>
    <p>予約番号: {{ $reservation->build_number }}</p>
    <p>来店日時: {{ $reservation->visit_date->format('Y-m-d') }} {{ $reservation->visit_time->format('H:i') }}</p>
    <hr>
    <p>またのご利用をお待ちしております。</p>
</body>

</html>
