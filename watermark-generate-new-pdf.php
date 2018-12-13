<?php
//This page create a new pdf file by using fpdf.
require('./vendor/WatermarkPDF/WatermarkPDF.php');

$pdf = new WatermarkPDF(null,"CHINMAY KUMAR SAHU");
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

//$pdf->Cell( 200, 230, $reportSubtitle, 0);


//MultiCell loop text
$txt = "FPDF is a PHP class which allows to generate PDF files with pure PHP, that is to say " .
        "without using the PDFlib library. F from FPDF stands for Free: you may use it for any " .
        "kind of usage and modify it to suit your needs.\n\n";
for ($i = 0; $i < 25; $i++){
    $pdf->MultiCell(0, 5, $txt, 0, 'J');
}

$pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser
//$pdf->Output("sampleUpdated.pdf", 'D'); //Download the file. open dialogue window in browser to save, not open with PDF browser viewer
//$pdf->Output("sampleUpdated.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
//$pdf->Output("sampleUpdated.pdf", 'I'); //I for "inline" to send the PDF to the browser
//$pdf->Output("sampleUpdated.pdf", 'S'); //return the document as a string. filename is ignored.
?>
