@extends('dashboard.layouts.app', [
    'title' => 'Reimbursement',
    'active' => 'Dashboard',
])

@section('content')
    <section class="flex w-full">
        <div class="flex flex-col w-full bg-gray-100">
            <div class="w-full">
                <div class="py-4 md:pt-12 md:pb-7">
                    <div>
                        <p tabindex="0"
                            class="focus:outline-none text-base sm:text-lg md:text-2xl lg:text-4xl font-bold leading-normal mb-2 text-gray-800">
                            Manajemen Reimburse
                        </p>
                        <p class="w-full text-disabled">
                            Halaman yang mengelola seluruh pengajuan <span class="">reimburse</span> staf, lakukan
                            verifikasi, dan tentukan status pengajuan secara terstruktur.
                        </p>
                    </div>
                </div>
                <div class="flex w-full space-x-4">
                    <div class="rounded-lg bg-white w-full shadow-md px-4 py-4 md:px-8 md:py-7 xl:px-10 mb-7">
                        <div class="mb-4 mt-4 overflow-x-hidden">
                            <table id="example" class="display min-w-full pt-5 leading-normal">
                                <thead>
                                    <tr class="mt-4">
                                        <th
                                            class="sticky-col sticky-col-1 bg-white px-6 py-3 text-center text-base font-bold leading-4 tracking-wider text-black">
                                            No
                                        </th>
                                        <th
                                            class="sticky-col sticky-col-2 bg-white px-6 py-3 text-start text-base font-bold leading-4 tracking-wider text-black">
                                            Nama Lengkap
                                        </th>
                                        <th
                                            class="bg-white px-6 py-3 text-center text-base font-bold leading-4 tracking-wider text-black">
                                            Tanggal
                                        </th>
                                        <th
                                            class="bg-white px-6 py-3 text-center text-base font-bold leading-4 tracking-wider text-black">
                                            Keterangan
                                        </th>
                                        <th
                                            class="bg-white px-6 py-3 text-center text-base font-bold leading-4 tracking-wider text-black">
                                            Jumlah
                                        </th>
                                        <th
                                            class="bg-white px-6 py-3 text-center text-base font-bold leading-4 tracking-wider text-black">
                                            File
                                        </th>
                                        <th
                                            class="bg-white px-6 py-3 text-center text-base font-bold leading-4 tracking-wider text-black">
                                            Status
                                        </th>
                                        <th
                                            class="bg-white px-6 right-0 py-3 text-center text-base font-bold leading-4 tracking-wider text-black">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reimbursements as $reimbursement)
                                        @php
                                            $itemDescription = data_get($reimbursement->items, '0.description', '-');
                                            $proofPath = data_get($reimbursement->proof_path, '0');
                                            $proofUrl = $proofPath
                                                ? \Illuminate\Support\Facades\Storage::url($proofPath)
                                                : null;
                                            $proofExt = $proofPath ? strtolower(pathinfo($proofPath, PATHINFO_EXTENSION)) : '';
                                            $isImageProof = in_array($proofExt, ['jpg', 'jpeg', 'png', 'webp'], true);
                                            $status = strtolower((string) ($reimbursement->status ?? 'pending'));
                                            $statusMap = [
                                                'approved' => [
                                                    'label' => 'Approved',
                                                    'bg' => '#ECFDF3',
                                                    'border' => '#12B76A',
                                                    'text' => '#12B76A',
                                                    'icon' => 'bxs-check-circle',
                                                ],
                                                'rejected' => [
                                                    'label' => 'Rejected',
                                                    'bg' => '#FEF3F2',
                                                    'border' => '#F04438',
                                                    'text' => '#F04438',
                                                    'icon' => 'bxs-x-circle',
                                                ],
                                                'pending' => [
                                                    'label' => 'Pending',
                                                    'bg' => '#FFFFED',
                                                    'border' => '#AAAA00',
                                                    'text' => '#AAAA00',
                                                    'icon' => 'bxs-time',
                                                ],
                                            ];
                                            $statusView = $statusMap[$status] ?? $statusMap['pending'];
                                        @endphp
                                        <tr
                                            class="border-b border-gray-200 hover:bg-gray-200 odd:bg-gray-100 even:bg-white">
                                            <td class="text-center px-6 py-4">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4"><a href=""
                                                    class="text-primary font-semibold underline">{{ $reimbursement->employee_name }}</a>
                                            </td>
                                            <td class="text-center px-6 py-4">
                                                {{ \Carbon\Carbon::parse($reimbursement->reimbursement_date)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-center px-6 py-4">{{ $itemDescription }}</td>
                                            <td class="text-center px-6 py-4">
                                                Rp. {{ number_format($reimbursement->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center px-6 py-4">
                                                @if ($proofPath)
                                                    <button type="button"
                                                        onclick="openProofModal('{{ route('dashboard.reimbursement.proof.download', ['reimbursement' => $reimbursement->id, 'index' => 0]) }}', '{{ $proofUrl }}', {{ $isImageProof ? 'true' : 'false' }})"
                                                        class="text-primary font-semibold align-middle flex flex-row items-center gap-2">
                                                        <i class="bx bx-file text-primary text-xl"></i>
                                                        <p>Bukti.jpg</p>
                                                    </button>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center px-6 py-4">
                                                <div class="p-1 rounded-full border flex flex-row gap-1 items-center justify-center"
                                                    style="background-color: {{ $statusView['bg'] }}; border-color: {{ $statusView['border'] }};">
                                                    <i class="bx {{ $statusView['icon'] }}"
                                                        style="color: {{ $statusView['text'] }};"></i>
                                                    <p class="text-sm" style="color: {{ $statusView['text'] }};">
                                                        {{ $statusView['label'] }}</p>
                                                </div>
                                            </td>
                                            <td class="text-center px-6 py-4">
                                                @if($status === 'approved')
                                                    <a href="{{ route('dashboard.reimbursement.export', $reimbursement->id) }}"
                                                        class="inline-flex items-center rounded p-2 hover:bg-blue-700"
                                                        style="background-color: #06E906">
                                                        <i class="bx bx-download text-white"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('dashboard.reimbursement.show', $reimbursement->id) }}"
                                                    class="inline-flex items-center rounded p-2 hover:bg-blue-700"
                                                    style="background-color: #3b82f6">
                                                    <i class="bx bxs-show text-white"></i>
                                                </a>
                                                <button type="button" onclick="openDeleteModal({{ $reimbursement->id }})"
                                                    class="inline-flex items-center rounded p-2 hover:bg-red-700"
                                                    style="background-color: #ef4444">
                                                    <i class="bx bxs-trash-alt text-white"></i>
                                                </button>
                                                @if ($status === 'pending')
                                                    <button type="button"
                                                        onclick="openAcceptModal({{ $reimbursement->id }})"
                                                        class="inline-flex items-center rounded p-2 hover:bg-yellow-700"
                                                        style="background-color: #00B300">
                                                        <i class="bx bx-check text-white"></i>
                                                    </button>
                                                    <button type="button"
                                                        onclick="openRejectModal({{ $reimbursement->id }})"
                                                        class="inline-flex items-center rounded p-2 hover:bg-red-700"
                                                        style="background-color: #FF3E38">
                                                        <i class="bx bx-x text-white"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    </section>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/40">
        <div class="relative w-[360px] md:w-[560px] rounded-[20px] bg-white p-6 text-center font-plusJakartaSans shadow-lg"
            style="background: linear-gradient(to right, #BD7979, #BD7979) top/100% 6px no-repeat, white; border-radius: 20px; background-clip: padding-box, border-box;">
            <!-- Warning Icon -->
            <img src="{{ asset('assets/images/alert-icons/error.webp') }}" alt="Warning Icon"
                class="mx-auto h-[83px] w-[83px]" />

            <!-- Title -->
            <h2 class="mt-4 text-2xl font-bold text-stone-900">Konfirmasi Hapus</h2>

            <!-- Message -->
            <p class="mt-2 text-base font-medium text-black">
                Apakah Anda yakin ingin menghapus kelas ini? Semua data terkait juga akan dihapus.
            </p>

            <!-- Actions -->
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" id="cancelDelete" onclick="closeDeleteModal()"
                    class="rounded-lg border border-stone-300 px-6 py-2 text-stone-700">Tidak</button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="rounded-[5px] bg-gradient-to-r from-[#74AABF] to-[#3986A3] px-6 py-2 font-medium text-white">
                        Ya
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Setujui Reimburse -->
    <div id="acceptModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/40">
        <div class="relative w-[360px] md:w-[560px] rounded-[20px] bg-white p-6 text-center font-plusJakartaSans shadow-lg"
            style="background: linear-gradient(to right, #74aabf, #3986a3) top/100% 6px no-repeat, white; border-radius: 20px; background-clip: padding-box, border-box;">
            <!-- Warning Icon -->
            <img src="{{ asset('assets/images/alert-icons/warning-gradient.webp') }}" alt="Warning Icon"
                class="mx-auto h-[83px] w-[83px]" />

            <!-- Title -->
            <h2 class="mt-4 text-2xl font-bold text-stone-900">Setujui Pengajuan Reimburse?</h2>

            <!-- Message -->
            <p class="mt-2 text-base font-medium text-black">
                Pastikan data dan dokumen telah diperiksa dengan benar sebelum menyetujui pengajuan.
            </p>

            <!-- Actions -->
            <div class="mt-6">
                <form id="acceptForm" method="POST" class="flex flex-col justify-center gap-5">
                    @csrf
                    @method('POST')
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col gap-2 items-start">
                            <label for="verification_note">Catatan Verifikasi</label>
                            <input type="text" id="verification_note" name="notes"
                                class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[6.5px] shadow-sm text-sm text-slate-500"
                                placeholder="Isi catatan persetujuan pengajuan reimburse.">
                        </div>

                        <div class="flex flex-col gap-2 items-start">
                            <label for="checked_by">Diperiksa Oleh</label>
                            <input type="text" id="checked_by" name="approved_by"
                                class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[6.5px] shadow-sm text-sm text-slate-500"
                                placeholder="Nama staff SecFin yang menyetujui pengajuan.">
                        </div>
                    </div>
                    <div class="flex justify-center gap-3">
                        <button type="button" id="cancelAccept" onclick="closeAcceptModal()"
                            class="rounded-lg border border-stone-300 px-6 py-2 text-stone-700">Tidak</button>
                        <button type="submit"
                            class="rounded-[5px] bg-gradient-to-r from-[#74AABF] to-[#3986A3] px-6 py-2 font-medium text-white">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tolak Reimburse -->
    <div id="rejectModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/40">
        <div class="relative w-[360px] md:w-[560px] rounded-[20px] bg-white p-6 text-center font-plusJakartaSans shadow-lg"
            style="background: linear-gradient(to right, #BD7979, #BD7979) top/100% 6px no-repeat, white; border-radius: 20px; background-clip: padding-box, border-box;">
            <!-- Warning Icon -->
            <img src="{{ asset('assets/images/alert-icons/warning-red.webp') }}" alt="Warning Icon"
                class="mx-auto h-[83px] w-[83px]" />

            <!-- Title -->
            <h2 class="mt-4 text-2xl font-bold text-stone-900">Tolak Pengajuan Reimburse?</h2>

            <!-- Message -->
            <p class="mt-2 text-base font-medium text-black">
                Berikan alasan penolakan agar dapat menjadi referensi bagi staff pengaju.
            </p>

            <!-- Actions -->
            <div class="mt-6">
                <form id="rejectForm" method="POST" class="flex flex-col justify-center gap-5">
                    @csrf
                    @method('POST')
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col gap-2 items-start">
                            <label for="rejection_note">Catatan Penolakan</label>
                            <input type="text" id="rejection" name="notes"
                                class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[6.5px] shadow-sm text-sm text-slate-500"
                                placeholder="Isi alasan penolakan pengajuan reimburse.">
                        </div>

                        <div class="flex flex-col gap-2 items-start">
                            <label for="checked_by">Diperiksa Oleh</label>
                            <input type="text" id="checked_by" name="approved_by"
                                class="w-full rounded-lg bg-[#F4F4F4] border-2 border-[#B3B3B3] px-1.5 py-[6.5px] shadow-sm text-sm text-slate-500"
                                placeholder="Nama staff SecFin yang menolak pengajuan.">
                        </div>
                    </div>
                    <div class="flex justify-center gap-3">
                        <button type="button" id="cancelAccept" onclick="closeRejectModal()"
                            class="rounded-lg border border-stone-300 px-6 py-2 text-stone-700">Tidak</button>
                        <button type="submit"
                            class="rounded-[5px] bg-gradient-to-r from-[#74AABF] to-[#3986A3] px-6 py-2 font-medium text-white">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Bukti -->
    <div id="proofModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/40">
        <div class="relative w-[360px] md:w-[560px] rounded-[20px] bg-white p-6 text-center font-plusJakartaSans shadow-lg"
            style="background: linear-gradient(to right, #74aabf, #3986a3) top/100% 6px no-repeat, white; border-radius: 20px; background-clip: padding-box, border-box;">
            <img src="{{ asset('assets/images/alert-icons/warning-gradient.webp') }}" alt="Proof Icon"
                class="mx-auto h-[83px] w-[83px]" />
            <h2 class="mt-4 text-2xl font-bold text-stone-900">Unduh Bukti</h2>
            <p class="mt-2 text-base font-medium text-black">
                Klik tombol di bawah untuk mengunduh file bukti.
            </p>
            <div id="proofPreviewWrapper" class="mt-4 hidden">
                <img id="proofPreviewImage" src="" alt="Preview Bukti"
                    class="mx-auto max-h-[280px] w-auto rounded-lg border border-gray-200" />
            </div>
            <p id="proofPreviewFallback" class="mt-4 text-sm text-gray-500 hidden">
                Preview hanya tersedia untuk file gambar.
            </p>
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" onclick="closeProofModal()"
                    class="rounded-lg border border-stone-300 px-6 py-2 text-stone-700">Batal</button>
                <a id="proofDownloadLink" href="#"
                    class="rounded-[5px] bg-gradient-to-r from-[#74AABF] to-[#3986A3] px-6 py-2 font-medium text-white">Download</a>
            </div>
        </div>
    </div>


    </div>
    </div>
    </div>



    </div>
    </section>


    <script>
        let deleteModal = document.getElementById('deleteModal');
        let deleteForm = document.getElementById('deleteForm');

        function openDeleteModal(userId) {
            deleteForm.action = `/dashboard/reimbursement/${userId}`;
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }


        // Accept Reimburse Modal
        let acceptModal = document.getElementById('acceptModal');
        let acceptForm = document.getElementById('acceptForm');

        function openAcceptModal(userId) {
            acceptForm.action = `/dashboard/reimbursement/${userId}/approve`;
            acceptModal.classList.remove('hidden');
        }

        function closeAcceptModal() {
            acceptModal.classList.add('hidden');
        }


        // Reject Reimburse Modal
        let rejectModal = document.getElementById('rejectModal');
        let rejectForm = document.getElementById('rejectForm');

        function openRejectModal(userId) {
            rejectForm.action = `/dashboard/reimbursement/${userId}/reject`;
            rejectModal.classList.remove('hidden');
        }

        function closeRejectModal() {
            rejectModal.classList.add('hidden');
        }

        let proofModal = document.getElementById('proofModal');
        let proofDownloadLink = document.getElementById('proofDownloadLink');
        let proofPreviewWrapper = document.getElementById('proofPreviewWrapper');
        let proofPreviewImage = document.getElementById('proofPreviewImage');
        let proofPreviewFallback = document.getElementById('proofPreviewFallback');

        function openProofModal(downloadUrl, previewUrl, isImage) {
            proofDownloadLink.href = downloadUrl;
            if (isImage && previewUrl) {
                proofPreviewImage.src = previewUrl;
                proofPreviewWrapper.classList.remove('hidden');
                proofPreviewFallback.classList.add('hidden');
            } else {
                proofPreviewImage.src = '';
                proofPreviewWrapper.classList.add('hidden');
                proofPreviewFallback.classList.remove('hidden');
            }
            proofModal.classList.remove('hidden');
        }

        function closeProofModal() {
            proofModal.classList.add('hidden');
            proofDownloadLink.href = '#';
            proofPreviewImage.src = '';
            proofPreviewWrapper.classList.add('hidden');
            proofPreviewFallback.classList.add('hidden');
        }
    </script>
@endsection
