@extends('layouts.app')
@section('title', 'Admin')

@push('styles')
<link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
<script src="{{ asset('js/admin.js') }}" defer></script>
@endpush

@section('content')
<div class="admin page">
    <h1 class="contact__title" style="margin-bottom: 16px;">Admin</h1>

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

    <div class="admin__heading">
        <div class="admin__pagination admin__pagination--top">
            {{ $contacts->links() }}
        </div>
    </div>

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
                    <td>{{ $contact->last_name }}　{{ $contact->first_name }}</td>
                    <td>{{ ['','男性','女性','その他'][$contact->gender] }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $categories[$contact->category_id] ?? 'その他' }}</td>
                    <td>
                        <button type="button" class="admin__detail-btn" data-modal-target="modal-{{ $contact->id }}">詳細</button>
                    </td>
                </tr>

                <div id="modal-{{ $contact->id }}" class="admin__modal" aria-hidden="true">
                    <div class="admin__modal-backdrop" data-modal-close></div>
                    <div class="admin__modal-dialog" role="dialog" aria-modal="true">
                        <button class="admin__modal-close" type="button" data-modal-close>×</button>
                        <div class="admin__modal-body">
                            <dl class="admin__detail-list">
                                <dt>お名前</dt><dd>{{ $contact->last_name }}　{{ $contact->first_name }}</dd>
                                <dt>性別</dt><dd>{{ ['','男性','女性','その他'][$contact->gender] }}</dd>
                                <dt>メールアドレス</dt><dd>{{ $contact->email }}</dd>
                                <dt>電話番号</dt><dd>{{ $contact->tel }}</dd>
                                <dt>住所</dt><dd>{{ $contact->address }}</dd>
                                <dt>建物名</dt><dd>{{ $contact->building ?? '-' }}</dd>
                                <dt>お問い合わせの種類</dt><dd>{{ $categories[$contact->category_id] ?? 'その他' }}</dd>
                                <dt>お問い合わせ内容</dt><dd>{{ $contact->detail }}</dd>
                            </dl>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" onsubmit="return confirm('削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin__button admin__button--danger">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


