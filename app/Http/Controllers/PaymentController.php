<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function receipt($id)
    {
        $payment = Payment::with(['student', 'course', 'enrollment'])
            ->findOrFail($id);

        // Check if user can access this receipt
        if (Auth::user()->hasRole('student') && $payment->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to payment receipt.');
        }

        return view('payments.receipt', compact('payment'));
    }

    public function downloadReceipt($id)
    {
        $payment = Payment::with(['student', 'course', 'enrollment'])
            ->findOrFail($id);

        // Check if user can access this receipt
        if (Auth::user()->hasRole('student') && $payment->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to payment receipt.');
        }

        // Generate PDF receipt (simplified version)
        $pdf = $this->generateReceiptPDF($payment);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf;
        }, 'receipt-' . $payment->transaction_id . '.pdf', [
            'Content-Type' => 'application/pdf'
        ]);
    }

    private function generateReceiptPDF($payment)
    {
        // This is a simplified version - in production, use a proper PDF library like DomPDF
        $html = view('payments.receipt-pdf', compact('payment'))->render();
        
        // For now, return HTML content
        // In production, convert this to PDF using a library
        return $html;
    }
}