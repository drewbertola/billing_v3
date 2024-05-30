<?php

return [
    'filePrefix' => env('INVOICE_FILE_PREFIX', ''),
    'fileSuffix' => env('INVOICE_FILE_SUFFIX', ''),
    'headerTitle' => env('INVOICE_HEADER_TITLE', ''),
    'payToName' => env('INVOICE_PAYTO_NAME', ''),
    'payToAddress1' => env('INVOICE_PAYTO_ADDRESS1', ''),
    'payToAddress2' => env('INVOICE_PAYTO_ADDRESS2', ''),
    'payToPhone' => env('INVOICE_PAYTO_PHONE', ''),
    'payToEmail' => env('INVOICE_PAYTO_EMAIL', ''),
    'footerLine1' => env('INVOICE_FOOTER_LINE1', ''),
    'footerLine2' => env('INVOICE_FOOTER_LINE2', ''),
];
