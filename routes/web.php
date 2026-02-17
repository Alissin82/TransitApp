<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');
