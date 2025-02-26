<?php

function getPrevMonth()
{
    $currentDate = new DateTime();

    $currentDate->sub(new DateInterval('P1M'));

    $prevMonth = $currentDate->format('Y-m');

    return $prevMonth;
}

function addEndDate($periode)
{
    // Parsing tahun dan bulan dari periode
    list($tahun, $bulan) = explode('-', $periode);

    // Hitung jumlah hari dalam bulan tersebut
    $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    // Buat tanggal akhir dengan format YYYY-MM-DD
    $tanggalAkhir = sprintf('%s-%s-%02d', $tahun, $bulan, $jumlahHari);

    return $tanggalAkhir;
}

function generateHeaderDate($periode)
{
    list($tahun, $bulan) = explode('-', $periode);

    // Hitung jumlah hari dalam bulan
    $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    // Array nama hari dalam bahasa Indonesia
    $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    // Generate array tanggal dari 01 hingga jumlah hari
    $tanggalHeader = array_map(function ($hari) {
        return str_pad($hari, 2, '0', STR_PAD_LEFT); // Format dua digit (01, 02, dst.)
    }, range(1, $jumlahHari));

    return $tanggalHeader;
}


function hitungJarak($lat1, $lon1, $lat2, $lon2)
{
    $R = 6371000; // Radius bumi dalam meter
    $phi1 = deg2rad($lat1);
    $phi2 = deg2rad($lat2);
    $deltaPhi = deg2rad($lat2 - $lat1);
    $deltaLambda = deg2rad($lon2 - $lon1);

    $a = sin($deltaPhi / 2) * sin($deltaPhi / 2) +
         cos($phi1) * cos($phi2) *
         sin($deltaLambda / 2) * sin($deltaLambda / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $R * $c; // Jarak dalam meter
}
