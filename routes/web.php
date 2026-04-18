<?php

use Illuminate\Support\Facades\Route;

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

// Frontend Routes (Home, Rooms, Restaurant, etc.)
require __DIR__ . '/frontend.php';

// Admin Routes (Dashboard, CMS, Management)
require __DIR__ . '/admin.php';

// Global Auth Routes (Laravel Breeze/Default)
require __DIR__ . '/auth.php';

