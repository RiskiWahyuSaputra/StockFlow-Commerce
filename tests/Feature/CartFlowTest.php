<?php

namespace Tests\Feature;

use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesEcommerceData;
use Tests\TestCase;

class CartFlowTest extends TestCase
{
    use CreatesEcommerceData, RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_adding_product_to_cart(): void
    {
        $product = $this->createActiveProduct([
            'stock' => 5,
        ]);

        $response = $this->post(route('cart.items.store'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_customer_can_add_product_to_cart_and_totals_are_saved_in_database(): void
    {
        $user = $this->createCustomer();
        $product = $this->createActiveProduct([
            'price' => 125000,
            'stock' => 10,
        ]);

        $response = $this->actingAs($user)->post(route('cart.items.store'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $cart = Cart::query()->where('user_id', $user->id)->firstOrFail();

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertSame(2, $cart->fresh()->total_items);
        $this->assertSame(250000.0, (float) $cart->fresh()->subtotal);
    }
}
