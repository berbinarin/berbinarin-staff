@extends('dashboard.layouts.app', [
    'title' => 'Reimbursement',
    'active' => 'Dashboard',
])

@section('content')
    <section class="flex w-full">
        <div class="flex w-full flex-col">
            @php
                $statusKey = strtolower((string) ($reimbursementData->status ?? 'pending'));
                $statusLabels = [
                    'pending' => 'Menunggu Verifikasi',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ];
                $statusLabel = $statusLabels[$statusKey] ?? $statusLabels['pending'];
                $submissionDate = $reimbursementData->reimbursement_date
                    ? \Carbon\Carbon::parse($reimbursementData->reimbursement_date)->locale('id')->translatedFormat('d F Y')
                    : '-';
                $verificationDate = $reimbursementData->approved_at
                    ? \Carbon\Carbon::parse($reimbursementData->approved_at)->locale('id')->translatedFormat('d F Y')
                    : '-';
                $itemDescription = data_get($reimbursementData->items, '0.description', '-');
                $proofPath = data_get($reimbursementData->proof_path, '0');
                $proofUrl = $proofPath ? \Illuminate\Support\Facades\Storage::url($proofPath) : null;
                $proofExt = $proofPath ? strtolower(pathinfo($proofPath, PATHINFO_EXTENSION)) : '';
                $isProofImage = in_array($proofExt, ['jpg', 'jpeg', 'png', 'webp'], true);
                $signaturePath = $reimbursementData->employee_signature_path;
                $signatureUrl = $signaturePath ? \Illuminate\Support\Facades\Storage::url($signaturePath) : null;
                $signatureExt = $signaturePath ? strtolower(pathinfo($signaturePath, PATHINFO_EXTENSION)) : '';
                $isSignatureImage = in_array($signatureExt, ['jpg', 'jpeg', 'png', 'webp'], true);
                $proofDownloadUrl = $proofPath
                    ? route('dashboard.reimbursement.proof.download', ['reimbursement' => $reimbursementData->id, 'index' => 0])
                    : null;
                $signatureDownloadUrl = $signaturePath
                    ? route('dashboard.reimbursement.signature.download', ['reimbursement' => $reimbursementData->id])
                    : null;
            @endphp
            <div class="py-4 md:pb-7 md:pt-12">
                <div class="mb-2 flex items-center gap-2">
                    <a href="{{ route('dashboard.reimbursement.index') }}">
                        <img src="{{ asset('assets/images/dashboard/icons/dashboard-back.webp') }}" alt="Back Btn" />
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
                            <p class="text-lg font-semibold">{{ $reimbursementData->reimbursement_number ?? '-' }}</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Status</h2>
                            <p class="text-lg font-semibold">{{ $statusLabel }}</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Tanggal Pengajuan</h2>
                            <p class="text-lg font-semibold">{{ $submissionDate }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Data Staff</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Nama Lengkap</h2>
                            <p class="text-lg font-semibold">{{ $reimbursementData->employee_name }}</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Nomor Telepon</h2>
                            <p class="text-lg font-semibold">{{ $reimbursementData->employee_phone_number }}</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Divisi</h2>
                            <p class="text-lg font-semibold">{{ $reimbursementData->employee_division }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Detail Reimburse</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Nominal Reimburse</h2>
                            <p class="text-lg font-semibold">
                                Rp. {{ number_format($reimbursementData->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Keterangan / Deskripsi Pengeluaran</h2>
                            <p class="text-lg font-semibold">{{ $itemDescription }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Dokumen Pendukung</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Bukti Nota</h2>
                            @if ($proofUrl)
                                <button type="button"
                                    onclick="openPreviewModal('Bukti Nota', '{{ $proofDownloadUrl }}', '{{ $proofUrl }}', {{ $isProofImage ? 'true' : 'false' }})"
                                    class="max-w-[10vw] text-left">
                                    <img src="{{ $isProofImage ? $proofUrl : asset('assets/images/dashboard/icons/bukti.webp') }}"
                                        alt="Bukti Nota" class="w-full">
                                    <p class="text-lg font-normal text-white underline bg-[#5F5F5FD9] px-2 py-1 rounded-b-lg">
                                        bukti.jpg</p>
                                </button>
                            @else
                                <p class="text-lg font-semibold text-gray-400">-</p>
                            @endif
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Tanda Tangan Digital Pengusul</h2>
                            @if ($signatureUrl)
                                <button type="button"
                                    onclick="openPreviewModal('Tanda Tangan', '{{ $signatureDownloadUrl }}', '{{ $signatureUrl }}', {{ $isSignatureImage ? 'true' : 'false' }})"
                                    class="max-w-[20vw] text-left">
                                    <img src="{{ $isSignatureImage ? $signatureUrl : asset('assets/images/dashboard/icons/tanda-tangan.webp') }}"
                                        alt="Tanda Tangan Digital Pengusul" class="max-w-[20vw]">
                                    <p class="text-lg font-normal text-white underline bg-[#5F5F5FD9] px-2 py-1 rounded-b-lg">
                                        TTD.jpg</p>
                                </button>
                            @else
                                <p class="text-lg font-semibold text-gray-400">-</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="mb-5 text-3xl font-bold text-primary-alt">Catatan Internal</h1>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Catatan Verifikator</h2>
                            <p class="text-lg font-semibold">{{ $reimbursementData->notes ?? '-' }}</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Diperiksa Oleh</h2>
                            <p class="text-lg font-semibold">{{ $reimbursementData->approved_by ?? '-' }}</p>
                        </div>
                        <div class="mb-2 flex flex-col">
                            <h2 class="mb-2 text-lg font-semibold text-gray-500">Tanggal Verifikasi</h2>
                            <p class="text-lg font-semibold">{{ $verificationDate }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div id="previewModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/40">
        <div class="relative w-[360px] md:w-[560px] rounded-[20px] bg-white p-6 text-center font-plusJakartaSans shadow-lg"
            style="background: linear-gradient(to right, #74aabf, #3986a3) top/100% 6px no-repeat, white; border-radius: 20px; background-clip: padding-box, border-box;">
            <img src="{{ asset('assets/images/alert-icons/warning-gradient.webp') }}" alt="Preview Icon"
                class="mx-auto h-[83px] w-[83px]" />
            <h2 id="previewTitle" class="mt-4 text-2xl font-bold text-stone-900">Preview</h2>
            <p class="mt-2 text-base font-medium text-black">
                Klik tombol di bawah untuk mengunduh file.
            </p>
            <div id="previewWrapper" class="mt-4 hidden">
                <img id="previewImage" src="" alt="Preview Bukti"
                    class="mx-auto max-h-[280px] w-auto rounded-lg border border-gray-200" />
            </div>
            <p id="previewFallback" class="mt-4 text-sm text-gray-500 hidden">
                Preview hanya tersedia untuk file gambar.
            </p>
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" onclick="closePreviewModal()"
                    class="rounded-lg border border-stone-300 px-6 py-2 text-stone-700">Batal</button>
                <a id="previewDownloadLink" href="#"
                    class="rounded-[5px] bg-gradient-to-r from-[#74AABF] to-[#3986A3] px-6 py-2 font-medium text-white">Download</a>
            </div>
        </div>
    </div>

    <script>
        let previewModal = document.getElementById('previewModal');
        let previewTitle = document.getElementById('previewTitle');
        let previewDownloadLink = document.getElementById('previewDownloadLink');
        let previewWrapper = document.getElementById('previewWrapper');
        let previewImage = document.getElementById('previewImage');
        let previewFallback = document.getElementById('previewFallback');

        function openPreviewModal(title, downloadUrl, previewUrl, isImage) {
            previewTitle.textContent = title;
            previewDownloadLink.href = downloadUrl || '#';
            if (isImage && previewUrl) {
                previewImage.src = previewUrl;
                previewWrapper.classList.remove('hidden');
                previewFallback.classList.add('hidden');
            } else {
                previewImage.src = '';
                previewWrapper.classList.add('hidden');
                previewFallback.classList.remove('hidden');
            }
            previewModal.classList.remove('hidden');
        }

        function closePreviewModal() {
            previewModal.classList.add('hidden');
            previewDownloadLink.href = '#';
            previewImage.src = '';
            previewWrapper.classList.add('hidden');
            previewFallback.classList.add('hidden');
        }
    </script>
@endsection
