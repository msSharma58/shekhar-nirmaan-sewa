<?php
// routes/web.php - ADD THESE ROUTES

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    ProjectController,
    ServiceController,
    TestimonialController,
    AdminContactController,
    MediaController,
    SettingsController,
};

// ── Public: Admin Login ──
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [AdminController::class, 'login'])->name('login')->middleware('guest');
    Route::post('login', [AdminController::class, 'loginPost'])->name('login.post');
    Route::post('logout',[AdminController::class, 'logout'])->name('logout');

    // ── Protected ──
    Route::middleware(['auth'])->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Projects
        Route::resource('projects', ProjectController::class);
        Route::patch('projects/{project}/toggle', [ProjectController::class, 'toggle'])->name('projects.toggle');

        // Services
        Route::get('services',              [ServiceController::class, 'index'])->name('services.index');
        Route::post('services',             [ServiceController::class, 'store'])->name('services.store');
        Route::put('services/{service}',    [ServiceController::class, 'update'])->name('services.update');
        Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

        // Testimonials
        Route::get('testimonials',                          [TestimonialController::class, 'index'])->name('testimonials.index');
        Route::post('testimonials',                         [TestimonialController::class, 'store'])->name('testimonials.store');
        Route::put('testimonials/{testimonial}',            [TestimonialController::class, 'update'])->name('testimonials.update');
        Route::delete('testimonials/{testimonial}',         [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
        Route::patch('testimonials/{testimonial}/toggle',   [TestimonialController::class, 'toggle'])->name('testimonials.toggle');

        // Messages / Contacts
        Route::get('messages',                       [AdminContactController::class, 'index'])->name('contacts.index');
        Route::patch('messages/{contact}/read',      [AdminContactController::class, 'markRead'])->name('contacts.read');
        Route::post('messages/read-all',             [AdminContactController::class, 'markAllRead'])->name('contacts.readAll');
        Route::delete('messages/{contact}',          [AdminContactController::class, 'destroy'])->name('contacts.destroy');

        // Media Library
        Route::get('media',              [MediaController::class, 'index'])->name('media');
        Route::post('media',             [MediaController::class, 'store'])->name('media.store');
        Route::delete('media/{media}',   [MediaController::class, 'destroy'])->name('media.destroy');

        // Settings
        Route::get('settings',              [SettingsController::class, 'index'])->name('settings');
        Route::put('settings',              [SettingsController::class, 'update'])->name('settings.update');
        Route::put('settings/hero',         [SettingsController::class, 'updateHero'])->name('settings.hero');
        Route::put('settings/stats',        [SettingsController::class, 'updateStats'])->name('settings.stats');
        Route::put('settings/password',     [SettingsController::class, 'updatePassword'])->name('settings.password');
    });
});
