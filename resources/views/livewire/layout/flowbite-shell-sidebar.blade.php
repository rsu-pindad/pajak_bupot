<?php

use Livewire\Volt\Component;

new class extends Component {}; ?>
{{-- <x-heroicons::solid.chevron-up class="size-4 ms-auto hidden h-4 w-4 hs-accordion-active:block" />
<x-heroicons::solid.chevron-down class="size-4 ms-auto block h-4 w-4 hs-accordion-active:hidden" /> --}}
<aside id="drawer-navigation"
       class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-14 transition-transform dark:border-gray-700 dark:bg-gray-800 md:translate-x-0"
       aria-label="Sidenav">
  <div class="h-full overflow-y-auto bg-white px-3 py-5 dark:bg-gray-800">

    <ul class="space-y-2">
      <li>
        <a href="{{ route('beranda') }}"
           class="@if (Route::currentRouteName() === 'beranda') active bg-blue-200 @endif group flex items-center rounded-lg p-2 text-base font-medium text-gray-900 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
          <x-cui-cil-chart-pie
                               class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
          <span class="ml-3">Beranda</span>
        </a>
      </li>
      <li>
        <button type="button"
                class="group flex w-full items-center rounded-lg p-2 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700"
                aria-controls="dropdown-pages"
                data-collapse-toggle="dropdown-pages">
          <x-cui-cil-file
                          class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
          <span class="ml-3 flex-1 whitespace-nowrap text-left">Bukti Potong</span>
          <x-cui-cil-chevron-circle-down-alt class="size-4" />
        </button>
        @if (request()->routeIs(['kode', 'satuan', 'vendor', 'tipe-merek', 'tipe', 'merek', 'unit']))
          display:block;
        @endif
        <ul id="dropdown-pages"
            class="@if (request()->routeIs(['bupot-upload', 'bupot-publish'])) space-y-2 py-2 @else hidden space-y-2 py-2 @endif">
          <li>
            <a href="{{ route('bupot-upload') }}"
               class="@if (Route::currentRouteName() === 'bupot-upload') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
              <span class="ml-3 flex-1 whitespace-nowrap">Unggah</span>
              <x-cui-cil-cloud-upload class="h-4 w-4" />
            </a>
          </li>
          <li>
            <a href="{{ route('bupot-publish') }}"
               class="@if (Route::currentRouteName() === 'bupot-publish') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
              <span class="ml-3 flex-1 whitespace-nowrap">Publish</span>
              <x-cui-cil-share-alt class="h-4 w-4" />
            </a>
          </li>
        </ul>
      </li>
      <li>
        <button type="button"
                class="group flex w-full items-center rounded-lg p-2 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700"
                aria-controls="dropdown-sales"
                data-collapse-toggle="dropdown-sales">
          <svg aria-hidden="true"
               class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
               fill="currentColor"
               viewBox="0 0 20 20"
               xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                  clip-rule="evenodd"></path>
          </svg>
          <span class="ml-3 flex-1 whitespace-nowrap text-left">Sales</span>
          <svg aria-hidden="true"
               class="h-6 w-6"
               fill="currentColor"
               viewBox="0 0 20 20"
               xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
          </svg>
        </button>
        <ul id="dropdown-sales"
            class="hidden space-y-2 py-2">
          <li>
            <a href="#"
               class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">Products</a>
          </li>
          <li>
            <a href="#"
               class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">Billing</a>
          </li>
          <li>
            <a href="#"
               class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">Invoice</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="#"
           class="group flex items-center rounded-lg p-2 text-base font-medium text-gray-900 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
          <svg aria-hidden="true"
               class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
               fill="currentColor"
               viewBox="0 0 20 20"
               xmlns="http://www.w3.org/2000/svg">
            <path
                  d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z">
            </path>
            <path
                  d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z">
            </path>
          </svg>
          <span class="ml-3 flex-1 whitespace-nowrap">Messages</span>
          <span
                class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-primary-100 text-xs font-semibold text-primary-800 dark:bg-primary-200 dark:text-primary-800">
            4
          </span>
        </a>
      </li>
      <li>
        <button type="button"
                class="group flex w-full items-center rounded-lg p-2 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700"
                aria-controls="dropdown-authentication"
                data-collapse-toggle="dropdown-authentication">
          <svg aria-hidden="true"
               class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
               fill="currentColor"
               viewBox="0 0 20 20"
               xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                  clip-rule="evenodd"></path>
          </svg>
          <span class="ml-3 flex-1 whitespace-nowrap text-left">Authentication</span>
          <svg aria-hidden="true"
               class="h-6 w-6"
               fill="currentColor"
               viewBox="0 0 20 20"
               xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
          </svg>
        </button>
        <ul id="dropdown-authentication"
            class="hidden space-y-2 py-2">
          <li>
            <a href="#"
               class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">Sign
              In</a>
          </li>
          <li>
            <a href="#"
               class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">Sign
              Up</a>
          </li>
          <li>
            <a href="#"
               class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">Forgot
              Password</a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</aside>
