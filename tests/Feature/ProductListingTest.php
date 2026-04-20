<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesEcommerceData;
use Tests\TestCase;

class ProductListingTest extends TestCase
{
    use CreatesEcommerceData, RefreshDatabase;

    public function test_product_listing_only_shows_active_products(): void
    {
        $visibleProduct = $this->createActiveProduct([
            'name' => 'Aurora Lamp',
        ]);

        $hiddenProduct = Product::factory()->draft()->create([
            'name' => 'Hidden Draft Product',
        ]);

        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertSee($visibleProduct->name);
        $response->assertDontSee($hiddenProduct->name);
    }

    public function test_product_listing_can_be_filtered_by_search_keyword(): void
    {
        $matchingProduct = $this->createActiveProduct([
            'name' => 'Nebula Speaker',
        ]);

        $nonMatchingProduct = $this->createActiveProduct([
            'name' => 'Desk Lamp',
        ]);

        $response = $this->get(route('products.index', [
            'search' => 'Nebula',
        ]));

        $response->assertOk();
        $response->assertSee($matchingProduct->name);
        $response->assertDontSee($nonMatchingProduct->name);
    }
}
