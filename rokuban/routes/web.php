<?php

use Illuminate\Support\Facades\Route;
//Adding Controller here before using them:
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaypalController;
//Ading Livewire Class Component for using in route:
use App\Livewire\Gerant\UserEdit;
use App\Livewire\Gerant\UserAdd;
use App\Livewire\Gerant\OrderManager;
use App\Livewire\Figures\FigureList;
use App\Livewire\Figures\FigureShow;
use App\Livewire\Cart;
use App\Livewire\Checkout;
use App\Livewire\Gerant\ShippingEdit;
use App\Livewire\Gerant\ShippingAdd;
use App\Livewire\Gerant\FigureEdit;
use App\Livewire\Gerant\FigureAdd;
use App\Livewire\Gerant\ShippingCompanyEdit;
use App\Livewire\Gerant\ShippingCompanyAdd;
use App\Livewire\Gerant\BrandEdit;
use App\Livewire\Gerant\BrandAdd;
use App\Livewire\Gerant\CategoryAdd;
use App\Livewire\Gerant\CategoryEdit;
use App\Livewire\Gerant\ScaleAdd;
use App\Livewire\Gerant\ScaleEdit;
use App\Livewire\Gerant\TvaEdit;
use App\Livewire\Gerant\TvaAdd;

//Route::view('/', 'welcome'); //Original homepage by Laravel / not used

/**
 * Route Home page & others page with no special context
 */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home_nl', function () {
        return redirect('/home')->with('message', 'Utilisateur inactif. Veuillez contacter un administrateur par mail.');
    })->name('home.notlog');
Route::get('/legal', [HomeController::class, 'legal'])->name('legal');
Route::get('/confidentiality', [HomeController::class, 'polconf'])->name('polconf');
Route::get('/retractation', [HomeController::class, 'retract'])->name('retract');

/** 
 * Route Client-oriented 
 * */
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
//Order-view
Route::get('/orders', [OrdersController::class, 'index'])->middleware(['auth'])->name('orders.index');
Route::get('/orders/{order}', [OrdersController::class, 'show'])->middleware(['auth'])->name('orders.show');
//Order-dl
Route::get('/orders/{order}/invoice', [OrdersController::class, 'downloadInvoice'])->middleware(['auth', 'complete.profil'])->name('orders.invoice');

/** 
 * Route Figure view oriented
 * */

Route::get('/figures', FigureList::class)->name('figures.index');
Route::get('/figures/{id}', FigureShow::class)->name('figures.show');

/**
 * Route Cart & (fake) Checkout oriented
 */
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->middleware(['auth', 'complete.profil'])->name('checkout');
Route::get('/order/success/{orderId}', function ($orderId) 
    {
        return view('order-success', ['orderId' => $orderId]);
    })
    ->middleware(['auth', 'complete.profil'])->name('order.success');

/**
 * PayPal Payment oriented
 */
Route::get('/paypal-checkout', [PaypalController::class, 'show'])->name('paypal.checkout');
Route::post('/paypal/payment', [PaypalController::class, 'payment'])->name('paypal_payment');
Route::get('paypal/success', [PaypalController::class, 'success'])->name('paypal_success');
Route::get('paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal_cancel');

/** 
 * Route Gerant-oriented 
 * */
//Route::view('dashboard', 'dashboard')
//    ->middleware(['gerant'])
//    ->name('dashboard');
Route::view('gerant/home', 'gerant.home')->middleware(['gerant'])->name('geranthome');
Route::view('gerant/dashboard', 'gerant.dashboard')->middleware(['gerant'])->name('gerantdashboard');
//Users Management
Route::get('gerant/dashboard/users/add', UserAdd::class)->middleware(['gerant'])->name('gerant.users.add');
Route::get('gerant/dashboard/users/{id}/edit', UserEdit::class)->middleware(['gerant'])->name('gerant.users.edit');
//Orders Management
Route::get('gerant/dashboard/orders/{id}', OrderManager::class)->middleware(['gerant'])->name('gerant.orders.manage');
Route::get('/gerant/dashboard/orders/{id}/invoice',[OrdersController::class, 'downloadInvoiceGerant'])->middleware(['gerant'])->name('gerant.orders.invoice');
Route::get('/gerant/dashboard/orders/{id}/shipping-label',[OrdersController::class, 'generateLabel'])->middleware(['gerant'])->name('gerant.orders.shipping-label');
//Figure Management
Route::get('gerant/dashboard/figures/add', FigureAdd::class)->middleware(['gerant'])->name('gerant.figures.add');
Route::get('gerant/dashboard/figures/{id}/edit', FigureEdit::class)->middleware(['gerant'])->name('gerant.figures.edit');
//Shipping Management
Route::get('gerant/dashboard/shippings/add', ShippingAdd::class)->middleware(['gerant'])->name('gerant.shippings.add');
Route::get('gerant/dashboard/shippings/{id}/edit', ShippingEdit::class)->middleware(['gerant'])->name('gerant.shippings.edit');
//Shippingcompanies Management
Route::get('gerant/dashboard/shippingcompanies/add', ShippingCompanyAdd::class)->middleware(['gerant'])->name('gerant.shippingcompanies.add');
Route::get('gerant/dashboard/shippingcompanies/{id}/edit', ShippingCompanyEdit::class)->middleware(['gerant'])->name('gerant.shippingcompanies.edit');
//Brand Management
Route::get('gerant/dashboard/brands/add', BrandAdd::class)->middleware(['gerant'])->name('gerant.brands.add');
Route::get('gerant/dashboard/brands/{id}/edit', BrandEdit::class)->middleware(['gerant'])->name('gerant.brands.edit');
//Categories Management
Route::get('gerant/dashboard/categories/add', CategoryAdd::class)->middleware(['gerant'])->name('gerant.categories.add');
Route::get('gerant/dashboard/categories/{id}/edit', CategoryEdit::class)->middleware(['gerant'])->name('gerant.categories.edit');
//Scale Management
Route::get('gerant/dashboard/scales/add', ScaleAdd::class)->middleware(['gerant'])->name('gerant.scales.add');
Route::get('gerant/dashboard/scales/{id}/edit', ScaleEdit::class)->middleware(['gerant'])->name('gerant.scales.edit');
//TVA Management
Route::get('gerant/dashboard/tvas/add', TvaAdd::class)->middleware(['gerant'])->name('gerant.tvas.add');
Route::get('gerant/dashboard/tvas/{id}/edit', TvaEdit::class)->middleware(['gerant'])->name('gerant.tvas.edit');

require __DIR__.'/auth.php';
