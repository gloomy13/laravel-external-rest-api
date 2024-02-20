<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('/pets', '/');

Route::get('/search', function () {
    $id     = request('id');
    $status = request('status');

    if ($id) {
        return redirect()->route('pets.show', ['id' => $id]);
    } 
    elseif ($status) {
        return redirect()->route('findPetsByStatus', ['status' => $status]);
    } 
    else {
        return redirect()->route('home');
    }
})->name('search');

Route::get('/find-pets-by-status', [PetController::class, 'showFindPetsByStatusForm'])->name('showFindPetsByStatusForm');
Route::get('/find-pets-by-status/{status}', [PetController::class, 'findPetsByStatus'])->name('findPetsByStatus');

Route::prefix('pets')->group(function () {
    Route::get('/', [PetController::class, 'index'])->name('pets.index');
    Route::get('/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/', [PetController::class, 'store'])->name('pets.store');
    Route::get('/{id}', [PetController::class, 'show'])->name('pets.show');
    Route::get('/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/{id}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/{id}', [PetController::class, 'destroy'])->name('pets.destroy');
    Route::get('/{id}/upload-image', [PetController::class, 'showUploadImageForm'])->name('pets.showUploadImageForm');
    Route::post('/{id}', [PetController::class, 'uploadImage'])->name('pets.uploadImage');
});
