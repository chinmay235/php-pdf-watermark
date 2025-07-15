# PHP PDF Watermark (Text & Image Watermark on PDFs)

**PDFWatermark** is a PHP utility that allows you to easily add **image or text watermarks** to **newly generated PDFs** or **existing PDF files**.  
It is built using the [FPDF](http://www.fpdf.org/en/download.php) library for PDF generation and [FPDI](http://www.setasign.com/products/fpdi/downloads/) for importing existing PDF documents.

---

## ✨ Features

- Add **image (JPG, PNG with alpha)** or **text** watermark
- Watermark **existing PDF files** or **generate new PDFs**
- Supports **rotated watermark text**
- Easy positioning and styling
- Compatible with 96 DPI image resolution

---

## 📦 Requirements

- PHP 5.6 or higher
- [FPDF Library](http://www.fpdf.org/)
- [FPDI Library](http://www.setasign.com/products/fpdi/)

---

## 📁 Installation

Download the required libraries:

- [Download FPDF](http://www.fpdf.org/en/download.php)
- [Download FPDI](http://www.setasign.com/products/fpdi/downloads/)

Include them in your project directory:

```
/fpdf/fpdf.php
/FPDI/fpdi.php
```


---

## 🔧 Add Watermark on a **New PDF**

### ✅ Example Usage

```php
require('fpdf/fpdf.php');

class PDF_Rotate extends FPDF {
    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q');
        $this->angle = $angle;

        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf(
                'q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',
                $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy
            ));
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
        $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 40, 100, 100, 0, 'PNG');
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(35, 190, 'CHINMAY KUMAR SAHU', 45);
    }

    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$txt = "FPDF is a PHP class which allows to generate PDF files with pure PHP...\n\n";

for ($i = 0; $i < 25; $i++) {
    $pdf->MultiCell(0, 5, $txt, 0, 'J');
}
$pdf->Output();
```

## 📝 Add Watermark to an Existing PDF

### ✅ Example Usage


```php
require('fpdf/fpdf.php');
require_once 'FPDI/fpdi.php';

class PDF_Rotate extends FPDI {
    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q');
        $this->angle = $angle;

        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf(
                'q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',
                $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy
            ));
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

        $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 40, 100, 100, 0, 'PNG');
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(20, 230, 'Raddyx Technologies Pvt. Ltd.', 45);

        if (is_null($this->_tplIdx)) {
            $this->numPages = $this->setSourceFile($fullPathToFile);
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx, 0, 0, 200);
    }

    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->Output();
```

## 📜 License
This project is open-source and free to use under the MIT License.


---

Let me know if you also want me to add usage screenshots, examples, or a downloadable ZIP for easy testing!



