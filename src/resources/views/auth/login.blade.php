@extends('layouts.app') @section('title', 'Login - FashionablyLate')
@push('styles')
<link href="{{ asset('css/register.css') }}" rel="stylesheet" />
@endpush @section('content')
<div class="register-page">
    <div class="register contact">
        <h1 class="contact__title">Login</h1>

        <form
            class="contact__form"
            method="POST"
            action="{{ route('login') }}"
            novalidate
        >
            @csrf @if ($errors->any())
            <div class="contact__form-errors">
                入力に不備があります。各項目をご確認ください。
            </div>
            @endif

            <div class="contact__form-group">
                <label class="contact__form-label contact__form-label--required"
                    >メールアドレス</label
                >
                <input
                    type="email"
                    name="email"
                    class="contact__form-input"
                    placeholder="例: test@example.com"
                    value="{{ old('email') }}"
                    required
                />
                @error('email')
                <div class="contact__form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="contact__form-group">
                <label class="contact__form-label contact__form-label--required"
                    >パスワード</label
                >
                <input
                    type="password"
                    name="password"
                    class="contact__form-input"
                    placeholder="例: coachtech1106"
                    required
                />
                @error('password')
                <div class="contact__form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="contact__form-group">
                <label class="contact__form-label">
                    <input
                        type="checkbox"
                        name="remember"
                        class="contact__form-checkbox"
                    />
                    ログイン状態を保持する
                </label>
            </div>

            <div class="contact__form-button">
                <button type="submit" class="contact__form-submit">
                    ログイン
                </button>
            </div>
        </form>

        <!-- <div
            class="contact__form-group"
            style="text-align: center; margin-top: 20px"
        >
            <a href="{{ route('register') }}" class="contact__form-link">
                アカウントをお持ちでない方はこちら
            </a>
        </div> -->
    </div>
</div>
@endsection
