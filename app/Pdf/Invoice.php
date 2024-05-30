<?php

namespace App\Pdf;

use LaminasPdf\Color\Html;
use LaminasPdf\Color\GrayScale;
use LaminasPdf\Font;
use LaminasPdf\Page;
use LaminasPdf\PdfDocument;

class Invoice
{
    public static function render($invoice, $lineItems, $customer)
    {
        if (empty($invoice)) {
            return 'no such invoice';
        }

        $pdf = new PdfDocument();

        $pdf->pages[] = $pdf->newPage(Page::SIZE_LETTER);

        // prepare content.
        $formattedId = sprintf("%06d", $invoice->id);
        $date = date("F d, Y", strtotime($invoice->date));
        $notes = explode("\n", $invoice->note);

        // prepare page.
        $lineHeight = 14;
        $y = 738;

        $c = array(); //colors
        $c["fill"]  = new GrayScale(0.8);
        $c["dark"]  = new GrayScale(0.0);
        $c["lite"]  = new GrayScale(0.5);
        $c["white"] = new GrayScale(1.0);
        $c["odd"]   = new Html("#ffffff");
        $c["even"]  = new Html("#f0f0f0");
        $c["blue"]  = new Html("#ddeeff");

        $nFont = Font::fontWithName(Font::FONT_HELVETICA);
        $bFont = Font::fontWithName(Font::FONT_HELVETICA_BOLD);
        $fontSize = 8;

        $page = $pdf->pages[0];
        $page->setLineWidth(0.5);

        // draw page.

        // header box
        $width = 468;
        $height = 36;
        $radius = 8;
        $x1 = 72;
        $y1 = 756;
        $x2 = $x1 + $width;
        $y2 = $y1 - $height;

        $page->setFillColor($c["blue"]);
        $page->setLineColor($c["lite"]);
        $page->drawRectangle($x1, $y1, $x2, $y2);

        $page->setFillColor($c["white"]);
        $page->drawRectangle($x1 - 1, $y1 + 1, $x1 + $radius, $y1 - $radius, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x1 - 1, $y2 + $radius, $x1 + $radius, $y2 - 1, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x2 - $radius, $y1 + 1, $x2 + 1, $y1 - $radius, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x2 - $radius, $y2 + $radius, $x2 + 1, $y2 - 1, Page::SHAPE_DRAW_FILL);

        $page->setFillColor($c["blue"]);
        $page->drawCircle($x1 + $radius, $y1 - $radius, $radius, M_PI*1/2, M_PI);
        $page->drawCircle($x1 + $radius, $y2 + $radius, $radius, M_PI, M_PI*3/2);
        $page->drawCircle($x2 - $radius, $y1 - $radius, $radius, 0, M_PI*1/2);
        $page->drawCircle($x2 - $radius, $y2 + $radius, $radius, M_PI*3/2, 0);

        $page->setFillColor($c["dark"]);
        $page->setLineColor($c["dark"]);

        $page->setFont($nFont, 20);
        $page->drawText(config('invoice.headerTitle'), 90, $y - 7, "UTF-8");

        $page->setFont($nFont, $fontSize + 1);
        $page->drawText("Invoice #:", 394, $y + 2, "UTF-8");
        $page->drawText($formattedId, 448, $y + 2, "UTF-8");

        $page->drawText("Date:", 394, $y - 12, "UTF-8");
        $page->drawText($date, 448, $y - 12, "UTF-8");

        // payable to box
        $width = 216;
        $height = 116;
        $radius = 8;
        $x1 = 324;
        $y1 = 702;
        $x2 = $x1 + $width;
        $y2 = $y1 - $height;
        $page->setFillColor($c["blue"]);
        $page->setLineColor($c["lite"]);
        $page->drawRectangle($x1, $y1, $x2, $y2);
        $page->setFillColor($c["white"]);
        $page->drawRectangle($x1 - 1, $y1 + 1, $x1 + $radius, $y1 - $radius, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x2 - $radius, $y1 + 1, $x2 + 1, $y1 - $radius, Page::SHAPE_DRAW_FILL);
        $page->setFillColor($c["blue"]);
        $page->drawCircle($x1 + $radius, $y1 - $radius, $radius, M_PI*1/2, M_PI);
        $page->drawCircle($x2 - $radius, $y1 - $radius, $radius, 0, M_PI*1/2);

        $y1 -= $lineHeight + 4;
        $page->setFillColor($c["white"]);
        $page->drawRectangle($x1, $y1, $x2, $y2);
        $page->drawRectangle($x1 - 1, $y2 + $radius, $x1 + $radius, $y2 - 1, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x2 - $radius, $y2 + $radius, $x2 + 1, $y2 - 1, Page::SHAPE_DRAW_FILL);
        $page->drawCircle($x1 + $radius, $y2 + $radius, $radius, M_PI, M_PI*3/2);
        $page->drawCircle($x2 - $radius, $y2 + $radius, 8, M_PI*3/2, 0);

        // payable to content
        $y = 688;
        $page->setFillColor($c["dark"]);
        $page->setFont($nFont, $fontSize + 1);
        $page->drawText("Payable To:", 351, $y, "UTF-8");

        $y -= $lineHeight + 4;
        $page->setFont($bFont, $fontSize + 1);
        $page->drawText(config('invoice.payToName'), 351, $y, "UTF-8");
        $page->setFont($nFont, $fontSize + 1);

        $y -= $lineHeight;
        $page->drawText(config('invoice.payToAddress1'), 351, $y, "UTF-8");
        $y -= $lineHeight;
        $page->drawText(config('invoice.payToAddress2'), 351, $y, "UTF-8");
        $y -= 2 * $lineHeight;
        $page->drawText("tel:", 351, $y, "UTF-8");
        $page->drawText(config('invoice.payToPhone'), 387, $y, "UTF-8");
        $y -= $lineHeight;
        $page->drawText("email:", 351, $y, "UTF-8");
        $page->drawText(config('invoice.payToEmail'), 387, $y, "UTF-8");

        // billed to box
        $width = 216;
        $height = 116;
        $radius = 8;
        $x1 = 72;
        $y1 = 702;
        $x2 = $x1 + $width;
        $y2 = $y1 - $height;
        $page->setFillColor($c["blue"]);
        $page->setLineColor($c["lite"]);
        $page->drawRectangle($x1, $y1, $x2, $y2);
        $page->setFillColor($c["white"]);
        $page->drawRectangle($x1 - 1, $y1 + 1, $x1 + $radius, $y1 - $radius, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x2 - $radius, $y1 + 1, $x2 + 1, $y1 - $radius, Page::SHAPE_DRAW_FILL);
        $page->setFillColor($c["blue"]);
        $page->drawCircle($x1 + $radius, $y1 - $radius, $radius, M_PI*1/2, M_PI);
        $page->drawCircle($x2 - $radius, $y1 - $radius, $radius, 0, M_PI*1/2);

        $y1 -= $lineHeight + 4;
        $page->setFillColor($c["white"]);
        $page->drawRectangle($x1, $y1, $x2, $y2);
        $page->drawRectangle($x1 - 1, $y2 + $radius, $x1 + $radius, $y2 - 1, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x2 - $radius, $y2 + $radius, $x2 + 1, $y2 - 1, Page::SHAPE_DRAW_FILL);
        $page->drawCircle($x1 + $radius, $y2 + $radius, $radius, M_PI, M_PI*3/2);
        $page->drawCircle($x2 - $radius, $y2 + $radius, 8, M_PI*3/2, 0);

        // billed to content
        $y = 688;
        $page->setFillColor($c["dark"]);
        $page->setFont($nFont, $fontSize + 1);
        $page->drawText("Billed To:", 99, $y, "UTF-8");

        $y -= $lineHeight + 4;
        $page->setFont($bFont, $fontSize + 1);
        $page->drawText($customer->name, 99, $y, "UTF-8");
        $page->setFont($nFont, $fontSize + 1);

        $y -= $lineHeight;
        $page->drawText($customer->bAddress1, 99, $y, "UTF-8");

        if ( ! empty($customer->bAddress2) )
        {
            $y -= $lineHeight;
            $page->drawText($customer->bAddress2, 99, $y, "UTF-8");
        }

        $y -= $lineHeight;
        $page->drawText("{$customer->bCity}, {$customer->bState} {$customer->bZip}", 99, $y, "UTF-8");

        $y -= 2 * $lineHeight;
        $page->drawText("attn:", 99, $y, "UTF-8");
        $page->setFont($bFont, $fontSize);
        $page->drawText($customer->billingContact, 135, $y, "UTF-8");
        $page->setFont($nFont, $fontSize);

        $y -= 0.75 * $lineHeight;
        $page->drawText("terms:", 99, $y, "UTF-8");
        //$page->drawText("NET 15", 135, $y);
        $page->drawText("Due on Receipt", 135, $y, "UTF-8");
        $y -= 4.25 * $lineHeight;

        // line items table.
        $padding = 9;
        $lineHeight = 16;
        $lineYOffset = 4;

        $xF1 =         72;  // start line #
        $xF2 = $xF1 +  18;  // start Description
        $xF3 = $xF2 + 234;  // start Quantity
        $xF4 = $xF3 +  45;  // start Price
        $xF5 = $xF4 +  54;  // start Units
        $xF6 = $xF5 +  54;  // start Ext
        $xF7 = $xF6 +  63;  // end

        $yStart = $y + 10;

        $page->setFillColor($c["blue"]);
        $page->drawRectangle($xF1, $yStart, $xF7, $y - $lineYOffset);
        $page->setFillColor($c["dark"]);

        $page->setFont($bFont, $fontSize);
        $x = $xF2 - (0.5 * (($xF2 - $xF1) + self::getWidthOf("#", "hb", $fontSize)));
        $page->drawText("#", $x, $y, "UTF-8");
        $x = $xF3 - (0.5 * (($xF3 - $xF2) + self::getWidthOf("Description", "hb", $fontSize)));
        $page->drawText("Description", $x, $y, "UTF-8");
        $x = $xF4 - (0.5 * (($xF4 - $xF3) + self::getWidthOf("Quantity", "hb", $fontSize)));
        $page->drawText("Quantity", $x, $y, "UTF-8");
        $x = $xF5 - (0.5 * (($xF5 - $xF4) + self::getWidthOf("Price", "hb", $fontSize)));
        $page->drawText("Price", $x, $y, "UTF-8");
        $x = $xF6 - (0.5 * (($xF6 - $xF5) + self::getWidthOf("Units", "hb", $fontSize)));
        $page->drawText("Units", $x, $y, "UTF-8");
        $x = $xF7 - (0.5 * (($xF7 - $xF6) + self::getWidthOf("Ext", "hb", $fontSize)));
        $page->drawText("Ext", $x, $y, "UTF-8");

        $page->setFont($nFont, $fontSize);

        $lineCnt = 1;

        foreach ( $lineItems as $line )
        {
            $price = sprintf("%0.2f", $line['price']);
            $qty   = sprintf("%0.2f", $line['quantity']);
            $ext   = sprintf("%0.2f", $price * $qty);

            $bkgColor = ( $lineCnt % 2 ) ? $c["odd"] : $c["even"];
            $page->setFillColor($bkgColor);
            $page->drawRectangle(72, $y - 4, 540, ($y - $lineHeight) - 4, Page::SHAPE_DRAW_FILL);
            $page->setFillColor($c["dark"]);

            $y -= $lineHeight;

            $x = ($xF2 - 4) - self::getWidthOf($lineCnt, "h", $fontSize);
            $page->drawText($lineCnt++, $x, $y, "UTF-8");

            $page->drawText($line['description'], $xF2 + $padding, $y, "UTF-8");

            $x = ($xF4 - $padding) - self::getWidthOf($qty, "h", $fontSize);
            $page->drawText($qty, $x, $y, "UTF-8");

            $x = ($xF5 - $padding) - self::getWidthOf("$" . $price, "h", $fontSize);
            $page->drawText("$" . $price, $x, $y, "UTF-8");

            $page->drawText($line['units'], $xF5 + $padding, $y, "UTF-8");

            $x = ($xF7 - $padding) - self::getWidthOf("$" . $ext, "h", $fontSize);
            $page->drawText("$" . $ext, $x, $y, "UTF-8");

            $page->drawLine($xF1, $y - $lineYOffset, $xF7, $y - $lineYOffset);
        }

        $page->setFont($bFont, $fontSize);

        $page->drawLine($xF2, $yStart, $xF2, $y - $lineYOffset);
        $page->drawLine($xF3, $yStart, $xF3, $y - $lineYOffset);
        $page->drawLine($xF4, $yStart, $xF4, $y - $lineYOffset);
        $page->drawLine($xF5, $yStart, $xF5, $y - $lineYOffset);
        $page->drawLine($xF6, $yStart, $xF6, $y - $lineYOffset);

        $page->drawLine($xF1, $yStart, $xF1, $y - $lineYOffset);
        $page->drawLine($xF7, $yStart, $xF7, $y - $lineYOffset);
        $page->drawLine($xF1, $y - $lineYOffset, $xF7, $y - $lineYOffset);

        $y -= $lineHeight;

        $page->setFillColor($c["fill"]);
        $page->drawRectangle($xF6, $y + 12, $xF7, $y - $lineYOffset);
        $page->setFillColor($c["dark"]);

        $total = sprintf("$%0.2f", $invoice->amount);

        $page->drawText("Total:", $xF5 + $padding, $y, "UTF-8");
        $x = ($xF7 - $padding) - self::getWidthOf($total, "h", $fontSize);
        $page->drawText($total, $x, $y, "UTF-8");

        $y -= 2 * $lineHeight;
        $page->setFont($bFont, $fontSize + 1);
        $page->drawText("Notes:", 72, $y, "UTF-8");
        $page->setFont($nFont, $fontSize);

        foreach ( $notes as $note )
        {
            $y -= $lineHeight;
            $page->drawText($note, 72, $y, "UTF-8");
        }

        $y -= $lineHeight;

        $width = 468;
        $height = 36;
        $radius = 8;
        $x1 = 72;
        $y1 = 72;
        $x2 = $x1 + $width;
        $y2 = $y1 - $height;

        $page->setFillColor($c["fill"]);
        $page->setLineColor($c["lite"]);
        $page->drawRectangle($x1, $y1, $x2, $y2);

        $page->setFillColor($c["white"]);
        $page->drawRectangle($x1 - 1, $y1 + 1, $x1 + $radius, $y1 - $radius, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x1 - 1, $y2 + $radius, $x1 + $radius, $y2 - 1, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x2 - $radius, $y1 + 1, $x2 + 1, $y1 - $radius, Page::SHAPE_DRAW_FILL);
        $page->drawRectangle($x2 - $radius, $y2 + $radius, $x2 + 1, $y2 - 1, Page::SHAPE_DRAW_FILL);

        $page->setFillColor($c["fill"]);
        $page->drawCircle($x1 + $radius, $y1 - $radius, $radius, M_PI*1/2, M_PI);
        $page->drawCircle($x1 + $radius, $y2 + $radius, $radius, M_PI, M_PI*3/2);
        $page->drawCircle($x2 - $radius, $y1 - $radius, $radius, 0, M_PI*1/2);
        $page->drawCircle($x2 - $radius, $y2 + $radius, $radius, M_PI*3/2, 0);

        $page->setFillColor($c["dark"]);
        $page->setLineColor($c["dark"]);

        $y = 58;

        $text = config('invoice.footerLine1');
        $page->setFont($nFont, $fontSize);
        $page->drawText($text, 306 - (0.5 * self::getWidthOf($text, "h", $fontSize)), $y, "UTF-8");

        $y -= $lineHeight;
        $text = config('invoice.footerLine2');
        $page->setFont($bFont, $fontSize);
        $page->drawText($text, 306 - (0.5 * self::getWidthOf($text, "hb", $fontSize)), $y, "UTF-8");

        if ( ! empty($saveFile) )
        {
            return $pdf->save($saveFile);
        }

        $result = new \stdClass();
        $result->pdf  = $pdf->render();
        $result->file = config('invoice.filePrefix') . $invoice->id . config('invoice.fileSuffix');

        return $result;
    }

    /**
     * this function returns the typographic width of a string.
     */
    private static function getWidthOf($str, $fontKey = "h", $ptSize = 20)
    {
        // get the width of a numeric - used for right justification.
        $wx = 0;

        for ($i = 0; $i < strlen($str); $i ++) {
            $ch = ord(substr($str, $i, 1));
            $wx += self::$charWx[$fontKey][$ch];
        }

        $width = ($wx / 1000) * $ptSize;

        return ($width);
    }

    private static $charWx = array(
        "h" => array(
            "32" => "278",
            "33" => "278",
            "34" => "355",
            "35" => "556",
            "36" => "556",
            "37" => "889",
            "38" => "667",
            "39" => "222",
            "40" => "333",
            "41" => "333",
            "42" => "389",
            "43" => "584",
            "44" => "278",
            "45" => "333",
            "46" => "278",
            "47" => "278",
            "48" => "556",
            "49" => "556",
            "50" => "556",
            "51" => "556",
            "52" => "556",
            "53" => "556",
            "54" => "556",
            "55" => "556",
            "56" => "556",
            "57" => "556",
            "58" => "278",
            "59" => "278",
            "60" => "584",
            "61" => "584",
            "62" => "584",
            "63" => "556",
            "64" => "1015",
            "65" => "667",
            "66" => "667",
            "67" => "722",
            "68" => "722",
            "69" => "667",
            "70" => "611",
            "71" => "778",
            "72" => "722",
            "73" => "278",
            "74" => "500",
            "75" => "667",
            "76" => "556",
            "77" => "833",
            "78" => "722",
            "79" => "778",
            "80" => "667",
            "81" => "778",
            "82" => "722",
            "83" => "667",
            "84" => "611",
            "85" => "722",
            "86" => "667",
            "87" => "944",
            "88" => "667",
            "89" => "667",
            "90" => "611",
            "91" => "278",
            "92" => "278",
            "93" => "278",
            "94" => "469",
            "95" => "556",
            "96" => "222",
            "97" => "556",
            "98" => "556",
            "99" => "500",
            "100" => "556",
            "101" => "556",
            "102" => "278",
            "103" => "556",
            "104" => "556",
            "105" => "222",
            "106" => "222",
            "107" => "500",
            "108" => "222",
            "109" => "833",
            "110" => "556",
            "111" => "556",
            "112" => "556",
            "113" => "556",
            "114" => "333",
            "115" => "500",
            "116" => "278",
            "117" => "556",
            "118" => "500",
            "119" => "722",
            "120" => "500",
            "121" => "500",
            "122" => "500",
            "123" => "334",
            "124" => "260",
            "125" => "334",
            "126" => "584",
            "161" => "333",
            "162" => "556",
            "163" => "556",
            "164" => "167",
            "165" => "556",
            "166" => "556",
            "167" => "556",
            "168" => "556",
            "169" => "191",
            "170" => "333",
            "171" => "556",
            "172" => "333",
            "173" => "333",
            "174" => "500",
            "175" => "500",
            "177" => "556",
            "178" => "556",
            "179" => "556",
            "180" => "278",
            "182" => "537",
            "183" => "350",
            "184" => "222",
            "185" => "333",
            "186" => "333",
            "187" => "556",
            "188" => "1000",
            "189" => "1000",
            "191" => "611",
            "193" => "333",
            "194" => "333",
            "195" => "333",
            "196" => "333",
            "197" => "333",
            "198" => "333",
            "199" => "333",
            "200" => "333",
            "202" => "333",
            "203" => "333",
            "205" => "333",
            "206" => "333",
            "207" => "333",
            "208" => "1000",
            "225" => "1000",
            "227" => "370",
            "232" => "556",
            "233" => "778",
            "234" => "1000",
            "235" => "365",
            "241" => "889",
            "245" => "278",
            "248" => "222",
            "249" => "611",
            "250" => "944",
            "251" => "611"
        ),
        "hb" => array(
            "32" => "278",
            "33" => "333",
            "34" => "474",
            "35" => "556",
            "36" => "556",
            "37" => "889",
            "38" => "722",
            "39" => "278",
            "40" => "333",
            "41" => "333",
            "42" => "389",
            "43" => "584",
            "44" => "278",
            "45" => "333",
            "46" => "278",
            "47" => "278",
            "48" => "556",
            "49" => "556",
            "50" => "556",
            "51" => "556",
            "52" => "556",
            "53" => "556",
            "54" => "556",
            "55" => "556",
            "56" => "556",
            "57" => "556",
            "58" => "333",
            "59" => "333",
            "60" => "584",
            "61" => "584",
            "62" => "584",
            "63" => "611",
            "64" => "975",
            "65" => "722",
            "66" => "722",
            "67" => "722",
            "68" => "722",
            "69" => "667",
            "70" => "611",
            "71" => "778",
            "72" => "722",
            "73" => "278",
            "74" => "556",
            "75" => "722",
            "76" => "611",
            "77" => "833",
            "78" => "722",
            "79" => "778",
            "80" => "667",
            "81" => "778",
            "82" => "722",
            "83" => "667",
            "84" => "611",
            "85" => "722",
            "86" => "667",
            "87" => "944",
            "88" => "667",
            "89" => "667",
            "90" => "611",
            "91" => "333",
            "92" => "278",
            "93" => "333",
            "94" => "584",
            "95" => "556",
            "96" => "278",
            "97" => "556",
            "98" => "611",
            "99" => "556",
            "100" => "611",
            "101" => "556",
            "102" => "333",
            "103" => "611",
            "104" => "611",
            "105" => "278",
            "106" => "278",
            "107" => "556",
            "108" => "278",
            "109" => "889",
            "110" => "611",
            "111" => "611",
            "112" => "611",
            "113" => "611",
            "114" => "389",
            "115" => "556",
            "116" => "333",
            "117" => "611",
            "118" => "556",
            "119" => "778",
            "120" => "556",
            "121" => "556",
            "122" => "500",
            "123" => "389",
            "124" => "280",
            "125" => "389",
            "126" => "584",
            "161" => "333",
            "162" => "556",
            "163" => "556",
            "164" => "167",
            "165" => "556",
            "166" => "556",
            "167" => "556",
            "168" => "556",
            "169" => "238",
            "170" => "500",
            "171" => "556",
            "172" => "333",
            "173" => "333",
            "174" => "611",
            "175" => "611",
            "177" => "556",
            "178" => "556",
            "179" => "556",
            "180" => "278",
            "182" => "556",
            "183" => "350",
            "184" => "278",
            "185" => "500",
            "186" => "500",
            "187" => "556",
            "188" => "1000",
            "189" => "1000",
            "191" => "611",
            "193" => "333",
            "194" => "333",
            "195" => "333",
            "196" => "333",
            "197" => "333",
            "198" => "333",
            "199" => "333",
            "200" => "333",
            "202" => "333",
            "203" => "333",
            "205" => "333",
            "206" => "333",
            "207" => "333",
            "208" => "1000",
            "225" => "1000",
            "227" => "370",
            "232" => "611",
            "233" => "778",
            "234" => "1000",
            "235" => "365",
            "241" => "889",
            "245" => "278",
            "248" => "278",
            "249" => "611",
            "250" => "944",
            "251" => "611"
        )
    );
}
