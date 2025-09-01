<?php

use TCPDF as PDF;
require 'vendor/autoload.php';


class CetakLaporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('cetak_laporan');
    }

    public function cetakPeriode()
    {
        // Proses cetak data berdasarkan periode
        $tglAwal = $this->input->post('tgl_1');
        $tglAkhir = $this->input->post('tgl_2');

        // Lakukan logika pemrosesan data sesuai tanggal
        // Misalnya, ambil data dari model berdasarkan tanggal

        // Load library TCPDF
        require_once APPPATH . 'libraries/tcpdf/tcpdf.php';

        // Membuat objek TCPDF
        $pdf = new PDF();

        // Set informasi dokumen
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Laporan Kas Masjid');

        // Menambahkan halaman
        $pdf->AddPage();

        // Menambahkan konten ke dokumen
        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 10, 'Laporan Kas Masjid', 0, 1, 'C');

        // Tambahkan data sesuai logika pemrosesan data
        // ...

        // Simpan atau keluarkan PDF
        $file = 'path/to/save/your_pdf.pdf';
        $pdf->Output($file, 'D');
    }
}
