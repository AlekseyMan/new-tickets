<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitController;

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
    return view('layouts.index');
});
Route::post('/auth', [LoginController::class, 'authenticate'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth']], function () {

    //Действия с балансом профиля
    Route::group(['prefix' => '/balance/{profile}'], function(){
        Route::post('/update', [ProfileController::class, 'updateBalance']);
        Route::post('/new-ticket', [ProfileController::class, 'newTicket']);
    });

    //Действия с пользователями групп
    Route::group(['prefix' => '/group/{group}'], function() {
        Route::post('/add-karateki-to-group', [GroupController::class, 'addKaratekiToGroup']);
        Route::post('/remove-from-group', [GroupController::class, 'removeFromGroup']);
    });

    //Resource контроллеры: school, karateki, group, visit
    Route::resource('group', 'App\Http\Controllers\GroupController');
    Route::resource('karateki', 'App\Http\Controllers\KaratekiController');
    Route::resource('visit', 'App\Http\Controllers\VisitController');
    Route::resource('profile/{profile}/ticket', 'App\Http\Controllers\TicketController');
    Route::resource('school', 'App\Http\Controllers\SchoolController', ['names' => [
        '/' => 'school.index'
    ]]);
});

/*
GET	/photo	index	photo.index
GET	/photo/create	create	photo.create
POST	/photo	store	photo.store
GET	/photo/{photo}	show	photo.show
GET	/photo/{photo}/edit	edit	photo.edit
PUT/PATCH	/photo/{photo}	update	photo.update
DELETE	/photo/{photo}	destroy	photo.destroy
 */