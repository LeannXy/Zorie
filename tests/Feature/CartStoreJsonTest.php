<?php

test('cart store returns a JSON login error for guests', function () {
    $response = $this->postJson(route('cart.store'), [
        'product_id' => 1,
        'size' => '42',
        'qty' => 1,
    ]);

    $response->assertUnauthorized()
        ->assertJson([
            'success' => false,
            'message' => 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.',
        ]);
});

test('cart store keeps redirecting guests from regular form submissions', function () {
    $response = $this->post(route('cart.store'), [
        'product_id' => 1,
        'size' => '42',
        'qty' => 1,
    ]);

    $response->assertRedirect(route('customer.login'));
});
