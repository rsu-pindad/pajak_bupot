<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>

  <div class="relative shadow-md sm:rounded-lg p-6">
    <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
      <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col"
              class="p-4">
            <div class="flex items-center">
              <input id="checkbox-all-search"
                     type="checkbox"
                     class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
              <label for="checkbox-all-search"
                     class="sr-only">checkbox</label>
            </div>
          </th>
          <th scope="col"
              class="px-6 py-3">
            Name
          </th>
          <th scope="col"
              class="px-6 py-3">
            Position
          </th>
          <th scope="col"
              class="px-6 py-3">
            Status
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
          <td class="w-4 p-4">
            <div class="flex items-center">
              <input id="checkbox-table-search-1"
                     type="checkbox"
                     class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
              <label for="checkbox-table-search-1"
                     class="sr-only">checkbox</label>
            </div>
          </td>
          <th scope="row"
              class="flex items-center whitespace-nowrap px-6 py-4 text-gray-900 dark:text-white">
            <img class="h-10 w-10 rounded-full"
                 src="/docs/images/people/profile-picture-1.jpg"
                 alt="Jese image">
            <div class="ps-3">
              <div class="text-base font-semibold">Neil Sims</div>
              <div class="font-normal text-gray-500">neil.sims@flowbite.com</div>
            </div>
          </th>
          <td class="px-6 py-4">
            React Developer
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <div class="me-2 h-2.5 w-2.5 rounded-full bg-green-500"></div> Online
            </div>
          </td>
        </tr>
        <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
          <td class="w-4 p-4">
            <div class="flex items-center">
              <input id="checkbox-table-search-2"
                     type="checkbox"
                     class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
              <label for="checkbox-table-search-2"
                     class="sr-only">checkbox</label>
            </div>
          </td>
          <th scope="row"
              class="flex items-center whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
            <img class="h-10 w-10 rounded-full"
                 src="/docs/images/people/profile-picture-3.jpg"
                 alt="Jese image">
            <div class="ps-3">
              <div class="text-base font-semibold">Bonnie Green</div>
              <div class="font-normal text-gray-500">bonnie@flowbite.com</div>
            </div>
          </th>
          <td class="px-6 py-4">
            Designer
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <div class="me-2 h-2.5 w-2.5 rounded-full bg-green-500"></div> Online
            </div>
          </td>
        </tr>
        <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600">
          <td class="w-4 p-4">
            <div class="flex items-center">
              <input id="checkbox-table-search-3"
                     type="checkbox"
                     class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
              <label for="checkbox-table-search-3"
                     class="sr-only">checkbox</label>
            </div>
          </td>
          <th scope="row"
              class="flex items-center whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
            <img class="h-10 w-10 rounded-full"
                 src="/docs/images/people/profile-picture-4.jpg"
                 alt="Jese image">
            <div class="ps-3">
              <div class="text-base font-semibold">Leslie Livingston</div>
              <div class="font-normal text-gray-500">leslie@flowbite.com</div>
            </div>
          </th>
          <td class="px-6 py-4">
            SEO Specialist
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <div class="me-2 h-2.5 w-2.5 rounded-full bg-red-500"></div> Offline
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

</div>
