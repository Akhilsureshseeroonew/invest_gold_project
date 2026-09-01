<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');

// Collection detail pages — declared before the page catch-all.
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('blog.show');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/careers/{job:slug}', [CareerController::class, 'show'])->name('careers.show');
Route::post('/careers/{job:slug}/apply', [CareerController::class, 'apply'])->name('careers.apply');

// Every managed page, including nested slugs like products/gold-loan.
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '(?!admin|livewire|storage|build|assets)[A-Za-z0-9\-_/]+')
    ->name('page');
