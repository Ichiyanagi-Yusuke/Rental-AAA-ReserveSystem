<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>代表者情報の編集 | RENTAL AAA</title>
    <style>
        /* 共通スタイル */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding: 0;
        }

        .main-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            min-height: 100vh;
        }

        .logo-section {
            padding: 2rem 1rem;
            text-align: center;
            border-bottom: 3px solid #e63946;
            position: relative;
        }

        .logo-section::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: #ffffff;
        }

        .logo-section img {
            max-width: 300px;
            width: 100%;
            height: auto;
        }

        .logo-section h4 {
            color: #1a1a1a;
            font-weight: 700;
            letter-spacing: 0.1em;
            margin-top: 1rem;
            font-size: 1.5rem;
        }

        .form-wrapper {
            background: #fafafa;
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            color: #2d2d2d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 0.5rem;
            border: none;
            border-bottom: 2px solid #e5e5e5;
            background: #f8f8f8;
            font-size: 1rem;
            color: #1a1a1a;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-bottom: 2px solid #e63946;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
            border: 1px solid #e5e5e5;
            padding: 0.75rem;
        }

        textarea.form-control:focus {
            border: 1px solid #e63946;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232d2d2d' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            padding-right: 2rem;
        }

        .error-msg {
            color: #e63946;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            display: block;
            font-weight: 600;
        }

        .button-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            border-top: 2px solid #e5e5e5;
            background: #ffffff;
        }

        .btn {
            padding: 1rem 3rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
            border: none;
            transition: all 0.3s;
        }

        .btn-submit {
            background: #e63946;
            color: #ffffff;
        }

        .btn-submit:hover {
            background: #d62839;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(230, 57, 70, 0.4);
        }

        .btn-back {
            background: #ffffff;
            color: #1a1a1a;
            border: 2px solid #2d2d2d;
        }

        .btn-back:hover {
            background: #2d2d2d;
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .form-wrapper {
                padding: 1.5rem;
            }

            .button-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-section">
            <img src="{{ asset('images/client/header-logo.png') }}" alt="ロゴ">
            <h4>代表者情報の編集</h4>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('client.reservation.edit.header.update') }}" method="post">
                @csrf

                <div class="form-group">
                    <label>姓</label>
                    <input type="text" class="form-control" name="rep_last_name"
                        value="{{ old('rep_last_name', $reservation->rep_last_name) }}" required>
                    @error('rep_last_name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>セイ</label>
                    <input type="text" class="form-control" name="rep_last_name_kana"
                        value="{{ old('rep_last_name_kana', $reservation->rep_last_name_kana) }}" required>
                    @error('rep_last_name_kana')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>名</label>
                    <input type="text" class="form-control" name="rep_first_name"
                        value="{{ old('rep_first_name', $reservation->rep_first_name) }}" required>
                    @error('rep_first_name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>メイ</label>
                    <input type="text" class="form-control" name="rep_first_name_kana"
                        value="{{ old('rep_first_name_kana', $reservation->rep_first_name_kana) }}" required>
                    @error('rep_first_name_kana')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>電話番号</label>
                    <input type="tel" class="form-control" name="phone"
                        value="{{ old('phone', $reservation->phone) }}" required>
                    @error('phone')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>メールアドレス</label>
                    <input type="email" class="form-control" name="email"
                        value="{{ old('email', $reservation->email) }}" required>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>来店予定日</label>
                    {{-- Reservationモデルのvisit_dateはDateキャストされている前提 --}}
                    <input type="date" class="form-control" name="visit_date"
                        value="{{ old('visit_date', $reservation->visit_date ? $reservation->visit_date->format('Y-m-d') : '') }}"
                        required>
                    @error('visit_date')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>来店予定時刻</label>
                    {{-- Reservationモデルのvisit_timeはDatetimeキャストされている前提 --}}
                    <input type="time" class="form-control" name="visit_time"
                        value="{{ old('visit_time', $reservation->visit_time ? $reservation->visit_time->format('H:i') : '') }}"
                        required>
                    @error('visit_time')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>返却予定日</label>
                    <input type="date" class="form-control" name="return_date"
                        value="{{ old('return_date', $reservation->return_date ? $reservation->return_date->format('Y-m-d') : '') }}"
                        required>
                    @error('return_date')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>ゲレンデ選択</label>
                    <select class="form-control" name="resort_id" required>
                        <option value="">選択してください</option>
                        @foreach ($resorts as $resort)
                            <option value="{{ $resort->id }}"
                                {{ old('resort_id', $reservation->resort_id) == $resort->id ? 'selected' : '' }}>
                                {{ $resort->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('resort_id')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>その他ご要望</label>
                    <textarea class="form-control" name="note" placeholder="ご要望があればご記入ください">{{ old('note', $reservation->note) }}</textarea>
                    @error('note')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="button-container">
                    <a href="{{ route('client.reservation.edit.menu') }}" class="btn btn-back">戻る</a>
                    <button type="submit" class="btn btn-submit">保存して戻る</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
