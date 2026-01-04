@extends('dashboard.layouts.app', [
    'title' => 'Reimbursement',
    'active' => 'Dashboard',
])

@section('content')
    <section class="flex w-full">
        <div class="flex w-full flex-col">
            <div class="py-4 md:pb-7 md:pt-12">
                <div class="mb-2 flex items-center gap-2">
                    <a href="{{ route('dashboard.reimbursement.index') }}">
                        <img src="{{ asset('assets/dashboard/svg-icon/dashboard-back.webp') }}" alt="Back Btn" />
                    </a>
                    <p class="text-base font-bold leading-normal text-gray-800 sm:text-lg md:text-2xl lg:text-4xl">Detail
                        Data Pendaftar</p>
                </div>
                <p class="w-full text-disabled">Halaman ini menampilkan informasi detail mengenai data peserta yang berhasil
                    mendaftar Berbinar+. Admin dapat melihat Informasi lengkap seputar Data diri dan Pilihan Kelas pengguna.
                </p>
            </div>
            <div class="rounded-lg bg-white px-4 py-4 shadow-md mb-7 md:px-8 md:py-7 xl:px-10 flex flex-col gap-10">
                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Informasi Umum</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Nomor Reimburse</h2>
                            <p class="text-lg font-semibold">FR-67</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Status</h2>
                            <p class="text-lg font-semibold">Menunggu Verifikasi</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Tanggal Pengajuan</h2>
                            <p class="text-lg font-semibold">1 Januari 2026</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Data Staff</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Nama Lengkap</h2>
                            <p class="text-lg font-semibold">Kanz Abiyu Alkautsar</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Nomor Telepon</h2>
                            <p class="text-lg font-semibold">081282103522</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Divisi</h2>
                            <p class="text-lg font-semibold">Web and Mobile Developer</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Detail Reimburse</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Nominal Reimburse</h2>
                            <p class="text-lg font-semibold">Rp. 1.000.000</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Keterangan / Deskripsi Pengeluaran</h2>
                            <p class="text-lg font-semibold">Pembuatan Dashboard Secfin</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Dokumen Pendukung</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Bukti Nota</h2>
                            <a href="" class="max-w-[10vw]">
                                <img src="{{ asset('assets/dashboard/icons/bukti.webp') }}" alt="Bukti Nota" class="w-full">
                                <p class="text-lg font-normal text-white underline bg-[#5F5F5FD9] px-2 py-1 rounded-b-lg">bukti.jpg</p>
                            </a>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Tanda Tangan Digital Pengusul</h2>
                            <a href="" class="max-w-[20vw]">
                                <img src="{{ asset('assets/dashboard/icons/tanda-tangan.webp') }}" alt="Tanda Tangan Digital Pengusul" class="max-w-[20vw]">
                                <p class="text-lg font-normal text-white underline bg-[#5F5F5FD9] px-2 py-1 rounded-b-lg">TTD.jpg</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Catatan Internal</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Catatan Verifikator</h2>
                            <p class="text-lg font-semibold">-</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Diperiksa Oleh</h2>
                            <p class="text-lg font-semibold">-</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Tanggal Verifikasi</h2>
                            <p class="text-lg font-semibold">-</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
