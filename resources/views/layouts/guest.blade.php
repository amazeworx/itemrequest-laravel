<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}">
  <link rel="icon" sizes="512x512" href="{{ asset('logo-512x512.png') }}">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="application-name" content="Item Request">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Item Request">
  <link rel="apple-touch-icon" href="{{ asset('logo-512x512.png') }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
  </div>
  <script src="{{ asset('/sw.js') }}"></script>
  <script>
    if (!navigator.serviceWorker.controller) {
      navigator.serviceWorker.register("/sw.js").then(function (reg) {
        console.log("Service worker has been registered for scope: " + reg.scope);
      });
    }
  </script>
</body>

</html>