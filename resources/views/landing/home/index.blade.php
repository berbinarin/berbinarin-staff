@extends(
    "landing.layouts.app",
    [
        "title" => "Berbinar Insightful Indonesia",
    ]
)

@push('style')
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
    </style>
@endpush

@section("content")
    <div class="bg-cover bg-center bg-no-repeat">
        <!-- Hero Section Start -->
        <section class="flex mt-8 h-screen w-full flex-col items-center justify-center gap-10 text-center">
            <!-- Judul -->
            <h1 class="font-plusJakartaSans text-[26px] max-sm:mt-16 font-bold text-[#333333] md:text-5xl">
                Selamat Datang
                <span class="text-gradient-blue">Sobat Binar!</span>
            </h1>
        </section>
        <!-- Hero Section End -->
    </div>
@endsection
