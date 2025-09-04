@extends('layouts.app')
@section('title', 'Admin')

@push('styles')
<link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
<script src="{{ asset('js/admin.js') }}" defer></script>
@endpush

@section('content')

<div class="admin">
    <div class="admin__header">
        <h1 class="admin__title">Admin</h1>
    </div>

    <div class="admin__zoom">
        <div class="admin__filters">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="admin__search">
            <input type="text" name="keyword" value="{{ $inputs['keyword'] }}" placeholder="名前やメールアドレスを入力してください" class="admin__input admin__input--keyword" />

            <select name="gender" class="admin__select admin__select--gender">
                <option value="gender" {{ $inputs['gender']==='gender' ? 'selected' : '' }} disabled>性別</option>
                @foreach($genders as $key => $label)
                    <option value="{{ $key }}" {{ (string)$inputs['gender']===(string)$key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <select name="category" class="admin__select admin__select--category">
                <option value="category" {{ $inputs['category']==='category' ? 'selected' : '' }} disabled>お問い合わせの種類</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ (string)$inputs['category']===(string)$key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <input type="date" name="date" value="{{ $inputs['date'] }}" class="admin__input admin__input--date" />

            <select name="match" class="admin__select">
                <option value="partial" {{ $inputs['match']==='partial' ? 'selected' : '' }}>部分一致</option>
                <option value="exact" {{ $inputs['match']==='exact' ? 'selected' : '' }}>完全一致</option>
            </select>

            <button class="admin__button admin__button--primary" type="submit">検索</button>
            <a class="admin__button admin__button--ghost" href="{{ route('admin.dashboard') }}">リセット</a>
        </form>

        @if(session('status'))
            <div class="admin__flash">{{ session('status') }}</div>
        @endif
        </div>

        <div class="admin__pager">
            <a href="{{ route('admin.contacts.export', request()->query()) }}" class="admin__button admin__button--export">エクスポート</a>
            <x-pagination :paginator="$contacts" align="right" />
        </div>

        <div class="admin__content">
        <div class="admin__table-wrapper">
            <table class="admin__table">
                <thead>
                    <tr>
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせの種類</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $contact->first_name }}　{{ $contact->last_name }}</td>
                        <td>{{ ['','男性','女性','その他'][$contact->gender] }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $categories[$contact->category_id] ?? 'その他' }}</td>
                        <td>
                            <button type="button" class="admin__detail-btn" data-modal-target="modal-{{ $contact->id }}">詳細</button>
                        </td>
                    </tr>

                    <x-admin.contact-modal :contact="$contact" :categories="$categories" />
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection


