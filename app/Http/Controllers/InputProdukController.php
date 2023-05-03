<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class InputProdukController extends Controller
{
    public function input_produk()
    {
        return view('penjual.input_produk');
    }

    public function simpan_input_produk(Request $request)
    {
        try {
            $gambar_produk = $request->file('gambar_produk');
            //ambil ekstensi gambar
            $ext_gambar_produk = $gambar_produk->getClientOriginalExtension();
            //ambil nama gambar
            $nama_gambar_produk = $gambar_produk->getClientOriginalName();
            //pindahkan gambar ke folder public/gambar/gambar_produk
            $gambar_produk->move('gambar/gambar_produk/', $nama_gambar_produk);
            $data = [
                'nama_produk' => $request->nama_produk,
                'gambar_produk' => $nama_gambar_produk,
                'stok' => $request->stok_produk,
                'deskripsi_produk' => $request->deskripsi_produk,
            ];
            //Start Transaction
            DB::beginTransaction();
            $insert_data = DB::table('produk')->insert($data);
            //Commit Transaction
            DB::commit();
            return redirect()->back()->with('message', 'Data produk berhasil diinput');
        } catch (Exception $e) {
            //rollback Transaction
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal di input, silahkan coba lagi!');
        }
    }

    public function report_produk()
    {
        try {
            $data_produk = DB::table('produk')
                ->select(
                    'produk.id',
                    'produk.nama_produk',
                    'produk.gambar_produk',
                    'produk.stok',
                    'produk.deskripsi_produk'
                )
                ->get();

            $data = [
                'data_produk' => $data_produk
            ];

            return view('penjual.report_produk', $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function edit_produk($id)
    {
        try {
            $data_produk = DB::table('produk')
                ->select(
                    'produk.id',
                    'produk.nama_produk',
                    'produk.gambar_produk',
                    'produk.stok',
                    'produk.deskripsi_produk'
                )
                ->where('produk.id', $id)
                ->get();

            $data = [
                'data_produk' => $data_produk,
                'id' => $id
            ];

            return view('penjual.edit_produk', $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function simpan_edit_produk(Request $request, $id)
    {
        try {
            $gambar_produk = $request->file('gambar_produk');

            if ($gambar_produk != "") {
                //ambil ekstensi gambar
                $ext_gambar_produk = $gambar_produk->getClientOriginalExtension();
                //ambil nama gambar
                $nama_gambar_produk = $gambar_produk->getClientOriginalName();
                //pindahkan gambar ke folder public/gambar/gambar_produk
                $gambar_produk->move('gambar/gambar_produk/', $nama_gambar_produk);
            } else {
                $nama_gambar_produk = $request->gambar_produk_lama;
            }

            $data_update = [
                'nama_produk' => $request->nama_produk,
                'gambar_produk' => $nama_gambar_produk,
                'stok' => $request->stok,
                'deskripsi_produk' => $request->deskripsi_produk,
            ];

            //Start Transaction
            DB::beginTransaction();
            $update_produk = DB::table('produk')->where('id', $id)->update($data_update);

            //Commit Transaction
            DB::commit();

            return redirect()->back()->with('message', 'Data produk berhasil di simpan');
        } catch (Exception $e) {
            //rollback Transaction
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal di disimpan, silahkan coba lagi!');
        }
    }

    public function hapus_produk($id)
    {
        try {
            //Start Transaction
            DB::beginTransaction();
            $hapus_produk = DB::table('produk')->where('id', $id)->delete();

            //Commit Transaction
            DB::commit();

            return redirect()->back()->with('message', 'Data produk berhasil dihapus');
        } catch (Exception $e) {
            //rollback Transaction
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal dihapus, silahkan coba lagi!');
        }
    }

    public function api_simpan_input_produk(Request $request)
    {
        try {
            $gambar_produk = $request->file('gambar_produk');


            //ambil ekstensi gambar
            $ext_gambar_produk = $gambar_produk->getClientOriginalExtension();
            //ambil nama gambar
            $nama_gambar_produk = $gambar_produk->getClientOriginalName();
            //pindahkan gambar ke folder public/gambar/gambar_produk
            $gambar_produk->move('gambar/gambar_produk/', $nama_gambar_produk);


            $data = [
                'nama_produk' => $request->nama_produk,
                'gambar_produk' => $nama_gambar_produk,
                'stok' => $request->stok,
                'deskripsi_produk' => $request->deskripsi_produk,
            ];


            //Start Transaction
            DB::beginTransaction();
            $insert_data = DB::table('produk')->insert($data);
            //Commit Transaction
            DB::commit();


            return response()->json(['message' => 'Data produk berhasil diinput'], 200);
        } catch (Exception $e) {
            //rollback Transaction
            DB::rollback();
            return response()->json(['message' => 'Data gagal diinput, silahkan coba lagi!'], 404);
        }
    }
    public function api_get_produk()
    {
        try {
            $data_produk = DB::table('produk')
                ->select(
                    'produk.id',
                    'produk.nama_produk',
                    'produk.gambar_produk',
                    'produk.stok',
                    'produk.deskripsi_produk'
                )
                ->get();


            $data = [
                'data_produk' => $data_produk
            ];


            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function api_simpan_edit_produk(Request $request)
    {
        $nama_produk = '';
        try {
            $id_produk = $request->id_produk;
            $gambar_produk = $request->file('gambar_produk');

            if ($gambar_produk != "") {
                //ambil ekstensi gambar
                $ext_gambar_produk = $gambar_produk->getClientOriginalExtension();
                //ambil nama gambar
                $nama_gambar_produk = $gambar_produk->getClientOriginalName();
                //pindahkan gambar ke folder public/gambar/gambar_produk
                $gambar_produk->move('gambar/gambar_produk/', $nama_gambar_produk);
            } else {
                $nama_gambar_produk = $request->gambar_produk_lama;
            }
            $data_update = [
                'nama_produk' => $request->nama_produk,
                'gambar_produk' => $nama_gambar_produk,
                'stok' => $request->stok,
                'deskripsi_produk' => $request->deskripsi_produk,
            ];

            //Start Transaction
            DB::beginTransaction();
            $update_produk = DB::table('produk')->where('id', $id_produk)->update($data_update);

            //Mendapatkan nama produk yang diupdate
            $nama_produk = DB::table('produk')->where('id', $id_produk)->value('nama_produk');

            //Commit Transaction
            DB::commit();

            return response()->json(['message' => "Data produk $nama_produk berhasil di edit"], 200);
        } catch (Exception $e) {
            //rollback Transaction
            DB::rollback();
            return response()->json(['message' => "Data produk $nama_produk gagal di edit"], 404);
        }
    }


    public function api_hapus_produk(Request $request)
    {
        try {
            $id_produk = $request->id_produk;
            $nama_produk = '';

            //Start Transaction
            DB::beginTransaction();
            $hapus_produk = DB::table('produk')->where('id', $id_produk)->delete();

            //Mendapatkan nama produk yang diupdate
            $nama_produk = DB::table('produk')->where('id', $id_produk)->value('nama_produk');

            //Commit Transaction
            DB::commit();

            return response()->json(['message' => "Data produk $nama_produk berhasil di hapus"], 200);
        } catch (Exception $e) {
            //rollback Transaction
            DB::rollback();
            return response()->json(['message' => "Data produk $nama_produk gagal di hapus"], 404);
        }
    }
}
