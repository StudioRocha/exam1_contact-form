<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
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
        $contacts = $this->buildQuery($request)
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->appends($request->query());

        return view('admin.contacts.index', [
            'contacts' => $contacts,
            'genders' => $this->genders(),
            'categories' => $this->categories(),
            'inputs' => [
                'keyword' => trim((string) $request->input('keyword')),
                'gender' => $request->input('gender', 'gender'),
                'category' => $request->input('category', 'category'),
                'date' => $request->input('date', ''),
                'match' => $request->input('match', 'partial'),
            ],
        ]);
    }

    /**
     * 現在の検索条件でCSVエクスポート
     */
    public function export(Request $request)
    {
        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
        $header = ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類', '電話番号', '住所', '作成日'];
        $genders = $this->genders();
        $categories = $this->categories();

        $query = $this->buildQuery($request)->latest('id');

        return response()->streamDownload(function () use ($query, $header, $genders, $categories) {
            $out = fopen('php://output', 'w');
            // BOM (for Excel)
            fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, $header);

            $query->chunk(500, function ($rows) use ($out, $genders, $categories) {
                foreach ($rows as $c) {
                    $row = [
                        $c->first_name . '　' . $c->last_name,
                        $genders[$c->gender] ?? '',
                        $c->email,
                        $categories[$c->category_id] ?? '',
                        $c->tel,
                        $c->address,
                        optional($c->created_at)->format('Y-m-d H:i'),
                    ];
                    fputcsv($out, $row);
                }
            });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * 検索条件の共通クエリ
     */
    private function buildQuery(Request $request): Builder
    {
        $match = $request->input('match', 'partial');
        $keyword = trim((string) $request->input('keyword'));
        $gender = $request->input('gender');
        $category = $request->input('category');
        $date = $request->input('date');

        $query = Contact::query();

        if ($keyword !== '') {
            $isExact = $match === 'exact';
            $value = $isExact ? $keyword : "%{$keyword}%";
            $operator = $isExact ? '=' : 'LIKE';

            $query->where(function ($q) use ($operator, $value, $isExact) {
                $q->where('first_name', $operator, $value)
                    ->orWhere('last_name', $operator, $value)
                    ->orWhere('email', $operator, $value);

                if ($isExact) {
                    $q->orWhereRaw("CONCAT(last_name, ' ', first_name) = ?", [$value])
                        ->orWhereRaw("CONCAT(last_name, first_name) = ?", [$value]);
                } else {
                    $q->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$value])
                        ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", [$value]);
                }
            });
        }

        if ($gender && $gender !== 'all' && $gender !== 'gender') {
            $query->where('gender', (int) $gender);
        }
        if ($category && $category !== 'all' && $category !== 'category') {
            $query->where('category_id', (int) $category);
        }
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        return $query;
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


