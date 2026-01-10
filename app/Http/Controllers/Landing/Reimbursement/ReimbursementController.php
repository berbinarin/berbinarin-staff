<?php

namespace App\Http\Controllers\Landing\Reimbursement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecretaryFinance\Reimbursement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReimbursementController extends Controller
{
    public function index()
    {
        return view('landing.reimbursement.reimbursement-form');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_name' => 'required|string|max:255',
            'employee_division' => 'required|string|max:255',
            'employee_phone_number' => 'required|string|max:25',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'employee_account_name' => 'required|string|max:255',
            'employee_account_number' => 'required|string|max:255',
            'employee_bank_name' => 'required|string|max:255',
            'employee_signature' => 'required|string',
            'proof_file' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        $proofPaths = [];
        if ($request->hasFile('proof_file')) {
            $proofPaths[] = $request->file('proof_file')->store('reimbursements/proofs', 'public');
        }

        $signaturePath = $this->storeSignatureImage($validatedData['employee_signature']);
        if ($signaturePath === null) {
            return redirect()->back()
                ->withErrors(['employee_signature' => 'Tanda tangan tidak valid.'])
                ->withInput();
        }

        Reimbursement::create([
            'reimbursement_date' => now()->toDateString(),
            'employee_name' => $validatedData['employee_name'],
            'employee_division' => $validatedData['employee_division'],
            'employee_position' => 'Staff',
            'items' => [
                [
                    'no' => 1,
                    'description' => $validatedData['description'],
                    'date' => now()->toDateString(),
                    'amount' => (int) $validatedData['total_amount'],
                ],
            ],
            'total_amount' => (int) $validatedData['total_amount'],
            'employee_account_number' => $validatedData['employee_account_number'],
            'employee_account_name' => $validatedData['employee_account_name'],
            'employee_bank_name' => $validatedData['employee_bank_name'],
            'employee_signature_path' => $signaturePath,
            'employee_phone_number' => $validatedData['employee_phone_number'],
            'proof_path' => $proofPaths,
        ]);

        return redirect()->back()->with('success', 'Berhasil mengajukan reimburse!');
    }

    private function storeSignatureImage(string $signatureData): ?string
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $signatureData, $matches)) {
            return null;
        }

        $extension = strtolower($matches[1]);
        if (!in_array($extension, ['png', 'jpg', 'jpeg', 'webp'], true)) {
            return null;
        }

        $base64Data = substr($signatureData, strpos($signatureData, ',') + 1);
        $binaryData = base64_decode($base64Data, true);
        if ($binaryData === false) {
            return null;
        }

        $fileName = 'reimbursements/signatures/' . Str::uuid() . '.' . $extension;
        Storage::disk('public')->put($fileName, $binaryData);

        return $fileName;
    }
}
