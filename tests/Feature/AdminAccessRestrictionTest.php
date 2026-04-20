<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesEcommerceData;
use Tests\TestCase;

class AdminAccessRestrictionTest extends TestCase
{
    use CreatesEcommerceData, RefreshDatabase;

    public function test_customer_cannot_access_admin_panel_routes(): void
    {
        $customer = $this->createCustomer();

        $response = $this->actingAs($customer)->get(route('admin.products.index'));

        $response->assertRedirect(route('dashboard', absolute: false));
        $response->assertSessionHas('status', 'Akses admin hanya untuk administrator.');
    }

    public function test_admin_can_access_admin_panel_routes(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.products.index'));

        $response->assertOk();
    }
}
