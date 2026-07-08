<?php
$fontDir = __DIR__ . '/font';
if (!is_dir($fontDir)) {
    mkdir($fontDir, 0777, true);
}

$fonts = [
    'helvetica.php',
    'helveticab.php',
    'helveticai.php',
    'courier.php',
    'times.php',
    'timesb.php',
    'timesi.php'
];

foreach ($fonts as $fontFile) {
    echo "Downloading font: $fontFile...\n";
    $url = "https://raw.githubusercontent.com/Setasign/FPDF/1.8.6/font/" . $fontFile;
    $content = file_get_contents($url);
    if ($content !== false) {
        file_put_contents($fontDir . '/' . $fontFile, $content);
        echo "Saved to font/$fontFile\n";
    } else {
        echo "Failed to download $fontFile\n";
    }
}
echo "Font download finished!\n";
