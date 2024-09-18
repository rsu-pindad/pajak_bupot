<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Slip Kehadiran</title>

    <!-- Fonts -->
    <link rel="stylesheet"
          type="text/css"
          href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <style>
      body {
        font-family: Ubuntu, sans-serif;
      }

      .watermark {
        -webkit-transform: rotate(331deg);
        -moz-transform: rotate(331deg);
        -o-transform: rotate(331deg);
        transform: rotate(331deg);
        font-size: 8em;
        color: rgba(112, 112, 112, 0.151);
        position: fixed;
        font-family: Ubuntu, sans-serif;
        text-transform: uppercase;
        padding-left: 10%;
        padding-top: 10%;
      }

      .antialiased {
        background-image: url("<?php public_path('pmu.png');?>");
        background-repeat: no-repeat;
        background-size: cover;
      }
    </style>
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css'])
  </head>

  <body class="antialiased">

    <span class="watermark">PMU</span>
    <div class="mx-auto my-auto px-8 py-8">
      <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
          <img class="mr-2 h-10 w-10"
               src="{{ public_path('pmu.png') }}"
               alt="Logo" />
          <div class="inline-block">
            <p class="text-lg font-semibold text-gray-700">PT PINDAD MEDIKA UTAMA</p>
            <p class="text-sm font-light text-gray-500">Jl. Jend. Gatot Soebroto No. 517 Bandung</p>
          </div>
        </div>
      </div>
      <div class="mb-2 flex items-center justify-center">
        <div class="inline-block text-center">
          <p class="text-sm font-medium text-gray-600">STRUK PEMBAYARAN INSENTIF KINERJA PEJABAT STRUKTURAL</p>
          <p class="text-sm font-medium text-gray-600">PERIODE BULAN
            {{ \App\Enums\Bulan::from($insentif->insentif_periode_bulan)->labels() }}
            {{ $insentif->kehadiran_tahun }} PEMBAYARAN
            {{ \App\Enums\Bulan::from($insentif->insentif_pembayaran_bulan)->labels() }}
            {{ $insentif->kehadiran_tahun }}</p>
        </div>
      </div>
      <hr class="border-1 mb-1 h-px bg-gray-200 dark:bg-gray-900">
      <hr class="border-1 mb-4 h-px bg-gray-200 dark:bg-gray-900">
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div class="grid-cols-subgrid grid gap-3">
          <table class="table-fixed text-nowrap">
            <thead>
              <tr>
                <th 
                    class="text-left">NO.</th>
                <th colspan="3"
                    class="text-left">{{$insentif->id}}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>NAMA</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ $insentif->nama_pegawai }}</td>
              </tr>
              <tr>
                <td>NPP</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ $insentif->npp_insentif }}</td>
              </tr>
              <tr>
                <td>LEVEL</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ $insentif->level_insentif }}</td>
              </tr>
              <tr>
                <td>JABATAN</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ $insentif->jabatan }}</td>
              </tr>
              <tr>
                <td>NOMINAL <br>MAX IKIN</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ number_format($insentif->nominal_max_insentif_kinerja,2,',', '.') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="grid-cols-subgrid grid gap-3">
          <table class="table-fixed text-nowrap">
            <thead>
              <tr>
                <th colspan="4"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>KINERJA KEUANGAN <br>PERUSAHAAN (%)</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ $insentif->kinerja_keuangan_perusahaan }}%</td>
              </tr>
              <tr>
                <td>NILAI / SCOR KPI (%)</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ $insentif->nilai_kpi}}%</td>
              </tr>
              <tr>
                <td>INSENTIF KINERJA</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ number_format($insentif->insentif_kinerja, 2, ',', '.') }}</td>
              </tr>
              <tr>
                <td>PEMBULATAN</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ number_format($insentif->pembulatan, 2, ',', '.') }}</td>
              </tr>
              <tr class="font-bold">
                <td>DITERIMAKAN</td>
                <td>:</td>
                <td colspan="2"
                    class="text-right">{{ number_format($insentif->jumlah_diterimakan, 2, ',', '.') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr class="border-1 mt-4 h-px bg-gray-200 dark:bg-gray-900">
      <hr class="border-1 mt-1 h-px bg-gray-200 dark:bg-gray-900">
      <footer class="fixed inset-x-0 bottom-0 p-4 text-center text-3xl">
        <div class="mx-auto w-full max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
          <span class="text-xs text-gray-400"><a href="https://pindadmedika.com/"
               class="hover:underline">PT Pindad Medika Utama</a>
          </span>
          <ul class="items-right mt-3 flex flex-wrap text-xs font-medium text-gray-400">
            <li>
              <a href="#"
                 class="hover:underline">berkas ini dibuat pada : {{ \Carbon\Carbon::now() }}</a>
            </li>
          </ul>
        </div>
      </footer>
    </div>

  </body>

</html>
