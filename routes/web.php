<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\PostController;
use App\Models\Site;

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
//     return view('welcome');
// });

Auth::routes([
    'register' => false,
]);
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('sites', SiteController::class);
    Route::get('/sites/fetch/{id}', [App\Http\Controllers\SiteController::class, 'fetch'])->name('sites.fetch');
    Route::post('/sites/fetch_data', [App\Http\Controllers\SiteController::class, 'fetch_data'])->name('sites.fetch_data');
    Route::get('/setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/update', [App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');

    Route::get('/sites/api_send/{id}', [App\Http\Controllers\SiteController::class, 'api_send'])->name('sites.api_send');
    Route::post('/sites/api_send_data', [App\Http\Controllers\SiteController::class, 'api_send_data'])->name('sites.api_send_data');
});
Route::get('/', [PostController::class, 'index'])->name('posts.home');
// Route::get('/{site_id}/{site_slug}', [PostController::class, 'site_index'])->name('posts.site_index');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/{site_id}/posts/{id}/{slug?}', [PostController::class, 'show'])->name('posts.show');
Route::get('/view/{site_id}/{site_slug}/{page?}', [PostController::class, 'site_index'])->name('posts.site_index');
Route::get('/category/{site_id}/{id}/{slug?}/{page?}', [PostController::class, 'category_show'])->name('category.show');


Route::get('/{site_id}/uploads/{year}/{month}/{filename}', function ($site_id, $year, $month, $filename) {
    $site = Site::where('id', $site_id)->first();
    $remoteUrl = $site->url . "/wp-content/uploads/{$year}/{$month}/{$filename}";
    $response = Http::get($remoteUrl);
    if ($response->failed()) {
        abort(404, 'Image not found.');
    }
    return response($response->body(), 200, [
        'Content-Type' => $response->header('Content-Type'),
    ]);
})->where(['year' => '[0-9]+', 'month' => '[0-9]+', 'filename' => '.*']);

// wordpress start
// admin P5NB ZnAu d4nO qkI0 0Da9 RYGF
