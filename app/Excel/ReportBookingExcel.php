<?php

namespace App\Excel;

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Helpers\AppHelper;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReportBookingExcel extends ReportExcel
{
    private $spreadsheet;
    private $data;
    private $tahun;

    public function __construct($data, $tahun){
        $this->data = $data;
        $this->tahun = $tahun;
        $this->view();
    }

    public function view(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName("arial");
        $spreadsheet->getDefaultStyle()->getFont()->setSize(13);

        // PAGE START
        $sheet->mergeCells("A1:Z1");

        // Set Header
        $sheet->setCellValue("A2", "Report Rekap Booking Tahun $this->tahun");
        $sheet->mergeCells("A2:Z3");
        $sheet->getStyle("A2:Z3")->getAlignment()->setHorizontal("center")->setVertical("center");
        $sheet->getStyle("A2:Z3")->getFont()->setBold(true)->setSize(15);

        $sheet->mergeCells("A4:Z4");
        $sheet->mergeCells("A5:Z5");

        $row = 6;

        $sheet->setCellValue("B$row", "NO");
        $sheet->getStyle("B$row")->getAlignment()->setHorizontal("center");

        $sheet->setCellValue("C$row", "DATE");
        $sheet->mergeCells("C$row:E$row");
        $sheet->getStyle("C$row:E$row")->getAlignment()->setHorizontal("center");

        $sheet->setCellValue("F$row", "QUANTITY");
        $sheet->mergeCells("F$row:H$row");
        $sheet->getStyle("F$row:H$row")->getAlignment()->setHorizontal("center");

        $sheet->setCellValue("I$row", "INVOICE NUMBER");
        $sheet->mergeCells("I$row:K$row");
        $sheet->getStyle("I$row:K$row")->getAlignment()->setHorizontal("center");

        $sheet->setCellValue("L$row", "NAME");
        $sheet->mergeCells("L$row:N$row");
        $sheet->getStyle("L$row:N$row")->getAlignment()->setHorizontal("center");

        $sheet->setCellValue("O$row", "SEAT");
        $sheet->mergeCells("O$row:Q$row");
        $sheet->getStyle("O$row:Q$row")->getAlignment()->setHorizontal("center");

        $sheet->setCellValue("R$row", "START TIME");
        $sheet->mergeCells("R$row:T$row");
        $sheet->getStyle("R$row:T$row")->getAlignment()->setHorizontal("center");

        $sheet->setCellValue("U$row", "END TIME");
        $sheet->mergeCells("U$row:W$row");
        $sheet->getStyle("U$row:W$row")->getAlignment()->setHorizontal("center");

        $sheet->setCellValue("X$row", "TOTAL PRICE");
        $sheet->mergeCells("X$row:Z$row");
        $sheet->getStyle("X$row:Z$row")->getAlignment()->setHorizontal("center");

        $sheet->getStyle("B$row:Z$row")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row++;

        foreach($this->data as $index => $data){
            $sheet->setCellValue("B$row", $index);
            $sheet->mergeCells("B$row:B" . ($row + 1));
            $sheet->getStyle("B$row:B" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("B$row:B" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("C$row", $data->tanggal);
            $sheet->mergeCells("C$row:E" . ($row + 1));
            $sheet->getStyle("C$row:E" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("C$row:E" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("F$row", $data->quantity);
            $sheet->mergeCells("F$row:H" . ($row + 1));
            $sheet->getStyle("F$row:H" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("F$row:H" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("I$row", $data->invoice_number);
            $sheet->mergeCells("I$row:K" . ($row + 1));
            $sheet->getStyle("I$row:K" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("I$row:K" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("L$row", $data->user->name);
            $sheet->mergeCells("L$row:N" . ($row + 1));
            $sheet->getStyle("L$row:N" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("L$row:N" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("O$row", $data->seat);
            $sheet->mergeCells("O$row:Q" . ($row + 1));
            $sheet->getStyle("O$row:Q" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("O$row:Q" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("R$row", $data->show_time->start_time);
            $sheet->mergeCells("R$row:T" . ($row + 1));
            $sheet->getStyle("R$row:T" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("R$row:T" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("U$row", $data->show_time->end_time);
            $sheet->mergeCells("U$row:W" . ($row + 1));
            $sheet->getStyle("U$row:W" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("U$row:W" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->setCellValue("X$row", AppHelper::rupiah($data->total_price));
            $sheet->mergeCells("X$row:Z" . ($row + 1));
            $sheet->getStyle("X$row:Z" . ($row + 1))->getAlignment()->setHorizontal("center")->setVertical("center");
            $sheet->getStyle("X$row:Z" . ($row + 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $row+=2;
        }

        $this->spreadsheet = $spreadsheet;
    }

    public function download ($filename = ""){
        $writer = new Xlsx($this->spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        $writer->save("php://output");
    }

}
