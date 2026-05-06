<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;
use App\Imports\UmkmImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UmkmExport;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class UmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::all();
        return view('admin.data-umkm', compact('umkms'));

    $umkms = Umkm::all();

    $dataChart = Umkm::select('desa', DB::raw('count(*) as total'))
        ->groupBy('desa')
        ->pluck('total', 'desa');

    return view('admin.data-umkm', [
        'umkms' => $umkms,
        'chartLabels' => $dataChart->keys(),
        'chartData' => $dataChart->values(),
    ]);
}

    public function create()
    {
        return view('admin.create-umkm');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_usaha' => 'required',
        'pemilik' => 'required',
        'bidang_usaha' => 'required',
        'desa' => 'required',
        'status_potensi' => 'required',
        'alamat' => 'nullable',
        'latitude' => 'nullable',
        'longitude' => 'nullable',
    ]);

    Umkm::create([
        'nama_usaha' => $request->nama_usaha,
        'pemilik' => $request->pemilik,
        'bidang_usaha' => $request->bidang_usaha,
        'desa' => $request->desa,
        'alamat' => $request->alamat,
        'status_potensi' => strtolower($request->status_potensi),
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    return redirect()->route('admin.data.umkm')->with('success', 'Data berhasil ditambahkan');
}

    public function edit($id)
    {
        $umkm = Umkm::findOrFail($id);
        return view('admin.edit-umkm', compact('umkm'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_usaha' => 'required',
            'pemilik' => 'required',
            'bidang_usaha' => 'required',
            'desa' => 'required',
            'status_potensi' => 'required',
        ]);

        $umkm = Umkm::findOrFail($id);

        $umkm->update([
            'nama_usaha' => $request->nama_usaha,
            'pemilik' => $request->pemilik,
            'bidang_usaha' => $request->bidang_usaha,
            'desa' => $request->desa,
            'status_potensi' => $request->status_potensi,
        ]);

        return redirect()->route('admin.data.umkm')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->delete();

        return redirect()->route('admin.data.umkm')->with('success', 'Data berhasil dihapus');
    }

    public function map()
{
    $umkms = Umkm::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();

    return view('map', compact('umkms'));
}

public function adminMap()
{
    if (!session('user_id')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
    }

    $umkms = Umkm::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();

    return view('admin.peta-umkm', compact('umkms'));
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(new UmkmImport, $request->file('file'));

    return redirect()->route('admin.data.umkm')->with('success', 'Data UMKM berhasil diimport');
}

public function dashboardPotensi()
{
    $wilayahOrder = [
        'Kembangarum',
        'Sutojayan',
        'Kalipang',
        'Bacem',
        'Kedungbunder',
        'Jingglong',
        'Sukorejo',
        'Sumberjo',
        'Jegu',
        'Pandanarum',
        'Kaulon',
    ];

    // ===== CHART BAR (PER DESA) =====
    $wilayahCounts = Umkm::whereNotNull('desa')
        ->selectRaw('desa, COUNT(*) as total')
        ->groupBy('desa')
        ->pluck('total', 'desa');

    $chartLabels = $wilayahOrder;

    $chartData = collect($wilayahOrder)->map(function ($wilayah) use ($wilayahCounts) {
        return (int) ($wilayahCounts[$wilayah] ?? 0);
    })->values();


    // ===== CHART PIE (SEKTOR USAHA) =====
    $sektorOrder = [
        'Kuliner',
        'Perdagangan',
        'Industri/Produksi',
        'Jasa',
        'Kecantikan',
        'Lainnya'
    ];

    $sektorCounts = Umkm::whereNotNull('bidang_usaha')
        ->selectRaw('bidang_usaha, COUNT(*) as total')
        ->groupBy('bidang_usaha')
        ->pluck('total', 'bidang_usaha');

// urutkan sesuai urutan tetap
    $pieLabels = $sektorOrder;

    $pieData = collect($sektorOrder)->map(function ($sektor) use ($sektorCounts) {
        return (int) ($sektorCounts[$sektor] ?? 0);
    })->values();


    // ===== RINGKASAN =====
    $totalUmkm = Umkm::count();

    $wilayahDominan = $wilayahCounts->sortDesc()->keys()->first() ?? '-';
    $jumlahDominan = $wilayahCounts->sortDesc()->first() ?? 0;

    $sektorDominan = $sektorCounts->sortDesc()->keys()->first() ?? '-';
    $jumlahSektorDominan = $sektorCounts->sortDesc()->first() ?? 0;


    return view('dashboard-potensi', compact(
        'chartLabels',
        'chartData',
        'pieLabels',
        'pieData',
        'totalUmkm',
        'wilayahDominan',
        'jumlahDominan',
        'sektorDominan',
        'jumlahSektorDominan'
    ));
}


public function adminDashboard()
{
    if (!session('user_id')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
    }

    $totalUmkm = Umkm::count();

    $umkmAktif = Umkm::count();

    $totalWilayah = Umkm::whereNotNull('desa')
        ->distinct('desa')
        ->count('desa');

    $sektorOrder = [
        'Kuliner',
        'Perdagangan',
        'Industri/Produksi',
        'Jasa',
        'Kecantikan',
        'Lainnya',
    ];

    $sektorCounts = Umkm::whereNotNull('bidang_usaha')
        ->selectRaw('bidang_usaha, COUNT(*) as total')
        ->groupBy('bidang_usaha')
        ->pluck('total', 'bidang_usaha');

    $sektorLabels = $sektorOrder;

    $sektorData = collect($sektorOrder)->map(function ($sektor) use ($sektorCounts) {
        return (int) ($sektorCounts[$sektor] ?? 0);
    })->values();

    $komposisiCounts = Umkm::whereNotNull('status_potensi')
        ->selectRaw('status_potensi, COUNT(*) as total')
        ->groupBy('status_potensi')
        ->get();

    $komposisiMap = [
        'tinggi' => 0,
        'sedang' => 0,
        'rendah' => 0,
    ];

    foreach ($komposisiCounts as $item) {
        $status = strtolower($item->status_potensi);
        if (array_key_exists($status, $komposisiMap)) {
            $komposisiMap[$status] = (int) $item->total;
        }
    }

    $komposisiLabels = ['Potensi Tinggi', 'Potensi Sedang', 'Potensi Rendah'];
    $komposisiData = [
        $komposisiMap['tinggi'],
        $komposisiMap['sedang'],
        $komposisiMap['rendah'],
    ];

    $mapUmkms = Umkm::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get([
            'nama_usaha',
            'pemilik',
            'bidang_usaha',
            'desa',
            'status_potensi',
            'latitude',
            'longitude'
        ]);

    return view('admin.dashboard', compact(
        'totalUmkm',
        'umkmAktif',
        'totalWilayah',
        'sektorLabels',
        'sektorData',
        'komposisiLabels',
        'komposisiData',
        'mapUmkms'
    ));
}

public function export()
{
    return Excel::download(new UmkmExport, 'backup-data-umkm.xlsx');
}

public function exportDashboardPdf()
{
    $totalUmkm = Umkm::count();

    $wilayahCounts = Umkm::whereNotNull('desa')
        ->selectRaw('desa, COUNT(*) as total')
        ->groupBy('desa')
        ->pluck('total', 'desa');

    $sektorCounts = Umkm::whereNotNull('bidang_usaha')
        ->selectRaw('bidang_usaha, COUNT(*) as total')
        ->groupBy('bidang_usaha')
        ->pluck('total', 'bidang_usaha');

    $wilayahDominan = $wilayahCounts->sortDesc()->keys()->first() ?? '-';
    $jumlahDominan = $wilayahCounts->sortDesc()->first() ?? 0;

    $sektorDominan = $sektorCounts->sortDesc()->keys()->first() ?? '-';
    $jumlahSektorDominan = $sektorCounts->sortDesc()->first() ?? 0;

    $pdf = Pdf::loadView('exports.dashboard-potensi-pdf', compact(
        'totalUmkm',
        'wilayahDominan',
        'jumlahDominan',
        'sektorDominan',
        'jumlahSektorDominan'
    ));

    return $pdf->download('dashboard-potensi-umkm.pdf');
}

}

