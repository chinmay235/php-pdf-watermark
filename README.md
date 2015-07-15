# php pdf for text and image watermark

PDFWatermark enables you to add an image as a watermark to new PDF files or existing PDF files. It uses FPDF that allows you to write PDF files and FPDI that allows you to import existing PDF documents into FPDF.

Using it, you can:

>Use jpg and png ( with alpha channels ) files with a 96 DPI resolution
>Easily position the watermark on the pages of the PDF file



    

[Click here](http://www.fpdf.org/en/download.php) to download fpdf latest version

[Click here](http://www.setasign.com/products/fpdi/downloads/) to download FPDI latest version


## Description
PHP PDF Watermark is a library to load watermark images provided via URL image or entered text.  
It returns an pdf format. 
PDFWatermarker enables you to add an image as a watermark to existing PDF files. It uses FPDF that allows you to write PDF files and FPDI that allows you to import existing PDF documents into FPDF.



#Generate Watermark with generate New PDF file.

##Usage

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
  
  
  
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    //MultiCell loop text
    $txt = "FPDF is a PHP class which allows to generate PDF files with pure PHP, that is to say " .
            "without using the PDFlib library. F from FPDF stands for Free: you may use it for any " .
            "kind of usage and modify it to suit your needs.\n\n";
    for ($i = 0; $i < 25; $i++){
        $pdf->MultiCell(0, 5, $txt, 0, 'J');
    }
    $pdf->Output();
    
    
#Generate Watermark on Existing PDF file

##Usage

    require('fpdf/fpdf.php');
    require_once 'FPDI/fpdi.php';
    
    
    class PDF_Rotate extends FPDI {

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
    
    
    
    $fullPathToFile = "chinmay235.pdf";

    class PDF extends PDF_Rotate {

    var $_tplIdx;
    
    function Header() {
        global $fullPathToFile;
        
        //Put the watermark
        $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 40, 100, 100, 0, 'PNG');
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(20, 230, 'Raddyx Technologies Pvt. Ltd.', 45);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx, 0, 0, 200);
        
        
    }

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    }
    
    
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $pdf->Output();
