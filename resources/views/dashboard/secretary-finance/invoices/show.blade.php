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
                        <img src="{{ asset('assets/dashboard/svg-icon/dashboard-back.webp') }}" alt="Back Btn" />
                    </a>
                    <p class="text-base font-bold leading-normal text-gray-800 sm:text-lg md:text-2xl lg:text-4xl">Detail
                        Data Invoice</p>
                </div>
                <p class="w-full text-disabled">Halaman ini menampilkan informasi lengkap invoice, meliputi detail tagihan, data pihak terkait, rincian biaya, serta ringkasan pembayaran untuk kebutuhan administrasi.
                </p>
            </div>
            <div class="rounded-lg bg-white px-4 py-4 shadow-md mb-7 md:px-8 md:py-7 xl:px-10 flex flex-col gap-10">
                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Informasi Umum</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Nomor Invoice</h2>
                            <p class="text-lg font-semibold">011 / INV / BERBINAR / VII / 2025</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Tanggal Pengajuan</h2>
                            <p class="text-lg font-semibold">1 Januari 2026</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Ditujukan Kepada</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Jabatan</h2>
                            <p class="text-lg font-semibold">Finance Manager</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Instansi</h2>
                            <p class="text-lg font-semibold">PT Maju Jaya</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Detail Tagihan</h1>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="">
                                    <th class="border-b-2 border-gray-300 px-4 py-2 text-center">No.</th>
                                    <th class="border-b-2 border-gray-300 px-4 py-2 text-left">Keterangan</th>
                                    <th class="border-b-2 border-gray-300 px-4 py-2 text-center">Jumlah</th>
                                    <th class="border-b-2 border-gray-300 px-4 py-2 text-center">Satuan</th>
                                    <th class="border-b-2 border-gray-300 px-4 py-2 text-center">Harga Satuan</th>
                                    <th class="border-b-2 border-gray-300 px-4 py-2 text-center">Diskon</th>
                                </tr>
                            </thead>
                            <tbody id="invoice-items">
                                <tr>
                                    <td class="border-b-2 border-gray-300 px-2 py-3 text-center">1</td>
                                    <td class="border-b-2 border-gray-300 px-2 py-3">
                                        <p class="px-1.5 py-[3px]">Pembelian Paket Kelas Berbinar+ A+</p>
                                    </td>
                                    <td class="border-b-2 border-gray-300 px-2 py-3">
                                        <p class="px-1.5 py-[3px] text-center">1</p>
                                    </td>
                                    <td class="border-b-2 border-gray-300 px-2 py-3">
                                        <p class="px-1.5 py-[3px] text-center">Paket</p>
                                    </td>
                                    <td class="border-b-2 border-gray-300 px-2 py-3">
                                        <p class="px-1.5 py-[3px] text-center">Rp. 200.000</p>
                                    </td>
                                    <td class="border-b-2 border-gray-300 px-2 py-3">
                                        <p class="px-1.5 py-[3px] text-center">Rp. 0</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Informasi Pembayaran</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Pembayaran Dapat Dilakukan Melalui</h2>
                            <p class="text-lg font-semibold">BCA - 1234567890 a.n PT Berbinar Insightful Indonesia</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Pengesahan</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Hormat Kami,</h2>
                            <p class="text-lg font-semibold">CEO Berbinar</p>
                        </div>
                    </div>
                </div>

                <h2 class="font-medium">Invoice ini diterbitkan secara digital dan sah tanpa tanda tangan basah.</h2>

            </div>
        </div>
    </section>
@endsection
