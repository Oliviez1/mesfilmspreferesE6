<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AmisController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\CreerCompteController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\PartageController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RechercherFilmController;
use App\Models\Partage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(AccueilController::class)->group(function () {
    Route::get('/', 'index')->name('accueil');
});

Route::controller(CreerCompteController::class)->group(function () {
    Route::get('/creercompte','displaycc')->name('creerCompte');
    Route::post('/creercompte','store')->name('creerComptePost');
});

Route::controller(ConnexionController::class)->group(function(){
    Route::get('/connexion','displaylogin')->name('login');
    Route::post('/connexion','store')->name('loginPost');
    Route::post('/deconnexion','destroy')->name('logout');
});

Route::controller(RechercherFilmController::class)->group(function () {
    Route::get('/rechercher-film','create')->name('rechercherFilm');
    Route::post('/rechercher-film','store')->name('rechercherFilmPost');
});

Route::middleware('auth')->group(function () {
    Route::controller(FavorisController::class)->group(function () {
        Route::get('/favoris','index')->name('favoris');
        Route::post('/favoris/ajouter','store')->name('favoris.add');
        Route::post('/favoris/{favori}','destroy')->name('favoris.destroy');
        Route::post('/favoris/{favori}/avis','updateAvis')->name('favoris.updateAvis');
    });

    Route::controller(AmisController::class)->group(function () {
        Route::get('/amis','index')->name('amis.index');
        Route::post('/amis/ajouter','store')->name('amis.add');
        Route::post('/amis/{ami}/supprimer','destroy')->name('amis.destroy');
    });

    Route::controller(PartageController::class)->group(function () {
        Route::get('/partages','index')->name('partages.index');
        Route::post('/partages/creer','store')->name('partages.store');
        Route::post('/partages/{partage}/supprimer','destroy')->name('partages.destroy');
    });

    Route::controller(ProfilController::class)->group(function () {
        Route::get('/profil','show')->name('profil.show');
        Route::post('/profil/mettre-a-jour','update')->name('profil.update');
    });
});