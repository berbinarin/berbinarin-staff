@extends('dashboard.layouts.app', [
    'title' => 'Dashboard',
])

@section('content')
    <section class="flex w-full">
        <div class="flex flex-col w-full">
            <div class="w-full">
                <div class="py-10">

                    {{-- Header Dashboard --}}
                    <div class="">
                        @role('manager-cpm')
                            <p tabindex="0" class="focus:outline-none text-4xl font-bold leading-normal text-gray-800 mb-2">
                                Dashboard</p>
                            <p class="w-full text-disabled">Fitur ini digunakan untuk menampilkan data pendaftar konseling
                                yang mendaftar melalui situs web Berbinar</p>
                        @endrole

                        @role('secfin')
                            <p tabindex="0" class="focus:outline-none text-4xl font-bold leading-normal text-gray-800 mb-2">
                                Dashboard Secretary & Finance</p>
                            <p class="w-full text-disabled">Halaman utama yang menampilkan ringkasan data <span class="italic">reimburse</span> dan <span class="italic">invoice</span> untuk memudahkan pemantauan serta pengelolaan administrasi keuangan.</p>
                        @endrole
                    </div>
                </div>
            </div>
            @role('manager-cpm')
                <div class="flex flex-col w-full gap-6">
                    <div class="flex flex-row w-full gap-6">

                        <div class="flex items-center p-[18px] bg-white shadow rounded-xl w-[293px] h-[94px]">
                            <div
                                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-primary bg-blur-bg rounded-xl mr-6">
                                <img src={{ asset('assets/dashboard/icons/psikolog.webp') }} alt=""
                                    class="h-8 w-5" />
                            </div>
                            <div>
                                <span class="block text-xl font-bold">20</span>
                                <span class="block text-[#717a7e] font-medium text-base">Psikolog</span>
                            </div>
                        </div>
                        <div class="flex items-center p-[18px] bg-white shadow rounded-xl w-[293px] h-[94px]">
                            <div
                                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-primary bg-blur-bg rounded-xl mr-6">
                                <img src={{ asset('assets/dashboard/icons/people.webp') }} alt=""
                                    class="h-10 w-10" />
                            </div>
                            <div>
                                <span class="block text-xl font-bold">30</span>
                                <span class="block text-[#717a7e] font-medium text-base">Peer Counselor</span>
                            </div>
                        </div>

                    </div>

                    {{-- ===================== CHART SECTION ===================== --}}
                    <div class="w-full grid grid-cols-1 gap-6">
                        <div
                            class="flex lg:h-[300px] xl:h-[340px] 2xl:h-[370px] w-full flex-col rounded-xl bg-white px-6 py-6 shadow">
                            <div class="mb-4">
                                <h1 class="text-[28px] text-[#75BADB] font-bold">Data Pendaftar Konseling</h1>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <p class="text-sm text-black font-medium">
                                        Berikut ini merupakan visualisasi jumlah pendaftar layanan konseling
                                        Peer Counselor dan Psikolog.
                                    </p>
                                </div>
                            </div>

                            <div class="flex w-full flex-col h-full">
                                <!-- Chart -->
                                <canvas id="marketingChart" class="max-h-[155px]"></canvas>

                                <!-- Legend -->
                                <div class="mb-4 flex gap-4 text-xs justify-center">
                                    <div class="flex items-center gap-1">
                                        <span class="inline-block h-3 w-3 rounded" style="background: #106681"></span>
                                        Psikolog
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="inline-block h-3 w-3 rounded" style="background: #E9B306"></span>
                                        Peer Counselor
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="flex items-start justify-start">
                                    <span class="font-normal text-xs xl:text-sm 2xl:text-base 3xl:text-lg 4xl:text-xl">
                                        Total pendaftar layanan konseling saat ini adalah
                                        <span class="font-bold text-xs xl:text-sm 2xl:text-base 3xl:text-lg 4xl:text-xl">
                                            pendaftar.</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ========================================================= --}}
                </div>

                @section('script')
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const chartDataValues = [];
                            const chartColors = ['rgba(16, 102, 129, 0.6)', 'rgba(233, 179, 6, 0.6)'];
                            const solidColors = ['#106681', '#E9B306'];
                            const chartLabels = ['Psikolog', 'Peer Counselor'];

                            const ctx = document.getElementById('marketingChart').getContext('2d');
                            const chartData = {
                                labels: chartLabels,
                                datasets: [{
                                    label: 'Jumlah',
                                    data: chartDataValues,
                                    backgroundColor: chartColors,
                                    borderRadius: 0,
                                    barThickness: 25,
                                }],
                            };

                            new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    indexAxis: 'y',
                                    scales: {
                                        x: {
                                            beginAtZero: true,
                                            grid: {
                                                color: '#eee'
                                            },
                                            position: 'top',
                                            ticks: {
                                                stepSize: 20,
                                                callback: (value) => (value % 20 === 0 ? value : ''),
                                            },
                                            min: 0,
                                            max: 100,
                                            suggestedMax: 100,
                                        },
                                        y: {
                                            grid: {
                                                color: '#eee'
                                            },
                                            ticks: {
                                                align: 'start', // ⬅️ ini yang penting
                                                crossAlign: 'near', // ⬅️ bantu supaya nempel di kiri
                                                padding: 5, // bisa ubah sesuai jarak yang diinginkan
                                            }
                                        },
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    },
                                    animation: false,
                                    maintainAspectRatio: false,
                                },

                                plugins: [{
                                    afterDatasetsDraw: (chart) => {
                                        const ctx = chart.ctx;
                                        chart.data.datasets.forEach((dataset, i) => {
                                            const meta = chart.getDatasetMeta(i);
                                            meta.data.forEach((bar, index) => {
                                                const value = dataset.data[index];
                                                ctx.save();
                                                ctx.font = 'normal 12px sans-serif';
                                                ctx.fillStyle = '#444';
                                                ctx.textAlign = 'left';
                                                ctx.textBaseline = 'middle';
                                                ctx.fillText(value, bar.x + 30, bar.y);
                                                ctx.restore();
                                            });
                                        });
                                    }

                                }],
                            });
                        });
                    </script>
                @endsection
            @endrole

            @role('secfin')
                <div class="flex flex-col w-full gap-6">
                    <div class="grid grid-cols-2 w-full gap-6">

                        <div class="flex flex-col gap-10 p-6 bg-white shadow-md rounded-xl w-full">
                            <h2 class="block text-2xl font-semibold">Total Reimburse Diajukan</h2>
                            <div class="flex flex-row w-full justify-between items-center">
                                <h3 class="block font-bold text-3xl">265</h3>
                                <img src={{ asset('assets/dashboard/icons/reimburse-total.webp') }} alt="" class="h-10 w-10" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-10 p-6 bg-white shadow-md rounded-xl w-full">
                            <h2 class="block text-2xl font-semibold">Menunggu Verifikasi</h2>
                            <div class="flex flex-row w-full justify-between items-center">
                                <h3 class="block font-bold text-3xl">18</h3>
                                <img src={{ asset('assets/dashboard/icons/menunggu-verifikasi.webp') }} alt="" class="h-10 w-10" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-10 p-6 bg-white shadow-md rounded-xl w-full">
                            <h2 class="block text-2xl font-semibold">Disetujui</h2>
                            <div class="flex flex-row w-full justify-between items-center">
                                <h3 class="block font-bold text-3xl">2</h3>
                                <img src={{ asset('assets/dashboard/icons/disetujui.webp') }} alt="" class="h-10 w-10" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-10 p-6 bg-white shadow-md rounded-xl w-full">
                            <h2 class="block text-2xl font-semibold">Ditolak</h2>
                            <div class="flex flex-row w-full justify-between items-center">
                                <h3 class="block font-bold text-3xl">4</h3>
                                <img src={{ asset('assets/dashboard/icons/ditolak.webp') }} alt="" class="h-10 w-10" />
                            </div>
                        </div>

                    </div>
            @endrole
        </div>
    </section>
@endsection
