<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Validator;

class BidangPendidikanController extends Controller
{
    protected $rules = array(
        'bidangPendidikan' => 'required'
    );

    protected $messages = array(
        'bidangPendidikan.required' => 'Bidang Pendidikan tidak boleh kosong.'
    );

    public function index()
    {
        $errors = new \Illuminate\Support\ViewErrorBag;

        $fieldEducation = DB::select('CALL viewAll_BidangPendidikan()');

        return view('admin.PengaturanDanKonfigurasi.BidangPendidikan.index', compact('fieldEducation', 'errors'));
    }


    public function fetchEducationField()
    {
        $fieldEducations = DB::select('CALL viewAll_BidangPendidikan()');
        return response()->json([
            'fieldEducations' => $fieldEducations
        ]);
    }

    public function create()
    {
        $errors = new \Illuminate\Support\ViewErrorBag;

        return view('admin.PengaturanDanKonfigurasi.BidangPendidikan.create', compact('errors'));
    }

    public function store(Request $request)
    {
        $BidangPendidikan = json_encode([
            'BidangPendidikan' => $request->get('bidangPendidikan'),
            'Keterangan'  => $request->get('keterangan')
        ]);

        //dd($BidangPendidikan);

        $response = DB::statement('CALL insert_bidangPendidikan(:dataBidangPendidikan)', ['dataBidangPendidikan' => $BidangPendidikan]);

        if ($response) {
            return redirect()->route('BidangPendidikan.index')->with('success', 'Bidang Pendidikan Berhasil Ditambahkan!');
        } else {
            return redirect()->route('BidangPendidikan.create')->with('error', 'Bidang Pendidikan Gagal Diubah!');
        }

        //return redirect()->route('BidangPendidikan.index');
    }

    public function edit($id)
    {
        $errors = new \Illuminate\Support\ViewErrorBag;
        //$id = $request->id;

        //dd($id);

        $fieldEducationData = DB::select('CALL view_BidangPendidikan_byId(' . $id . ')');
        $fieldEducation = $fieldEducationData[0];

        if ($fieldEducation) {
           return view('admin.PengaturanDanKonfigurasi.BidangPendidikan.edit', compact('fieldEducation', 'errors'));
        } else {
            return redirect()->route('BidangPendidikan.index')->with('error', 'Bidang Pendidikan Tidak Ditemukan!');
        }
    }


    public function update(Request $request, $id)
    {
        $BidangPendidikan = json_encode([
            'IdBidangPendidikan' => $id,
            'BidangPendidikan' => $request->get('bidangPendidikan'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $response = DB::statement('CALL update_bidangPendidikan(:dataBidangPendidikan)', ['dataBidangPendidikan' => $BidangPendidikan]);

        if ($response) {
            return redirect()->route('BidangPendidikan.index')->with('success', 'Bidang Pendidikan Berhasil Diubah!');
        } else {
            return redirect()->route('BidangPendidikan.edit', $id)->with('error', 'Bidang Pendidikan Gagal Diubah!');
        }
    }

    public function delete(Request $request)
    {

        $fieldEducationData = DB::select('CALL view_BidangPendidikan_byId(' . $request->get('idBidangPendidikan') . ')');
        $fieldEducation = $fieldEducationData[0];

        if ($fieldEducation) {
            $id = $request->get('idBidangPendidikan');

            $response = DB::select('CALL delete_bidangPendidikan(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Bidang Pendidikan Berhasil Dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Bidang Pendidikan Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $fieldEducationData = DB::select('CALL view_BidangPendidikan_byId(' . $id . ')');
        $fieldEducation = $fieldEducationData[0];

        if ($fieldEducation) {
            return response()->json([
                'status' => 200,
                'fieldEducation' => $fieldEducation
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Bidang Pendidikan Tidak Ditemukan.'
            ]);
        }
    }
}
