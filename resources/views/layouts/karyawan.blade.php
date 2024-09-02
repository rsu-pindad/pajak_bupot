<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body>
    <div class="bg-gray-50 antialiased dark:bg-gray-900">
      <livewire:layout.flowbite-shell-navbar />

      <!-- Sidebar -->
      <livewire:layout.flowbite-shell-sidebar />

      <main class="h-auto p-4 pt-20 md:ml-64">
        {{$slot}}
      </main>
    </div>
  </body>

</html>
