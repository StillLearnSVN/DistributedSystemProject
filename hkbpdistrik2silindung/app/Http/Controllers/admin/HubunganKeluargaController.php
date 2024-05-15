<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class HubunganKeluargaController extends Controller
{
    protected $rules = [
        'nama_hub_keluarga' => 'required',
        'keterangan' => 'nullable'
    ];

    protected $messages = [
        'nama_hub_keluarga.required' => 'Nama Hubungan Keluarga field is required.',
        // 'keterangan.required' => 'Keterangan field is required.' // You may not need this if keterangan is nullable
    ];

    public function index()
    {
        // Fetch all hubungan keluarga from Go microservice
        $response = Http::get('http://localhost:8082/hubungan_keluarga');
        $hubunganKeluargas = $response->json();

        return view('admin.PengaturanDanKonfigurasi.HubunganKeluarga.index', compact('hubunganKeluargas'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.HubunganKeluarga.create');
    }

    public function store(Request $request)
    {
        // Send request to create a new hubungan keluarga to Go microservice
        $response = Http::post('http://localhost:8082/hubungan_keluarga', $request->all());

        if ($response->successful()) {
            return redirect()->route('HubunganKeluarga.index')->with('success', 'Hubungan Keluarga added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add hubungan keluarga.')->withInput();
        }
    }

    public function edit($id)
    {
        // Fetch hubungan keluarga by ID from Go microservice
        $response = Http::get("http://localhost:8082/hubungan_keluarga/$id");
        $hubunganKeluarga = $response->json();

        return view('admin.PengaturanDanKonfigurasi.HubunganKeluarga.edit', compact('hubunganKeluarga'));
    }

    public function update(Request $request, $id)
    {
        // Send request to update hubungan keluarga to Go microservice
        $response = Http::put("http://localhost:8082/hubungan_keluarga/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('HubunganKeluarga.index')->with('success', 'Hubungan Keluarga updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update hubungan keluarga.')->withInput();
        }
    }

    public function delete($id)
    {
        // Send request to delete hubungan keluarga to Go microservice
        $response = Http::delete("http://localhost:8082/hubungan_keluarga/$id");

        if ($response->successful()) {
            return response()->json(['message' => 'Hubungan Keluarga deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Failed to delete hubungan keluarga.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $hubunganKeluargaData = DB::select('CALL view_HubunganKeluarga_byId(?)', [$id]);

        if (!empty($hubunganKeluargaData)) {
            $hubunganKeluarga = $hubunganKeluargaData[0];
            return response()->json([
                'status' => 200,
                'hubunganKeluarga' => $hubunganKeluarga
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Hubungan Keluarga Tidak Ditemukan.'
            ]);
        }
    }
}
