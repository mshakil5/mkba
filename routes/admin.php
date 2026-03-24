<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyDetailsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TimelineController;
use App\Http\Controllers\Admin\TrusteeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');
    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user-update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::post('/user-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');

    // Slider
    Route::get('/slider', [SliderController::class, 'getSlider'])->name('allslider');
    Route::post('/slider', [SliderController::class, 'sliderStore']);
    Route::get('/slider/{id}/edit', [SliderController::class, 'sliderEdit']);
    Route::post('/slider-update', [SliderController::class, 'sliderUpdate']);
    Route::delete('/slider/{id}', [SliderController::class, 'sliderDelete'])->name('slider.delete');
    Route::post('/slider-status', [SliderController::class, 'toggleStatus']);
    Route::post('/sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.updateOrder');

    // Contact
    Route::get('/contacts', [ContactController::class,'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class,'show'])->name('contacts.show');
    Route::delete('/contacts/{id}/delete', [ContactController::class,'destroy'])->name('contacts.delete');
    Route::post('/contacts/toggle-status', [ContactController::class,'toggleStatus'])->name('contacts.toggleStatus');

    // FAQ
    Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');
    Route::post('/faq', [FAQController::class, 'store'])->name('faq.store');
    Route::get('/faq/{id}/edit', [FAQController::class, 'edit'])->name('faq.edit');
    Route::post('/faq-update', [FAQController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{id}', [FAQController::class, 'destroy'])->name('faq.delete');

    Route::get('/company-details', [CompanyDetailsController::class, 'index'])->name('admin.companyDetails');
    Route::post('/company-details', [CompanyDetailsController::class, 'update'])->name('admin.companyDetails');

    Route::get('/company/seo-meta', [CompanyDetailsController::class, 'seoMeta'])->name('admin.company.seo-meta');
    Route::post('/company/seo-meta/update', [CompanyDetailsController::class, 'seoMetaUpdate'])->name('admin.company.seo-meta.update');

    Route::get('/about-us', [CompanyDetailsController::class, 'aboutUs'])->name('admin.aboutUs');
    Route::post('/about-us', [CompanyDetailsController::class, 'aboutUsUpdate'])->name('admin.aboutUs');

    Route::get('/privacy-policy', [CompanyDetailsController::class, 'privacyPolicy'])->name('admin.privacy-policy');
    Route::post('/privacy-policy', [CompanyDetailsController::class, 'privacyPolicyUpdate'])->name('admin.privacy-policy');

    Route::get('/terms-and-conditions', [CompanyDetailsController::class, 'termsAndConditions'])->name('admin.terms-and-conditions');
    Route::post('/terms-and-conditions', [CompanyDetailsController::class, 'termsAndConditionsUpdate'])->name('admin.terms-and-conditions');
    
    Route::get('/mail-body', [CompanyDetailsController::class, 'mailBody'])->name('admin.mail-body');
    Route::post('/mail-body', [CompanyDetailsController::class, 'mailBodyUpdate'])->name('admin.mail-body');

    Route::get('/home-footer', [CompanyDetailsController::class, 'homeFooter'])->name('admin.home-footer');
    Route::post('/home-footer', [CompanyDetailsController::class, 'homeFooterUpdate'])->name('admin.home-footer');

    Route::get('/copyright', [CompanyDetailsController::class, 'copyright'])->name('admin.copyright');
    Route::post('/copyright', [CompanyDetailsController::class, 'copyrightUpdate'])->name('admin.copyright');

    Route::get('/master', [MasterController::class, 'index'])->name('master.index');
    Route::post('/master', [MasterController::class, 'store'])->name('master.store');
    Route::get('/master/{id}/edit', [MasterController::class, 'edit'])->name('master.edit');
    Route::post('/master-update', [MasterController::class, 'update'])->name('master.update');
    Route::delete('/master/{id}', [MasterController::class, 'destroy'])->name('master.delete');

    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::post('/sections/update-order', [SectionController::class, 'updateOrder'])->name('sections.updateOrder');
    Route::post('/sections/toggle-status', [SectionController::class, 'toggleStatus'])->name('sections.toggleStatus');

    // Category crud
    Route::get('/category', [CategoryController::class, 'index'])->name('allcategory');
    Route::get('/parent-categories', [CategoryController::class, 'parentCategories'])->name('parent.categories');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/category-update', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::post('/category-status', [CategoryController::class, 'toggleStatus']);

    
    // mission
    Route::get('/mission', [MissionController::class, 'index'])->name('mission.index');
    Route::post('/mission', [MissionController::class, 'store'])->name('mission.store');
    Route::get('/mission/{id}/edit', [MissionController::class, 'edit'])->name('mission.edit');
    Route::post('/mission-update', [MissionController::class, 'update'])->name('mission.update');
    Route::delete('/mission/{id}', [MissionController::class, 'destroy'])->name('mission.delete');

    Route::get('/events', [EventController::class, 'index'])->name('event.index');
    Route::post('/event-store', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::post('/event-update', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('event.delete');

    Route::get('/activities', [ActivityController::class, 'index'])->name('activity.index');
    Route::post('/activity-store', [ActivityController::class, 'store'])->name('activity.store');
    Route::get('/activity/{id}/edit', [ActivityController::class, 'edit'])->name('activity.edit');
    Route::post('/activity-update', [ActivityController::class, 'update'])->name('activity.update');
    Route::delete('/activity/{id}', [ActivityController::class, 'destroy'])->name('activity.delete');

    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery-store', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::post('/gallery-update', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.delete');

    Route::get('/trustees', [TrusteeController::class, 'index'])->name('trustee.index');
    Route::post('/trustee-store', [TrusteeController::class, 'store'])->name('trustee.store');
    Route::get('/trustee/{id}/edit', [TrusteeController::class, 'edit'])->name('trustee.edit');
    Route::post('/trustee-update', [TrusteeController::class, 'update'])->name('trustee.update');
    Route::delete('/trustee/{id}', [TrusteeController::class, 'destroy'])->name('trustee.delete');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::post('/blog-store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blog-update', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('blog.delete');


    // About Content (Single Record)
    Route::get('/about-edit', [AboutController::class, 'editAbout'])->name('admin.about.edit');
    Route::post('/about-update', [AboutController::class, 'updateAbout'])->name('admin.about.update');

    // Timeline CRUD
    Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline.index');
    Route::post('/timeline-store', [TimelineController::class, 'store'])->name('timeline.store');
    Route::get('/timeline/{id}/edit', [TimelineController::class, 'edit'])->name('timeline.edit');
    Route::post('/timeline-update', [TimelineController::class, 'update'])->name('timeline.update');
    Route::delete('/timeline/{id}', [TimelineController::class, 'destroy'])->name('timeline.delete');



});