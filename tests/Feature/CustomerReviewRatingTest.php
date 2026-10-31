<?php

use App\Models\Category;
use App\Models\CustomerAccount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

test('review form initializes clickable stars and submits the selected order item', function () {
    $customer = CustomerAccount::create([
        'name' => 'Review Customer',
        'email' => 'review-customer@example.com',
    ]);
    $category = Category::create([
        'name' => 'Shoes',
        'slug' => 'shoes',
    ]);
    $product = Product::create([
        'name' => 'Review Product',
        'price' => 100000,
        'stock' => 5,
    ]);
    $product->categories()->attach($category);
    $order = Order::forceCreate([
        'customer_id' => $customer->id,
        'order_number' => 'REVIEW-ORDER-001',
        'total' => 100000,
        'payment_method' => 'Transfer',
        'status' => 'Completed',
    ]);
    $orderItem = OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'price' => 100000,
    ]);

    $response = $this->withSession([
        'customer_id' => $customer->id,
    ])->get(route('customer.reviews'));

    $response->assertOk()
        ->assertSee('reviewRating: 5')
        ->assertSee('reviewHover: 0')
        ->assertSee("order_item_id: {$orderItem->id}", false)
        ->assertSee(':aria-pressed="reviewRating === star"', false);
});
