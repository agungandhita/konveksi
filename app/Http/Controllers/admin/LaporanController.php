<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pembayaran::with(['pesanan.user', 'pesanan.layanan']);
        
        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        // Filter berdasarkan status pembayaran
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }
        
        // Filter berdasarkan metode pembayaran
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }
        
        $pembayaran = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Statistik
        $totalPembayaran = $query->count();
        $totalNominal = $query->sum('total_harga');
        $pembayaranDiterima = $query->where('status_pembayaran', 'diterima')->count();
        $pembayaranDitolak = $query->where('status_pembayaran', 'ditolak')->count();
        
        return view('admin.laporan.index', compact(
            'pembayaran',
            'totalPembayaran',
            'totalNominal',
            'pembayaranDiterima',
            'pembayaranDitolak'
        ));
    }
    
    /**
     * Export laporan ke CSV
     */
    public function exportCsv(Request $request)
    {
        $query = Pembayaran::with(['pesanan.user', 'pesanan.layanan']);
        
        // Apply same filters as index
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }
        
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }
        
        $pembayaran = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'laporan_pembayaran_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($pembayaran) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header CSV
            fputcsv($file, [
                'ID',
                'Nama Pemesan',
                'Email User',
                'Layanan',
                'Jumlah Order',
                'Total Harga',
                'Harga Bordir',
                'Metode Pembayaran',
                'Nomor Rekening',
                'Nama Pemilik Rekening',
                'Status Pembayaran',
                'Tanggal Upload',
                'Tanggal Verifikasi',
                'Catatan Admin',
                'Tanggal Dibuat'
            ]);
            
            // Data CSV
            foreach ($pembayaran as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->pesanan->nama_pemesan ?? '-',
                    $item->pesanan->user->email ?? '-',
                    $item->pesanan->layanan->nama_layanan ?? '-',
                    $item->pesanan->jumlah_order ?? '-',
                    $item->total_harga,
                    $item->harga_bordir,
                    $item->metode_pembayaran,
                    $item->nomor_rekening ?? '-',
                    $item->nama_pemilik_rekening ?? '-',
                    $item->status_pembayaran,
                    $item->tanggal_upload ? $item->tanggal_upload->format('Y-m-d H:i:s') : '-',
                    $item->tanggal_verifikasi ? $item->tanggal_verifikasi->format('Y-m-d H:i:s') : '-',
                    $item->catatan_admin ?? '-',
                    $item->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Export laporan ke Excel (HTML format)
     */
    public function exportExcel(Request $request)
    {
        $query = Pembayaran::with(['pesanan.user', 'pesanan.layanan']);
        
        // Apply same filters as index
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }
        
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }
        
        $pembayaran = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'laporan_pembayaran_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $html = $this->generateExcelHtml($pembayaran);
        
        return Response::make($html, 200, $headers);
    }
    
    /**
     * Generate HTML for Excel export
     */
    private function generateExcelHtml($pembayaran)
    {
        // Calculate summary data
        $totalNominal = $pembayaran->sum('total_harga');
        $totalBordir = $pembayaran->sum('harga_bordir');
        $totalDiterima = $pembayaran->where('status_pembayaran', 'diterima')->count();
        $totalDitolak = $pembayaran->where('status_pembayaran', 'ditolak')->count();
        $totalMenunggu = $pembayaran->where('status_pembayaran', 'menunggu')->count();
        $totalDitinjau = $pembayaran->where('status_pembayaran', 'ditinjau')->count();
        
        $html = '<?xml version="1.0" encoding="UTF-8"?>';
        $html .= '<?mso-application progid="Excel.Sheet"?>';
        $html .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"';
        $html .= ' xmlns:o="urn:schemas-microsoft-com:office:office"';
        $html .= ' xmlns:x="urn:schemas-microsoft-com:office:excel"';
        $html .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"';
        $html .= ' xmlns:html="http://www.w3.org/TR/REC-html40">';
        
        // Document Properties
        $html .= '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">';
        $html .= '<Title>Laporan Pembayaran Konveksi</Title>';
        $html .= '<Author>Sistem Konveksi</Author>';
        $html .= '<Created>' . date('Y-m-d\TH:i:s\Z') . '</Created>';
        $html .= '</DocumentProperties>';
        
        // Excel Workbook Properties
        $html .= '<ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">';
        $html .= '<WindowHeight>12000</WindowHeight>';
        $html .= '<WindowWidth>18000</WindowWidth>';
        $html .= '<WindowTopX>0</WindowTopX>';
        $html .= '<WindowTopY>0</WindowTopY>';
        $html .= '<ProtectStructure>False</ProtectStructure>';
        $html .= '<ProtectWindows>False</ProtectWindows>';
        $html .= '</ExcelWorkbook>';
        
        // Styles
        $html .= '<Styles>';
        
        // Default style
        $html .= '<Style ss:ID="Default" ss:Name="Normal">';
        $html .= '<Alignment ss:Vertical="Center"/>';
        $html .= '<Borders/>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="11"/>';
        $html .= '<Interior/>';
        $html .= '<NumberFormat/>';
        $html .= '<Protection/>';
        $html .= '</Style>';
        
        // Header style
        $html .= '<Style ss:ID="HeaderStyle">';
        $html .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1"/>';
        $html .= '<Interior ss:Color="#4472C4" ss:Pattern="Solid"/>';
        $html .= '</Style>';
        
        // Title style
        $html .= '<Style ss:ID="TitleStyle">';
        $html .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="16" ss:Bold="1"/>';
        $html .= '</Style>';
        
        // Data styles
        $html .= '<Style ss:ID="DataStyle">';
        $html .= '<Alignment ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="10"/>';
        $html .= '</Style>';
        
        // Number style
        $html .= '<Style ss:ID="NumberStyle">';
        $html .= '<Alignment ss:Horizontal="Right" ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="10"/>';
        $html .= '<NumberFormat ss:Format="#,##0"/>';
        $html .= '</Style>';
        
        // Center style
        $html .= '<Style ss:ID="CenterStyle">';
        $html .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="10"/>';
        $html .= '</Style>';
        
        // Status styles
        $html .= '<Style ss:ID="StatusMenunggu">';
        $html .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="10" ss:Bold="1"/>';
        $html .= '<Interior ss:Color="#FFF2CC" ss:Pattern="Solid"/>';
        $html .= '</Style>';
        
        $html .= '<Style ss:ID="StatusDitinjau">';
        $html .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="10" ss:Bold="1"/>';
        $html .= '<Interior ss:Color="#FCE4D6" ss:Pattern="Solid"/>';
        $html .= '</Style>';
        
        $html .= '<Style ss:ID="StatusDiterima">';
        $html .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="10" ss:Bold="1"/>';
        $html .= '<Interior ss:Color="#E2EFDA" ss:Pattern="Solid"/>';
        $html .= '</Style>';
        
        $html .= '<Style ss:ID="StatusDitolak">';
        $html .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="10" ss:Bold="1"/>';
        $html .= '<Interior ss:Color="#FFCDD2" ss:Pattern="Solid"/>';
        $html .= '</Style>';
        
        // Summary style
        $html .= '<Style ss:ID="SummaryHeader">';
        $html .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="12" ss:Color="#FFFFFF" ss:Bold="1"/>';
        $html .= '<Interior ss:Color="#70AD47" ss:Pattern="Solid"/>';
        $html .= '</Style>';
        
        $html .= '<Style ss:ID="SummaryData">';
        $html .= '<Alignment ss:Horizontal="Right" ss:Vertical="Center"/>';
        $html .= '<Borders>';
        $html .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>';
        $html .= '</Borders>';
        $html .= '<Font ss:FontName="Calibri" ss:Size="11" ss:Bold="1"/>';
        $html .= '</Style>';
        
        $html .= '</Styles>';
        
        // Worksheet
        $html .= '<Worksheet ss:Name="Laporan Pembayaran">';
        
        // Column widths
        $html .= '<Table ss:ExpandedColumnCount="15" ss:ExpandedRowCount="' . ($pembayaran->count() + 20) . '" x:FullColumns="1" x:FullRows="1">';
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="50"/>';  // ID
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="150"/>'; // Nama Pemesan
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="200"/>'; // Email
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="150"/>'; // Layanan
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="80"/>';  // Jumlah Order
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="120"/>'; // Total Harga
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="120"/>'; // Harga Bordir
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="100"/>'; // Metode Pembayaran
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="150"/>'; // Nomor Rekening
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="150"/>'; // Nama Pemilik
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="120"/>'; // Status
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="150"/>'; // Tanggal Upload
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="150"/>'; // Tanggal Verifikasi
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="200"/>'; // Catatan
        $html .= '<Column ss:AutoFitWidth="0" ss:Width="150"/>'; // Tanggal Dibuat
        
        // Title
        $html .= '<Row ss:Height="30">';
        $html .= '<Cell ss:MergeAcross="14" ss:StyleID="TitleStyle">';
        $html .= '<Data ss:Type="String">LAPORAN PEMBAYARAN KONVEKSI</Data>';
        $html .= '</Cell>';
        $html .= '</Row>';
        
        // Export date
        $html .= '<Row ss:Height="20">';
        $html .= '<Cell ss:MergeAcross="14" ss:StyleID="CenterStyle">';
        $html .= '<Data ss:Type="String">Tanggal Export: ' . date('d/m/Y H:i:s') . '</Data>';
        $html .= '</Cell>';
        $html .= '</Row>';
        
        // Empty row
        $html .= '<Row ss:Height="15"/>';
        
        // Header row
        $html .= '<Row ss:Height="40">';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">ID</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Nama Pemesan</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Email User</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Layanan</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Jumlah Order</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Total Harga</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Harga Bordir</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Metode Pembayaran</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Nomor Rekening</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Nama Pemilik Rekening</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Status Pembayaran</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Tanggal Upload</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Tanggal Verifikasi</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Catatan Admin</Data></Cell>';
        $html .= '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Tanggal Dibuat</Data></Cell>';
        $html .= '</Row>';
        
        // Data rows
        foreach ($pembayaran as $item) {
            $statusStyle = 'Status' . ucfirst($item->status_pembayaran);
            
            $html .= '<Row ss:Height="25">';
            $html .= '<Cell ss:StyleID="CenterStyle"><Data ss:Type="Number">' . $item->id . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">' . htmlspecialchars($item->pesanan->nama_pemesan ?? '-') . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">' . htmlspecialchars($item->pesanan->user->email ?? '-') . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">' . htmlspecialchars($item->pesanan->layanan->nama_layanan ?? '-') . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="CenterStyle"><Data ss:Type="Number">' . ($item->pesanan->jumlah_order ?? 0) . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="NumberStyle"><Data ss:Type="Number">' . $item->total_harga . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="NumberStyle"><Data ss:Type="Number">' . $item->harga_bordir . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="CenterStyle"><Data ss:Type="String">' . htmlspecialchars($item->metode_pembayaran) . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">' . htmlspecialchars($item->nomor_rekening ?? '-') . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">' . htmlspecialchars($item->nama_pemilik_rekening ?? '-') . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="' . $statusStyle . '"><Data ss:Type="String">' . strtoupper($item->status_pembayaran) . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="CenterStyle"><Data ss:Type="String">' . ($item->tanggal_upload ? $item->tanggal_upload->format('d/m/Y H:i') : '-') . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="CenterStyle"><Data ss:Type="String">' . ($item->tanggal_verifikasi ? $item->tanggal_verifikasi->format('d/m/Y H:i') : '-') . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">' . htmlspecialchars($item->catatan_admin ?? '-') . '</Data></Cell>';
            $html .= '<Cell ss:StyleID="CenterStyle"><Data ss:Type="String">' . $item->created_at->format('d/m/Y H:i') . '</Data></Cell>';
            $html .= '</Row>';
        }
        
        // Empty rows before summary
        $html .= '<Row ss:Height="15"/>';
        $html .= '<Row ss:Height="15"/>';
        
        // Summary section
        $html .= '<Row ss:Height="30">';
        $html .= '<Cell ss:MergeAcross="1" ss:StyleID="SummaryHeader"><Data ss:Type="String">RINGKASAN LAPORAN</Data></Cell>';
        for ($i = 2; $i < 15; $i++) {
            $html .= '<Cell/>';
        }
        $html .= '</Row>';
        
        $html .= '<Row ss:Height="25">';
        $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">Total Data Pembayaran</Data></Cell>';
        $html .= '<Cell ss:StyleID="SummaryData"><Data ss:Type="Number">' . $pembayaran->count() . '</Data></Cell>';
        for ($i = 2; $i < 15; $i++) {
            $html .= '<Cell/>';
        }
        $html .= '</Row>';
        
        $html .= '<Row ss:Height="25">';
        $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">Total Nominal Pembayaran</Data></Cell>';
        $html .= '<Cell ss:StyleID="SummaryData"><Data ss:Type="Number">' . $totalNominal . '</Data></Cell>';
        for ($i = 2; $i < 15; $i++) {
            $html .= '<Cell/>';
        }
        $html .= '</Row>';
        
        $html .= '<Row ss:Height="25">';
        $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">Total Harga Bordir</Data></Cell>';
        $html .= '<Cell ss:StyleID="SummaryData"><Data ss:Type="Number">' . $totalBordir . '</Data></Cell>';
        for ($i = 2; $i < 15; $i++) {
            $html .= '<Cell/>';
        }
        $html .= '</Row>';
        
        $html .= '<Row ss:Height="25">';
        $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">Pembayaran Diterima</Data></Cell>';
        $html .= '<Cell ss:StyleID="SummaryData"><Data ss:Type="Number">' . $totalDiterima . '</Data></Cell>';
        for ($i = 2; $i < 15; $i++) {
            $html .= '<Cell/>';
        }
        $html .= '</Row>';
        
        $html .= '<Row ss:Height="25">';
        $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">Pembayaran Ditolak</Data></Cell>';
        $html .= '<Cell ss:StyleID="SummaryData"><Data ss:Type="Number">' . $totalDitolak . '</Data></Cell>';
        for ($i = 2; $i < 15; $i++) {
            $html .= '<Cell/>';
        }
        $html .= '</Row>';
        
        $html .= '<Row ss:Height="25">';
        $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">Pembayaran Menunggu</Data></Cell>';
        $html .= '<Cell ss:StyleID="SummaryData"><Data ss:Type="Number">' . $totalMenunggu . '</Data></Cell>';
        for ($i = 2; $i < 15; $i++) {
            $html .= '<Cell/>';
        }
        $html .= '</Row>';
        
        $html .= '<Row ss:Height="25">';
        $html .= '<Cell ss:StyleID="DataStyle"><Data ss:Type="String">Pembayaran Ditinjau</Data></Cell>';
        $html .= '<Cell ss:StyleID="SummaryData"><Data ss:Type="Number">' . $totalDitinjau . '</Data></Cell>';
        for ($i = 2; $i < 15; $i++) {
            $html .= '<Cell/>';
        }
        $html .= '</Row>';
        
        $html .= '</Table>';
        $html .= '</Worksheet>';
        $html .= '</Workbook>';
        
        return $html;
    }
}