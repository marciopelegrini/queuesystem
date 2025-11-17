<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<title>{{ config('app.name') }} {!! empty($subtitle) ? '' : ' &vellip; ' . $subtitle !!}</title>
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
{{-- Load resources --}}
<link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
@vite('resources/css/app.css')
</head>
<body class="bg-zinc-200">

    {{-- User top bar --}}

    {{-- Main horizontal menu --}}

    {{-- Main content --}}
    <div class="p-8">
        {{ $slot }}
    </div>


</body>
</html>
