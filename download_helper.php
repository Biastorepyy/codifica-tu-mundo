<?php
echo "Downloading FPDF 1.86...\n";
$zipData = file_get_contents('http://www.fpdf.org/files/pub/fpdf186.zip');
if ($zipData === false) {
    die("Failed to download zip.\n");
}
file_put_contents('fpdf.zip', $zipData);

echo "Extracting FPDF...\n";
$zip = new ZipArchive;
if ($zip->open('fpdf.zip') === TRUE) {
    // Extract everything to the current directory
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Extracted successfully!\n";
} else {
    echo "Failed to open zip.\n";
}

unlink('fpdf.zip');
echo "Done!\n";
