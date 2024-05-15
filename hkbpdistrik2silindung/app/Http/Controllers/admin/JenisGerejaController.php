<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class JenisGerejaController extends Controller
{
    protected $rules = [
        'jenis_gereja' => 'required',
        'keterangan' => 'nullable'
    ];

    protected $messages = [
        'jenis_gereja.required' => 'Jenis Gereja field is required.',
        // 'keterangan.required' => 'Keterangan field is required.' // You may not need this if keterangan is nullable
    ];

    public function index()
    {
        // Fetch all jenis gereja from Go microservice
        $response = Http::get('http://localhost:8081/jenis_gereja');
        $jenisGerejas = $response->json();

        return view('admin.PengaturanDanKonfigurasi.JenisGereja.index', compact('jenisGerejas'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.JenisGereja.create');
    }

    public function store(Request $request)
    {
        // Send request to create a new jenis gereja to Go microservice
        $response = Http::post('http://localhost:8081/jenis_gereja', $request->all());

        if ($response->successful()) {
            return redirect()->route('JenisGereja.index')->with('success', 'Jenis Gereja added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add jenis gereja.')->withInput();
        }
    }

    public function edit($id)
    {
        // Fetch jenis gereja by ID from Go microservice
        $response = Http::get("http://localhost:8081/jenis_gereja/$id");
        $jenisGereja = $response->json();

        return view('admin.PengaturanDanKonfigurasi.JenisGereja.edit', compact('jenisGereja'));
    }

    public function update(Request $request, $id)
    {
        // Send request to update jenis gereja to Go microservice
        $response = Http::put("http://localhost:8081/jenis_gereja/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('JenisGereja.index')->with('success', 'Jenis Gereja updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update jenis gereja.')->withInput();
        }
    }

    public function delete($id)
    {
        // Send request to delete jenis gereja to Go microservice
        $response = Http::delete("http://localhost:8081/jenis_gereja/$id");

        if ($response->successful()) {
            return response()->json(['message' => 'Jenis Gereja deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Failed to delete jenis gereja.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function detail(Request $request)
    {
        $id = $request->id;

        $jenisGerejaData = DB::select('CALL view_JenisGereja_byId(?)', [$id]);

        if (!empty($jenisGerejaData)) {
            $jenisGereja = $jenisGerejaData[0];
            return response()->json([
                'status' => 200,
                'jenis_gereja' => $jenisGereja
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Gereja Tidak Ditemukan.'
            ]);
        }
    }
}
