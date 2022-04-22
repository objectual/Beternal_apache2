<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\StateProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\admin\UserRoleController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\user\MediaController;
use App\Http\Controllers\user\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\NotificationController;
use App\Http\Controllers\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.home');
});

Route::get('/', function () {
    dd('working');
});

// start routes for ajax request
Route::get('/provinces/{id}', [StateProvinceController::class, 'getStateProvinces']);
Route::get('/cities/{id}', [CityController::class, 'getCities']);
Route::get('/filter-recipent/{contact_id}', [UserController::class, 'filterRecipent']);
// end routes for ajax request

// start footer routes
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::get('/splash', [HomeController::class, 'splash'])->name('splash');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/our-team', [HomeController::class, 'ourTeam'])->name('our-team');
Route::get('/our-solution', [HomeController::class, 'ourSolution'])->name('our-solution');
Route::get('/term-and-conditions', [HomeController::class, 'termAndConditions'])->name('term-and-conditions');
Route::get('/help-and-support', [HomeController::class, 'helpAndSupport'])->name('help-and-support');
Route::get('/forget-code', [HomeController::class, 'forgetCode'])->name('forget-code');
// end footer routes

Route::get('/survey', [HomeController::class, 'survey'])->name('servey');

Route::get('/dashboard', function () {
    return view('frontend.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::middleware('auth', 'user')->group(function () {
    // Route::get('/splash',[dashboardController::class, 'splash'])->name('splash');
    Route::get('/success-signup', [HomeController::class, 'successSignup'])->name('success-signup');
    Route::get('/my-account',[UserController::class, 'myAccountPage'])->name('user.profile');
    Route::get('/edit-account',[UserController::class, 'myAccountEdit'])->name('user.profile.edit');
    Route::post('/edit-account',[UserController::class, 'myAccountUpdate'])->name('user.profile.update');
    Route::group(['prefix' => 'recipents'], function () {
        Route::get('/',[UserController::class,'allRecipents'])->name('user.recipents');
        Route::get('add-form',[UserController::class,'addForm'])->name('user.recipents.add-form');
        Route::post('/add-recipent', [UserController::class, 'addRecipent'])->name('user.recipents.add-recipent');
        Route::get('view-recipent',[UserController::class,'viewRecipent'])->name('user.recipents.view-recipent');
        Route::get('/provinces/{id}', [StateProvinceController::class, 'getStateProvinces']);
        Route::get('/cities/{id}', [CityController::class, 'getCities']);
        Route::get('/add-group/{group_title}', [UserController::class, 'addGroup']);
    });
    Route::group(['prefix' => 'medias'], function () {
        Route::get('/',[MediaController::class,'media'])->name('user.medias');
        Route::get('capture-video',[MediaController::class,'captureVideo'])->name('user.medias.capture-video');
        Route::get('capture-audio',[MediaController::class,'captureAudio'])->name('user.medias.capture-audio');
        Route::get('capture-image',[MediaController::class,'captureImage'])->name('user.medias.capture-image');
        Route::post('upload-media',[MediaController::class,'uploadMedia'])->name('user.medias.upload-media');
        Route::post('store-media', [MediaController::class,'store'])->name('user.medias.store-media');
        Route::get('my-media',[MediaController::class,'myMedia'])->name('user.medias.my-media');
        Route::get('shared-media-recipents',[MediaController::class,'sharedMediaRecipents'])->name('user.medias.shared-media-recipents');
        Route::get('shared-media',[MediaController::class,'sharedMedia'])->name('user.medias.shared-media');
        Route::get('my-media-details',[MediaController::class,'myMediaDetails'])->name('user.medias.my-media-details');
    });
    Route::group(['prefix' => 'legacy'], function () {
        Route::get('/',[MediaController::class,'legacy'])->name('user.legacy');
        Route::get('/success-legacy',[MediaController::class,'successLegacy'])->name('user.success-legacy');
    });
    Route::group(['prefix' => 'schedule-media'], function () {
        Route::get('/',[MediaController::class,'scheduleMedia'])->name('user.schedule-media');
        Route::get('/delivery',[MediaController::class,'deliveryMedia'])->name('user.delivery');
        Route::get('/success-schedule',[MediaController::class,'successSchedule'])->name('user.success-schedule');
    });
    Route::group(['prefix' => 'subscription'], function () {
        Route::get('/',[SubscriptionController::class,'plans'])->name('user.subscription');
        Route::get('/subscription-successfull',[SubscriptionController::class,'subscriptionSuccessfull'])->name('user.subscription-successfull');
    });
    Route::group(['prefix' => 'payment'], function () {
        Route::get('/',[PaymentController::class,'payment'])->name('user.payment');
        Route::get('/payment-successfull',[PaymentController::class,'paymentSuccessfull'])->name('user.payment-successfull');
    });
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/',[NotificationController::class,'index'])->name('user.notifications');
    });
});

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
    Route::group(['prefix' => 'users'], function () {
        Route::get('/',[UserController::class,'index'])->name('admin.users');
        Route::get('show/{id}',[UserController::class,'show'])->name('admin.users.show');
        Route::post('update',[UserController::class,'store'])->name('admin.users.update');
    });
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/',[UserRoleController::class,'index'])->name('admin.roles');
        Route::get('add-form',[UserRoleController::class,'addForm'])->name('admin.roles.add-form');
        Route::post('add-update',[UserRoleController::class,'store'])->name('admin.roles.add-update');
        Route::get('show/{id}',[UserRoleController::class,'show'])->name('admin.roles.show');
    });
    Route::group(['prefix' => 'countries'], function () {
        Route::get('/',[CountryController::class,'index'])->name('admin.countries');
        Route::get('add-form',[CountryController::class,'addForm'])->name('admin.countries.add-form');
        Route::post('add-update',[CountryController::class,'store'])->name('admin.countries.add-update');
        Route::get('show/{id}',[CountryController::class,'show'])->name('admin.countries.show');
    });
    Route::group(['prefix' => 'provinces'], function () {
        Route::get('/',[StateProvinceController::class,'index'])->name('admin.provinces');
        Route::get('add-form',[StateProvinceController::class,'addForm'])->name('admin.provinces.add-form');
        Route::post('add-update',[StateProvinceController::class,'store'])->name('admin.provinces.add-update');
        Route::get('show/{id}',[StateProvinceController::class,'show'])->name('admin.provinces.show');
    });
    Route::group(['prefix' => 'cities'], function () {
        Route::get('/',[CityController::class,'index'])->name('admin.cities');
        Route::get('add-form',[CityController::class,'addForm'])->name('admin.cities.add-form');
        Route::post('add-update',[CityController::class,'store'])->name('admin.cities.add-update');
        Route::get('show/{id}',[CityController::class,'show'])->name('admin.cities.show');
        Route::get('/provinces/{id}', [StateProvinceController::class, 'getStateProvinces']);
    });
});
