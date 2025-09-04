@extends('layouts.app') @section('title', 'Register - FashionablyLate')
@push('styles')
<link href="{{ asset('css/register.css') }}" rel="stylesheet" />
@endpush @section('content')
<div class="register-page">
    <div class="register contact">
        <h1 class="contact__title">Register</h1>

        <form
            class="contact__form"
            method="POST"
            action="{{ route('register') }}"
            novalidate
        >
            @csrf @if ($errors->any())
            <div class="contact__form-errors">
                入力に不備があります。各項目をご確認ください。
            </div>
            @endif

            <div class="contact__form-group">
                <label class="contact__form-label contact__form-label--required"
                    >お名前</label
                >
                <input
                    type="text"
                    name="name"
                    class="contact__form-input"
                    placeholder="例: 山田 太郎"
                    value="{{ old('name') }}"
                    required
                />
                @error('name')
                <div class="contact__form-error">{{ $message }}</div>
                @enderror
            </div>

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
            </div>

            <div class="contact__form-group">
                <label class="contact__form-label contact__form-label--required"
                    >パスワード（確認用）</label
                >
                <input
                    type="password"
                    name="password_confirmation"
                    class="contact__form-input"
                    placeholder="もう一度同じパスワードを入力"
                    required
                />
                @error('password')
                <div class="contact__form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="contact__form-button">
                <button type="submit" class="contact__form-submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection
