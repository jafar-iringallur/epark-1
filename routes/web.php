<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LibraryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
// */
// Route::any('/login', function () {
//     return view('login');
// });

// Route::post('/userlogin', [LibraryController::class, 'userLogin']);

 Route::any('/', [LibraryController::class, 'home'])->name('home');
 Route::any('/books', [LibraryController::class, 'bookCategories'])->name('bookCategories');
 Route::get('/book/{category}', [LibraryController::class, 'books'])->name('books');
 Route::get('/search', [LibraryController::class, 'search'])->name('search');
 Route::get('/load_books', [LibraryController::class, 'loadBook'])->name('load_books');

Route::any('/out', [LibraryController::class, 'out']);
Route::middleware(['auth'])->group(function () {
    Route::any('/home', [LibraryController::class, 'dashboard'])->name('admin.home');

    Route::get('/booklist/{category}', [LibraryController::class, 'booklist'])->name('admin.book');
    Route::get('/download/{category}', [LibraryController::class, 'download'])->name('admin.download');
    Route::any('/categories', [LibraryController::class, 'categories'])->name('admin.categories');

    Route::any('/books/add', [LibraryController::class, 'addBook'])->name('admin.book.add');
    Route::post('/books/save', [LibraryController::class, 'saveBook'])->name('admin.book.save');

    Route::any('/bookedit/{id}', [LibraryController::class, 'editBook'])->name('admin.book.edit');
    Route::post('/books/update', [LibraryController::class, 'updateBook'])->name('admin.book.update');

    Route::any('/bookdelete/{id}', [LibraryController::class, 'deleteBook'])->name('admin.book.delete');


    Route::get('/members', [LibraryController::class, 'memberlist'])->name('admin.member');
    Route::any('/members/add', [LibraryController::class, 'addMember'])->name('admin.member.add');
    Route::post('/members/save', [LibraryController::class, 'saveMember'])->name('admin.member.save');

    Route::any('/memberedit/{id}', [LibraryController::class, 'editMember'])->name('admin.member.edit');
    Route::post('/members/update', [LibraryController::class, 'updateMember'])->name('admin.member.update');

    Route::any('/memberdelete/{id}', [LibraryController::class, 'deleteMember'])->name('admin.member.delete');

    Route::any('/record/{type}', [LibraryController::class, 'record'])->name('admin.records');
    Route::any('/recordbook/{id}', [LibraryController::class, 'recordBook'])->name('admin.records.book');
    Route::any('/recordmember/{id}', [LibraryController::class, 'recordMember'])->name('admin.records.member');

    Route::post('/records/getmember/{type}', [LibraryController::class, 'getMember'])->name('admin.records.getmember');
    Route::post('/records/getbook/{type}', [LibraryController::class, 'getBook'])->name('admin.records.getbook');
    Route::post('/records/save/{type}', [LibraryController::class, 'saveRecord'])->name('admin.records.save');
    Route::post('/record/close/{type}', [LibraryController::class, 'closeRecord'])->name('admin.records.close');
    Route::post('/record/renew/{type}', [LibraryController::class, 'renewRecord'])->name('admin.records.renew');


});


// Route::get('/view/{id}', [StudentController::class,'view']);
// Route::get('/add', [StudentController::class,'add']);
// Route::post('/save', [StudentController::class,'save']);
// Route::get('/delete/{id}', [StudentController::class,'delete']);
// Route::get('/edit/{id}', [StudentController::class,'edit']);
// Route::post('/update/{id}', [StudentController::class,'update']);
 
Auth::routes();
