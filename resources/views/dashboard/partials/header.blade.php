<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ $title }} - Berbinar Insightful Indonesia</title>

<link rel="icon" href="{{ asset('assets/landing/images/logo/logo-berbinar.webp') }}" type="image/x-icon" />

<!-- Vendor CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css" />
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-rounded/css/uicons-bold-rounded.css" />
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css" />
<link rel="stylesheet"
    href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />


<!-- Add DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">

<!-- DataTables Custom Styling -->
<style>
    .dataTables_wrapper .dataTable thead th {
        padding: 1rem;
        background-color: white;
        border-bottom: 1px solid #e5e7eb;
    }

    /* Keep Tailwind's text alignment classes */
    .dataTables_wrapper .dataTable thead th.text-center {
        text-align: center !important;
    }

    .dataTables_wrapper .dataTable thead th.text-left {
        text-align: left !important;
    }

    .dataTables_wrapper .dataTable thead th.text-right {
        text-align: right !important;
    }
</style>


<!-- App CSS (Tailwind via Vite) -->
@vite('resources/css/app.css')
