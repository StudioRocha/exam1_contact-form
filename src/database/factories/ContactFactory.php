<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/** @extends Factory<\App\Models\Contact> */
class ContactFactory extends Factory
{
    protected $model = \App\Models\Contact::class;

    public function definition(): array
    {
        $faker = $this->faker; // ja_JP（config/app.php の faker_locale 参照）
        $gender = $faker->randomElement([1, 2, 3]);

        // 日本向け住所（改行をスペースに）
        $address = str_replace(["\n", "\r"], ' ', $faker->address);

        // 既存のカテゴリIDからランダムに選択（将来件数が増減しても対応）
        $categoryId = Category::query()->inRandomOrder()->value('id') ?? 1;

        return [
            // first_name=姓、last_name=名（本PJのカラム運用）
            'first_name'  => $faker->lastName,
            'last_name'   => $faker->firstName,
            'gender'      => $gender,
            'email'       => $faker->unique()->safeEmail,
            'tel'         => $faker->numerify('0##-####-####'), // 日本の携帯っぽい形式
            'address'     => $address,
            'building'    => $faker->optional()->secondaryAddress,
            'category_id' => $categoryId,
            'detail'      => $faker->realText(120), // 日本語テキスト
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}


