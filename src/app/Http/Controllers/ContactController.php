<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    /**
     * お問い合わせフォーム入力ページを表示
     */
    public function index()
    {
        $categories = Category::orderBy('id')->get();
        return view('Index', compact('categories'));
    }

    /**
     * お問い合わせフォーム確認ページを表示
     */
    public function confirm(ContactFormRequest $request)
    {
        // セッションにデータを保存
        $request->session()->put('contact_data', $request->all());

        $genderLabel = [
            '1' => '男性',
            '2' => '女性',
            '3' => 'その他',
        ][$request->gender] ?? '';

        $categoryLabel = Category::where('id', $request->category_id)->value('content') ?? '';

        return view('contact.confirm', compact('request', 'genderLabel', 'categoryLabel'));
    }

    /**
     * 入力画面に戻る（値を保持）
     */
    public function back(Request $request)
    {
        $contactData = $request->session()->get('contact_data', []);
        return redirect()->route('home')->withInput($contactData);
    }

    /**
     * お問い合わせを送信
     */
    public function store(Request $request)
    {
        // セッションデータを取得
        $contactData = $request->session()->get('contact_data');

        if (!$contactData) {
            return redirect()->route('home')->with('error', 'セッションが切れました。再度入力してください。');
        }

        // 電話番号を結合
        $tel = ($contactData['tel1'] ?? '') . '-' . ($contactData['tel2'] ?? '') . '-' . ($contactData['tel3'] ?? '');

        // 永続化
        Contact::create([
            'first_name'  => $contactData['first_name'] ?? null,
            'last_name'   => $contactData['last_name'] ?? null,
            'gender'      => (int)($contactData['gender'] ?? 0),
            'email'       => $contactData['email'] ?? null,
            'tel'         => $tel,
            'address'     => $contactData['address'] ?? null,
            'building'    => $contactData['building'] ?? null,
            'category_id' => (int)($contactData['category_id'] ?? 0),
            'detail'      => $contactData['detail'] ?? null,
        ]);

        // セッションデータをクリア
        $request->session()->forget('contact_data');

        return redirect()->route('contact.thanks');
    }

    /**
     * サンクスページを表示
     */
    public function thanks()
    {
        return view('contact.thanks');
    }
}
