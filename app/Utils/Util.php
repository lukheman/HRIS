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
