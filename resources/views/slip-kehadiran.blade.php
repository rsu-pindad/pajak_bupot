<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Slip Kehadiran</title>

    <!-- Fonts -->
    <link rel="preconnect"
          href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body>

    <p>Nama Pegawai : {{ $kehadiran->nama_pegawai }}</p>
    <p>Nomor Pokok Pegawai : {{ $kehadiran->npp_kehadiran }}</p>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <p>A. Komponen Perhitungan Kehadiran</p>
        <p>Tunjangan Kehadiran : {{ $kehadiran->tunjangan_kehadiran }}</p>
        <p>Tunjangan Kehadiran : {{ $kehadiran->jumlah_hari_kerja }}</p>
        <p>Tunjangan Kehadiran : {{ $kehadiran->jumlah_jam_terbuang }}</p>
        <p>Tunjangan Kehadiran : {{ $kehadiran->jumlah_cuti }}</p>
      </div>
      <div>
        <p>B. Perhitungan Kehadiran</p>
        <p>Potongan Absensi : {{ $kehadiran->potongan_absensi }}</p>
        <p>Jumlah Pendapatan : {{ $kehadiran->jumlah_pendapatan }}</p>
        <p>Pembulatan : {{ $kehadiran->jumlah_pembulatan }}</p>
        <p>Diterimakan : {{ $kehadiran->jumlah_diterimakan }}</p>
      </div>
    </div>

  </body>

</html>
