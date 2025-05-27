<?php
require_once("DBConnection.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends connection {
    public $con;
    public $listReport;
    public $listgetsatae;

    public function __construct() {
        $this->con = $this->connection();
    }

    // show Report by Gender
    public function ReportGender() {
        $sql = "SELECT gender AS gender, COUNT(id) AS count FROM users GROUP BY gender ORDER BY COUNT(id) DESC";
        $result = $this->con->query($sql);
        $this->listReport = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $this->listReport[$i] = $row;
            $i++;
        }
    }

    // show Report by provinces
    public function Reportprovinces() {
        $sql = "SELECT p.ProvinceName AS Province, COUNT(u.id) AS count FROM users u JOIN provinces p ON u.province_id = p.IDProvince GROUP BY p.ProvinceName ORDER BY COUNT(u.id) DESC";
        $result = $this->con->query($sql);
        $this->listReport = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $this->listReport[$i] = $row;
            $i++;
        }
    }

// show Report by City
    public function ReportCity() {
        $sql = "SELECT p.ProvinceName AS Province, c.CityName AS City, COUNT(u.id) AS count FROM users u JOIN cities c ON u.city_id = c.IDCity JOIN provinces p ON c.province_id = p.IDProvince GROUP BY p.ProvinceName, c.CityName ORDER BY p.ProvinceName, c.CityName";
        $result = $this->con->query($sql);
        $this->listReport = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $this->listReport[$i] = $row;
            $i++;
        }
    }

//export excel
    public function exportExel($data, $type) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if ($type == 'Gender') {
            $sheet->setCellValue('A1', 'جنسیت');
            $sheet->setCellValue('B1', 'تعداد');
        } elseif ($type == 'provinces') {
            $sheet->setCellValue('A1', 'استان');
            $sheet->setCellValue('B1', 'تعداد');
        } elseif ($type == 'city') {
            $sheet->setCellValue('A1', 'استان');
            $sheet->setCellValue('B1', 'شهرستان');
            $sheet->setCellValue('C1', 'تعداد');
        }

        $row = 2;
        foreach ($data as $record) {
            if ($type == 'Gender') {
                $sheet->setCellValue('A' . $row, $record['gender'] == 'male' ? 'مرد' : 'زن');
                $sheet->setCellValue('B' . $row, $record['count']);
            } elseif ($type == 'provinces') {
                $sheet->setCellValue('A' . $row, $record['Province']);
                $sheet->setCellValue('B' . $row, $record['count']);
            } elseif ($type == 'city') {
                $sheet->setCellValue('A' . $row, $record['Province']);
                $sheet->setCellValue('B' . $row, $record['City']);
                $sheet->setCellValue('C' . $row, $record['count']);
            }
            $row++;
        }

        // تنظیم هدرها و ارسال فایل اکسل
        $filename = "report_" . date("Y-m-d_H-i-s") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: Fri, 11 Nov 2011 11:11:11 GMT'); // گذشته‌نگر برای جلوگیری از کش شدن
        header('Cache-Control: max-age=1');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function getUsersOfState() {
        $sql = "SELECT provinces.ProvinceName AS provinces , COUNT(users.id) AS count 
                FROM users  
                INNER JOIN provinces  ON users.province_id = provinces.IDProvince 
                GROUP BY provinces.ProvinceName
                ORDER BY COUNT(users.id) DESC;";

        $result = $this->con->query($sql);
        $listgetsatae = [];
        while ($row = $result->fetch_assoc()) {
            $listgetsatae[] = $row;
        }
        return $listgetsatae;
    }
}
?>
