<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MixedController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Exports\MembersInvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[UserController::class,'login']);
Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
    Route::post('/add-user',[UserController::class,'addUser']);
    Route::post('/calculate-discount', [DiscountController::class, 'calculateDiscount']);
    Route::post('/discount', [DiscountController::class, 'addDiscount']);
    Route::post('/company', [CompanyProfileController::class, 'updateOrCreate']);
    Route::post('/package', [PackageController::class, 'addPackage']);

    Route::get('/all-users',[UserController::class,'allUsers']);
   
    Route::put('/member/{id}/update',[MemberController::class,'updateMember']);
    Route::put('/user/{id}/update',[UserController::class,'updateUser']);
    Route::put('/invoice/{id}/update',[UserController::class,'updateInvoice']);
    Route::put('/discount/{id}/toggle', [DiscountController::class, 'toggleActiveStatus']);
    Route::put('/discount/{id}/update', [DiscountController::class, 'updateDiscount']);
    Route::put('/package/{id}/update', [PackageController::class, 'updatePackage']);

    Route::delete('/member/{id}/delete',[MemberController::class,'deleteMember']);
    Route::delete('/user/{id}/delete',[UserController::class,'deleteUser']);
    Route::delete('/invoice/{id}/delete',[UserController::class,'deleteInvoice']);
    Route::delete('/invoices/{id}', [InvoiceController::class, 'deleteInvoice']);
    Route::delete('/discount/{id}/delete', [DiscountController::class, 'deleteDiscount']);
    Route::delete('/package/{id}/delete', [PackageController::class, 'deletePackage']);
});

Route::middleware(['auth:sanctum', 'ability:admin,user'])->group(function () {
    Route::post('/add-member',[MemberController::class,'addMember']);
    Route::post('/create-invoice',[InvoiceController::class,'addInvoice']);
    Route::post('/profile/{id}/image', [UserController::class, 'updateImage']);
    Route::post('/logout', [UserController::class, 'logout']);
    
    Route::put('/password/{id}/update', [UserController::class, 'updatePassword']);
    
    Route::get('/company', [CompanyProfileController::class, 'show']);
    Route::get('/all-members',[MemberController::class,'allMembers']);
    Route::get('/invoice-report/{id}/report',[InvoiceController::class,'invoiceReport']);
    Route::get('/invoice-reports',[InvoiceController::class,'allInvoices']);
    Route::get('/all-packages', [PackageController::class, 'allPackages']);
    Route::get('/package/{id}', [PackageController::class, 'package']);
    Route::get('/total-packages', [PackageController::class, 'totalPackages']);
    Route::get('/all-discounts',[DiscountController::class,'allDiscounts']);
    Route::get('/active-discounts',[DiscountController::class,'allActiveDiscounts']);
    Route::get('/total-members',[MemberController::class,'totalMembers']);
    Route::get('/total-invoices',[InvoiceController::class,'totalInvoices']);
    Route::get('/total-packages',[PackageController::class,'totalPackages']);
    Route::get('/total-discounts',[InvoiceController::class,'totalDiscounts']);
    Route::get('/totals',[MixedController::class,'fetchAllCounts']);
    Route::get('/user/{id}',[UserController::class,'user']);
    Route::get('/member/{id}',[MemberController::class,'member']);
    Route::get('/invoice/{id}',[UserController::class,'invoice']);
    Route::get('/company', [CompanyProfileController::class, 'show']);
    Route::get('/profile/{id}', [UserController::class, 'getProfile']);
    Route::get('/monthly-reports', [ReportController::class, 'getMonthlyReports']);
    Route::get('/download-report', [ReportController::class, 'downloadReport']);
    Route::get('/export-members-invoices', function () {
        return Excel::download(new MembersInvoicesExport, 'members_invoices.xlsx');
    });
    #Route::get('/chart-report', [ReportController::class, 'downloadChartReport']);
});