<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TeamsController;

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

//TODO для реализации поддомена и переноса основного сайта сюда же
//Route::group(['domain' => '{account}.localhost'], function () {
//    Route::get('/', [ProfileController::class, 'index']);
//});

Route::get('/', function () {
    return redirect()->route("school.index");
});
Route::post('/auth', [LoginController::class, 'authenticate'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth']], function () {

    Route::post('/teams/update-teams', [TeamsController::class, 'updateKaratekiTeams']);
    Route::post('/tickets/get-info', [TicketController::class, 'getReport']);
    //Действия с балансом профиля
    Route::group(['prefix' => '/balance/{profile}'], function () {
        Route::get('/addPaymentForTicket', [ProfileController::class, 'addPaymentForTicket']);
        Route::get('/new-ticket', [ProfileController::class, 'newTicket']);
        Route::post('/update-balance', [ProfileController::class, 'updateBalance']);
        Route::get('/delete-profile', [ProfileController::class, 'destroy']);
    });

    //Действия с пользователями групп
    Route::group(['prefix' => '/group/{group}'], function () {
        Route::post('/add-karateki-to-group', [GroupController::class, 'addKaratekiToGroup']);
        Route::post('/remove-from-group', [GroupController::class, 'removeFromGroup']);
    });

    //Действия с абонементамим
    Route::group(['prefix' => '/profile/{profile}/ticket/{ticket}'], function() {
        Route::get('/resume-ticket', [TicketController::class, 'resumeTicket']);
        Route::get('/pause-ticket', [TicketController::class, 'pauseTicket']);
        Route::get('/close-ticket', [TicketController::class, 'closeTicket']);
        Route::get('/open-ticket', [TicketController::class, 'openTicket']);
    });

    //Resource контроллеры: school, karateki, group, visit, settings
    Route::resource('group', 'App\Http\Controllers\GroupController');
    Route::resource('coaches', 'App\Http\Controllers\CoachesController');
    Route::resource('karateki', 'App\Http\Controllers\KaratekiController');
    Route::resource('visit', 'App\Http\Controllers\VisitController');
    Route::resource('profile/{profile}/ticket', 'App\Http\Controllers\TicketController');
    Route::resource('school', 'App\Http\Controllers\SchoolController');
    Route::resource('teams', 'App\Http\Controllers\TeamsController');
    Route::resource('settings', 'App\Http\Controllers\SettingController');
});
Route::get('/teams-list', [TeamsController::class, 'teamsList']);

/*
GET	/photo	index	photo.index
GET	/photo/create	create	photo.create
POST	/photo	store	photo.store
GET	/photo/{photo}	show	photo.show
GET	/photo/{photo}/edit	edit	photo.edit
PUT/PATCH	/photo/{photo}	update	photo.update
DELETE	/photo/{photo}	destroy	photo.destroy
 */
