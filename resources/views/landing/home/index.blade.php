@extends('landing.layouts.app', [
    'title' => 'Berbinar Insightful Indonesia',
])

@section('style')
    <style>
        .text-gradient {
            background: linear-gradient(to right, #f7b23b, #916823);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .text-gradient-blue {
            background: linear-gradient(to right, #3986a3, #15323d);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .group {
            transition:
                transform 0.3s ease-in-out,
                border 0.3s;
            transform-origin: center;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .group:hover {
            transform: scaleY(1.2);
            border: 5px solid #3986A3;
            height: 315px;
        }

        .group:hover .transform {
            transform: scaleY(0.83);
        }
    </style>
@endsection

@section('content')
    <div class="mt-28 sm:mt-32 leading-snug flex items-center justify-center">
        <img src="{{ asset('assets/images/landing/icons/staff-icon.svg') }}" alt="Staff Icon" class="w-[30px] mr-3" />
        <h1
            class="font text-gradient text-center text-[28px] font-bold text-black pb-1 max-md:mx-10 max-sm:mx-2 max-sm:text-[29px]">
            Staff Berbinar
        </h1>
    </div>
    <p class="font text-center text-[15px] font-bold text-black pb-1 max-md:mx-10 max-sm:mx-2 max-sm:text-[15px]">
        Halaman ini berfungsi sebagai akses layanan internal untuk mendukung kebutuhan kerja <br> dan administrasi staff
        Berbinar.
    </p>

    <div class="mx-20 my-12 hidden items-center justify-center space-x-5 md:flex">
        <div class="flex items-stretch" style="height: 300px">
            <div
                class="group relative h-auto w-[394px] origin-center transform items-center overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 before:absolute before:inset-0 before:scale-0 before:rounded-full before:bg-[#FFEACE] before:transition-transform before:duration-300 hover:before:scale-150">
                <div
                    class="flex transform flex-col justify-center space-y-2 p-4 text-center transition-transform duration-300 group-hover:-mt-10 group-hover:scale-y-[0.83]">
                    <h1
                        class="font text-gradient-blue text-xl font-semibold leading-relaxed text-black transition-all duration-300 group-hover:text-[26px] group-hover:leading-normal max-sm:text-[29px]">
                        <em>Konseling</em>
                    </h1>
                    <img src="{{ asset('assets/images/landing/product/counseling-staff.png') }}" alt="Psikolog"
                        class="h-36 w-auto object-contain transition-all duration-300 group-hover:mt-3 group-hover:h-[160px]" />
                    <p class="text-sm font-semibold leading-tight text-black">
                    <p>Ajukan sesi konseling khusus staff untuk menjaga kesehatan mental dan keseimbangan kerja.</p>
                    </p>
                </div>
                <div
                    class="absolute bottom-0 left-1/2 flex -translate-x-1/2 translate-y-10 justify-center transition-all duration-300 group-hover:-translate-y-1 group-hover:scale-y-[0.83] group-hover:mb-1.5">
                    <a href="{{ route('counseling.index') }}">
                        <button
                            class="text-[15px] rounded-[10px] bg-gradient-to-r from-[#3986A3] to-[#225062] px-4 py-2 text-white max-sm:rounded-md max-sm:px-6 max-sm:text-[15px]">
                            Daftar Konseling
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <img src="{{ asset('assets/images/logo/logo-berbinar.webp') }}" alt="Berbinar"
            class="h-20 w-auto object-contain" />

        <div class="flex items-stretch" style="height: 300px">
            <div
                class="group relative h-auto w-[394px] origin-center transform items-center overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 before:absolute before:inset-0 before:scale-0 before:rounded-full before:bg-[#FFEACE] before:transition-transform before:duration-300 hover:before:scale-150">
                <div
                    class="flex transform flex-col justify-center space-y-2 p-4 text-center transition-transform duration-300 group-hover:-mt-10 group-hover:scale-y-[0.83]">
                    <h1
                        class="font text-gradient-blue text-xl font-semibold leading-relaxed text-black transition-all duration-300 group-hover:text-[26px] group-hover:leading-normal max-sm:text-[29px]">
                        <em> Reimburse</em>
                    </h1>
                    <img src="{{ asset('assets/images/landing/product/reimburse.png') }}" alt="Peer Counselor"
                        class="h-36 w-auto object-contain transition-all duration-300 group-hover:mt-3 group-hover:h-[160px]" />
                    <p class="text-sm font-semibold leading-tight text-black">
                    <p>Kelola dan ajukan penggantian biaya kerja secara mudah dan sesuai kebijakan.</p>
                    </p>
                </div>
                <div
                    class="absolute bottom-0 left-1/2 flex -translate-x-1/2 translate-y-10 justify-center transition-all duration-300 group-hover:-translate-y-1 group-hover:scale-y-[0.83] group-hover:mb-1.5">
                    <a href="#">
                        <button id="btn-ajukan-reimburse"
                            class="text-[15px] rounded-[10px] bg-gradient-to-r from-[#3986A3] to-[#225062] px-4 py-2 text-white max-sm:rounded-md max-sm:px-6 max-sm:text-[15px]">
                            Ajukan <i>Reimburse</i </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-4 my-12 flex flex-col items-center justify-center space-y-4 md:hidden">
        <div class="relative w-full max-w-[350px] items-center rounded-2xl border bg-white shadow-md">
            <div class="flex flex-col justify-center space-y-3 p-3 text-center">
                <h1 class="font text-gradient-blue text-2xl font-semibold text-black max-sm:text-[29px]">
                    <em>Psikolog</em>
                </h1>
                <img src="{{ asset('assets/images/landing/product/counseling-staff.png') }}" alt="Psikolog"
                    class="h-36 w-auto object-contain" />
                <div class="flex justify-center">
                    <a href="{{ route('counseling.registrationPsikolog') }}">
                        <button
                            class="text-md rounded-xl bg-gradient-to-r from-[#3986A3] to-[#225062] w-[170px] py-2 text-white max-sm:w-[190px] max-sm:text-[15px]">
                            Daftar Konseling
                        </button>
                    </a>
                </div>
                <p class="text-[13px] font-semibold leading-tight text-black">
                    Ajukan sesi konseling khusus staff untuk menjaga kesehatan mental dan keseimbangan kerja.
                </p>
            </div>
        </div>

        <div class="relative w-full max-w-[350px] items-center rounded-2xl border bg-white shadow-md">
            <div class="flex flex-col justify-center space-y-3 p-3 text-center">
                <h1 class="font text-gradient-blue text-2xl font-semibold text-black max-sm:text-[29px]">
                    <em>Reimburse</em>
                </h1>
                <img src="{{ asset('assets/images/landing/product/reimburse.png') }}" alt="Reimburse"
                    class="h-36 w-auto object-contain" />
                <div class="flex justify-center">
                    <a href="{{ route('reimbursement.index') }}" id="btn-ajukan-reimburse-mobile">
                        <button id="btn-ajukan-reimburse-mobile"
                            class="text-md rounded-xl bg-gradient-to-r from-[#3986A3] to-[#225062] w-[170px] py-2 text-white max-sm:w-[190px] max-sm:text-[15px]">
                            Ajukan <i>Reimburse</i>
                        </button>
                    </a>
                </div>
                <p class="text-[13px] font-semibold leading-tight text-black">
                    Kelola dan ajukan penggantian biaya kerja secara mudah dan sesuai kebijakan.
                </p>
            </div>
        </div>

        <img src="{{ asset('assets/images/logo/logo-berbinar.webp') }}" alt="Berbinar"
            class="h-14 w-auto object-contain mt-4" />
    </div>


    <!-- Modal Alert Reimburse -->
    <div id="modal-reimburse"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden px-2">
        <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-[95vw] sm:max-w-lg relative mx-2 sm:mx-0 sm:p-8">
            <button id="close-modal-reimburse"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
            <div class="flex flex-col items-center">
                <div class="flex items-center mb-4">
                    <span class="mr-3">
                        <img src="{{ asset('assets/images/landing/icons/reimburse-icon.svg') }}" alt="Reimburse Icon"
                            class="w-8 h-8 sm:w-8 sm:h-8" />
                    </span>
                    <h2 class="text-lg sm:text-2xl font-bold text-yellow-600 mb-0">Reimburse Staff</h2>
                </div>
                <p class="text-center text-black mb-6 text-sm sm:text-base">
                    Pastikan seluruh data dan dokumen pendukung telah siap sebelum mengajukan reimburse.
                </p>
                <a href="{{ route('reimbursement.index') }}">
                    <button id="modal-ajukan-reimburse"
                        class="bg-gradient-to-r from-[#3986A3] to-[#225062] text-white font-bold px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow text-sm sm:text-base">
                        Ajukan Reimburse
                    </button>
                </a>

            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        const btnAjukan = document.getElementById('btn-ajukan-reimburse');
        const btnAjukanMobile = document.getElementById('btn-ajukan-reimburse-mobile');
        const modal = document.getElementById('modal-reimburse');
        const closeModal = document.getElementById('close-modal-reimburse');

        btnAjukan && btnAjukan.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        btnAjukanMobile && btnAjukanMobile.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>
@endpush
