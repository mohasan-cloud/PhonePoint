<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\ModulesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilerController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\ImageModuleController;
use App\Http\Controllers\ModulesDataController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteSettingController;

use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\TechioMarektingController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\WidgetsdetailController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Livewire\Controllers\HttpConnectionHandler;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\BillController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopBillController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// routes/web.php


// routes/web.php

Route::post('/search-by-shop-name', [ShopBillController::class, 'searchByShopName'])->name('search.shop.name');
Route::post('/search-by-unique-id', [ShopBillController::class, 'searchByUniqueId'])->name('search.unique.id');

Route::get('/update-wholesale-prices', [ProductController::class, 'updateWholesalePrices']);

Route::post('/bills/export-last-month', [BillController::class, 'exportLastMonth'])->name('bills.exportLastMonth');
Route::get('/update-product-profit', [ProductController::class, 'updateProductProfit']);

Route::resource('expenses', ExpenseController::class);

Route::get('shop/products/details/{barcode}', [ShopBillController::class, 'shopgetProductDetails']);
Route::post('/products/export', [ProductController::class, 'exportProducts'])->name('products.export');

Route::resource('categories', CategoryController::class);

Route::post('/discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discounts.toggleStatus');

Route::resource('discounts', DiscountController::class);

Route::post('/find-shop', [ShopController::class, 'findShop']);
Route::get('shops/bills', [ShopBillController::class, 'index'])->name('shop.bills.index');

Route::get('/bills/{id}/shop', [ShopBillController::class, 'show'])->name('bills.show');




Route::get('/bills/{bill}/refund/shop', [ShopBillController::class, 'showRefundPage'])->name('shop.bills.refund');
Route::post('/bills/{bill}/refund/shop', [ShopBillController::class, 'processRefund'])->name('shop.bills.processRefund');



Route::get('/Shop/bill', [ShopBillController::class, 'listing'])->name('Shop.bill');
Route::post('shop/store/bill', [ShopBillController::class, 'storeBill']);
Route::post('shop/mark/pending-bill', [ShopBillController::class, 'markAsPending']);

Route::resource('shops', ShopController::class);

Route::post('/bills/{id}/pay', [BillController::class, 'markAsPaid'])->name('bills.markAsPaid');

Route::resource('products', ProductController::class)->except(['show']);
Route::get('products/{product}/print-barcode', [ProductController::class, 'printBarcode'])->name('products.printBarcode');
Route::get('/products/scan', [ProductController::class, 'scanMultiple'])->name('products.scanMultiple');
Route::get('/products/details/{identifier}', [ProductController::class, 'getProductDetails']);

Route::get('/bills/{bill}/refund', [BillController::class, 'showRefundPage'])->name('bills.refund');
Route::post('/bills/{bill}/refund', [BillController::class, 'processRefund'])->name('bills.processRefund');

Route::post('/mark/pending-bill', [BillController::class, 'markAsPending']);
Route::get('/bills/{id}', [BillController::class, 'show'])->name('bills.show');
Route::post('/bills/return', [BillController::class, 'processReturn'])->name('bills.processReturn');
Route::get('/bills/{bill}/products', [BillController::class, 'getProducts']);
Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
Route::get('pending/bills', [BillController::class, 'pendingbills'])->name('pending.bills');


Route::post('/store/bill', [BillController::class, 'storeBill']);

Route::get('/bills/{id}/details', [BillController::class, 'showDetails'])->name('bills.showDetails');

// Route::post('/bills/{id}/pending', [BillController::class, 'markAsPending']);

Route::get('/permissions-by-module', [ModulesController::class, 'getPermissionsByModule'])->name('permissions.by.module');
Route::get('/permissions-with-roles', [ModulesController::class, 'getPermissionsWithRoles']);
Route::post('/assign-roles-to-permission', [ModulesController::class, 'assignRolesToPermission'])->name('assign.roles.to.permission');
Route::post('/assign-role', [ModulesController::class, 'assignRole'])->name('assign.role');


Route::post('/signup', [SignupController::class, 'signup'])->name('signup.store');
Route::post('/verify-email', [SignupController::class, 'verifyEmail'])->name('signup.verify');



Route::get('/register', [SignupController::class, 'showSignupForm'])->name('signup.show');
Route::post('register', [SignupController::class, 'signup'])->name('signup.store');
Route::post('verify-email', [SignupController::class, 'verifyEmail'])->name('signup.verify');

Route::post('/subscribe', [SubscribeController::class, 'subscribe'])->name('subscribe');
Route::get('/get-departments', [DashboardController::class, 'getDepartments'])->name('getDepartments');
Route::get('/get-cards', [DashboardController::class, 'getCardsData'])->name('getCards');
Route::get('/getUserSelection', [DashboardController::class, 'getUserSelection'])->name('getUserSelection');
Route::post('/storeUserSelection', [DashboardController::class, 'storeUserSelection'])->name('storeUserSelection');
 Route::post('/clearUserSelection', [DashboardController::class, 'clearUserSelection'])->name('clearUserSelection');

 Route::post('/notify-it', [DashboardController::class, 'notifyIT'])->name('notifyIT');

 Route::post('new/get-departments', [ModulesController::class, 'getDepartmentsByIndustry'])->name('new.get.departments');
 Route::post('/save-permissions', [ModulesController::class, 'savePermissions']);



Route::delete('/routes/{id}', [RouteController::class, 'destroy'])->name('routes.destroy');
Route::post('/routes/update-order', [RouteController::class, 'updateOrder'])->name('routes.updateOrder');

Route::post('/contact/update-status', [ContactController::class, 'updateStatus'])->name('contact.update.status');

Route::get('contact/track', [ContactController::class, 'track'])->name('contact.track');
Route::post('contact/track', [ContactController::class, 'trackResult'])->name('contact.track.result');

Route::get('contact/details', [ContactController::class, 'showDetails'])->name('contact.details');
Route::get('track', [ContactController::class, 'track'])->name('trach.details');

Route::delete('/remove-route/{id}', [HeaderController::class, 'removeRoute'])->name('route.remove');

// In routes/web.php

Route::get('admin-settings', [AdminSettingController::class, 'createOrUpdate'])->name('admin-settings.index');
Route::post('admin-settings/update', [AdminSettingController::class, 'storeOrUpdate'])->name('admin-settings.update');

Route::get('/about/form/{id?}', [AboutController::class, 'form'])->name('about.form');
Route::post('/about/save/{id?}', [AboutController::class, 'save'])->name('about.save');





Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
Route::post('/routes', [RouteController::class, 'store'])->name('routes.store');
Route::get('/routes/edit/{id}', [RouteController::class, 'edit'])->name('routes.edit');



Route::resource('widgetsdetail', WidgetsdetailController::class);


Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('clear-compiled');
    Artisan::call('optimize:clear');

    return 'All caches cleared.';
});

Route::get('/get-stats', function () {
    $stats = App\Models\ModulesData::select('id', 'title', 'extra_field_1', 'extra_field_2', 'module_id')->whereIn('module_id', [1, 2])->where('status', 'active')->orderBy('id', 'DESC')->take(10)->get();

    return json_encode($stats);
});


Route::post('/get-alt-tag', function () {
    try {

        $alt = App\Models\Deal_images::where('image_name', request()->fileName)->first();
        echo $alt->alt_tag;
    } catch (\Exception $e) {
    }
});

Route::post('/post-alt-tag', function () {
    try {

        $alt = App\Models\Deal_images::where('image_name', request()->fileName)->first();
        $alt->alt_tag = request()->alt_tag;
        $alt->update();
        echo $alt->alt_tag;
    } catch (\Exception $e) {
    }
});



Route::get('/report', function () {
    return view('report');
});

Route::post('login', [LoginController::class, 'login']);


//Route::get('report', Report::class)->name('report');

Route::post('ajax_upload_file', [FilerController::class, 'upload'])->name('filer.image-upload');
Route::post('ajax_remove_file', [FilerController::class, 'fileDestroy'])->name('filer.image-remove');
Route::delete('/users/bulk-delete', [UsersController::class, 'bulkDelete'])->name('users.bulkDelete');

/*End Classes*/
Route::resource('users', UsersController::class);

/* Permissions*/
Route::get('/permissions-add', [PermissionsController::class, 'addshow'])->name('permissions.add');
Route::post('/permissions/store', [PermissionsController::class, 'store'])->name('permissions.store');
Route::get('/permissions-list', [PermissionsController::class, 'list'])->name('permissions.list');
Route::get('/permissions-edit/{encryptedId}', [PermissionsController::class, 'edit'])->name('permissions.edit');
Route::post('/permissions/update/{id}', [PermissionsController::class, 'update'])->name('permissions.update');
Route::post('/permissions/delete/{id}', [PermissionsController::class, 'delete'])->name('permissions.destroy');
Route::post('/update-permission', [PermissionsController::class, 'updatePermission']);

/* role*/
Route::get('/role-add', [RolesController::class, 'addshow'])->name('role.add');
Route::post('/role/store', [RolesController::class, 'store'])->name('role.store');
Route::get('/role-list', [RolesController::class, 'list'])->name('role.list');
Route::get('/role-edit/{encryptedId}', [RolesController::class, 'edit'])->name('role.edit');
Route::post('/role/update/{id}', [RolesController::class, 'update'])->name('role.update');
Route::post('/role/delete/{id}', [RolesController::class, 'delete'])->name('role.destroy');
Route::get('/role/{encryptedId}/give-permission', [RolesController::class, 'addPermissionToRole'])->name('addPermissionToRole');
Route::post('/role/{id}/update-permission', [RolesController::class, 'updatePermissiontorole'])->name('updatePermissiontorole');




Route::get('/', [WelcomeController::class, 'index'])
    ->name('WelcomeController')
    ->middleware(['log.traffic', 'check.access']);

Route::get('/fill-course-detail', [ModulesDataController::class, 'add'])->name('modules.data.add');
Route::post('/{module}/store', [ModulesDataController::class, 'store'])->name('modules.data.store');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});



Route::get('/link-storage', function () {
    try {
        // Define the source and target paths for the symbolic link
        $sourcePath = storage_path('app/public');
        $targetPath = public_path('custom-storage');

        // Create the symbolic link
        symlink($sourcePath, $targetPath);

        return 'Storage link created successfully';
    } catch (\Exception $e) {
        return 'Error creating storage link: ' . $e->getMessage();
    }
});


Route::get('/import', [CmsController::class, 'import'])->name('cms.import');
Route::get('/filter-states', [CmsController::class, 'filterStates'])->name('filter-states');
Route::get('/filter-cities', [CmsController::class, 'filterCities'])->name('filter-cities');

Route::get('/filter-sub-categories', [CmsController::class, 'filterSubCategories'])->name('filter-sub-categories');
Route::get('/filter-sub-sub-categories', [CmsController::class, 'filterSubSubCategories'])->name('filter-sub-sub-categories');


// Route::get('Blogs', [BlogController::class, 'get'])->name('get.Blogs');                                //comment this code
Route::get('/post/{slug}', [PostsController::class, 'detail'])->name('post.detail');
Route::get('/post-list', [PostsController::class, 'index'])->name('post.index');



Route::get('/{slug}', [CmsController::class, 'index'])->name('cms.page');
