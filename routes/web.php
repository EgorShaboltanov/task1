<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;

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


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('layouts.app');
});



// Определяем маршруты для авторизации с использованием middleware 'guest'
Route::middleware('guest')->group(function() {
    
    // Маршрут для отображения формы входа (HTTP GET)
    // Когда пользователь перейдет по URL '/login', выполнится метод 'create' контроллера 'AuthenticatedSessionController'
    // Имя 'login' присваивается маршруту и может быть использовано для генерации URL
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');


     // Маршрут для обработки отправки формы входа (HTTP POST)
    // Когда пользователь отправит POST-запрос на URL '/login', выполнится метод 'store' контроллера 'AuthenticatedSessionController'

    Route::post('login',[AuthenticatedSessionController::class,'store']);


});



// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');


// Начало группы маршрутов с пространством имен 'App\Http\Controllers\Auth'
Route::group(['namespace'=> 'Auth'], function(){
     // Определение маршрута GET для страницы регистрации пользователя
    Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
     // Этот маршрут будет доступен по URL-адресу '/register'
     // Метод 'showRegistrationForm' контроллера 'RegisterController' будет вызван при обращении к маршруту
       // Все контроллеры в этой группе будут искаться в пространстве имен 'App\Http\Controllers\Auth'
    // Маршруту присвоено имя 'register', которое может быть использовано для генерации ссылок
    Route::post('/register',[RegisterController::class, 'createUserStore'])->name('createUser');
    
});


Route::middleware('auth')->group(function() {
Route::post('logout',[AuthenticatedSessionController::class,'destroy'])->name('logout');
});

Route::get('/home', function () {
    return view('layouts.home');
})->middleware('auth')->name('home');



Route::get('/statistics', 'OrderStatisticsController@orderStatistics')->name('statistics');



