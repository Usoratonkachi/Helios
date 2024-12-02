<?php
require_once __DIR__ . '/../../vendor/autoload.php';  // TCPDF betöltése

// SOAP kliens inicializálása
$client = new SoapClient("http://helyes_szerver_soap_link");

try {
    // SOAP hívás
    $response = $client->getAllDals(); // a helyes metódus meghívása
} catch (SoapFault $fault) {
    // SOAP hiba kezelése
    echo "SOAP Hiba: " . $fault->getMessage();
    exit();
}

// PDF generálása TCPDF segítségével
$pdf = new TCPDF('P', 'mm', 'A4');
$pdf->AddPage();  // Új oldal hozzáadása
$pdf->SetFont('helvetica', '', 12);  // Betűtípus és méret beállítása

// Fejléc a PDF-en
$pdf->Cell(0, 10, 'Dalok lista:', 0, 1);

// Adatok kiírása a PDF-be
foreach ($response as $dal) {
    // Feltételezve, hogy a válasz tömbje 'nev' mezőt tartalmaz
    $pdf->Cell(0, 10, $dal['nev'], 0, 1);  // 'nev' mező, cseréld ki a megfelelő mezőkre
}

// PDF mentése és megjelenítése
$pdf->Output('generated.pdf', 'I');  // PDF kimenet (a böngészőben megjelenítve)
?>
