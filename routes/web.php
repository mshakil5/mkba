<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// cache clear
Route::get('/clear', function() {
  Auth::logout();
  session()->flush();
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  return "Cleared!";
});

 Route::fallback(function () {
    return redirect('/');
});

require __DIR__.'/admin.php';

Auth::routes();

// Route::get('/', [HomeController::class, 'dashboard'])->name('home');
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('frontend.gallery');
Route::get('/trustee', [FrontendController::class, 'trustee'])->name('frontend.trustee');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/events', [FrontendController::class, 'events'])->name('frontend.events');
Route::get('/activities', [FrontendController::class, 'activities'])->name('frontend.activities');
Route::get('/blogs', [FrontendController::class, 'blogs'])->name('frontend.blogs');
Route::get('/blog/{slug}', [FrontendController::class, 'blogDetail'])->name('frontend.blogDetail');
Route::get('/event/{slug}', [FrontendController::class, 'eventDetail'])->name('frontend.eventDetail');
Route::post('/contact', [FrontendController::class, 'storeContact'])->name('contact.store');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user', 'verified']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');

});