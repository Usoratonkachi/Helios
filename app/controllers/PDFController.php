<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class PdfController extends Controller {

    public function index() {
        // SOAP kliens inicializálása
        try {
            $client = new SoapClient(null, [
                'location' => "http://heliosprojektview.nhely.hu/Helios_Projekt/public/index.php?url=soap/server",
                'uri' => "http://heliosprojektview.nhely.hu/Helios_Projekt/public/index.php?url=soap/server",
                'trace' => 1,
                'exceptions' => true,
            ]);

            // Adatok lekérdezése a SOAP szerverről
            $dals = $client->getAllDals();
            $nyelvek = $client->getAllNyelvek();
            $versenyek = $client->getAllVersenyek();

            // Adatok átadása a nézetnek
            require_once __DIR__ . '/../views/pdf_form.php';


        } catch (SoapFault $fault) {
            error_log("SOAP Hiba: " . $fault->getMessage());
            echo "SOAP Hiba: " . $fault->getMessage();
        }
    }

    public function generate() {
        // SOAP kliens inicializálása
        try {
            $client = new SoapClient(null, [
                'location' => "http://heliosprojektview.nhely.hu/Helios_Projekt/public/index.php?url=soap/server",
                'uri' => "http://heliosprojektview.nhely.hu/Helios_Projekt/public/index.php?url=soap/server",
                'trace' => 1,
                'exceptions' => true,
            ]);

            // Adatok lekérdezése a SOAP szerverről
            $dals = $client->getAllDals();
            $nyelvek = $client->getAllNyelvek();
            $versenyek = $client->getAllVersenyek();

            // Felhasználói bemenetek
            $input1 = $_POST['input1'];
            $input2 = $_POST['input2'];
            $input3 = $_POST['input3'];

            // Nyelv és Verseny adatok előkészítése párosításhoz
            $nyelvMap = [];
            foreach ($nyelvek as $nyelv) {
                $nyelvMap[$nyelv['orszag']] = $nyelv['nyelv'];
            }

            $versenyMap = [];
            foreach ($versenyek as $verseny) {
                $versenyMap[$verseny['ev']] = [
                    'varos' => $verseny['varos'],
                    'induloszam' => $verseny['induloszam']
                ];
            }

            // PDF generálás TCPDF használatával
            $pdf = new TCPDF('L', 'mm', 'A4');
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 10);

            // Táblázat fejlécek beállítása
            $header = [
                'Év' => 20,
                'Sorrend' => 20,
                'Ország' => 30,
                'Hivatalos Nyelv' => 40,
                'Nyelv' => 30,
                'Előadó' => 40,
                'Eredeti' => 40,
                'Magyar' => 40,
                'Helyezés' => 20,
                'Pontszám' => 20,
                'Város' => 30,
                'Indulószám' => 30
            ];

            // Címek kirajzolása
            foreach ($header as $col => $width) {
                $pdf->Cell($width, 7, $col, 1, 0, 'C');
            }
            $pdf->Ln();

            // Táblázat tartalom
            foreach ($versenyek as $verseny) {
                if ($verseny['ev'] == $input1 && $verseny['varos'] == $input2) {
                    $ev = htmlspecialchars($verseny['ev']);
                    $varos = htmlspecialchars($verseny['varos']);
                    $induloszam = htmlspecialchars($verseny['induloszam']);
                    $dalsForYear = array_filter($dals, function($dal) use ($ev, $input3) {
                        return $dal['ev'] == $ev && $dal['nyelv'] == $input3;
                    });

                    foreach ($dalsForYear as $entry) {
                        $orszag = htmlspecialchars($entry['orszag']);
                        $hivatalosNyelv = isset($nyelvMap[$orszag]) ? htmlspecialchars($nyelvMap[$orszag]) : 'N/A';

                        $row = [
                            'Év' => $ev,
                            'Sorrend' => htmlspecialchars($entry['sorrend']),
                            'Ország' => $orszag,
                            'Hivatalos Nyelv' => $hivatalosNyelv,
                            'Nyelv' => htmlspecialchars($entry['nyelv']),
                            'Előadó' => htmlspecialchars($entry['eloado']),
                            'Eredeti' => htmlspecialchars($entry['eredeti']),
                            'Magyar' => htmlspecialchars($entry['magyar']),
                            'Helyezés' => htmlspecialchars($entry['helyezes']),
                            'Pontszám' => htmlspecialchars($entry['pontszam']),
                            'Város' => $varos,
                            'Indulószám' => $induloszam
                        ];

                        // Sor maximális magasságának kiszámítása és cellaszélességek beállítása
                        $maxHeight = 0;
                        foreach ($row as $col => $value) {
                            $nb = $pdf->getNumLines($value, $header[$col]);
                            $height = 6 * $nb; // 6 az alap cella magasság
                            if ($height > $maxHeight) {
                                $maxHeight = $height;
                            }
                        }

                        // Adatok hozzáadása a PDF-hez a maximális sor magassággal
                        foreach ($row as $col => $value) {
                            $width = $header[$col];
                            $pdf->MultiCell($width, $maxHeight, $value, 1, 'L', false, 0, '', '', true, 0, false, true, $maxHeight, 'M', true);
                        }
                        $pdf->Ln();
                    }
                }
            }

            // PDF letöltés
            $pdf->Output('generated.pdf', 'D');

        } catch (SoapFault $fault) {
            error_log("SOAP Hiba: " . $fault->getMessage());
            echo "SOAP Hiba: " . $fault->getMessage();
        }
    }
}
?>
