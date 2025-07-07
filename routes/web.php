<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ItemContributionController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\IdeaAdminController;
use App\Http\Controllers\Admin\ProjectAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Middleware\IsAdmin;


// Halaman guest (belum login)
Route::get('/', function () {
    return view('guest'); // resources/views/guest.blade.php
})->middleware('guest')->name('landing');

// Halaman setelah login
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard'); // ganti jadi 'dashboard' biar konsisten
    
Route::get('/tentang-kami', function () {
    return view('about');
})->name('about');
//  Grup route yang hanya untuk user login
Route::middleware('auth')->group(function () {

    // Route untuk menampilkan halaman profil (index)
    // Tampilkan profil sendiri
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Edit profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update profil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Hapus akun
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ide
    Route::resource('ideas', IdeaController::class);
    Route::post('ideas/{idea}/vote', [IdeaController::class, 'vote'])->name('ideas.vote');

    // Proyek
    Route::resource('projects', ProjectController::class);
    // Produk UMKM untuk user login (kelola)
    Route::resource('products', ProductController::class);

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    // Komentar
    Route::post('/comments/reply-to/{comment}', [CommentController::class, 'reply'])->name('comments.reply');
    Route::post('/comments/{model}/{id}', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/vote', [CommentController::class, 'vote'])->name('comments.vote');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    Route::post('/project-items/{item}/contribute', [ItemContributionController::class, 'store'])->name('item-contributions.store');
    Route::delete('/project-items/{item}/cancel', [ItemContributionController::class, 'destroy'])->name('item-contributions.destroy');
    //map
    Route::get('/peta', [MapController::class, 'index'])->name('map.index');
    Route::get('/map', [MapController::class, 'index'])->name('map.index');

    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
     Route::get('/profile/activity', [ActivityController::class, 'index'])->name('profile.activity');


});

Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/activities', [ActivityController::class, 'adminIndex'])->name('activities.index');
        //pdf
        Route::get('/dashboard/export/pdf', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'exportPdf'])->name('dashboard.export.pdf');
        Route::get('/users/export/pdf', [UserAdminController::class, 'exportPDF'])->name('users.export.pdf');

        //user
        Route::get('/users', [\App\Http\Controllers\Admin\UserAdminController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UserAdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserAdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserAdminController::class, 'destroy'])->name('users.destroy');
        // IDEAS
        Route::get('/ideas', [IdeaAdminController::class, 'index'])->name('ideas.index');
        Route::get('/ideas/{id}', [IdeaAdminController::class, 'show'])->name('ideas.show');
        Route::get('/ideas/{id}/edit', [IdeaAdminController::class, 'edit'])->name('ideas.edit');
        Route::put('/ideas/{id}', [IdeaAdminController::class, 'update'])->name('ideas.update');
        Route::delete('/ideas/{id}', [IdeaAdminController::class, 'destroy'])->name('ideas.destroy');

        Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

        // PROJECTS
        Route::get('/projects', [ProjectAdminController::class, 'index'])->name('projects.index');
        Route::get('/projects/{id}', [ProjectAdminController::class, 'show'])->name('projects.show');
        Route::get('/projects/{id}/edit', [ProjectAdminController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{id}', [ProjectAdminController::class, 'update'])->name('projects.update'); // ✅ ini yang kurang
        Route::put('/projects/comments/{comment}', [ProjectAdminController::class, 'updateComment'])->name('projects.comments.update');
        Route::delete('/projects/{id}', [ProjectAdminController::class, 'destroy'])->name('projects.destroy');
         // Produk UMKM
        Route::get('/products', [ProductAdminController::class, 'index'])->name('products.index');
        Route::get('/products/{id}', [ProductAdminController::class, 'show'])->name('products.show');
        Route::get('/products/{id}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductAdminController::class, 'update'])->name('products.update');
        Route::put('/products/comments/{comment}', [ProductAdminController::class, 'updateComment'])->name('products.comments.update');
        Route::delete('/products/{id}', [ProductAdminController::class, 'destroy'])->name('products.destroy');
    });

require __DIR__.'/auth.php';
