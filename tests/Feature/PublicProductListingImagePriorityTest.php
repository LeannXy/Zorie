<?php

use App\Models\Product;
use App\Models\ProductImage;

test('product listing prioritizes its first image and lazy loads the remaining images', function () {
    foreach ([1, 2] as $number) {
        $product = Product::create([
            'name' => "Listing Shoe {$number}",
            'price' => 100000,
            'stock' => 5,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => "products/listing-shoe-{$number}.jpg",
        ]);
    }

    $response = $this->get(route('all-products'));
    $html = $response->getContent();

    $response->assertOk();
    expect(substr_count($html, 'class="prod-image"'))->toBe(2)
        ->and(substr_count($html, 'fetchpriority="high"'))->toBe(1)
        ->and(substr_count($html, 'loading="lazy"'))->toBe(1);
});
