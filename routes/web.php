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

// Route::get('/', function () {
//     return view('frontend.home');
// });

// Route::get('/set-countries', [HomeController::class, 'setCountries'])->name('set-countries');
// Route::get('/set-states', [HomeController::class, 'setStates'])->name('set-states');
// Route::get('/set-cities', [HomeController::class, 'setCities'])->name('set-cities');
// Route::get('/cities-data/{id}', [HomeController::class, 'citiesData'])->name('cities-data');

Route::get('/', [HomeController::class, 'index'])->name('index');

// Route::get('/', function () {
//     return view('welcome');
// });

// start routes for ajax request
Route::get('/provinces/{id}', [StateProvinceController::class, 'getStateProvinces']);
Route::get('/cities/{id}', [CityController::class, 'getCities']);
Route::get('/filter-recipent/{contact_id}', [UserController::class, 'filterRecipent']);
Route::get('/set-timezone/{user_timezone}', [HomeController::class, 'setTimezone']);
Route::get('/schedule-timezone/{timezone}/{state}', [MediaController::class, 'scheduleTimezone']);
Route::get('/device-token/{toke}', [UserController::class, 'updateDeviceToken']);
// end routes for ajax request


// start footer routes
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::get('/splash', [HomeController::class, 'splash'])->name('splash');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/our-team', [HomeController::class, 'ourTeam'])->name('our-team');
Route::get('/our-solution', [HomeController::class, 'ourSolution'])->name('our-solution');
Route::get('/term-and-conditions', [HomeController::class, 'termAndConditions'])->name('term-and-conditions');
Route::get('/help-and-support', [HomeController::class, 'helpAndSupport'])->name('help-and-support');
// end footer routes

Route::get('/forget-code', [HomeController::class, 'forgetCode'])->name('forget-code');
Route::get('/survey', [HomeController::class, 'survey'])->name('servey');
Route::get('/confirmation/{token}', [UserController::class, 'recipientConfirmation'])->name('confirmation');
Route::get('/confirmation-success/{token}', [UserController::class, 'updateConfirmation'])->name('confirmation-success');
Route::get('/deny/{token}', [UserController::class, 'recipientDeny'])->name('deny');
Route::get('/confirmation-contact/{token}', [UserController::class, 'contactConfirmation'])->name('confirmation-contact');
Route::get('/contact-success/{token}', [UserController::class, 'updateContactConfirmation'])->name('contact-success');
Route::get('/deny-contact/{token}', [UserController::class, 'contactDeny'])->name('deny-contact');
Route::get('/user-status/{token}', [UserController::class, 'userStatus'])->name('user-status');
Route::get('/status-success/{token}', [UserController::class, 'updateUserStatus'])->name('status-success');
Route::get('/email-status/{type}/{token}', [UserController::class, 'updateEmailStatus'])->name('email-status');
Route::get('/distribution/{type}/{token}', [UserController::class, 'distributionStatus'])->name('distribution');
Route::get('/legacy-confirmation/{type}/{token}', [UserController::class, 'legacyConfirmation'])->name('legacy-confirmation');
Route::get('/media-url/{token}', [MediaController::class, 'displayEventMedia'])->name('received');
Route::get('/dev-testing', [HomeController::class, 'devloperTesting'])->name('dev-testing');

require __DIR__.'/auth.php';
Route::middleware('auth', 'user')->group(function () {
    Route::get('/dashboard',[dashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/success-signup', [HomeController::class, 'successSignup'])->name('success-signup');
    Route::get('/my-account',[UserController::class, 'myAccountPage'])->name('user.profile');
    Route::get('/edit-account',[UserController::class, 'myAccountEdit'])->name('user.profile.edit');
    Route::post('/edit-account',[UserController::class, 'myAccountUpdate'])->name('user.profile.update');
    Route::group(['prefix' => 'recipents'], function () {
        Route::get('/',[UserController::class,'allRecipents'])->name('user.recipents');
        Route::get('add-form',[UserController::class,'addForm'])->name('user.recipents.add-form');
        Route::post('/add-recipent', [UserController::class, 'addRecipent'])->name('user.recipents.add-recipent');
        Route::get('view-recipent/{id}',[UserController::class,'viewRecipent'])->name('user.recipents.view-recipent');
        Route::get('edit-recipent',[UserController::class,'editRecipent'])->name('user.recipents.edit-recipent');
        Route::post('/update-recipent', [UserController::class, 'updateRecipent'])->name('user.recipents.update-recipent');
        Route::get('delete-recipent/{id}',[UserController::class,'deleteRecipent'])->name('user.recipents.delete-recipent');
        Route::get('/provinces/{id}', [StateProvinceController::class, 'getStateProvinces']);
        Route::get('/cities/{id}', [CityController::class, 'getCities']);
        Route::get('/add-group/{group_title}', [UserController::class, 'addGroup']);
    });
    Route::group(['prefix' => 'media'], function () {
        Route::get('/add-media',[MediaController::class,'media'])->name('user.media');
        Route::get('capture-video',[MediaController::class,'captureVideo'])->name('user.media.capture-video');
        Route::get('upload-video',[MediaController::class,'uploadVideoFromMobile'])->name('user.media.upload-video');
        Route::get('capture-audio',[MediaController::class,'captureAudio'])->name('user.media.capture-audio');
        Route::get('capture-image',[MediaController::class,'captureImage'])->name('user.media.capture-image');
        Route::post('upload-media',[MediaController::class,'uploadMedia'])->name('user.media.upload-media');
        Route::post('store-media', [MediaController::class,'store'])->name('user.media.store-media');
        Route::get('my-media',[MediaController::class,'myMedia'])->name('user.media.my-media');
        Route::get('my-media-details/{id}',[MediaController::class,'myMediaDetails'])->name('user.media.my-media-details');
        Route::get('my-media-delete/{id}',[MediaController::class,'myMediaDelete'])->name('user.media.my-media-delete');
        Route::get('my-media-edit/{id}',[MediaController::class,'myMediaEdit'])->name('user.media.my-media-edit');
        Route::post('update-media',[MediaController::class,'updateMedia'])->name('user.media.update-media');
        Route::get('shared-media',[MediaController::class,'sharedMedia'])->name('user.media.shared-media');
        Route::get('shared-media-recipents',[MediaController::class,'sharedMediaRecipents'])->name('user.media.shared-media-recipents');
    });
    Route::group(['prefix' => 'legacy'], function () {
        Route::get('/',[MediaController::class,'legacy'])->name('user.legacy');
        Route::get('legacy-details/{id}',[MediaController::class,'myLegacyDetails'])->name('user.legacy-details');
        Route::get('legacy-delete/{id}',[MediaController::class,'legacyDelete'])->name('user.legacy-delete');
        Route::get('legacy-edit/{id}',[MediaController::class,'legacyEdit'])->name('user.legacy-edit');
        Route::post('legacy-update',[MediaController::class,'legacyUpdate'])->name('user.legacy-update');
        Route::get('legacy-add/{id}',[MediaController::class,'legacyAdd'])->name('user.legacy-add');
        Route::get('/success-legacy',[MediaController::class,'successLegacy'])->name('user.success-legacy');
    });
    Route::group(['prefix' => 'schedule-media'], function () {
        Route::get('/',[MediaController::class,'scheduleMedia'])->name('user.schedule-media');
        Route::get('/delivery',[MediaController::class,'deliveryMedia'])->name('user.delivery');
        Route::post('/schedule-delivery',[MediaController::class,'scheduleDeliveryMedia'])->name('user.schedule-delivery');
        Route::get('/success-schedule',[MediaController::class,'successSchedule'])->name('user.success-schedule');
        // Route::get('/details-schedule',[MediaController::class,'detailsSchedule'])->name('user.details-schedule');
        Route::get('/delete-schedule/{id}',[MediaController::class,'deleteSchedule'])->name('user.delete-schedule');
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
        Route::get('delete/{id}',[UserController::class,'deleteUser'])->name('admin.users.delete');
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
