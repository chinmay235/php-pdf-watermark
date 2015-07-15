<?php
//This page create a new pdf file by using fpdf.
require('fpdf/fpdf.php');
class PDF_Rotate extends FPDF {

    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle*=M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

}

class PDF extends PDF_Rotate {

    function Header() {
        //Put the watermark
        $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World',40,100,100,0,'PNG');
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(35, 190, 'CHINMAY KUMAR SAHU', 45);
    }

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

}

# ==========================

$pdf = new PDF();
//$pdf = new FPDI();
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
