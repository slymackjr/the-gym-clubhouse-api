<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function allInvoices()
    {
        $invoices = Invoice::all();
        if ($invoices) {
            return response()->json([
                'success' => true,
                'message' => 'Invoices retrieved successfully',
                'data' => $invoices
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No invoices found'
            ]);
        }
    }
    public function totalInvoices()
{
    $invoices = Invoice::all();
    $total = $invoices->count();
    return response()->json([
        'success' => true,
        'message' => $total > 0 ? 'Invoices retrieved successfully' : 'No Invoices found',
        'data' => $total,
    ]);
}

public function totalDiscounts()
{
    $total = Invoice::where('discount_percentage', '>', 0)->count();
    return response()->json([
        'success' => true,
        'message' => $total > 0 ? 'Discounts retrieved successfully' : 'No discounts found',
        'data' => $total,
    ]);
}


    public function addInvoice(Request $request)
    {
        $validatedData = $request->validate([
            'user_name' => 'required|string',
            'user_phone' => 'required|string',
            'user_email' => 'required|email',
            'member_name' => 'required|string',
            'member_id' => 'required|numeric',
            'member_phone' => 'required|string',
            'amount_paid' => 'required|numeric',
            'status' => 'nullable|string',
            'package_name' => 'required|string',
            'discount_percentage' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'memo' => 'nullable|string'
        ]);

        $invoice = Invoice::create($validatedData);
        $company = CompanyProfile::first();
        if ($invoice) {
            $this->generateInvoiceReport($invoice, $company);
            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully',
                'data' => $invoice
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create invoice'
            ]);
        }
    }

    public function updateInvoice(Request $request, int $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validatedData = $request->validate([
            'user_name' => 'sometimes|string',
            'user_phone' => 'sometimes|string',
            'user_email' => 'sometimes|email',
            'member_name' => 'sometimes|string',
            'member_phone' => 'sometimes|string',
            'amount_paid' => 'sometimes|numeric',
            'status' => 'sometimes|string',
            'package_name' => 'sometimes|string',
            'discount_percentage' => 'sometimes|numeric',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'memo' => 'sometimes|string'
        ]);

        $invoice->update($validatedData);

        if ($invoice) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice updated successfully',
                'data' => $invoice
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update invoice'
            ]);
        }
    }

    public function deleteInvoice(int $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceFilePath = $invoice->invoice_file;

        if (!empty($invoiceFilePath) && Storage::disk('public')->exists($invoiceFilePath)) {
            Storage::disk('public')->delete($invoiceFilePath);
        }

        $success = $invoice->delete();

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice deleted successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete invoice',
            ]);
        }
    }


    public function invoiceReport(int $id)
{
    $invoice = Invoice::findOrFail($id);
    $company = CompanyProfile::first();

    if (empty($invoice->invoice_file) || !Storage::disk('public')->exists($invoice->invoice_file)) {
        $this->generateInvoiceReport($invoice, $company);
    }

    return response()->json([
        'success' => true,
        'message' => 'Invoice report generated successfully',
        'data' => [
            'download_url' => asset("storage/{$invoice->invoice_file}"),
        ],
    ]);
}


    private function generateInvoiceReport(Invoice $invoice, CompanyProfile $company)
{
    $timestamp = now()->format('Ymd_His');
    $fileName = "invoice_report_{$timestamp}.pdf";
    $filePath = "invoices/{$fileName}";

    $pdf = app('dompdf.wrapper');
    $pdf->loadView('invoices.invoice', compact('invoice', 'company'));

    Storage::disk('public')->put($filePath, $pdf->output());

    $invoice->invoice_file = $filePath;
    $invoice->save();
}


    

}
