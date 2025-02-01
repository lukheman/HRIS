<?php

namespace App\Interfaces;

interface AbsensiInterface
{
    public function listAbsensi();
    public function absensiBulanan();
    public function updateAbsensi();
    public function cetakLaporanAbsensi();
}
