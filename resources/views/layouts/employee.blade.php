<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <wireui:scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body>
    <div class="bg-gray-50 antialiased dark:bg-gray-900">
      <livewire:layout.flowbite-shell-navbar/>
      
      <!-- Sidebar -->
      <livewire:layout.flowbite-shell-sidebar/>
      
      <main class="h-auto p-4 pt-20 md:ml-64">
        <x-wireui-notifications position="top"/>
        <x-wireui-dialog />
        {{ $slot }}
      </main>
    </div>
    <script type="module">
      Wireui.hook('load', () => console.log('wireui ok'));
    </script>
    @stack('customScript');
  </body>

</html>
