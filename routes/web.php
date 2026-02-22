<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/valentines', function () {
    return view('events.valentines');
})->name('valentines');

Route::get('/fathers-day', function () {
    return view('events.fathers-day');
})->name('fathers-day');

Route::get('/mothers-day', function () {
    return view('events.mothers-day');
})->name('mothers-day');

Route::get('/birthday', function () {
    return view('events.birthday');
})->name('birthday');

Route::get('/christmas', function () {
    return view('events.christmas');
})->name('christmas');

Route::get('/new-year', function () {
    return view('events.new-year');
})->name('new-year');
