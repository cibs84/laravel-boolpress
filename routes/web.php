<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

// Le regole per creare le rotte per instradare tutte le richieste da parte di un utente autenticato
Route::middleware('auth') // controlla che l'accesso sia consentito solo agli utenti loggati
->namespace('Admin') // per evitare di scrivere 'Admin\HomeController@index' come secondo argomento di get()
->name('admin.')    // va prima dell'argomento di name(), in questo caso 'name'. Tutti i name delle rotte inizieranno con 'admin.home'
->prefix('admin') // va prima del primo argomento di get(), in questo caso '/'. Tutti gli url inizieranno con '/admin/'
->group(function() { // raggruppa tutte le rotte per la parte di amministrazione del sito, in modo che abbiano applicate le modifiche dei metodi sopra 
	Route::get('/', 'HomeController@index')->name('home');
    Route::resource('posts', 'PostController');
    Route::resource('categories', 'CategoryController');
});

// Le regole per creare tutte le rotte relative alle richieste di un utente anonimo
Route::get('{any?}', function () {
    return view('guest.home');
})->where('any', '.*');