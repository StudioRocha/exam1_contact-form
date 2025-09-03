<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    private const PER_PAGE = 7;

    /**
     * 一覧 + 検索
     */
    public function index(Request $request): View
    {
        $match = $request->input('match', 'partial'); // partial | exact
        $keyword = trim((string) $request->input('keyword'));
        $gender = $request->input('gender'); // all|1|2|3
        $category = $request->input('category'); // all|id
        $date = $request->input('date'); // Y-m-d

        $query = Contact::query();

        if ($keyword !== '') {
            $isExact = $match === 'exact';
            $value = $isExact ? $keyword : "%{$keyword}%";
            $operator = $isExact ? '=' : 'LIKE';

            $query->where(function ($q) use ($operator, $value, $isExact) {
                $q->where('first_name', $operator, $value)
                  ->orWhere('last_name', $operator, $value)
                  ->orWhere('email', $operator, $value);

                // フルネーム（スペースあり/なし）
                if ($isExact) {
                    $q->orWhereRaw("CONCAT(last_name, ' ', first_name) = ?", [$value])
                      ->orWhereRaw("CONCAT(last_name, first_name) = ?", [$value]);
                } else {
                    $q->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$value])
                      ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", [$value]);
                }
            });
        }

        if ($gender && $gender !== 'all') {
            $query->where('gender', (int) $gender);
        }

        if ($category && $category !== 'all') {
            $query->where('category_id', (int) $category);
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $contacts = $query->latest('id')->paginate(self::PER_PAGE)->appends($request->query());

        return view('admin.contacts.index', [
            'contacts' => $contacts,
            'genders' => $this->genders(),
            'categories' => $this->categories(),
            'inputs' => [
                'keyword' => $keyword,
                // 初期表示はプレースホルダー（性別 / お問い合わせの種類）を選択状態にする
                'gender' => $gender ?? 'gender',
                'category' => $category ?? 'category',
                'date' => $date ?? '',
                'match' => $match,
            ],
        ]);
    }

    /**
     * 削除
     */
    public function destroy(int $id): RedirectResponse
    {
        Contact::where('id', $id)->delete();
        return back()->with('status', '削除しました');
    }

    private function genders(): array
    {
        return [
            'all' => '全て',
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        ];
    }

    private function categories(): array
    {
        // 本来はマスタから。ここでは固定値で対応
        return [
            'all' => '全て',
            1 => '商品のお問い合わせについて',
            2 => '配送について',
            3 => '返品・交換について',
            4 => 'その他',
        ];
    }
}


