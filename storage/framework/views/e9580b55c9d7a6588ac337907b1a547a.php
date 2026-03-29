<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #111;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header-img {
            width: 100%;
            max-height: 100px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        h1 {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 8px 0;
        }
        h2 {
            font-size: 13px;
            font-weight: bold;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
            margin-top: 15px;
            margin-bottom: 8px;
        }
        h3 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .fecha-emision {
            text-align: right;
            font-size: 10px;
            margin-bottom: 10px;
        }
        .data-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table td {
            padding: 3px 5px;
            vertical-align: top;
        }
        table.data-table td.label {
            font-weight: bold;
            width: 35%;
        }
        table.bordered {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.bordered th,
        table.bordered td {
            border: 1px solid #d1d5db;
            padding: 5px 8px;
            text-align: left;
            font-size: 10px;
        }
        table.bordered th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .footer-signatures {
            margin-top: 60px;
            width: 100%;
        }
        .footer-signatures td {
            width: 50%;
            text-align: center;
            padding: 0 30px;
            vertical-align: top;
        }
        .signature-line {
            border-top: 1px solid #9ca3af;
            padding-top: 5px;
            font-size: 9px;
        }
        .page-break {
            page-break-before: always;
        }
        .mb-5 { margin-bottom: 5px; }
        .mb-10 { margin-bottom: 10px; }
        .mb-15 { margin-bottom: 15px; }
        .mt-10 { margin-top: 10px; }
        .mt-15 { margin-top: 15px; }
        .text-xs { font-size: 9px; }
        .text-sm { font-size: 10px; }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH /home/ubuntu/Documents/FondoSolidarioEntrega/FondoSolidarioEntrega/resources/views/pdf/layout.blade.php ENDPATH**/ ?>