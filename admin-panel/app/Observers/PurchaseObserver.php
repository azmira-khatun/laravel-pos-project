<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Product;
use Carbon\Carbon;

class PurchaseObserver
{
    /**
     * Handle the Purchase "created" event. (As previously implemented)
     */
    public function created(Purchase $purchase): void
    {
        $product = Product::find($purchase->product_id);

        if ($product) {
            Stock::create([
                'product_id' => $purchase->product_id,
                'product_name' => $product->product_name ?? $product->name, // Ensure you get the correct name column
                'quantity' => $purchase->product_quantity, // Incoming quantity is positive
                'purchase_id' => $purchase->id,
                'vendor_id' => $purchase->vendor_id,
                'unit_cost' => $purchase->product_price,
                'transaction_type' => 'Purchase',
                'movement_date' => $purchase->purchase_date ?? Carbon::now(),
                // 'stock_after' calculation logic (if implemented)
            ]);
        }
    }

    /**
     * Handle the Purchase "updated" event.
     * Adjusts the stock if the product or quantity has changed.
     */
    public function updated(Purchase $purchase): void
    {
        // Check if the quantity or product was changed
        if ($purchase->isDirty('product_quantity') || $purchase->isDirty('product_id')) {

            $oldQuantity = $purchase->getOriginal('product_quantity');
            $newQuantity = $purchase->product_quantity;
            $quantityDifference = $newQuantity - $oldQuantity;

            // Get the ID of the product *after* the update (in case product_id changed)
            $newProductId = $purchase->product_id;
            $product = Product::find($newProductId);

            if ($product && $quantityDifference !== 0) {
                // Create a new stock movement reflecting the difference
                Stock::create([
                    'product_id' => $newProductId,
                    'product_name' => $product->product_name ?? $product->name,
                    // The quantity can be positive (increase) or negative (decrease)
                    'quantity' => $quantityDifference,
                    'purchase_id' => $purchase->id,
                    'vendor_id' => $purchase->vendor_id,
                    'unit_cost' => $purchase->product_price,
                    'transaction_type' => 'Purchase Correction',
                    'note' => 'Adjustment for updated purchase ID: ' . $purchase->id,
                    'movement_date' => Carbon::now(),
                ]);
            }
        }
    }

    /**
     * Handle the Purchase "deleted" event.
     * Reverses the original stock movement.
     */
    public function deleted(Purchase $purchase): void
    {
        $product = Product::find($purchase->product_id);

        if ($product) {
            // Create a negative stock movement to reverse the purchase quantity
            Stock::create([
                'product_id' => $purchase->product_id,
                'product_name' => $product->product_name ?? $product->name,
                // Quantity is negative to subtract from stock
                'quantity' => -$purchase->product_quantity,
                'purchase_id' => $purchase->id,
                'vendor_id' => $purchase->vendor_id,
                'unit_cost' => $purchase->product_price,
                'transaction_type' => 'Purchase Reversal',
                'note' => 'Reversal for deleted purchase ID: ' . $purchase->id,
                'movement_date' => Carbon::now(),
            ]);
        }

        // OPTIONAL: Delete the original stock movement(s) associated with this purchase.
// It's generally better to keep historical movements, but if you want to clean up:
// Stock::where('purchase_id', $purchase->id)->delete();
    }

    // ... other methods (restored, forceDeleted, etc.)
}