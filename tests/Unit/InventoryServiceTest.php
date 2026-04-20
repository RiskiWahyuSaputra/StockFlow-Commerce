<?php

namespace Tests\Unit;

use App\Models\InventoryLog;
use App\Services\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\Concerns\CreatesEcommerceData;
use Tests\TestCase;

class InventoryServiceTest extends TestCase
{
    use CreatesEcommerceData, RefreshDatabase;

    public function test_restock_updates_stock_and_creates_inventory_log(): void
    {
        $admin = $this->createAdmin();
        $product = $this->createActiveProduct([
            'stock' => 4,
        ]);

        $inventoryService = app(InventoryService::class);

        $log = $inventoryService->restock($product->id, 6, $admin, 'Restock dari supplier test');

        $this->assertSame(10, $product->fresh()->stock);
        $this->assertSame(InventoryLog::TYPE_RESTOCK, $log->type);
        $this->assertSame(4, $log->quantity_before);
        $this->assertSame(6, $log->quantity_after - $log->quantity_before);
        $this->assertSame('Restock dari supplier test', $log->note);
    }

    public function test_change_stock_prevents_negative_inventory(): void
    {
        $product = $this->createActiveProduct([
            'stock' => 3,
        ]);

        $inventoryService = app(InventoryService::class);

        $this->expectException(ValidationException::class);

        $inventoryService->changeStock($product->id, -5, InventoryLog::TYPE_ADJUSTMENT, [
            'reference_type' => 'test_case',
            'reference_id' => 1,
        ]);
    }
}
