<?php

namespace App\Http\Controllers\Dashboard\SecretaryFinance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SecretaryFinance\Invoice;
use App\Services\InvoiceNumberService;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceNumberService $invoiceNumberService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::orderBy('invoice_date', 'asc')->get();

        return view('dashboard.secretary-finance.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = Carbon::today();
        $invoiceNumber = $this->invoiceNumberService->createInvoiceNumber($today);

        return view('dashboard.secretary-finance.invoices.create', [])->with([
            'invoiceNumber' => $invoiceNumber,
            'todayDate' => $today->format('Y-m-d'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50',
            'invoice_date' => 'required|date',

            'customer_name' => 'required|string|max:255',
            'customer_agency' => 'required|string|max:255',

            'products' => 'required|array|min:1',
            'products.*.description' => 'required|string|max:255',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit' => 'required|string|max:50',
            'products.*.unit_price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0',
        ]);

        $subtotalAmount = 0;
        $totalDiscount = 0;
        $products = [];

        foreach ($validated['products'] as $idx => $item) {
            $qty = (int) $item['quantity'];
            $price = (float) $item['unit_price'];
            $discount = isset($item['discount']) ? (float) $item['discount'] : 0;

            $beforeDiscount = $qty * $price;
            $lineSubtotal = max($beforeDiscount - $discount, 0);

            $subtotalAmount += $beforeDiscount;
            $totalDiscount += $discount;

            $products[] = [
                'no' => $idx + 1,
                'description' => $item['description'],
                'quantity' => $qty,
                'unit' => $item['unit'],
                'unit_price' => $price,
                'discount' => $discount,
                'subtotal' => $lineSubtotal,
            ];
        }

        $totalAmount = max($subtotalAmount - $totalDiscount, 0);

        // $terbilang = $this->terbilangRupiah((int) round($totalAmount));

        Invoice::create([
            'invoice_number' => $validated['invoice_number'],
            'invoice_date' => $validated['invoice_date'],
            'customer_name' => $validated['customer_name'],
            'customer_agency' => $validated['customer_agency'],
            'products' => $products, // ← array → auto JSON
            'subtotal_amount' => $subtotalAmount,
            'total_discount' => $totalDiscount,
            'total_amount' => $totalAmount,
        ]);

        return redirect()->route('dashboard.invoice.index');
    }

    private function penyebut(int $nilai): string
    {
        $nilai = abs($nilai);
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

        if ($nilai < 12) {
            return " " . $huruf[$nilai];
        } elseif ($nilai < 20) {
            return $this->penyebut($nilai - 10) . " Belas";
        } elseif ($nilai < 100) {
            return $this->penyebut((int) ($nilai / 10)) . " Puluh" . $this->penyebut($nilai % 10);
        } elseif ($nilai < 200) {
            return " Seratus" . $this->penyebut($nilai - 100);
        } elseif ($nilai < 1000) {
            return $this->penyebut((int) ($nilai / 100)) . " Ratus" . $this->penyebut($nilai % 100);
        } elseif ($nilai < 2000) {
            return " Seribu" . $this->penyebut($nilai - 1000);
        } elseif ($nilai < 1000000) {
            return $this->penyebut((int) ($nilai / 1000)) . " Ribu" . $this->penyebut($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            return $this->penyebut((int) ($nilai / 1000000)) . " Juta" . $this->penyebut($nilai % 1000000);
        } elseif ($nilai < 1000000000000) {
            return $this->penyebut((int) ($nilai / 1000000000)) . " Miliar" . $this->penyebut($nilai % 1000000000);
        } else {
            return $this->penyebut((int) ($nilai / 1000000000000)) . " Triliun" . $this->penyebut($nilai % 1000000000000);
        }
    }

    private function terbilangRupiah(int $nilai): string
    {
        if ($nilai === 0) {
            return "Nol Rupiah";
        }

        $result = trim($this->penyebut($nilai));
        return $result . " Rupiah";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoiceData = Invoice::findOrFail($id);

        return view('dashboard.secretary-finance.invoices.show', compact('invoiceData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoiceData = Invoice::findOrFail($id);

        return view('dashboard.secretary-finance.invoices.edit', compact('invoiceData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50',
            'invoice_date' => 'required|date',

            'customer_name' => 'required|string|max:255',
            'customer_agency' => 'required|string|max:255',

            'products' => 'required|array|min:1',
            'products.*.description' => 'required|string|max:255',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit' => 'required|string|max:50',
            'products.*.unit_price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0',
        ]);

        $subtotalAmount = 0;
        $totalDiscount = 0;
        $products = [];

        foreach ($validated['products'] as $idx => $item) {
            $qty = (int) $item['quantity'];
            $price = (float) $item['unit_price'];
            $discount = isset($item['discount']) ? (float) $item['discount'] : 0;

            $beforeDiscount = $qty * $price;
            $lineSubtotal = max($beforeDiscount - $discount, 0);

            $subtotalAmount += $beforeDiscount;
            $totalDiscount += $discount;

            $products[] = [
                'no' => $idx + 1,
                'description' => $item['description'],
                'quantity' => $qty,
                'unit' => $item['unit'],
                'unit_price' => $price,
                'discount' => $discount,
                'subtotal' => $lineSubtotal,
            ];
        }

        $totalAmount = max($subtotalAmount - $totalDiscount, 0);

        try {
            $invoice->update([
                'invoice_number' => $validated['invoice_number'],
                'invoice_date' => $validated['invoice_date'],
                'customer_name' => $validated['customer_name'],
                'customer_agency' => $validated['customer_agency'],
                'products' => $products, // ← array → auto JSON
                'subtotal_amount' => $subtotalAmount,
                'total_discount' => $totalDiscount,
                'total_amount' => $totalAmount,
            ]);

            return redirect()->route('dashboard.invoice.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update invoice: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'invoice_number' => $invoice->invoice_number . '-deleted',
        ]);

        $invoice->delete();

        return redirect()->route('dashboard.invoice.index');
    }

    public function exportDocx(Invoice $invoice)
    {
        $templatePath = storage_path('app/template/invoice.docx');
        if (!file_exists($templatePath)) {
            abort(404, 'Template invoice tidak ditemukan.');
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        $invoiceDate = $invoice->invoice_date
            ? Carbon::parse($invoice->invoice_date)->locale('id')->translatedFormat('d F Y')
            : '';

        $formatRupiah = function ($amount) {
            return 'Rp. ' . number_format((float) $amount, 0, ',', '.');
        };

        $templateProcessor->setValue('invoice_number', $invoice->invoice_number ?? '');
        $templateProcessor->setValue('invoice_date', $invoiceDate);
        $templateProcessor->setValue('customer_name', $invoice->customer_name ?? '');
        $templateProcessor->setValue('customer_agency', $invoice->customer_agency ?? '');
        $totalAmount = (float) ($invoice->total_amount ?? 0);
        $templateProcessor->setValue('total_amount', $formatRupiah($totalAmount));
        $templateProcessor->setValue('price', $this->terbilangRupiah((int) round($totalAmount)));

        $items = $invoice->products ?? [];
        $itemCount = count($items);
        $useClone = $itemCount > 1;

        if ($useClone) {
            $templateProcessor->cloneRow('no', $itemCount);
        }

        foreach ($items as $idx => $item) {
            $row = $idx + 1;
            $suffix = $useClone ? "#{$row}" : '';

            $qty = (int) ($item['quantity'] ?? 0);
            $unitPrice = (float) ($item['unit_price'] ?? 0);
            $price = $qty * $unitPrice;
            $subtotal = isset($item['subtotal']) ? (float) $item['subtotal'] : max($price - (float) ($item['discount'] ?? 0), 0);

            $templateProcessor->setValue("no{$suffix}", $row);
            $templateProcessor->setValue("description{$suffix}", $item['description'] ?? '');
            $templateProcessor->setValue("qty{$suffix}", $qty);
            $templateProcessor->setValue("unit{$suffix}", $item['unit'] ?? '');
            $templateProcessor->setValue("unit_price{$suffix}", $formatRupiah($unitPrice));
            $templateProcessor->setValue("subtotal{$suffix}", $formatRupiah($subtotal));
        }

        if ($itemCount === 0) {
            $templateProcessor->setValue('no', '-');
            $templateProcessor->setValue('description', '-');
            $templateProcessor->setValue('qty', '0');
            $templateProcessor->setValue('unit', '-');
            $templateProcessor->setValue('unit_price', $formatRupiah(0));
            $templateProcessor->setValue('subtotal', $formatRupiah(0));
        }

        $safeInvoice = preg_replace('/[^A-Za-z0-9._-]/', '_', (string) $invoice->invoice_number);
        $fileName = "{$safeInvoice}.docx";
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $tempPath = $tempDir . DIRECTORY_SEPARATOR . $fileName;

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }
}
