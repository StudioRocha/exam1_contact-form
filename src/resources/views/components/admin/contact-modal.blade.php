@props([ 'contact', 'categories' => [], ])

<div id="modal-{{ $contact->id }}" class="admin__modal" aria-hidden="true">
    <div class="admin__modal-backdrop" data-modal-close></div>
    <div class="admin__modal-dialog" role="dialog" aria-modal="true">
        <button class="admin__modal-close" type="button" data-modal-close>
            ×
        </button>
        <div class="admin__modal-body">
            <dl class="admin__detail-list">
                <dt>お名前</dt>
                <dd>{{ $contact->first_name }}　{{ $contact->last_name}}</dd>
                <dt>性別</dt>
                <dd>{{ ['', '男性', '女性', 'その他'][$contact->gender] }}</dd>
                <dt>メールアドレス</dt>
                <dd>{{ $contact->email }}</dd>
                <dt>電話番号</dt>
                <dd>{{ $contact->tel }}</dd>
                <dt>住所</dt>
                <dd>{{ $contact->address }}</dd>
                <dt>建物名</dt>
                <dd>{{ $contact->building ?? '-' }}</dd>
                <dt>お問い合わせの種類</dt>
                <dd>{{ $categories[$contact->category_id] ?? 'その他' }}</dd>
                <dt>お問い合わせ内容</dt>
                <dd>{{ $contact->detail }}</dd>
            </dl>
            <form
                method="POST"
                action="{{ route('admin.contacts.destroy', $contact->id) }}"
                onsubmit="return confirm('削除しますか？');"
            >
                @csrf @method('DELETE')
                <button
                    type="submit"
                    class="admin__button admin__button--danger"
                >
                    削除
                </button>
            </form>
        </div>
    </div>
</div>
