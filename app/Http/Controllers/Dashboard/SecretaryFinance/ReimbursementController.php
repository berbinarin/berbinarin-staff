<?php

namespace App\Http\Controllers\Dashboard\SecretaryFinance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecretaryFinance\Reimbursement;
use App\Services\ReimbursementNumberService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class ReimbursementController extends Controller
{
    public function __construct(private ReimbursementNumberService $reimbursementNumberService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reimbursements = Reimbursement::orderBy('created_at', 'asc')->get();

        return view('dashboard.secretary-finance.reimbursements.index', compact('reimbursements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.secretary-finance.reimbursements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    public function show(string $id)
    {
        $reimbursementData = Reimbursement::findOrFail($id);

        return view('dashboard.secretary-finance.reimbursements.show', compact('reimbursementData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.secretary-finance.reimbursements.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function approve(Request $request, Reimbursement $reimbursement)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
            'approved_by' => 'nullable|string|max:255',
        ]);

        $approvedAt = now();
        $reimbursementNumber = $reimbursement->reimbursement_number;
        if (!$reimbursementNumber) {
            $reimbursementNumber = $this->reimbursementNumberService->createReimbursementNumber(
                Carbon::parse($approvedAt)
            );
        }

        $reimbursement->update([
            'status' => 'approved',
            'notes' => $validated['notes'] ?? null,
            'approved_by' => $validated['approved_by'] ?? optional(auth()->user())->name,
            'approved_at' => $approvedAt,
            'reimbursement_number' => $reimbursementNumber,
        ]);

        return redirect()->route('dashboard.reimbursement.index');
    }

    public function reject(Request $request, Reimbursement $reimbursement)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
            'approved_by' => 'nullable|string|max:255',
        ]);

        $reimbursement->update([
            'status' => 'rejected',
            'notes' => $validated['notes'] ?? null,
            'approved_by' => $validated['approved_by'] ?? optional(auth()->user())->name,
            'approved_at' => now(),
        ]);

        return redirect()->route('dashboard.reimbursement.index');
    }

    public function downloadProof(Reimbursement $reimbursement, int $index)
    {
        $proofs = $reimbursement->proof_path ?? [];
        if (!isset($proofs[$index])) {
            abort(404, 'Bukti tidak ditemukan.');
        }

        $path = $proofs[$index];
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        return Storage::disk('public')->download($path);
    }

    public function downloadSignature(Reimbursement $reimbursement)
    {
        $path = $reimbursement->employee_signature_path;
        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'Tanda tangan tidak ditemukan.');
        }

        return Storage::disk('public')->download($path);
    }

    public function exportDocx(Reimbursement $reimbursement)
    {
        $templatePath = storage_path('app/template/reimbursement.docx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template reimbursement tidak ditemukan.');
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        $formatRupiah = function ($amount) {
            return 'Rp. ' . number_format((float) $amount, 0, ',', '.');
        };

        $reimburseDate = $reimbursement->reimbursement_date
            ? Carbon::parse($reimbursement->reimbursement_date)->locale('id')->translatedFormat('d F Y')
            : '';

        $templateProcessor->setValue('reimburse_no', $reimbursement->reimbursement_number ?? '-');
        $templateProcessor->setValue('reimburse_date', $reimburseDate);
        $templateProcessor->setValue('employee_name', $reimbursement->employee_name ?? '');
        $templateProcessor->setValue('employee_division', $reimbursement->employee_division ?? '');
        $templateProcessor->setValue('employee_position', $reimbursement->employee_position ?? '');
        $templateProcessor->setValue('employee_phone_number', $reimbursement->employee_phone_number ?? '');
        $templateProcessor->setValue('employee_account_number', $reimbursement->employee_account_number ?? '');
        $templateProcessor->setValue('employee_bank_name', $reimbursement->employee_bank_name ?? '');
        $templateProcessor->setValue('employee_account_name', $reimbursement->employee_account_name ?? '');
        $templateProcessor->setValue('total_amount', $formatRupiah($reimbursement->total_amount ?? 0));

        $items = $reimbursement->items ?? [];
        $itemCount = count($items);
        $useClone = $itemCount > 1;

        if ($useClone) {
            $templateProcessor->cloneRow('no', $itemCount);
        }

        foreach ($items as $idx => $item) {
            $row = $idx + 1;
            $suffix = $useClone ? "#{$row}" : '';

            $itemDate = !empty($item['date'])
                ? Carbon::parse($item['date'])->format('d/m/Y')
                : '';
            $nominal = (float) ($item['amount'] ?? 0);

            $templateProcessor->setValue("no{$suffix}", $row);
            $templateProcessor->setValue("date{$suffix}", $itemDate);
            $templateProcessor->setValue("description{$suffix}", $item['description'] ?? '');
            $templateProcessor->setValue("nominal{$suffix}", $formatRupiah($nominal));
        }

        if ($itemCount === 0) {
            $templateProcessor->setValue('no', '-');
            $templateProcessor->setValue('date', '-');
            $templateProcessor->setValue('description', '-');
            $templateProcessor->setValue('nominal', $formatRupiah(0));
        }

        $this->setTemplateImage($templateProcessor, 'proof_image', $reimbursement->proof_path[0] ?? null, 220);
        $this->setTemplateImage($templateProcessor, 'signature', $reimbursement->employee_signature_path ?? null, 140);

        $reimbursementNumber = (string) ($reimbursement->reimbursement_number ?? '');
        $numericNumber = null;
        if (preg_match('/(\d{3})$/', $reimbursementNumber, $matches)) {
            $numericNumber = $matches[1];
        }
        $suffix = $numericNumber ?? (string) $reimbursement->id;
        $fileName = "Formulir Reimbursement-{$suffix}.docx";
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $tempPath = $tempDir . DIRECTORY_SEPARATOR . $fileName;

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }

    private function setTemplateImage(TemplateProcessor $templateProcessor, string $key, ?string $path, int $maxWidth): void
    {
        // Kalau tidak ada file: kosongkan placeholder gambar (jangan isi text "-")
        if (!$path || !Storage::disk('public')->exists($path)) {
            $templateProcessor->setValue($key, '');
            return;
        }

        $fullPath = Storage::disk('public')->path($path);

        $info = @getimagesize($fullPath);
        if ($info === false) {
            $templateProcessor->setValue($key, '');
            return;
        }

        [$w, $h] = $info;
        // hitung height biar ratio aman tanpa 'ratio' option
        $newW = $maxWidth;
        $newH = (int) round(($h / max($w, 1)) * $newW);

        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
            $templateProcessor->setValue($key, '');
            return;
        }

        $templateProcessor->setImageValue($key, [
            'path' => $fullPath,
            'width' => $newW,
            'height' => $newH,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reimbursement = Reimbursement::findOrFail($id);
        $reimbursement->delete();

        return redirect()->route('dashboard.reimbursement.index');
    }
}
