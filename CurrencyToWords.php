<?php
class CurrencyToWords {
    
    private static $ones = array(
        0 => 'kosong',
        1 => 'satu',
        2 => 'dua',
        3 => 'tiga',
        4 => 'empat',
        5 => 'lima',
        6 => 'enam',
        7 => 'tujuh',
        8 => 'lapan',
        9 => 'sembilan'
    );

    private static $tens = array(
        10 => 'sepuluh',
        20 => 'dua puluh',
        30 => 'tiga puluh',
        40 => 'empat puluh',
        50 => 'lima puluh',
        60 => 'enam puluh',
        70 => 'tujuh puluh',
        80 => 'lapan puluh',
        90 => 'sembilan puluh'
    );

    private static $units = array(
        'seribu juta' => 1000000000,
        'juta' => 1000000,
        'ribu' => 1000,
        'ratus' => 100
    );

    private static $sen = 'sen';

    public static function convertToWords($amount) {
        $words = '';

        $ringgit = floor($amount);
        $sen = round(($amount - $ringgit) * 100);

        if ($ringgit == 0) {
            $words .= 'kosong';
        } else {
            foreach (self::$units as $unit => $value) {
                if ($ringgit >= $value) {
                    $current = floor($ringgit / $value);
                    $words .= self::convertToWords($current) . ' ' . $unit . ' ';
                    $ringgit -= $current * $value;
                }
            }

            if ($ringgit > 0) {
                if ($ringgit < 10) {
                    $words .= self::$ones[$ringgit];
                } elseif ($ringgit < 20) {
                    $words .= self::$ones[$ringgit - 10] . ' belas';
                } elseif ($ringgit < 100) {
                    $words .= self::$tens[$ringgit - $ringgit % 10];
                    $remainder = $ringgit % 10;
                    if ($remainder > 0) {
                        $words .= ' ' . self::$ones[$remainder];
                    }
                }
            }
        }

        // Convert sen to words
        if ($sen > 0) {
            if ($words != '') {
                $words .= ' dan ';
            }
            if ($sen < 10) {
                $words .= self::$sen . " " . self::$ones[$sen] . ' ';
            } elseif ($sen < 20) {
                $words .= self::$sen . " " . self::$ones[$sen - 10] . ' belas ';
            } else {
                $words .= self::$sen . " " . self::$tens[$sen - $sen % 10];
                $remainder = $sen % 10;
                if ($remainder > 0) {
                    $words .=  ' ' . self::$ones[$remainder] . ' ';
                }
            }
        }

        return strtoupper($words);
    }
}
?>
