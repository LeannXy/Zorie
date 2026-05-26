<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::take(5)->get();

        $products = Product::take(5)->get();

        $comments = [

            "Sepatunya nyaman dipakai",

            "Kualitas bagus dan pengiriman cepat",

            "Bahannya premium",

            "Ukuran pas, recommended",

            "Lumayan bagus untuk harga segini",

            "Desainnya keren",

            "Sangat puas dengan produk ini"

        ];

        foreach ($users as $user) {

            Testimonial::create([

                'user_id' =>
                $user->id,

                'product_id' =>
                $products->random()->id,

                'rating' =>
                rand(3, 5),

                'comment' =>
                $comments[array_rand($comments)],

                'Approved' =>
                collect([
                    'Pending',
                    'Approved'
                ])->random()

            ]);
        }
    }
}
