<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

new #[Layout('layouts.guest')] class extends Component {
    public string $name_sei = '';
    public string $name_mei = '';
    public string $name_sei_kana = '';
    public string $name_mei_kana = '';
    public string $gender = '';
    public string $birthdate = '';
    public string $postal_1 = '';
    public string $postal_2 = '';
    public string $postal_code = '';
    public string $prefecture = '';
    public string $city = '';
    public string $address_line = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $birthYear = '';
    public string $birthMonth = '';
    public string $birthDay = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $postal_code = $this->postal_1 . $this->postal_2;
        $this->birthdate = sprintf('%04d/%02d/%02d', (int) $this->birthYear, (int) $this->birthMonth, (int) $this->birthDay);
        $validated = $this->validate([
            'name_sei' => ['required', 'string', 'max:255'],
            'name_mei' => ['required', 'string', 'max:255'],
            'name_sei_kana' => ['required', 'string', 'max:255'],
            'name_mei_kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'in:male,female,other'],
            'birthdate' => ['required', 'date'],
            'postal_1' => ['required'],
            'postal_2' => ['required'],
            'prefecture' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'address_line' => ['nullable', 'string', 'max:255'],
        ]);
        $validated['postal_code'] = $postal_code;
        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('home', absolute: false), navigate: true);
    }

    public function getYearsProperty(): array
    {
        $thisYear = now()->year;
        return range($thisYear, 1900);
    }

    public function getMonthsProperty(): array
    {
        return range(1, 12);
    }

    public function getDaysProperty(): array
    {
        if ($this->birthYear === '' || $this->birthMonth === '') {
            return [];
        }
        $y = (int) $this->birthYear;
        $m = (int) $this->birthMonth;

        $lastDay = Carbon::create($y, $m, 1)->endOfMonth()->day;
        return range(1, $lastDay);
    }
    public function fetchAddress(): void
    {
        $postal_code = $this->postal_1 . $this->postal_2;

        if (strlen($postal_code) !== 7) {
            $this->prefecture = '';
            $this->city = '';
            return;
        }

        $response = Http::get('https://zipcloud.ibsnet.co.jp/api/search', [
            'zipcode' => $postal_code,
        ]);

        if (!$response->ok()) {
            $this->prefecture = '';
            $this->city = '';
            return;
        }

        $data = $response->json();

        if (!empty($data['results'])) {
            $this->prefecture = $data['results'][0]['address1'] ?? '';
            $this->city = $data['results'][0]['address2'] ?? '';
        } else {
            $this->prefecture = '';
            $this->city = '';
        }
    }
    public function updatedPostal1(): void
    {
        $this->fetchAddress();
    }

    public function updatedPostal2(): void
    {
        $this->fetchAddress();
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div class="flex gap-6">
            <div>
                <x-input-label for="name_sei" :value="__('姓')" />
                <x-text-input wire:model="name_sei" id="name_sei" class="block mt-1 w-full" type="text" name="name"
                    required autofocus autocomplete="name_sei" placeholder="山田" />
                <x-input-error :messages="$errors->get('name_sei')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="name_mei" :value="__('名')" />
                <x-text-input wire:model="name_mei" id="name_mei" class="block mt-1 w-full" type="text"
                    name="name" required autofocus autocomplete="name_mei" placeholder="健太郎" />
                <x-input-error :messages="$errors->get('name_mei')" class="mt-2" />
            </div>
        </div>
        <div class="flex gap-6 mt-4">
            <div>
                <x-input-label for="name_sei_kana" :value="__('セイ')" />
                <x-text-input wire:model="name_sei_kana" id="name_sei_kana" class="block mt-1 w-full" type="text"
                    name="name" required autofocus autocomplete="name_sei_kana" placeholder="ヤマダ" />
                <x-input-error :messages="$errors->get('name_sei_kana')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="name_mei_kana" :value="__('メイ')" />
                <x-text-input wire:model="name_mei_kana" id="name_mei_kana" class="block mt-1 w-full" type="text"
                    name="name" required autofocus autocomplete="name_mei_kana" placeholder="ケンタロウ" />
                <x-input-error :messages="$errors->get('name_mei_kana')" class="mt-2" />
            </div>
        </div>
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="gender" :value="__('性別')" />
            <div class="mt-2 flex gap-6 text-sm">
                <label class="inline-flex items-center gap-2">
                    <input wire:model="gender" type="radio" name="gender" value="male">
                    <span>男性</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input wire:model="gender" type="radio" name="gender" value="female">
                    <span>女性</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input wire:model="gender" type="radio" name="gender" value="other">
                    <span>その他</span>
                </label>
            </div>

        </div>
        <div class="mt-4">
            <x-input-label for="birthYear" value="生年月日" />
            {{-- <pre>{{ $birthYear }} / {{ $birthMonth }} / {{ $birthDay }}</pre> --}}
            <div class="mt-2 flex items-center gap-2">
                <select wire:model.live="birthYear" name="birthYear" id=""
                    class="border rounded text-sm h-9 px-3 pr-8 w-24">
                    <option value="">----</option>
                    @foreach ($this->years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
                <span>年</span>

                <select wire:model.live="birthMonth" name="birthMonth" id=""
                    class="border rounded text-sm h-9 px-3 pr-8 w-24">
                    <option value="">----</option>
                    @foreach ($this->months as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
                <span>月</span>


                <select wire:model.live="birthDay" name="birthDay" id=""
                    class="border rounded text-sm h-9 px-3 pr-8 w-24">
                    <option value="">----</option>
                    @foreach ($this->days as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                    @endforeach
                </select>
                <span>日</span>
            </div>
        </div>

        <div class="h-adr">
            <span class="p-country-name" style="display:none;">Japan</span>
            <div class="mt-4">

                <div class="text-center mt-6 mb-2 mr-5">
                    <x-input-label :value="__('郵便番号')" />
                </div>

                <div class="flex justify-center items-center gap-2">
                    <x-text-input wire:model.live="postal_1" id="postal_1" class="block w-20" type="text"
                        inputmode="numeric" maxlength="3" autocomplete="postal-code" placeholder="123" />

                    <span class="text-gray-500">-</span>

                    <x-text-input wire:model.live="postal_2" id="postal_2" class="block w-24" type="text"
                        inputmode="numeric" maxlength="4" placeholder="4567" />
                </div>
                <input id="postal_code" type="hidden" class="p-postal-code" name="postal_code">
                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label :value="__('都道府県')" />
                <x-text-input wire:model="prefecture" id="prefecture" name="prefecture"
                    class="p-region block mt-1 w-full p-region" type="text" required
                    autocomplete="address-level1" />
                <x-input-error class="mt-2" :messages="$errors->get('prefecture')" />
            </div>
            <div class="mt-4">
                <x-input-label :value="__('市区町村')" />
                <x-text-input wire:model="city" id="city" name="city" class="block mt-1 w-full"
                    type="text" value="{{ old('city', $user->city ?? '') }}" required
                    autocomplete="address-level2" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
            <div class="mt-4">
                <x-input-label for="address_line" :value="__('建物名・部屋番号')" />
                <x-text-input wire:model="address_line" id="address_line" class="block mt-1 w-full" type="text" name="address_line"
                    :value="old('address_line')" required />
                <x-input-error :messages="$errors->get('address_line')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}" wire:navigate>
                {{ __('戻る') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('登録') }}
            </x-primary-button>
        </div>
    </form>
</div>
