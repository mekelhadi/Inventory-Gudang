<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Satuan;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    /**
     * INDEX
     */
    public function index()
    {
        return view('barang.index', [
            'barangs'       => Barang::all(),
            'jenis_barangs' => Jenis::all(),
            'satuans'       => Satuan::all()
        ]);
    }

    /**
     * GET DATA BARANG
     */
    public function getDataBarang()
    {
        try {

            $barangs = Barang::all();

            return response()->json([
                'success' => true,
                'data' => $barangs
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * CREATE
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'nama_barang'   => 'required',
            'deskripsi'     => 'required',

            'gambar'        => 'required|array|max:20',
            'gambar.*'      => 'image|mimes:jpeg,png,jpg|max:2048',

            'stok_minimum'  => 'required|numeric',
            'jenis_id'      => 'required',
            'satuan_id'     => 'required'

        ], [

            'nama_barang.required'  => 'Nama barang wajib diisi',
            'deskripsi.required'    => 'Deskripsi wajib diisi',
            'gambar.required'       => 'Gambar wajib diupload',
            'stok_minimum.required' => 'Stok minimum wajib diisi'

        ]);

        // VALIDASI ERROR
        if ($validator->fails()) {

            return response()->json(
                $validator->errors(),
                422
            );
        }

        // ================= IMAGE =================
        $images = [];

        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $index => $file) {

                // extension
                $extension = $file->getClientOriginalExtension();

                // nama barang
                $namaBarang = strtolower($request->nama_barang);

                // spasi jadi -
                $namaBarang = str_replace(' ', '-', $namaBarang);

                // hapus karakter aneh
                $namaBarang = preg_replace(
                    '/[^A-Za-z0-9\-]/',
                    '',
                    $namaBarang
                );

                // nama file final
                $filename =
                    $namaBarang .
                    '-' .
                    time() .
                    '-' .
                    $index .
                    '.' .
                    $extension;

                // simpan file
                $path = $file->storeAs(
                    'gambar-barang',
                    $filename,
                    'public'
                );

                $images[] = $path;
            }
        }

        // ================= KODE BARANG =================
        $kode_barang = 'PRPTY-' .
            str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

        // ================= INSERT =================
        $barang = Barang::create([

            'nama_barang'   => $request->nama_barang,

            'deskripsi'     => $request->deskripsi,

            'user_id'       => auth()->user()->id,

            'kode_barang'   => $kode_barang,

            'gambar'        => json_encode($images),

            'stok'          => 0,

            'stok_minimum'  => $request->stok_minimum,

            'jenis_id'      => $request->jenis_id,

            'satuan_id'     => $request->satuan_id
        ]);

        return response()->json([

            'success' => true,
            'message' => 'Data berhasil disimpan!',
            'data'    => $barang

        ]);
    }

    /**
     * SHOW
     */
    public function show(Barang $barang)
    {
        $barang->load([
            'jenis',
            'satuan'
        ]);

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    /**
     * EDIT
     */
    public function edit(Barang $barang)
    {
        return response()->json([

            'success' => true,
            'message' => 'Edit Data Barang',
            'data'    => $barang

        ]);
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Barang $barang)
    {
        $validator = Validator::make($request->all(), [

            'nama_barang'   => 'required',

            'deskripsi'     => 'required',

            'gambar'        => 'nullable|array|max:20',

            'gambar.*'      => 'image|mimes:jpeg,png,jpg|max:2048',

            'stok_minimum'  => 'required|numeric',

            'jenis_id'      => 'required',

            'satuan_id'     => 'required'

        ]);

        // VALIDASI ERROR
        if ($validator->fails()) {

            return response()->json(
                $validator->errors(),
                422
            );
        }

        // ================= OLD IMAGE =================
        $oldImages = [];

        if ($barang->gambar) {

            if (
                is_array(
                    json_decode($barang->gambar, true)
                )
            ) {

                $oldImages = json_decode(
                    $barang->gambar,
                    true
                );

            } else {

                $oldImages = [$barang->gambar];
            }
        }

        $images = $oldImages;

        // ================= NEW IMAGE =================
        if ($request->hasFile('gambar')) {

            // DELETE OLD IMAGE
            foreach ($oldImages as $img) {

                if (
                    Storage::disk('public')->exists($img)
                ) {

                    Storage::disk('public')->delete($img);
                }
            }

            $images = [];

            foreach ($request->file('gambar') as $index => $file) {

                // extension
                $extension = $file->getClientOriginalExtension();

                // nama barang
                $namaBarang = strtolower($request->nama_barang);

                // spasi jadi -
                $namaBarang = str_replace(' ', '-', $namaBarang);

                // hapus karakter aneh
                $namaBarang = preg_replace(
                    '/[^A-Za-z0-9\-]/',
                    '',
                    $namaBarang
                );

                // nama file
                $filename =
                    $namaBarang .
                    '-' .
                    time() .
                    '-' .
                    $index .
                    '.' .
                    $extension;

                // simpan file
                $path = $file->storeAs(
                    'gambar-barang',
                    $filename,
                    'public'
                );

                $images[] = $path;
            }
        }

        // ================= UPDATE =================
        $barang->update([

            'nama_barang'   => $request->nama_barang,

            'deskripsi'     => $request->deskripsi,

            'stok_minimum'  => $request->stok_minimum,

            'user_id'       => auth()->user()->id,

            'gambar'        => json_encode($images),

            'jenis_id'      => $request->jenis_id,

            'satuan_id'     => $request->satuan_id
        ]);

        return response()->json([

            'success' => true,
            'message' => 'Data berhasil diupdate!',
            'data'    => $barang

        ]);
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        try {

            $barang = Barang::find($id);

            if (!$barang) {

                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // ================= DELETE IMAGE =================
            if ($barang->gambar) {

                $images = json_decode(
                    $barang->gambar,
                    true
                );

                if (is_array($images)) {

                    foreach ($images as $img) {

                        if (
                            Storage::disk('public')->exists($img)
                        ) {

                            Storage::disk('public')->delete($img);
                        }
                    }
                }
            }

            // ================= DELETE DATA =================
            $barang->delete();

            return response()->json([

                'success' => true,
                'message' => 'Data berhasil dihapus'

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()

            ], 500);
        }
    }

    /**
     * CETAK PDF
     */
    public function cetakPdf($id)
    {
        $item = Barang::with([
            'jenis',
            'satuan'
        ])->findOrFail($id);

        $lastBarangMasuk = BarangMasuk::where(
            'nama_barang',
            $item->nama_barang
        )
        ->with('supplier')
        ->latest()
        ->first();

        $pdf = Pdf::loadView(
            'pdf.barang',
            compact(
                'item',
                'lastBarangMasuk'
            )
        );

        return $pdf->stream(
            'detail-barang.pdf'
        );
    }
}