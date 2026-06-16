<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $barangCount        = Barang::count();
    $barangMasukCount   = BarangMasuk::count();
    $barangKeluarCount  = BarangKeluar::count();
    $userCount          = User::count();

    $barangMasukPerBulan = BarangMasuk::selectRaw('
        DATE_FORMAT(created_at, "%Y-%m") as bulan,
        SUM(jumlah_masuk) as total
    ')
    ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m")')
    ->orderBy('bulan')
    ->pluck('total', 'bulan');

    $barangKeluarPerBulan = BarangKeluar::selectRaw('
        DATE_FORMAT(created_at, "%Y-%m") as bulan,
        SUM(jumlah_keluar) as total
    ')
    ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m")')
    ->orderBy('bulan')
    ->pluck('total', 'bulan');

    $semuaBulan = $barangMasukPerBulan->keys()->merge(
        $barangKeluarPerBulan->keys()
    )->unique()->sort()->values();

    $chartLabels = $semuaBulan->map(fn($b) => date('M', strtotime($b . '-01')));
    $barangMasukData = $semuaBulan->map(fn($b) => (int) $barangMasukPerBulan->get($b, 0));
    $barangKeluarData = $semuaBulan->map(fn($b) => (int) $barangKeluarPerBulan->get($b, 0));

    $barangMinimum = Barang::where('stok', '<=', 10)->get();

    return view('dashboard', [
        'barang'            => $barangCount,
        'barangMasuk'       => $barangMasukCount,
        'barangKeluar'      => $barangKeluarCount,
        'user'              => $userCount,
        'chartLabels'       => $chartLabels,
        'barangMasukData'   => $barangMasukData,
        'barangKeluarData'  => $barangKeluarData,
        'barangMinimum'     => $barangMinimum
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
