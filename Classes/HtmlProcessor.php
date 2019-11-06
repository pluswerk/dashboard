<?php
declare(strict_types=1);

namespace PLUSWERK\Dashboard;


final class HtmlProcessor
{
    private $tableBodyData;

    public function __construct(array $tableBodyDataParam)
    {
        $this->tableBodyData = $tableBodyDataParam;
    }

    private function createOneRow(array $dataItem): string
    {
        return '<tr><td>'. $dataItem['name']. '</td><td><a href="https://'. $dataItem['domains'][0]. '">' . $dataItem['domains'][0] . '</a></td></tr>';
    }

    private function createMultipleRows(array $dataItem): string
    {
        $rows = '<tr><td>' . $dataItem['name'] . '</td><td>';
        foreach ($dataItem['domains'] as $domain) {
            $rows .= '<a href="https://'. $domain. '">' . $domain . '</a><br/>';
        }
        $rows .= '</td></tr>';
        return $rows;
    }

    public function generateTableBody(): string
    {
        $htmlTableRows = '';
        foreach ($this->tableBodyData as $tableRow) {
            if (count($tableRow['domains']) === 1) {
                $htmlTableRows .= $this->createOneRow($tableRow);
            } else {
                $htmlTableRows .= $this->createMultipleRows($tableRow);
            }
        }
        return $htmlTableRows;
    }

    public function generateTable(string $tableBody): string
    {
        return <<<HTML
            <html lang="en">
                <body>
                    <table>
                        <thead>
                            <tr><th>Container Name</th><th>Url(s)</th></tr>
                        </thead>
                        <tbody>
                            {$tableBody}
                        </tbody>
                    </table>
                </body>
            </html>
        HTML;
    }
}
