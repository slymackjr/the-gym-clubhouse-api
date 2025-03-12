<?php

use Illuminate\Support\Facades\Route;

Route::get('/invoice-template', function () {
    return view('invoices.invoice');
});
