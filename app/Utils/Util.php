<?php

function getPrevMonth()
{
    $currentDate = new DateTime();

    $currentDate->sub(new DateInterval('P1M'));

    $prevMonth = $currentDate->format('Y-m');

    return $prevMonth;
}
function addEndDate($periode) {
    // Parsing tahun dan bulan dari periode
    list($tahun, $bulan) = explode('-', $periode);

    // Hitung jumlah hari dalam bulan tersebut
    $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    // Buat tanggal akhir dengan format YYYY-MM-DD
    $tanggalAkhir = sprintf('%s-%s-%02d', $tahun, $bulan, $jumlahHari);

    return $tanggalAkhir;
}

