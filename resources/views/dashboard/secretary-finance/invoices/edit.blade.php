@extends('dashboard.layouts.app', [
    'title' => 'Invoice',
    'active' => 'Dashboard',
])

@section('content')
    <section class="flex w-full">
        <div class="flex w-full flex-col">
            <div class="py-4 md:pb-7 md:pt-12">
                <div class="mb-2 flex items-center gap-2">
                    <a href="{{ route('dashboard.invoice.index') }}">
                        <img src="{{ asset('assets/images/dashboard/icons/dashboard-back.webp') }}" alt="Back Btn" />
                    </a>
                    <p class="text-base font-bold leading-normal text-gray-800 sm:text-lg md:text-2xl lg:text-4xl">Ubah
                        Invoice</p>
                </div>
                <p class="w-full text-disabled">Perbarui data <span class="italic">invoice</span>. Dokumen akan digenerate
                    ulang secara otomatis dalam format PDF.</p>
            </div>
            <div class="rounded-lg bg-white px-4 py-4 shadow-md md:px-8 md:py-7 xl:px-10 mb-7">
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- @dd($invoiceData) --}}

                {{-- <form id="berbinarForm" action="{{ route("dashboard.invoice.store") }}" method="POST" enctype="multipart/form-data"> --}}
                <form id="berbinarForm" action="{{ route('dashboard.invoice.update', $invoiceData->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col gap-5 w-full">

                        <div>
                            <label for="invoice_number" class="mb-2 block font-semibold text-gray-900">Nomor Invoice</label>
                            <input type="text" id="invoice_number" name="invoice_number"
                                class="block w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] p-2.5 text-sm text-gray-900 focus:border-primary focus:ring-primary"
                                placeholder="011 / INV / BERBINAR / VII / 2025" required readonly
                                value="{{ $invoiceData->invoice_number }}">
                        </div>

                        <p class="text-gray-500 font-semibold">Ditujukan Kepada :</p>

                        <div class="flex flex-row gap-5 w-full">
                            <div class="w-1/3 flex flex-col gap-2">
                                <label for="position">Jabatan</label>
                                <input type="text" name="customer_name"
                                    class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[6.5px] shadow-sm text-sm"
                                    value="{{ $invoiceData->customer_name }}">
                            </div>
                            <div class="w-1/3 flex flex-col gap-2">
                                <label for="agency">Instansi</label>
                                <input type="text" name="customer_agency"
                                    class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[6.5px] shadow-sm text-sm"
                                    value="{{ $invoiceData->customer_agency }}">
                            </div>
                            @php
                                $invoice_date = $invoiceData->invoice_date
                                    ? \Carbon\Carbon::parse($invoiceData->invoice_date)
                                    : null;
                            @endphp
                            <div class="w-1/3 flex flex-col gap-2">
                                <label for="invoice_date">Tanggal Invoice</label>
                                <input type="date" name="invoice_date"
                                    class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[6.5px] shadow-sm text-sm"
                                    value="{{ $invoice_date ? $invoice_date->format('Y-m-d') : '' }}" readonly>
                            </div>
                        </div>

                        <hr class="my-5 border border-gray-300">

                        <div class="flex flex-col gap-5">
                            <h2 class="mb-2 text-xl font-semibold">Detail Tagihan</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto border-collapse">
                                    <thead>
                                        <tr class="">
                                            <th class="border-b-2 border-gray-300 px-4 py-2 text-left">No.</th>
                                            <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Keterangan</th>
                                            <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Jumlah</th>
                                            <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Satuan</th>
                                            <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Harga Satuan</th>
                                            <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Diskon</th>
                                            <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice-products">
                                        @forelse ($invoiceData->products ?? [] as $item)
                                            <tr>
                                                <td class="border-b-2 border-gray-300 px-2 py-3 text-center">
                                                    {{ $loop->iteration }}</td>
                                                <td class="border-b-2 border-gray-300 px-2 py-3">
                                                    <input type="text" name="products[{{ $loop->index }}][description]"
                                                        class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm shadow-sm focus:outline"
                                                        placeholder="Masukkan keterangan"
                                                        value="{{ $item['description'] }}">
                                                </td>
                                                <td class="border-b-2 border-gray-300 px-2 py-3">
                                                    <input type="number" name="products[{{ $loop->index }}][quantity]"
                                                        class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm focus:outline"
                                                        placeholder="0" value="{{ $item['quantity'] }}">
                                                </td>
                                                <td class="border-b-2 border-gray-300 px-2 py-3">
                                                    <input type="text" name="products[{{ $loop->index }}][unit]"
                                                        class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm focus:outline"
                                                        placeholder="pcs" value="{{ $item['unit'] }}">
                                                </td>
                                                <td class="border-b-2 border-gray-300 px-2 py-3">
                                                    <input type="text" name="products[{{ $loop->index }}][unit_price]"
                                                        class="js-rupiah w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm focus:outline"
                                                        placeholder="Rp. 0" value="{{ $item['unit_price'] }}">
                                                </td>
                                                <td class="border-b-2 border-gray-300 px-2 py-3">
                                                    <input type="text" name="products[{{ $loop->index }}][discount]"
                                                        class="js-rupiah w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm focus:outline"
                                                        placeholder="0" value="{{ $item['discount'] }}">
                                                </td>
                                                <td class="border-b-2 border-gray-300 px-2 py-3 flex justify-center">
                                                    <button type="button"
                                                        class="inline-flex items-center rounded p-2 hover:bg-red-700"
                                                        style="background-color: #ef4444" onclick="removeRow(this)">
                                                        <i class="bx bxs-trash-alt text-white"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6"
                                                    class="border-b-2 border-gray-300 px-2 py-3 text-center text-gray-500">
                                                    Belum ada data produk.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="flex flex-row justify-center">
                                    <button type="button" onclick="addRow()"
                                        class="mt-4 rounded px-4 py-2 text-gray-500 flex gap-2 items-center"><i
                                            class="bx bx-plus-circle text-xl"></i>Tambah Baris</button>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 border border-gray-300">

                        <div class="flex flex-col gap-5">
                            <h2 class="mb-2 text-xl font-semibold">Ringkasan</h2>

                            <!-- Ini dia diitung oleh sistem -->
                            <div>
                                <label for="total"
                                    class="mb-2 block font-semibold text-gray-900">Total</label>
                                <!-- <input type="text" id="total" name="total"
                                                        class="block w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] p-2.5 text-sm text-gray-900 focus:border-primary focus:ring-primary"
                                                        placeholder="Rp. " required> -->
                                <div
                                    id="total" class="block w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] p-2.5 text-sm text-gray-900">
                                    Rp. </div>
                            </div>

                            <!-- Ini dia diitung oleh sistem -->
                            <div>
                                <label for="calculated" class="mb-2 block font-semibold text-gray-900">Terbilang</label>
                                <!-- <input type="text" id="calculated" name="calculated"
                                                        class="block w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] p-2.5 text-sm text-gray-900 focus:border-primary focus:ring-primary"
                                                        placeholder="" required> -->
                                <div id="calculated"
                                    class="block w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] p-2.5 text-sm text-gray-900">
                                    &nbsp;</div>
                            </div>

                        </div>

                        <hr class="my-5 border border-gray-300">


                        <div class="flex flex-col gap-5">
                            <h2 class="mb-2 text-xl font-semibold">Informasi Pembayaran</h2>

                            <div>
                                <h2 class="mb-2 block font-semibold text-gray-900">Pembayaran Dapat Dilakukan Melalui</h2>
                                <p
                                    class="block w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] p-2.5 text-sm text-gray-900">
                                    BCA 123456478948 a.n PT. Berbinar Insighful Indonesia
                                </p>
                            </div>

                        </div>

                        <hr class="my-5 border border-gray-300">

                        <div class="flex flex-col gap-5">
                            <h2 class="mb-2 text-xl font-semibold">Pengesahan</h2>

                            <div>
                                <h2 class="mb-2 block font-semibold text-gray-900">Hormat Kami,</h2>
                                <p
                                    class="block w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] p-2.5 text-sm text-gray-900">
                                    CEO Berbinar
                                </p>
                            </div>

                        </div>

                        <hr class="my-5 border border-gray-300">

                        <h2 class="font-medium">Invoice ini diterbitkan secara digital dan sah tanpa tanda tangan basah.
                        </h2>

                        <div class="flex flex-row justify-end gap-5">
                            <button type="button" onclick="openCancelModal()"
                                class="rounded px-10 py-2 text-[#055472] bg-[#B0E9FF] flex gap-2 items-center">Batal</button>
                            <button type="button" onclick="openConfirmModal()"
                                class="rounded px-10 py-2 text-white bg-primary flex gap-2 items-center">Simpan
                                Perubahan</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </section>

    <!-- Modal Batal -->
    <div id="cancelModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/40">
        <div class="relative w-[360px] md:w-[560px] rounded-[20px] bg-white p-6 text-center font-plusJakartaSans shadow-lg"
            style="background: linear-gradient(to right, #BD7979, #BD7979) top/100% 6px no-repeat, white; border-radius: 20px; background-clip: padding-box, border-box;">
            <!-- Warning Icon -->
            <img src="{{ asset('assets/images/alert-icons/error.webp') }}" alt="Warning Icon"
                class="mx-auto h-[83px] w-[83px]" />

            <!-- Title -->
            <h2 class="mt-4 text-2xl font-bold text-stone-900">Batalkan Pengubahan Invoice?</h2>

            <!-- Message -->
            <p class="mt-2 text-base font-medium text-black">
                Perubahan yang telah kamu buat tidak akan disimpan.
            </p>

            <!-- Actions -->
            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ route('dashboard.invoice.index') }}"
                    class="rounded-lg border border-stone-300 px-6 py-2 text-stone-700">Batalkan</a>
                <button type="button" onclick="closeCancelModal()"
                    class="rounded-[5px] bg-gradient-to-r from-[#74AABF] to-[#3986A3] px-6 py-2 font-medium text-white">Tetap
                    di Halaman</button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="confirmModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/40">
        <div class="relative w-[360px] md:w-[560px] rounded-[20px] bg-white p-6 text-center font-plusJakartaSans shadow-lg"
            style="background: linear-gradient(to right, #74aabf, #3986a3) top/100% 6px no-repeat, white; border-radius: 20px; background-clip: padding-box, border-box;">
            <!-- Warning Icon -->
            <img src="{{ asset('assets/images/alert-icons/warning-gradient.webp') }}" alt="Warning Icon"
                class="mx-auto h-[83px] w-[83px]" />

            <!-- Title -->
            <h2 class="mt-4 text-2xl font-bold text-stone-900">Buat PDF Invoice?</h2>

            <!-- Message -->
            <p class="mt-2 text-base font-medium text-black">
                Pastikan seluruh data telah diisi dengan benar sebelum mengirim. Pengajuan yang sudah dikirim tidak dapat
                diubah.
            </p>

            <!-- Actions -->
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" onclick="closeConfirmModal()"
                    class="rounded-lg border border-stone-300 px-6 py-2 text-stone-700">Kembali</button>
                <button type="submit" form="berbinarForm"
                    class="rounded-[5px] bg-gradient-to-r from-[#74AABF] to-[#3986A3] px-6 py-2 font-medium text-white">Buat
                    PDF</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let rowCount = 1;

        function addRow() {
            rowCount++;
            const tbody = document.getElementById('invoice-products');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td class="border-b-2 border-gray-300 px-2 py-3 text-center">${rowCount}.</td>
            <td class="border-b-2 border-gray-300 px-2 py-3">
                <input type="text" name="products[${rowCount-1}][description]" class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm shadow-sm focus:outline" placeholder="Masukkan keterangan">
            </td>
            <td class="border-b-2 border-gray-300 px-2 py-3">
                <input type="number" name="products[${rowCount-1}][quantity]" class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm shadow-sm focus:outline" placeholder="0">
            </td>
            <td class="border-b-2 border-gray-300 px-2 py-3">
                <input type="text" name="products[${rowCount-1}][unit]" class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm shadow-sm focus:outline" placeholder="pcs">
            </td>
            <td class="border-b-2 border-gray-300 px-2 py-3">
                <input type="text" name="products[${rowCount-1}][unit_price]" class="js-rupiah w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm shadow-sm focus:outline" placeholder="Rp. 0">
            </td>
            <td class="border-b-2 border-gray-300 px-2 py-3">
                <input type="text" name="products[${rowCount-1}][discount]" class="js-rupiah w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[3px] text-sm shadow-sm focus:outline" placeholder="0">
            </td>
            <td class="border-b-2 border-gray-300 px-2 py-3 flex justify-center">
                <button type="button" class="inline-flex items-center rounded p-2 hover:bg-red-700" style="background-color: #ef4444" onclick="removeRow(this)">
                    <i class="bx bxs-trash-alt text-white"></i>
                </button>
            </td>
        `;
            tbody.appendChild(newRow);
        }

        function removeRow(button) {
            const row = button.closest('tr');
            row.remove();
            updateRowNumbers();
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#invoice-products tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
                // Update name attributes if needed
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.name;
                    if (name) {
                        const match = name.match(/products\[(\d+)\]\[(\w+)\]/);
                        if (match) {
                            input.name = `products[${index}][${match[2]}]`;
                        }
                    }
                });
            });
            rowCount = rows.length;
        }


        let cancelModal = document.getElementById('cancelModal');
        let cancelForm = document.getElementById('cancelForm');

        function openCancelModal(userId) {
            cancelModal.classList.remove('hidden');
        }

        function closeCancelModal() {
            cancelModal.classList.add('hidden');
        }


        let confirmModal = document.getElementById('confirmModal');
        let confirmForm = document.getElementById('confirmForm');

        function openConfirmModal(userId) {
            confirmModal.classList.remove('hidden');
        }

        function closeConfirmModal() {
            confirmModal.classList.add('hidden');
        }
    </script>

    <script>
        function formatRupiah(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        function cleanRupiahValue(value) {
            return value.replace(/[^\d]/g, '');
        }

        function formatRupiahInput(input) {
            const digits = cleanRupiahValue(input.value);
            if (!digits) {
                input.value = '';
                return;
            }
            input.value = 'Rp. ' + formatRupiah(parseInt(digits, 10));
        }

        function getRupiahNumber(input) {
            const digits = cleanRupiahValue(input?.value || '');
            return digits ? parseFloat(digits) : 0;
        }

        function recalcTotal() {
            const rows = document.querySelectorAll('#invoice-products tr');
            let subtotal = 0;
            let totalDiscount = 0;

            rows.forEach(row => {
                const qty = parseFloat(row.querySelector('input[name*="[quantity]"]')?.value || 0);
                const price = getRupiahNumber(row.querySelector('input[name*="[unit_price]"]'));
                const disc = getRupiahNumber(row.querySelector('input[name*="[discount]"]'));

                subtotal += qty * price;
                totalDiscount += disc;
            });

            const total = Math.max(subtotal - totalDiscount, 0);

            document.getElementById('total').textContent = 'Rp. ' + formatRupiah(Math.round(total));
            document.getElementById('calculated').textContent = terbilangRupiah(Math.round(total));
        }

        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('js-rupiah')) {
                formatRupiahInput(e.target);
            }
            if (e.target.closest('#invoice-products')) {
                recalcTotal();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            rowCount = document.querySelectorAll('#invoice-products tr').length || 1;
            document.querySelectorAll('.js-rupiah').forEach(formatRupiahInput);
            recalcTotal();
        });

        document.getElementById('berbinarForm')?.addEventListener('submit', () => {
            document.querySelectorAll('.js-rupiah').forEach((input) => {
                input.value = cleanRupiahValue(input.value);
            });
        });

        function penyebut(n) {
            const angka = [
                "",
                "Satu",
                "Dua",
                "Tiga",
                "Empat",
                "Lima",
                "Enam",
                "Tujuh",
                "Delapan",
                "Sembilan",
                "Sepuluh",
                "Sebelas"
            ];

            if (n < 12) return angka[n];
            if (n < 20) return penyebut(n - 10) + " Belas";
            if (n < 100) return penyebut(Math.floor(n / 10)) + " Puluh " + penyebut(n % 10);
            if (n < 200) return "Seratus " + penyebut(n - 100);
            if (n < 1000) return penyebut(Math.floor(n / 100)) + " Ratus " + penyebut(n % 100);
            if (n < 2000) return "Seribu " + penyebut(n - 1000);
            if (n < 1000000) return penyebut(Math.floor(n / 1000)) + " Ribu " + penyebut(n % 1000);
            if (n < 1000000000) return penyebut(Math.floor(n / 1000000)) + " Juta " + penyebut(n % 1000000);
            if (n < 1000000000000) return penyebut(Math.floor(n / 1000000000)) + " Miliar " + penyebut(n % 1000000000);
            return penyebut(Math.floor(n / 1000000000000)) + " Triliun " + penyebut(n % 1000000000000);
        }

        function terbilangRupiah(n) {
            n = Math.round(n);
            if (n === 0) return "Nol Rupiah";
            return (penyebut(n).replace(/\s+/g, ' ').trim() + " Rupiah");
        }
    </script>
@endsection
