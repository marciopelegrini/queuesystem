<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ config('app.name') }} {!! empty($subtitle) ? '' : ' &vellip; ' . $subtitle !!}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    {{-- Load resources --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    {{-- datatables --}}
    <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}">
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>

    {{-- CSS --}}
    @vite('resources/css/app.css')
</head>
<body class="bg-zinc-200">

{{-- User top bar --}}
<x-layouts.user_top_bar/>

{{-- Main horizontal menu --}}
<x-layouts.main_menu/>
{{-- Main content --}}
<div class="p-8">
    {{ $slot }}
</div>


</body>
</html>
