<?php

namespace App\Service;

class EdifactService
{

    public function generateEDIFACTRentMessage(
        string $startDate, string $endDate, int $userId, int $bookId
    ): string
    {
        // Nagłówek UNB
        $unbSegment = "UNB+UNOA:2+SENDER_ID+RECEIVER_ID+210929:1418+1'";

        // Nagłówek UNH z nowym numerem modelu
        $unhSegment = "UNH+1+ORDERS:D:96A:UN'";

        // Informacje o zamówieniu BGM
        $bgmSegment = "BGM+220+ORD123+9'";

        // Data i czas DTM
        $dtmSegment = "DTM+137:{$startDate}:102'";

        // Informacje o zamawiającym NAD
        $nadSegmentBuyer = "NAD+BY+{$userId}::9'";

        // Informacje o odbiorcy NAD
        $nadSegmentSupplier = "NAD+SU+987654321::9'";

        // Informacje o pozycji zamówienia LIN
        $linSegment = "LIN+1++{$bookId}:IN'";

        // Informacje o produkcie PIA
        $piaSegment = "PIA+1+ABC1234:IN'";

        // Ilość zamówiona QTY
        $qtySegment = "QTY+21:48'";

        // Data i czas ponownie DTM
        $dtmSegment2 = "DTM+2:{$endDate}:102'";

        // Cena jednostkowa PRI
        $priSegment = "PRI+AAA:14.58:CT:AAE:1:KGM'";

        // Zakończenie sekcji specyfikacji UNS
        $unsSegment = "UNS+S'";

        // Liczymy liczbę segmentów
        $segmentsCount = $this->countSegments($unbSegment . $unhSegment . $bgmSegment . $dtmSegment .
            $nadSegmentBuyer . $nadSegmentSupplier . $linSegment .
            $piaSegment . $qtySegment. $dtmSegment2 . $priSegment . $unsSegment);

        // Zakończenie komunikatu UNT z dynamicznie obliczoną liczbą segmentów
        $untSegment = "UNT+{$segmentsCount}+1'";

        // Łączymy wszystkie segmenty w jedną wiadomość
        $edifactMessage = $unbSegment . $unhSegment . $bgmSegment . $dtmSegment . $nadSegmentBuyer .
            $nadSegmentSupplier . $linSegment . $piaSegment . $qtySegment . $dtmSegment2 . $priSegment .
            $unsSegment . $untSegment;

        return $edifactMessage;
    }

    /**
     * @param string $edifactMessage
     * @return array
     */
    function parseEDIFACTRentMessage(string $edifactMessage): array
    {
        // Rozdzielamy segmenty
        $segments = explode("'", $edifactMessage);

        // Inicjalizujemy zmienne
        $userId = null;
        $bookId = null;
        $startDate = null;
        $endDate = null;

        // Parsujemy segmenty i wypisujemy interesujące nas informacje
        foreach ($segments as $segment) {
            $fields = explode('+', $segment);

            // Sprawdzamy typ segmentu
            $segmentType = $fields[0];

            // Parsujemy interesujące nas pola
            if ($segmentType === 'NAD') {
                if ($userId) { continue; }
                $userId = explode('::', $fields[2])[0];
            } elseif ($segmentType === 'LIN') {
                $bookId = explode(':', $fields[3])[0];
            } elseif ($segmentType === 'DTM') {
                if (!$startDate) {
                    $sd = explode(':', $fields[1])[1];
                    $ts = strtotime($sd);
                    $startDate = new \DateTimeImmutable(("@$ts"));
                    continue;
                }

                $sd = explode(':', $fields[1])[1];
                $ts = strtotime($sd);
                $endDate = new \DateTimeImmutable(("@$ts"));
            }
        }

        return [
            'rentFrom' => $startDate,
            'rentTo' => $endDate,
            'itemId' => $bookId,
            'userId' => $userId
        ];
    }

    private function countSegments($edifactMessage) {
        $segments = explode("'", $edifactMessage);
        // Usuwamy pusty segment z końca
        array_pop($segments);
        return count($segments);
    }

}