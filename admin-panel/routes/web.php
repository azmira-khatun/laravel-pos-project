<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ExpiredProductController;
use App\Http\Controllers\DamageProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesItemController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\SalesInvoiceController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\ProfitRecordController;


Route::get('/', function () {
    return view('portal');
});
Route::get('/master', function () {
    return view('master');
});
Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboardCard');
});



Route::resource('roles', RoleController::class);

// ===================================
// 1. User Management Routes
// ===================================
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/add-user', [UserController::class, 'create'])->name('userCreate');
Route::post('userStore', [UserController::class, 'store'])->name('userStore');
Route::get('userEdit/{user_id}', [UserController::class, 'update'])->name('userEdit');
Route::post('editStoreU', [UserController::class, 'editStoreU'])->name('editStoreU');
Route::delete('delete', [UserController::class, 'destroy'])->name('delete');

// Category CRUD Routes (সংশোধিত এবং সঠিক)
Route::get('/add-category', [CategoryController::class, 'index'])->name('category.index'); // <-- 'category.index' নাম দিলাম
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');

// 'edit' রুটটি 'edit' মেথডকে কল করবে
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');

// 'update' রুটটি 'update' মেথডকে কল করবে এবং POST বা PUT ব্যবহার করবে
Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');

// 'delete' রুটটি 'destroy' মেথডকে কল করবে এবং ID বহন করবে
Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');

// sub category
Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('subCategory.index');
Route::get('/sub-categories/create', [SubCategoryController::class, 'create'])->name('subCategory.create');
Route::post('/sub-categories', [SubCategoryController::class, 'store'])->name('subCategory.store');
Route::get('/sub-categories/{subCategory}/edit', [SubCategoryController::class, 'edit'])->name('subCategory.edit');
Route::put('/sub-categories/{subCategory}', [SubCategoryController::class, 'update'])->name('subCategory.update');
Route::delete('/sub-categories/{subCategory}', [SubCategoryController::class, 'destroy'])->name('subCategory.destroy');

// Damage Products
Route::get('/damage-products', [DamageProductController::class, 'index'])->name('damageProduct.index');
Route::get('/damage-products/create', [DamageProductController::class, 'create'])->name('damageProduct.create');
Route::post('/damage-products', [DamageProductController::class, 'store'])->name('damageProduct.store');
Route::get('/damage-products/{damageProduct}/edit', [DamageProductController::class, 'edit'])->name('damageProduct.edit');
Route::put('/damage-products/{damageProduct}', [DamageProductController::class, 'update'])->name('damageProduct.update');
Route::delete('/damage-products/{damageProduct}', [DamageProductController::class, 'destroy'])->name('damageProduct.destroy');
Route::get('/damage-products/{damageProduct}', [DamageProductController::class, 'show'])->name('damageProduct.show');









Route::get('/product_units', [ProductUnitController::class, 'index'])->name('productUnitIndex');
Route::get('/product_units/create', [ProductUnitController::class, 'create'])->name('productUnitCreate');
Route::post('/product_units', [ProductUnitController::class, 'store'])->name('productUnitStore');
Route::get('/product_units/{unit}/edit', [ProductUnitController::class, 'edit'])->name('productUnitEdit');
Route::put('/product_units/{unit}', [ProductUnitController::class, 'update'])->name('productUnitUpdate');
Route::delete('/product_units/{unit}', [ProductUnitController::class, 'destroy'])->name('productUnitDelete');
Route::post('/products/store-multiple', [ProductController::class, 'storeMultiple'])->name('products.storeMultiple');


// Payment Method CRUD Routes
Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('paymentMethodIndex');
Route::get('/payment-methods/create', [PaymentMethodController::class, 'create'])->name('paymentMethodCreate');
Route::post('/payment-methods', [PaymentMethodController::class, 'store'])->name('paymentMethodStore');
Route::get('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'show'])->name('paymentMethodShow');
Route::get('/payment-methods/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('paymentMethodEdit');
Route::put('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('paymentMethodUpdate');
Route::delete('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('paymentMethodDelete');




// product start

Route::prefix('products')->group(function () {
    // List all products
    Route::get('/', [ProductController::class, 'index'])->name('products.index');

    // Create a single product
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');

    // Create multiple products
    Route::get('/create-multiple', [ProductController::class, 'createMultiple'])->name('products.createMultiple');
    Route::post('/store-multiple', [ProductController::class, 'storeMultiple'])->name('products.storeMultiple');

    // Edit / Update / Delete product
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
});



// // SINGLE PRODUCT CRUD
// Route::resource('products', ProductController::class);

// // MULTIPLE PRODUCT ROUTES
// Route::get('/products/create-multiple', [ProductController::class, 'createMultiple'])
//     ->name('products.createMultiple');

// Route::post('/products/store-multiple', [ProductController::class, 'storeMultiple'])
//     ->name('products.storeMultiple');



Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
Route::get('/discounts/create', [DiscountController::class, 'create'])->name('discounts.create');
Route::post('/discounts', [DiscountController::class, 'store'])->name('discounts.store');
Route::get('/discounts/{discount}', [DiscountController::class, 'show'])->name('discounts.show');
Route::get('/discounts/{discount}/edit', [DiscountController::class, 'edit'])->name('discounts.edit');
Route::put('/discounts/{discount}', [DiscountController::class, 'update'])->name('discounts.update');
Route::delete('/discounts/{discount}', [DiscountController::class, 'destroy'])->name('discounts.destroy');





// vendor start




Route::get('/vendors', [VendorController::class, 'index'])->name('vendorIndex');
Route::get('/vendors/create', [VendorController::class, 'create'])->name('vendorCreate');
Route::post('/vendors', [VendorController::class, 'store'])->name('vendorStore');
Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->name('vendorShow');
Route::get('/vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendorEdit');
Route::put('/vendors/{vendor}', [VendorController::class, 'update'])->name('vendorUpdate');
Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendorDelete');

// Customer CRUD Routes (স্ট্যান্ডার্ড Laravel পদ্ধতি)
Route::get('/customers', [CustomerController::class, 'index'])->name('customerIndex');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customerCreate');
Route::post('/customers', [CustomerController::class, 'store'])->name('customerStore');
Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customerShow');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customerEdit');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customerUpdate');
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customerDelete');


// Stock crud
// Stock Routes
Route::prefix('stocks')->group(function() {
    Route::get('/', [StockController::class, 'index'])->name('stocks.index');
    // Optional: যদি future-এ create/edit/delete চান
    // Route::get('/create', [StockController::class, 'create'])->name('stocks.create');
    // Route::post('/', [StockController::class, 'store'])->name('stocks.store');
    // Route::get('/{stock}/edit', [StockController::class, 'edit'])->name('stocks.edit');
    // Route::put('/{stock}', [StockController::class, 'update'])->name('stocks.update');
    // Route::delete('/{stock}', [StockController::class, 'destroy'])->name('stocks.destroy');
});
// Expired Products CRUD
Route::get('/expired_products', [ExpiredProductController::class, 'index'])->name('expiredProductsIndex');
Route::get('/expired_products/create', [ExpiredProductController::class, 'create'])->name('expiredProductsCreate');
Route::post('/expired_products', [ExpiredProductController::class, 'store'])->name('expiredProductsStore');
Route::get('/expired_products/{expiredProduct}/edit', [ExpiredProductController::class, 'edit'])->name('expiredProductsEdit');
Route::put('/expired_products/{expiredProduct}', [ExpiredProductController::class, 'update'])->name('expiredProductsUpdate');
Route::delete('/expired_products/{expiredProduct}', [ExpiredProductController::class, 'destroy'])->name('expiredProductsDelete');


Route::get('/purchase-returns', [PurchaseReturnController::class, 'index'])->name('purchaseReturns.index');
Route::get('/purchase-returns/create', [PurchaseReturnController::class, 'create'])->name('purchaseReturns.create');
Route::post('/purchase-returns', [PurchaseReturnController::class, 'store'])->name('purchaseReturns.store');
Route::get('/purchase-returns/{return}', [PurchaseReturnController::class, 'show'])->name('purchaseReturns.show');
Route::get('/purchase-returns/{return}/edit', [PurchaseReturnController::class, 'edit'])->name('purchaseReturns.edit');
Route::put('/purchase-returns/{return}', [PurchaseReturnController::class, 'update'])->name('purchaseReturns.update');
Route::delete('/purchase-returns/{return}', [PurchaseReturnController::class, 'destroy'])->name('purchaseReturns.destroy');





// 🧾 Purchases Routes
Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');

Route::get('/purchases/history', [PurchaseController::class, 'history'])->name('purchases.history');
Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
Route::put('/purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');



Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');

// routes/web.php

Route::prefix('sales-items')->group(function () {

    Route::get('/', [SalesItemController::class, 'index'])->name('salesitems.index');
    Route::get('/create', [SalesItemController::class, 'create'])->name('salesitems.create');
    Route::post('/', [SalesItemController::class, 'store'])->name('salesitems.store');
    Route::get('/{sales_item}', [SalesItemController::class, 'show'])->name('salesitems.show');
    Route::get('/{sales_item}/edit', [SalesItemController::class, 'edit'])->name('salesitems.edit');
    Route::put('/{sales_item}', [SalesItemController::class, 'update'])->name('salesitems.update');
    Route::delete('/{sales_item}', [SalesItemController::class, 'destroy'])->name('salesitems.destroy');

});

Route::get('/sales_invoices', [SalesInvoiceController::class, 'index'])->name('salesInvoiceIndex');
Route::get('/sales_invoices/{invoice}', [SalesInvoiceController::class, 'show'])->name('salesInvoiceShow');
Route::get('/sales_invoices/{invoice}/edit', [SalesInvoiceController::class, 'edit'])->name('salesInvoiceEdit');

// 🧾 Purchase Invoices Routes
// Purchase Invoices Routes

Route::get('/purchase-invoices', [PurchaseInvoiceController::class, 'index'])->name('purchaseInvoices.index');
Route::get('/purchase-invoices/create', [PurchaseInvoiceController::class, 'create'])->name('purchaseInvoices.create');
Route::post('/purchase-invoices', [PurchaseInvoiceController::class, 'store'])->name('purchaseInvoices.store');
Route::get('/purchase-invoices/{purchaseInvoice}', [PurchaseInvoiceController::class, 'show'])->name('purchaseInvoices.show');
Route::delete('/purchase-invoices/{purchaseInvoice}', [PurchaseInvoiceController::class, 'destroy'])->name('purchaseInvoices.destroy');




Route::get('/purchase-items', [PurchaseItemController::class, 'index'])
        ->name('purchase_items.index');

Route::get('/purchase-items/create', [PurchaseItemController::class, 'create'])->name('purchase_items.create');

Route::post('/purchase-items/store', [PurchaseItemController::class, 'store'])->name('purchase_items.store');

Route::get('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'show'])
        ->name('purchase_items.show');

Route::get('/purchase-items/{purchaseItem}/edit', [PurchaseItemController::class, 'edit'])
        ->name('purchase_items.edit');

Route::put('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'update'])
        ->name('purchase_items.update');

Route::delete('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'destroy'])
        ->name('purchase_items.destroy');



Route::get('/purchase_returns', [PurchaseReturnController::class, 'index'])->name('purchase_returns.index');
Route::get('/purchase_returns/create', [PurchaseReturnController::class, 'create'])->name('purchase_returns.create');
Route::post('/purchase_returns/store', [PurchaseReturnController::class, 'store'])->name('purchase_returns.store');
Route::get('/purchase_returns/{id}', [PurchaseReturnController::class, 'show'])->name('purchase_returns.show');
Route::get('/purchase_returns/{id}/edit', [PurchaseReturnController::class, 'edit'])->name('purchase_returns.edit');
Route::put('/purchase_returns/{id}', [PurchaseReturnController::class, 'update'])->name('purchase_returns.update');
Route::delete('/purchase_returns/{id}', [PurchaseReturnController::class, 'destroy'])->name('purchase_returns.destroy');

// AJAX route to fetch purchase data
Route::post('/purchase_returns/fetch_purchase_data', [PurchaseReturnController::class, 'fetchPurchaseData'])
    ->name('purchase_returns.fetch_purchase_data');





// Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
// Route::get('/stocks/create', [StockController::class, 'create'])->name('stocks.create');
// Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store');
// Route::get('/stocks/{stock}', [StockController::class, 'show'])->name('stocks.show');
// Route::get('/stocks/{stock}/edit', [StockController::class, 'edit'])->name('stocks.edit');
// Route::put('/stocks/{stock}', [StockController::class, 'update'])->name('stocks.update');
// Route::delete('/stocks/{stock}', [StockController::class, 'destroy'])->name('stocks.destroy');



// Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
// Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
// Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
// Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
// Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
// Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
// Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');





// Route::prefix('sales/{sale}')->group(function () {
//     Route::get('/items', [SaleItemController::class, 'index'])->name('sales.items.index');
//     Route::get('/items/create', [SaleItemController::class, 'create'])->name('sales.items.create');
//     Route::post('/items', [SaleItemController::class, 'store'])->name('sales.items.store');
//     Route::get('/items/{item}/edit', [SaleItemController::class, 'edit'])->name('sales.items.edit');
//     Route::put('/items/{item}', [SaleItemController::class, 'update'])->name('sales.items.update');
//     Route::delete('/items/{item}', [SaleItemController::class, 'destroy'])->name('sales.items.destroy');
// });



Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');


Route::get('/stock-movements', [StockMovementController::class, 'index'])->name('stockMovements.index');
Route::get('/stock-movements/create', [StockMovementController::class, 'create'])->name('stockMovements.create');
Route::post('/stock-movements', [StockMovementController::class, 'store'])->name('stockMovements.store');
Route::get('/stock-movements/{stockMovement}', [StockMovementController::class, 'show'])->name('stockMovements.show');




// Profit Records CRUD

Route::get('/profit-records', [ProfitRecordController::class, 'index'])->name('profit-records.index');
Route::get('/profit-records/{id}', [ProfitRecordController::class, 'show'])->name('profit-records.show');
