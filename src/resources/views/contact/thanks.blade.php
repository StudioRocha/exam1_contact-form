@extends('layouts.app') @section('title', 'Thanks - FashionablyLate')
@push('styles')
<link href="{{ asset('css/thanks.css') }}" rel="stylesheet" />
@endpush @section('content')
<div class="thanks">
    <h1 class="thanks__title" aria-hidden="true">Thank you</h1>
    <p class="thanks__message">お問い合わせありがとうございました。</p>
    <div class="thanks__actions">
        <a href="{{ route('home') }}" class="contact__form-submit thanks__home"
            >HOME</a
        >
    </div>
</div>
@endsection
