@extends('landing.layouts.app', [
    'title' => 'Berbinar Insightful Indonesia',
])

@section('style')
    <style>
        .step-section {
            display: none;
        }

        .step-section.active {
            display: block;
        }

        .text-gradient {
            background: linear-gradient(to right, #f7b23b, #916823);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        select {
            background-image: none !important;
        }

        .form-input {
            border-radius: 8px !important;
            background-color: #f3f4f6 !important;
        }

        /* Custom file upload */
        .custom-file-upload {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f7f7f7;
            height: 48px;
            width: 100%;
            cursor: pointer;
            position: relative;
            padding-left: 40px;
            font-size: 16px;
            color: #888;
            transition: border 0.2s;
        }

        .custom-file-upload:hover {
            border: 1.5px solid #3986A3;
        }

        .custom-file-upload .upload-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            opacity: 0.7;
        }

        .input-file-hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
<div
    class="mx-4 mb-8 mt-24 rounded-2xl bg-none px-6 py-6 shadow-none sm:mx-24 sm:mb-20 sm:mt-36 md:bg-white md:px-12 md:shadow-lg">

    {{-- Back --}}
    <div class="mb-6 flex justify-between">
        <a href="{{ route('home.index') }}">
            <div class="flex items-center space-x-2 text-[#3986A3]">
                <img src="{{ asset('assets/landing/images/vector/left-arrow.webp') }}" class="h-3" />
                <p class="text-[15px] font-semibold">Kembali</p>
            </div>
        </a>
    </div>

    {{-- Title --}}
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold text-[#3986A3]">Form Pengajuan Reimburse</h1>
        <p class="mt-2 text-sm text-gray-500">
            Pastikan seluruh data yang diisi sesuai dan dokumen pendukung telah dilampirkan.
        </p>
    </div>

    {{-- FORM --}}
    <form class="space-y-10">

        {{-- DATA STAFF --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <h3 class="font-semibold text-gray-800">Data Staff</h3>
                <p class="text-sm text-gray-500">
                    Informasi staff yang mengajukan reimburse.
                </p>
            </div>

            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="form-label">Nama Lengkap<span class="text-red-500">*</span></label>
                    <input type="text" class="form-input w-full" />
                </div>

                <div>
                    <label class="form-label">Divisi<span class="text-red-500">*</span></label>
                    <input type="text" class="form-input w-full" />
                </div>
            </div>
        </div>

        <hr>

        {{-- KONTAK STAFF --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <h3 class="font-semibold text-gray-800">Kontak Staff</h3>
                <p class="text-sm text-gray-500">
                    Data kontak yang dapat dihubungi.
                </p>
            </div>

            <div class="md:col-span-2">
                <label class="form-label">Nomor Telepon<span class="text-red-500">*</span></label>
                <input type="text" class="form-input w-full" placeholder="+62" />
            </div>
        </div>

        <hr>

        {{-- DETAIL REIMBURSE --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <h3 class="font-semibold text-gray-800">Detail Reimburse</h3>
                <p class="text-sm text-gray-500">
                    Rincian biaya yang diajukan.
                </p>
            </div>

            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="form-label">Nominal Reimburse<span class="text-red-500">*</span></label>
                    <input type="text" class="form-input w-full" placeholder="Rp." />
                </div>

                <div>
                    <label class="form-label">Keterangan<span class="text-red-500">*</span></label>
                    <input type="text" class="form-input w-full" placeholder="Print Proposal" />
                </div>
            </div>
        </div>

        <hr>

        {{-- INFORMASI PEMBAYARAN --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <h3 class="font-semibold text-gray-800">Informasi Pembayaran</h3>
                <p class="text-sm text-gray-500">
                    Data rekening atau e-wallet.
                </p>
            </div>


            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="form-label">Nama Pemilik Rekening<span class="text-red-500">*</span></label>
                    <input type="text" class="form-input w-full" />
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="form-label">Nomor Rekening / E-Wallet<span class="text-red-500">*</span></label>
                        <input type="text" class="form-input w-full" />
                    </div>
                    <div>
                        <label class="form-label">Bank / Merchant<span class="text-red-500">*</span></label>
                        <input type="text" class="form-input w-full" />
                    </div>
                </div>
            </div>

            
        </div>

        <hr>

        {{-- DOKUMEN --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <h3 class="font-semibold text-gray-800">Dokumen Pendukung</h3>
                <p class="text-sm text-gray-500">
                    Unggah bukti pengeluaran.
                </p>
            </div>
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Upload Bukti Nota<span class="text-red-500">*</span></label>
                        <label class="custom-file-upload">
                            <img src="{{ asset('assets/landing/images/vector/upload-icon.svg') }}" class="upload-icon" alt="Upload" />
                            <span>Pilih file</span>
                            <input type="file" class="input-file-hidden" />
                        </label>
                    </div>
                    <div>
                        <label class="form-label">TTD Pengusul<span class="text-red-500">*</span></label>
                        <label class="custom-file-upload">
                            <img src="{{ asset('assets/landing/images/vector/upload-icon.svg') }}" class="upload-icon" alt="Upload" />
                            <span>Pilih file</span>
                            <input type="file" class="input-file-hidden" />
                        </label>
                    </div>
                </div>
            </div>
        </div>

        
        {{-- SUBMIT --}}
        <div class="pt-6 text-right">
            <button
                class="rounded-xl px-6 py-2 font-semibold text-[#055472]"
                style="background:#B0E9FF !important">
                Batal
            </button>

            <button
                class="rounded-xl bg-[#3986A3] px-6 py-2 font-semibold text-white hover:bg-[#2f6f86]">
                Kirim Pengajuan
            </button>
        </div>

    </form>
</div>
@endsection


@push('script')

@endpush
