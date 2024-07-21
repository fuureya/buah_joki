<?php

require_once __DIR__ . './../vendor/autoload.php';

// Pastikan direktori temporer ada dan dapat ditulisi
$tempDir = __DIR__ . '/temppdf/';
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true); // Buat direktori jika belum ada
}

$mpdf = new \Mpdf\Mpdf(['tempDir' => $tempDir]);
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();
