<?php

use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubCriteriaController;
use Illuminate\Routing\Route as RoutingRoute;
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
    Route::get('/index',function(){
        return view('index.index');
    });
    Route::middleware('auth.check')->group(function () {
        Route::controller(DashboardController::class)->name('dashboard.')->group(function () {
            Route::get('/', 'view')->name('view');
            Route::get('/user/add-user', 'viewAdd')->name('viewAdd');
            Route::post('/user/add', 'add')->name('add');
            Route::get('/user/edit-user/{user}', 'viewEdit')->name('viewEdit');
            Route::patch('/user/edit-user/{user}', 'edit')->name('edit');
            Route::delete('/user/{user}', 'delete')->name('delete');

            Route::get('/login','loginView')->name('login.view')->withoutMiddleware('auth.check');
            Route::post('/login/auth', 'auth')->name('login.auth')->withoutMiddleware('auth.check');
            Route::post('/logout', 'logout')->name('logout');
        });
        Route::controller(StudentController::class)->name('student.')->group(function () {
            Route::get('/student', 'view')->name('view');
            Route::get('/student/add-student', 'viewAdd')->name('viewAdd');
            Route::post('/student/add', 'add')->name('add');
            Route::get('/student/edit-student/{student}', 'viewEdit')->name('viewEdit');
            Route::patch('/student/edit-student/{student}', 'edit')->name('edit');
            Route::delete('/student/{student}', 'delete')->name('delete');
  
            Route::get('/students/import', [StudentController::class, 'viewImport'])->name('students.import');
            Route::post('/students/import', [StudentController::class, 'import'])->name('students.import.post');

        });
        Route::controller(GroupController::class)->name('group.')->group(function () {
            // Menampilkan Kelola Kelompok
            Route::get('/group', 'view')->name('view');
            // CRUD Kelas
            Route::get('/group/add-grade', 'viewAddGrade')->name('viewAddGrade');
            Route::post('/group/addG', 'addG')->name('addG');
            Route::get('/group/edit-grade/{grade}', 'viewEditGrade')->name('viewEditGrade');
            Route::patch('/group/edit-grade/{grade}', 'editG')->name('editG');
            Route::delete('/group/{grade}', 'deleteG')->name('deleteG');
            // CRUD Angkatan
            Route::get('/group/add-year', 'viewAddYear')->name('viewAddYear');
            Route::post('/group/addY', 'addY')->name('addY');
            Route::get('/group/edit-year/{year}', 'viewEditYear')->name('viewEditYear');
            Route::patch('/group/edit-year/{year}', 'editY')->name('editY');
            Route::delete('/group/delete/{year}', 'deletey')->name('deletey');
        });
        // Controller Kriteria
        Route::controller(CriteriaController::class)->name('criteria.')->group(function () {
            Route::get('/criteria', 'view')->name('view');
            Route::get('/criteria/add-criteria', 'viewAdd')->name('viewAdd');
            Route::post('/criteria/add', 'add')->name('add');
            Route::get('/criteria/edit-criteria/{criteria}', 'viewEdit')->name('viewEdit');
            Route::patch('/criteria/edit-criteria/{criteria}', 'edit')->name('edit');
            Route::delete('/criteria/{criteria}', 'delete')->name('delete');
        });
        //Controller Sub Kriteria
        Route::controller(SubCriteriaController::class)->name('subcriteria.')->group(function () {
            Route::get('/subcriteria', 'view')->name('view');
            Route::post('/subcriteria', 'add')->name('add');
            Route::patch('/subcriteria/edit/{subCriteria}', 'subCriteriaEdit')->name('edit');
            Route::delete('/subcriteria/delete/{subCriteria}', 'subCriteriaDelete')->name('delete');
        });

        Route::controller(RatingController::class)->name('rating.')->group(function () {
            Route::get('/rating', 'view')->name('view');
            Route::post('/rating', 'add')->name('add');
            Route::patch('/rating/edit/{rating}', 'edit')->name('edit');
            Route::delete('/rating/delete/{rating}', 'delete')->name('delete');
        });
        Route::controller(ResultController::class)->name('calculate.')->group(function () {
            Route::get('/kalkulasi', 'calculateView')->name('view');
            Route::post('/kalkulasi/proses', 'calculate')->name('process');
        });
    
    });




