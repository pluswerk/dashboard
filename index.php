<?php

require "vendor/autoload.php";

use PLUSWERK\Dashboard\HtmlProcessor;
use PLUSWERK\Dashboard\DataProcessor;

$containerDataProcessor = new DataProcessor();
$data = $containerDataProcessor->process();

$htmlProcessor = new HtmlProcessor($data);
$tableBody = $htmlProcessor->generateTableBody();
$table = $htmlProcessor->generateTable($tableBody);

echo $table;
