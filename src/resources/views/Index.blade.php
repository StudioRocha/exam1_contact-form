@extends('layouts.app')

@section('title', 'Contact - FashionablyLate')

@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="contact">
    <h1 class="contact__title">Contact</h1>
    
    <form class="contact__form" method="POST" action="{{ route('contact.confirm') }}" novalidate>
        @csrf
        @if ($errors->any())
        <div class="contact__form-errors">入力に不備があります。各項目をご確認ください。</div>
        @endif
        
        <!-- お名前 -->
        <div class="contact__form-group">
            <label class="contact__form-label contact__form-label--required">お名前</label>
            <div class="contact__form-input contact__form-input--name">
                <input type="text" name="first_name" placeholder="例:山田" value="{{ old('first_name') }}" autocomplete="family-name" required>
                <input type="text" name="last_name" placeholder="例:太郎" value="{{ old('last_name') }}" autocomplete="given-name" required>
            </div>
            @if ($errors->has('first_name') || $errors->has('last_name'))
                <div class="contact__form-error">
                    {{ $errors->first('first_name') }}
                    @if ($errors->has('last_name')) {{ $errors->first('last_name') }} @endif
                </div>
            @endif
        </div>
        
        <!-- 性別 -->
        <div class="contact__form-group">
            <label class="contact__form-label contact__form-label--required">性別</label>
            <div class="contact__form-radio-group">
                <label class="contact__form-radio">
                    <input type="radio" name="gender" value="1" {{ old('gender', '1') == '1' ? 'checked' : '' }} required>
                    <span>男性</span>
                </label>
                <label class="contact__form-radio">
                    <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}>
                    <span>女性</span>
                </label>
                <label class="contact__form-radio">
                    <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}>
                    <span>その他</span>
                </label>
            </div>
            @if ($errors->has('gender'))
                <div class="contact__form-error">{{ $errors->first('gender') }}</div>
            @endif
        </div>
        
        <!-- メールアドレス -->
        <div class="contact__form-group">
            <label class="contact__form-label contact__form-label--required">メールアドレス</label>
            <input type="email" name="email" class="contact__form-input" placeholder="例: test@example.com" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <div class="contact__form-error">{{ $errors->first('email') }}</div>
            @endif
        </div>
        
        <!-- 電話番号 -->
        <div class="contact__form-group">
            <label class="contact__form-label contact__form-label--required">電話番号</label>
            <div class="contact__form-input contact__form-input--tel">
                <input type="tel" name="tel1" placeholder="080" value="{{ old('tel1') }}" required>
                <span>-</span>
                <input type="tel" name="tel2" placeholder="1234" value="{{ old('tel2') }}" required>
                <span>-</span>
                <input type="tel" name="tel3" placeholder="5678" value="{{ old('tel3') }}" required>
            </div>
            @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                <div class="contact__form-error">{{ $errors->first('tel1') ?: $errors->first('tel2') ?: $errors->first('tel3') }}</div>
            @endif
        </div>
        
        <!-- 住所 -->
        <div class="contact__form-group">
            <label class="contact__form-label contact__form-label--required">住所</label>
            <input type="text" name="address" class="contact__form-input" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}" required>
            @if ($errors->has('address'))
                <div class="contact__form-error">{{ $errors->first('address') }}</div>
            @endif
        </div>
        
        <!-- 建物名 -->
        <div class="contact__form-group">
            <label class="contact__form-label">建物名</label>
            <input type="text" name="building" class="contact__form-input" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}">
        </div>
        
        <!-- お問い合わせの種類 -->
        <div class="contact__form-group">
            <label class="contact__form-label contact__form-label--required">お問い合わせの種類</label>
            <select name="category_id" class="contact__form-select" required>
                <option value="">選択してください</option>
                @foreach(($categories ?? []) as $c)
                    <option value="{{ $c->id }}" {{ old('category_id') == (string)$c->id ? 'selected' : '' }}>
                        {{ $c->content }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
                <div class="contact__form-error">{{ $errors->first('category_id') }}</div>
            @endif
        </div>
        
        <!-- お問い合わせ内容 -->
        <div class="contact__form-group">
            <label class="contact__form-label contact__form-label--required">お問い合わせ内容</label>
            <textarea name="detail" class="contact__form-textarea" placeholder="お問い合わせ内容をご記載ください" required>{{ old('detail') }}</textarea>
            @if ($errors->has('detail'))
                <div class="contact__form-error">{{ $errors->first('detail') }}</div>
            @endif
        </div>
        
        <!-- 送信ボタン -->
        <div class="contact__form-button">
            <button type="submit" class="contact__form-submit">確認画面</button>
        </div>
    </form>
</div>
@endsection
