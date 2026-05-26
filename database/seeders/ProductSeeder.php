<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products=[

            [

                'name'=>'Nike Air Max',

                'price'=>1200000,

                'stock'=>15,

                'discount'=>10,

                'description'=>'Comfort sneakers'

            ],

            [

                'name'=>'Adidas Run',

                'price'=>900000,

                'stock'=>20,

                'discount'=>5,

                'description'=>'Running shoes'

            ],

            [

                'name'=>'Puma Speed',

                'price'=>800000,

                'stock'=>12,

                'discount'=>0,

                'description'=>'Sport shoes'

            ]

        ];
        

        foreach($products as $product){

            Product::create($product);

        }
    }
}