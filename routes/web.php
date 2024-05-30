<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LineItemController;
use App\Http\Controllers\PaymentController;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware(ThrottleRequests::using('login'));
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/', [CustomerController::class, 'list']);
Route::get('/customers/edit/{customerId}', [CustomerController::class, 'edit']);
Route::post('/customers/save/{customerId}', [CustomerController::class, 'save']);
Route::get('/customers/balance/{customerId}', [CustomerController::class, 'balance']);
Route::get('/customers', [CustomerController::class, 'list']);
Route::get('/invoices/pdf/{invoiceId}', [InvoiceController::class, 'pdf']);
Route::get('/invoices/edit/{invoiceId}/{customerId?}', [InvoiceController::class, 'edit']);
Route::post('/invoices/save/{invoiceId}', [InvoiceController::class, 'save']);
Route::get('/invoices/toggle-emailed/{invoiceId}', [InvoiceController::class, 'toggleEmailed']);
Route::get('/invoices', [InvoiceController::class, 'list']);
Route::get('/payments/edit/{paymentId}/{customerId?}', [PaymentController::class, 'edit']);
Route::post('/payments/save/{paymentId}', [PaymentController::class, 'save']);
Route::get('/payments', [PaymentController::class, 'list']);
Route::get('/line-items/edit/{invoiceId}/{lineItemId}', [LineItemController::class, 'edit']);
Route::post('/line-items/save/{lineItemId}', [LineItemController::class, 'save']);
