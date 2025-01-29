<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

function generateQrCodeString($nik)
{

    // Membuat QR Code langsung ke output
    $qrCode = Builder::create()
      ->writer(new PngWriter())       // Menentukan format PNG
      ->data($nik)   // Data yang akan dienkode
      ->size(300)                     // Ukuran QR Code
      ->margin(10)                    // Margin di sekitar QR Code
      ->build();

    return $qrCode->getString();

}
