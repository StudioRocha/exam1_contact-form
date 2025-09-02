@extends('layouts.app') @section('title', 'Confirm - FashionablyLate')
@push('styles')
<link href="{{ asset('css/confirm.css') }}" rel="stylesheet" />
@endpush @section('content')
<div class="confirm">
    <h1 class="confirm__title">Confirm</h1>

    <div class="confirm__table">
        <div class="confirm__row">
            <div class="confirm__th">お名前</div>
            <div class="confirm__td">
                {{ $request->first_name }}　{{ $request->last_name }}
            </div>
        </div>
        <div class="confirm__row">
            <div class="confirm__th">性別</div>
            <div class="confirm__td">{{ $genderLabel }}</div>
        </div>
        <div class="confirm__row">
            <div class="confirm__th">メールアドレス</div>
            <div class="confirm__td">{{ $request->email }}</div>
        </div>
        <div class="confirm__row">
            <div class="confirm__th">電話番号</div>
            <div class="confirm__td">
                {{ $request->tel1 }}-{{ $request->tel2 }}-{{ $request->tel3 }}
            </div>
        </div>
        <div class="confirm__row">
            <div class="confirm__th">住所</div>
            <div class="confirm__td">{{ $request->address }}</div>
        </div>
        <div class="confirm__row">
            <div class="confirm__th">建物名</div>
            <div class="confirm__td">{{ $request->building }}</div>
        </div>
        <div class="confirm__row">
            <div class="confirm__th">お問い合わせの種類</div>
            <div class="confirm__td">{{ $categoryLabel }}</div>
        </div>
        <div class="confirm__row confirm__row--grow">
            <div class="confirm__th">お問い合わせ内容</div>
            <div class="confirm__td">{!! nl2br(e($request->detail)) !!}</div>
        </div>
    </div>

    <div class="confirm__actions">
        <form method="POST" action="{{ route('contact.store') }}">
            @csrf
            <button type="submit" class="contact__form-submit">送信</button>
        </form>
        <form method="GET" action="{{ route('contact.back') }}">
            <button type="submit" class="confirm__back-link">修正</button>
        </form>
    </div>
</div>
@endsection
