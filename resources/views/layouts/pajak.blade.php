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
        {{-- <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
          <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64"></div>
          <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64"></div>
          <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64"></div>
          <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64"></div>
        </div>
        <div class="mb-4 h-96 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600"></div>
        <div class="mb-4 grid grid-cols-2 gap-4">
          <div class="h-48 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-72"></div>
          <div class="h-48 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-72"></div>
          <div class="h-48 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-72"></div>
          <div class="h-48 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-72"></div>
        </div>
        <div class="mb-4 h-96 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600"></div>
        <div class="grid grid-cols-2 gap-4">
          <div class="h-48 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-72"></div>
          <div class="h-48 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-72"></div>
          <div class="h-48 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-72"></div>
          <div class="h-48 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-72"></div>
        </div> --}}
      </main>
    </div>
  </body>

</html>
