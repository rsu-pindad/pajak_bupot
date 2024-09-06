<?php

use Livewire\Volt\Component;

new class extends Component {}; ?>
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
                aria-controls="dropdown-bupot"
                data-collapse-toggle="dropdown-bupot">
          <x-cui-cil-file
                          class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
          <span class="ml-3 flex-1 whitespace-nowrap text-left">Bukti Potong</span>
          <x-cui-cil-chevron-circle-down-alt class="size-4" />
        </button>
        <ul id="dropdown-bupot"
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
                aria-controls="dropdown-karyawan"
                data-collapse-toggle="dropdown-karyawan">
          <x-cui-cil-user
                          class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
          <span class="ml-3 flex-1 whitespace-nowrap text-left">Karyawan</span>
          <x-cui-cil-chevron-circle-down-alt class="size-4" />
        </button>
        <ul id="dropdown-karyawan"
            class="@if (request()->routeIs(['karyawan-personalia'])) space-y-2 py-2 @else hidden space-y-2 py-2 @endif">
          <li>
            <a href="{{ route('karyawan-personalia') }}"
               class="@if (Route::currentRouteName() === 'karyawan-personalia') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
              <span class="ml-3 flex-1 whitespace-nowrap">Personalia</span>
              <x-cui-cil-people class="h-4 w-4" />
            </a>
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
                aria-controls="dropdown-payroll"
                data-collapse-toggle="dropdown-payroll">
                <x-cui-cil-money
                class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
          <span class="ml-3 flex-1 whitespace-nowrap text-left">Payroll</span>
          <x-cui-cil-chevron-circle-down-alt class="size-4" />
        </button>
        <ul id="dropdown-payroll"
            class="@if (request()->routeIs(['payroll-insentif','payroll-kehadiran'])) space-y-2 py-2 @else hidden space-y-2 py-2 @endif">
          <li>
          <a href="{{ route('payroll-insentif') }}"
               class="@if (Route::currentRouteName() === 'payroll-insentif') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
              <span class="ml-3 flex-1 whitespace-nowrap">Insentif</span>
              <x-cui-cil-thumb-up class="h-4 w-4" />
            </a>
          </li>
          <a href="{{ route('payroll-kehadiran') }}"
               class="@if (Route::currentRouteName() === 'payroll-kehadiran') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
              <span class="ml-3 flex-1 whitespace-nowrap">Kehadiran</span>
              <x-cui-cil-calendar-check class="h-4 w-4" />
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</aside>
