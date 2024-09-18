<?php

use Livewire\Volt\Component;

new class extends Component {}; ?>
<aside id="drawer-navigation"
       class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-14 transition-transform dark:border-gray-700 dark:bg-gray-800 md:translate-x-0"
       aria-label="Sidenav">
  <div class="h-full overflow-y-auto bg-white px-3 py-5 dark:bg-gray-800">

    <ul class="space-y-2">
      @hasanyrole(['super-admin', 'payroll','personalia','employee'])
        <li>
          <a href="{{ route('beranda') }}"
            class="@if (Route::currentRouteName() === 'beranda') active bg-blue-200 @endif group flex items-center rounded-lg p-2 text-base font-medium text-gray-900 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
            <x-cui-cil-chart-pie
                                class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
            <span class="ml-3">Beranda</span>
          </a>
        </li>
      @endhasanyrole
      @hasexactroles('pajak')
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
      @endhasexactroles
      @hasexactroles('personalia')
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
      @endhasexactroles
      @hasanyrole(['super-admin', 'payroll'])
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
              class="@if (request()->routeIs(['payroll-insentif', 'payroll-kehadiran'])) space-y-2 py-2 @else hidden space-y-2 py-2 @endif">
              <li>
                <a href="{{ route('payroll-insentif') }}"
                   class="@if (Route::currentRouteName() === 'payroll-insentif') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
                  <span class="ml-3 flex-1 whitespace-nowrap">Insentif</span>
                  <x-cui-cil-thumb-up class="h-4 w-4" />
                </a>
              </li>
              <li>
                <a href="{{ route('payroll-kehadiran') }}"
                  class="@if (Route::currentRouteName() === 'payroll-kehadiran') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
                  <span class="ml-3 flex-1 whitespace-nowrap">Kehadiran</span>
                  <x-cui-cil-calendar-check class="h-4 w-4" />
                </a>
              </li>
          </ul>
        </li>
      @endhasanyrole
      @hasexactroles('employee')
        <li>
          <button type="button"
                  class="group flex w-full items-center rounded-lg p-2 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700"
                  aria-controls="dropdown-karyawan"
                  data-collapse-toggle="dropdown-karyawan">
            <x-cui-cil-user
                            class="h-6 w-6 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
            <span class="ml-3 flex-1 whitespace-nowrap text-left">Dokumen</span>
            <x-cui-cil-chevron-circle-down-alt class="size-4" />
          </button>
          <ul id="dropdown-karyawan"
              class="@if (request()->routeIs(['karyawan-personalia'])) space-y-2 py-2 @else hidden space-y-2 py-2 @endif">
            @hasexactroles('super-admin')
            <li>
              <a href="{{ route('karyawan-personalia') }}"
                 class="@if (Route::currentRouteName() === 'karyawan-personalia') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
                <span class="ml-3 flex-1 whitespace-nowrap">Bukti Potong</span>
                <x-cui-cil-people class="h-4 w-4" />
              </a>
            </li>
            @endhasexactroles
            <li>
              <a href="{{ route('employee-insentif') }}"
                 class="@if (Route::currentRouteName() === 'employee-insentif') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
                <span class="ml-3 flex-1 whitespace-nowrap">Slip Insentif</span>
                <x-cui-cil-people class="h-4 w-4" />
              </a>
            </li>
            <li>
              <a href="{{ route('employee-kehadiran') }}"
                 class="@if (Route::currentRouteName() === 'employee-kehadiran') active bg-blue-200 @endif group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-300 dark:text-white dark:hover:bg-gray-700">
                <span class="ml-3 flex-1 whitespace-nowrap">Slip Kehadiran</span>
                <x-cui-cil-calendar-check class="h-4 w-4" />
              </a>
            </li>
          </ul>
        </li>
      @endhasexactroles
    </ul>
  </div>
</aside>
