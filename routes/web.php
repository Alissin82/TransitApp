<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');

Route::prefix('terminals')->name('terminals.')->group(function () {
    Route::livewire('/', 'pages::terminals.index')->name('index');
    Route::livewire('/create', 'pages::terminals.form')->name('create');
    Route::livewire('/{terminal}/edit', 'pages::terminals.form')->name('edit');
});

Route::prefix('transit-lines')->name('transit-lines.')->group(function () {
    Route::livewire('/', 'pages::transit-lines.index')->name('index');
    Route::livewire('/create', 'pages::transit-lines.form')->name('create');
    Route::livewire('/{transitLine}/edit', 'pages::transit-lines.form')->name('edit');
});
