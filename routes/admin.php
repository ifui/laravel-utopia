<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 路由前缀： /admin
| 路由命名前缀： admin.
*/

// 注册
Route::post('/register', [AuthController::class, 'register'])->name('register');
// 登录
Route::post('/login', [AuthController::class, 'login'])->name('login');
// 用户登出
Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout'])->name('logout');
// 刷新令牌
Route::middleware('auth:sanctum')->get('/refresh', [AuthController::class, 'refresh'])->name('refresh');
// 登录用户信息
Route::middleware('auth:sanctum')->get('/userinfo', [AuthController::class, 'userinfo'])->name('userinfo');

// 管理员用户管理
Route::middleware('auth:sanctum')->resource('/admin_users', AdminUserController::class);
