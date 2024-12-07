<?php
require_once('tcpdf/tcpdf.php');
include './connect.php';

// Tạo class PDF mới kế thừa từ TCPDF
class MYPDF extends TCPDF {
    public function Header() {
        $this->SetY(15);
        $this->SetFont('dejavusans', 'B', 15);
        $this->Cell(0, 15, 'BÁO CÁO DOANH THU', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
    
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'I', 8);
        $this->Cell(0, 10, 'Trang '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Khởi tạo PDF
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Thiết lập thông tin tài liệu
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Báo Cáo Doanh Thu');

// Thêm margin top cho trang
$pdf->SetMargins(15, 40, 15); // Left, Top, Right margins

// Thêm trang
$pdf->AddPage();

// Thêm khoảng trống đầu trang
$pdf->Ln(20); // Thêm 20mm khoảng trống

// Thiết lập font
$pdf->SetFont('dejavusans', '', 12);

// Lấy dữ liệu thống kê
$tongtienhientai = 0;
$donthanhcong = rowCount("SELECT * FROM donhang WHERE status=3");
$donhuy = rowCount("SELECT * FROM donhang WHERE status=4");

foreach (selectAll("SELECT * FROM donhang WHERE status=3") as $item) {
    $tongtienhientai += $item['tongtien'];
}

// Thêm thông tin tổng quan với khoảng cách
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(0, 10, 'THÔNG TIN TỔNG QUAN', 0, 1, 'L');
$pdf->Ln(5); // Thêm khoảng trống 5mm

$pdf->SetFont('dejavusans', '', 12);
$pdf->Cell(0, 10, 'Tổng doanh thu: ' . number_format($tongtienhientai) . ' VNĐ', 0, 1, 'L');
$pdf->Cell(0, 10, 'Số đơn thành công: ' . $donthanhcong . ' đơn', 0, 1, 'L');
$pdf->Cell(0, 10, 'Số đơn hủy: ' . $donhuy . ' đơn', 0, 1, 'L');

// Thêm bảng chi tiết với khoảng cách lớn hơn
$pdf->Ln(15); // Tăng khoảng cách lên 15mm
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(0, 10, 'CHI TIẾT ĐƠN HÀNG THÀNH CÔNG', 0, 1, 'L');
$pdf->Ln(5); // Thêm khoảng trống 5mm

// Header của bảng
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('dejavusans', 'B', 11);
$pdf->Cell(15, 10, 'STT', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Họ Tên', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Tài Khoản', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Số Đơn', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Tổng Tiền', 1, 1, 'C', true);

// Dữ liệu bảng với khoảng cách dòng lớn hơn
$pdf->SetFont('dejavusans', '', 11);
$stt = 1;
foreach (selectAll("SELECT * FROM donhang WHERE status=3 ORDER BY tongtien DESC") as $row) {
    $idtaikhoan1 = $row["id_taikhoan"];
    foreach (selectAll("SELECT * FROM taikhoan WHERE id = '$idtaikhoan1'") as $rows) {
        $numrow = rowCount("SELECT * FROM donhang WHERE status=3 && id_taikhoan = $idtaikhoan1");
        
        // Tăng chiều cao của cell lên 12mm
        $pdf->Cell(15, 12, $stt++, 1, 0, 'C');
        $pdf->Cell(60, 12, $rows['hoten'], 1, 0, 'L');
        $pdf->Cell(60, 12, $rows['taikhoan'], 1, 0, 'L');
        $pdf->Cell(25, 12, $numrow, 1, 0, 'C');
        $pdf->Cell(30, 12, number_format($row['tongtien']), 1, 1, 'R');
    }
}

// Xuất file PDF
$pdf->Output('bao_cao_doanh_thu.pdf', 'I');