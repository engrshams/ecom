<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- new line --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />    
    <!-- Add Google Fonts link -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>