<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aplikasi HRD PT. SMP</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  @yield('script-top')
</head>
{{-- <body background="{{asset('storages/motif-dayak.jpg')}}"> --}}
<body>
  @yield('basic-content')
  <script>
    var Laravel = {
      csrfToken: '{{ csrf_token() }}'
    }
  </script>
  <script src="{{ mix('js/app.js') }}"></script>
  {{-- @yield('script-bottom') --}}
  @include('_layout.javascript')
</body>
</html>
