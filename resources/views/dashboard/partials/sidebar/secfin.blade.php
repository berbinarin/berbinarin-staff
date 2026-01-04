@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route;

    if (!function_exists('isRouteNameStartWith')) {
        function isRouteNameStartWith($routeName, $type = 'text')
        {
            $isActive = Str::startsWith(Route::currentRouteName(), $routeName);

            if ($type === 'bg') {
                return $isActive ? 'bg-[#3986A3] rounded-xl' : '';
            }

            return $isActive ? 'text-white' : 'text-gray-700 hover:text-primary';
        }
    }
@endphp

@php
    $isActivePsikolog = Str::startsWith(Route::currentRouteName(), 'dashboard.reimbursement');
    $isActivePeer = Str::startsWith(Route::currentRouteName(), 'dashboard.invoice');
@endphp

<li class="my-5 rounded-lg p-2 {{ isRouteNameStartWith('dashboard.reimbursement', 'bg') }}">
    <a href="{{ route('dashboard.reimbursement.index') }}"
        class="flex flex-row items-center duration-700 {{ isRouteNameStartWith('dashboard.reimbursement') }}">
        <img src="{{ asset('assets/dashboard/icons/reimburse.webp') }}" alt="Reimbursement Icon"
            class="mr-2 h-[21px] w-[21px] object-contain transition duration-300 {{ $isActivePsikolog ? 'brightness-0 invert' : 'brightness-100' }} {{ isRouteNameStartWith('dashboard.reimbursement') }}" />

        <span class="ml-4 text-xs lg:text-base font-normal leading-5">Reimburse</span>
    </a>
</li>

<li class="my-5 rounded-lg p-2 {{ isRouteNameStartWith('dashboard.invoice', 'bg') }}">
    <a href="{{ route('dashboard.invoice.index') }}"
        class="flex flex-row items-center duration-700 {{ isRouteNameStartWith('dashboard.invoice') }}">
        <img src="{{ asset('assets/dashboard/icons/invoice.webp') }}" alt="Invoice Icon"
            class="mr-2 h-[24px] w-[24px] object-contain transition duration-300 {{ $isActivePeer ? 'brightness-0 invert' : 'brightness-100' }} {{ isRouteNameStartWith('dashboard.invoice') }}" />

        <span class="ml-4 text-xs lg:text-base font-normal leading-5">Invoice</span>
    </a>
</li>
