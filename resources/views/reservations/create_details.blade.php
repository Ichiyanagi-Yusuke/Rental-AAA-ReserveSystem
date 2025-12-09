<x-app-layout>
    @php
        $repLast = $header['rep_last_name'] ?? '';
        $repFirst = $header['rep_first_name'] ?? '';
        $repLastK = $header['rep_last_name_kana'] ?? '';
        $repFirstK = $header['rep_first_name_kana'] ?? '';
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約利用者情報の入力
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6" x-data="reservationDetails()">

            {{-- フラッシュメッセージ --}}
            @if (session('status'))
                <div class="p-3 rounded-md bg-blue-50 border border-blue-200 text-sm text-blue-800">
                    {{ session('status') }}
                </div>
            @endif

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="p-3 rounded-md bg-red-50 border border-red-200 text-sm text-red-800">
                    <p class="font-semibold mb-1">入力内容にエラーがあります。</p>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 代表者情報 --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">代表者情報</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-700">
                    <div>
                        <span class="text-gray-500">お名前：</span>
                        <span>{{ $repLast }} {{ $repFirst }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">フリガナ：</span>
                        <span>{{ $repLastK }} {{ $repFirstK }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">電話番号：</span>
                        <span>{{ $header['phone'] ?? '' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">メールアドレス：</span>
                        <span>{{ $header['email'] ?? '' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">来店日：</span>
                        <span>{{ $header['visit_date'] ?? '' }} {{ $header['visit_time'] ?? '' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">返却予定日：</span>
                        <span>{{ $header['return_date'] ?? '' }}</span>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('reservations.create.header') }}"
                        class="text-sm text-indigo-600 hover:underline">
                        代表者情報を修正する
                    </a>
                </div>
            </div>

            {{-- 利用者入力フォーム --}}
            <form method="POST" action="{{ route('reservations.store.details') }}"
                class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6 space-y-4">
                @csrf

                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold text-gray-800">利用者情報</h3>

                    <button type="button" @click="addGuest()"
                        class="inline-flex items-center px-3 py-1.5 rounded-md border border-indigo-300 text-sm text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                        利用者を追加
                    </button>
                </div>

                {{-- 利用者ごとのカード --}}
                <template x-for="(guest, index) in guests" :key="index">
                    <div class="border border-gray-200 rounded-lg p-3 sm:p-4 space-y-4">
                        {{-- ヘッダー --}}
                        <div class="flex items-center justify-between">
                            <div class="font-semibold text-gray-800">
                                利用者 <span x-text="index + 1"></span>
                            </div>
                            <button type="button" @click="removeGuest(index)" x-show="guests.length > 1"
                                class="text-xs text-red-600 hover:underline">
                                この利用者を削除
                            </button>
                        </div>

                        {{-- セクション1: 基本情報 --}}
                        <div class="pt-3 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">基本情報</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">氏名（必須）</label>
                                    <input type="text" class="w-full border-gray-300 rounded-md text-sm"
                                        x-model="guest.guest_name" :name="`guests[${index}][guest_name]`">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">フリガナ（必須）</label>
                                    <input type="text" class="w-full border-gray-300 rounded-md text-sm"
                                        x-model="guest.guest_name_kana" :name="`guests[${index}][guest_name_kana]`">
                                </div>

                                <div>
                                    <span class="block text-xs text-gray-600 mb-1">性別（必須）</span>
                                    <div class="flex flex-wrap gap-3 text-sm">
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="border-gray-300"
                                                :name="`guests[${index}][gender]`" value="woman"
                                                x-model="guest.gender">
                                            <span class="ml-1">女性</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="border-gray-300"
                                                :name="`guests[${index}][gender]`" value="man"
                                                x-model="guest.gender">
                                            <span class="ml-1">男性</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="border-gray-300"
                                                :name="`guests[${index}][gender]`" value="none"
                                                x-model="guest.gender">
                                            <span class="ml-1">未回答</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <label class="inline-flex items-center mt-5 md:mt-6">
                                        <input type="checkbox" class="border-gray-300" x-model="guest.is_child"
                                            :name="`guests[${index}][is_child]`" value="1">
                                        <span class="ml-1 text-sm">子供</span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">身長（cm）</label>
                                    <input type="number" step="1" min="0"
                                        class="w-full border-gray-300 rounded-md text-sm" x-model="guest.height"
                                        :name="`guests[${index}][height]`">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">足のサイズ（cm）</label>
                                    <input type="number" step="0.5" min="0"
                                        class="w-full border-gray-300 rounded-md text-sm" x-model="guest.foot_size"
                                        :name="`guests[${index}][foot_size]`">
                                </div>
                            </div>
                        </div>

                        {{-- セクション2: メインギア --}}
                        <div class="pt-3 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">メインギア</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">
                                        メインギアプラン（スキー / スノーボード）
                                    </label>
                                    <select class="w-full border-gray-300 rounded-md text-sm"
                                        :name="`guests[${index}][main_gear_menu_id]`"
                                        @change="guest.main_gear_menu_id = $event.target.value">

                                        <option value="">選択なし</option>

                                        <template x-for="menu in getMainMenus(guest)" :key="menu.id">
                                            {{-- 【変更点2】:selected を追加して強制的に選択させる --}}
                                            <option :value="String(menu.id)" x-text="menu.name"
                                                :selected="String(guest.main_gear_menu_id) === String(menu.id)">
                                            </option>
                                        </template>
                                    </select>

                                    {{-- Step On チェックボックス --}}
                                    <div class="mt-2" x-show="isStepOnAvailable(guest)">
                                        <label class="inline-flex items-center text-sm">
                                            <input type="checkbox" class="border-gray-300" x-model="guest.is_step_on"
                                                :name="`guests[${index}][is_step_on]`" value="1">
                                            <span class="ml-1">Step On を利用する</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">
                                        スタンス（スノーボード時）
                                    </label>
                                    <input type="text" class="w-full border-gray-300 rounded-md text-sm"
                                        placeholder="例：レギュラー / 右3° 左12°" x-model="guest.stance"
                                        :name="`guests[${index}][stance]`" :disabled="!isSnowboardSelected(guest)">
                                </div>
                            </div>
                        </div>

                        {{-- セクション3: ウェア --}}
                        <div class="pt-3 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">ウェア</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">ウェアプラン</label>
                                    <select class="w-full border-gray-300 rounded-md text-sm"
                                        :name="`guests[${index}][wear_menu_id]`"
                                        @change="guest.wear_menu_id = $event.target.value">
                                        <option value="">選択なし</option>
                                        <template x-for="menu in getWearMenus(guest)" :key="menu.id">
                                            <option :value="String(menu.id)" x-text="menu.name"
                                                :selected="String(guest.wear_menu_id) === String(menu.id)"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">ウェアサイズ</label>
                                    <input type="text" class="w-full border-gray-300 rounded-md text-sm"
                                        x-model="guest.wear_size" :name="`guests[${index}][wear_size]`">
                                </div>
                            </div>
                        </div>

                        {{-- セクション4: アクセサリ --}}
                        <div class="pt-3 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">アクセサリ</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">グローブプラン</label>
                                    <select class="w-full border-gray-300 rounded-md text-sm"
                                        :name="`guests[${index}][glove_menu_id]`"
                                        @change="guest.glove_menu_id = $event.target.value">
                                        <option value="">選択なし</option>
                                        <template x-for="menu in getGloveMenus(guest)" :key="menu.id">
                                            <option :value="String(menu.id)" x-text="menu.name"
                                                :selected="String(guest.glove_menu_id) === String(menu.id)"></option>
                                        </template>
                                    </select>

                                    <div class="mt-2">
                                        <label class="block text-xs text-gray-600 mb-1">グローブサイズ</label>
                                        <input type="text" class="w-full border-gray-300 rounded-md text-sm"
                                            x-model="guest.glove_size" :name="`guests[${index}][glove_size]`">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">ゴーグルプラン</label>
                                    <select class="w-full border-gray-300 rounded-md text-sm"
                                        :name="`guests[${index}][goggle_menu_id]`"
                                        @change="guest.goggle_menu_id = $event.target.value">
                                        <option value="">選択なし</option>
                                        <template x-for="menu in getGoggleMenus(guest)" :key="menu.id">
                                            <option :value="String(menu.id)" x-text="menu.name"
                                                :selected="String(guest.goggle_menu_id) === String(menu.id)"></option>
                                        </template>
                                    </select>

                                    <div class="mt-2">
                                        <label class="inline-flex items-center text-sm">
                                            <input type="checkbox" class="border-gray-300"
                                                x-model="guest.is_helmet_used"
                                                :name="`guests[${index}][is_helmet_used]`" value="1">
                                            <span class="ml-1">ヘルメットを利用する</span>
                                        </label>
                                    </div>
                                </div>


                            </div>
                        </div>

                        {{-- セクション5: ご要望 --}}
                        <div class="pt-3 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">ご要望</h4>
                            <textarea class="w-full border-gray-300 rounded-md text-sm" rows="2" x-model="guest.note"
                                :name="`guests[${index}][note]`"></textarea>
                        </div>
                    </div>
                </template>

                {{-- ボタン群 --}}
                <div class="flex flex-col sm:flex-row sm:justify-between gap-3 pt-2">
                    <a href="{{ route('reservations.create.header') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                        代表者情報へ戻る
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 rounded-md bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                        確認画面へ進む
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function reservationDetails() {
            const rawGuests = @json($details);

            const mainMenusAdult = @json($mainMenusAdult);
            const mainMenusChild = @json($mainMenusChild);
            const wearMenusAdult = @json($wearMenusAdult);
            const wearMenusChild = @json($wearMenusChild);
            const gloveMenusAdult = @json($gloveMenusAdult);
            const gloveMenusChild = @json($gloveMenusChild);
            const goggleMenusAdult = @json($goggleMenusAdult);
            const goggleMenusChild = @json($goggleMenusChild);
            const boardCategoryId = @json($boardCategoryId);

            const allMainMenus = [...mainMenusAdult, ...mainMenusChild];

            const blankGuest = () => ({
                guest_name: '',
                guest_name_kana: '',
                gender: '',
                is_child: false,
                height: '',
                foot_size: '',
                stance: '',
                main_gear_menu_id: '',
                wear_menu_id: '',
                wear_size: '',
                glove_menu_id: '',
                glove_size: '',
                goggle_menu_id: '',
                is_helmet_used: false,
                is_step_on: false,
                note: '',
            });

            const initialGuests = Array.isArray(rawGuests) && rawGuests.length ?
                rawGuests.map(g => ({
                    guest_name: g.guest_name ?? '',
                    guest_name_kana: g.guest_name_kana ?? '',
                    gender: g.gender ?? '',
                    is_child: Boolean(g.is_child ?? false),
                    height: g.height ?? '',
                    foot_size: g.foot_size ?? '',
                    stance: g.stance ?? '',
                    main_gear_menu_id: g.main_gear_menu_id ?? '',
                    wear_menu_id: g.wear_menu_id ?? '',
                    wear_size: g.wear_size ?? '',
                    glove_menu_id: g.glove_menu_id ?? '',
                    glove_size: g.glove_size ?? '',
                    goggle_menu_id: g.goggle_menu_id ?? '',
                    is_helmet_used: Boolean(g.is_helmet_used ?? false),
                    is_step_on: Boolean(g.is_step_on ?? false),
                    note: g.note ?? '',
                })) : [blankGuest()];

            return {
                mainMenusAdult,
                mainMenusChild,
                wearMenusAdult,
                wearMenusChild,
                gloveMenusAdult,
                gloveMenusChild,
                goggleMenusAdult,
                goggleMenusChild,
                boardCategoryId,
                allMainMenus,

                guests: initialGuests,

                addGuest() {
                    this.guests.push(blankGuest());
                },

                removeGuest(index) {
                    if (this.guests.length > 1) {
                        this.guests.splice(index, 1);
                    }
                },

                getMainMenus(guest) {
                    return guest.is_child ? this.mainMenusChild : this.mainMenusAdult;
                },
                getWearMenus(guest) {
                    return guest.is_child ? this.wearMenusChild : this.wearMenusAdult;
                },
                getGloveMenus(guest) {
                    return guest.is_child ? this.gloveMenusChild : this.gloveMenusAdult;
                },
                getGoggleMenus(guest) {
                    return guest.is_child ? this.goggleMenusChild : this.goggleMenusAdult;
                },

                isSnowboardSelected(guest) {
                    const menuId = guest.main_gear_menu_id;
                    if (!menuId) return false;
                    const menu = this.allMainMenus.find(m => String(m.id) === String(menuId));
                    if (!menu) return false;
                    return this.boardCategoryId && String(menu.rental_menu_category_id) === String(this.boardCategoryId);
                },

                // 「スノーボードカテゴリが選ばれているときに Step On を表示」
                isStepOnAvailable(guest) {
                    const menuId = guest.main_gear_menu_id;
                    if (!menuId) return false;
                    const menu = this.allMainMenus.find(m => String(m.id) === String(menuId));
                    if (!menu) return false;
                    if (!this.boardCategoryId) return false;

                    return String(menu.rental_menu_category_id) === String(this.boardCategoryId);
                },
            };
        }
    </script>
</x-app-layout>
