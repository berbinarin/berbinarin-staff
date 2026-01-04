<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Header --}}
    @include('landing.partials.header')

    {{-- Additional Style --}}
    @stack('style')
</head>

<body class="relative w-full overflow-x-hidden">

    <main class="relative flex w-full flex-col bg-[#F7F9FA] font-plusJakartaSans">
        {{-- Main Content --}}
        @yield('content')
    </main>

    {{-- Script --}}
    @include('dashboard.partials.script')

    {{-- Additional Script --}}
    @stack('script')

    {{-- Alert --}}
    @include('components.alert')
</body>

</html>
