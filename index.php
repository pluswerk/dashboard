<?php

require "vendor/autoload.php";

use Pluswerk\Dashboard\HtmlProcessor;
use Pluswerk\Dashboard\DataProcessor;

$containerDataProcessor = new DataProcessor();
$data = $containerDataProcessor->process();

$htmlProcessor = new HtmlProcessor($data);
$tableBody = $htmlProcessor->generateTableBody();
$table = $htmlProcessor->generateTable($tableBody);

echo $table;
