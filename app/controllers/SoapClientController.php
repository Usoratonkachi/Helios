<?php
class SoapClientController {
    public function testSoap() {
        try {
            $client = new SoapClient(null, [
                'location' => "http://heliosprojektview.nhely.hu/Helios_Projekt/public/index.php?url=soap/server",  // Módosított domain
                'uri' => "http://heliosprojektview.nhely.hu/Helios_Projekt/public/index.php?url=soap/server",  // Módosított domain
                'trace' => 1,
                'exceptions' => true,
            ]);

            $dals = $client->getAllDals();
            $nyelvek = $client->getAllNyelvek();
            $versenyek = $client->getAllVersenyek();

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

            // Adatok megjelenítése táblázatban
            echo '<h2>Dalok</h2>';
            echo '<table border="1" cellpadding="10">';
            echo '<tr><th>Év</th><th>Sorrend</th><th>Ország</th><th>Hivatalos Nyelv</th><th>Nyelv</th><th>Előadó</th><th>Eredeti</th><th>Magyar</th><th>Helyezés</th><th>Pontszám</th><th>Város</th><th>Indulószám</th></tr>';

            foreach ($dals as $entry) {
                $ev = htmlspecialchars($entry['ev']);
                $orszag = htmlspecialchars($entry['orszag']);
                $varos = isset($versenyMap[$ev]['varos']) ? htmlspecialchars($versenyMap[$ev]['varos']) : 'N/A';
                $induloszam = isset($versenyMap[$ev]['induloszam']) ? htmlspecialchars($versenyMap[$ev]['induloszam']) : 'N/A';
                $hivatalosNyelv = isset($nyelvMap[$orszag]) ? htmlspecialchars($nyelvMap[$orszag]) : 'N/A';

                echo '<tr>';
                echo '<td>' . $ev . '</td>';
                echo '<td>' . htmlspecialchars($entry['sorrend']) . '</td>';
                echo '<td>' . $orszag . '</td>';
                echo '<td>' . $hivatalosNyelv . '</td>';
                echo '<td>' . htmlspecialchars($entry['nyelv']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['eloado']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['eredeti']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['magyar']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['helyezes']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['pontszam']) . '</td>';
                echo '<td>' . $varos . '</td>';
                echo '<td>' . $induloszam . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } catch (SoapFault $fault) {
            error_log("SOAP Hiba: " . $fault->getMessage());
            echo "SOAP Hiba: " . $fault->getMessage();
        }
    }
}
?>
