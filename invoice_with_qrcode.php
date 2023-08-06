<?php

require_once 'vendor/autoload.php';

use TCPDF;
use PHPQRCode\QRCode;

// Upload the PDF file
$pdf_file = file_get_contents('invoice.pdf');

// Create a new TCPDF instance
$pdf = new TCPDF();

// Detect the online link in the PDF
$pattern = '/https?:\/\/[a-zA-Z0-9\-\.]+\.[a-z]{2,6}/';
preg_match($pattern, $pdf_file, $matches);
$link = $matches[0];

// Generate a QR code for the link
$qrcode = new QRCode();
$qrcode->setText($link);
$qrcode->setSize(100);
$qrcode->setMargin(10);
$qrcode->png('qrcode.png');

// Embed the QR code into the PDF
$image = $pdf->Image('qrcode.png', 10, 10, 100, 100);

// Output the PDF file
$pdf->Output('invoice_with_qrcode.pdf', 'F');

?>
