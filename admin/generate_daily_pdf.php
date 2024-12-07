<?php
require_once('tcpdf/tcpdf.php');
include './connect.php';

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetY(15);
        $this->SetFont('dejavusans', 'B', 15);
        $this->Cell(0, 15, 'BÁO CÁO DOANH THU NGÀY '.date('d/m/Y'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
    
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'I', 8);
        $this->Cell(0, 10, 'Trang '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator('Admin');
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Báo Cáo Doanh Thu Ngày '.date('d/m/Y'));

$pdf->SetMargins(15, 40, 15);
$pdf->AddPage();
$pdf->Ln(20);

$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(0, 10, 'CHI TIẾT DOANH THU THEO KHÁCH HÀNG', 0, 1, 'L');
$pdf->Ln(5);

// Header của bảng
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('dejavusans', 'B', 11);
$pdf->Cell(15, 10, 'STT', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Họ Tên', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Email', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Số Đơn', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Tổng Tiền', 1, 1, 'C', true);

// Dữ liệu bảng
$pdf->SetFont('dejavusans', '', 11);
$today = date('d/m/Y');
$stt = 1;
$tongDoanhThu = 0;

$query = "SELECT dh.*, tk.hoten, tk.taikhoan 
          FROM donhang dh 
          JOIN taikhoan tk ON dh.id_taikhoan = tk.id 
          WHERE dh.status = 3 
          AND dh.thoigian LIKE '%$today%'
          GROUP BY dh.id_taikhoan";

foreach (selectAll($query) as $row) {
    $idTaiKhoan = $row['id_taikhoan'];
    $soDon = rowCount("SELECT * FROM donhang WHERE status=3 
                       AND id_taikhoan = $idTaiKhoan 
                       AND thoigian LIKE '%$today%'");
    
    $tongTien = 0;
    foreach (selectAll("SELECT tongtien FROM donhang 
                       WHERE status=3 
                       AND id_taikhoan = $idTaiKhoan 
                       AND thoigian LIKE '%$today%'") as $item) {
        $tongTien += $item['tongtien'];
    }
    $tongDoanhThu += $tongTien;

    $pdf->Cell(15, 12, $stt++, 1, 0, 'C');
    $pdf->Cell(60, 12, $row['hoten'], 1, 0, 'L');
    $pdf->Cell(60, 12, $row['taikhoan'], 1, 0, 'L');
    $pdf->Cell(25, 12, $soDon, 1, 0, 'C');
    $pdf->Cell(30, 12, number_format($tongTien), 1, 1, 'R');
}

// Tổng doanh thu
$pdf->Ln(10);
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(0, 10, 'Tổng Doanh Thu Ngày: '.number_format($tongDoanhThu).' VNĐ', 0, 1, 'R');

$pdf->Output('bao_cao_doanh_thu_ngay_'.date('d_m_Y').'.pdf', 'I');
?> 