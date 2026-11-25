<?php

use App\Models\Product;

test('product detail keeps its cart form selector inside the Alpine data attribute', function () {
    $product = Product::create([
        'name' => 'Alpine Test Shoe',
        'price' => 100000,
        'stock' => 5,
    ]);

    $response = $this->get(route('product.show', $product));

    $response->assertOk()
        ->assertSee("form.querySelector('button[type=submit]')", false);
});
