<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PendidikanController extends Controller
{
    protected $rules = [
        'pendidikan' => 'required',
        'keterangan' => 'required'
    ];

    protected $messages = [
        'pendidikan.required' => 'Pendidikan field is required.',
        'keterangan.required' => 'Keterangan field is required.'
    ];

    public function index()
    {
        // Fetch all pendidikan from Go microservice
        $response = Http::get('http://localhost:8083/pendidikan');
        $pendidikans = $response->json();

        return view('admin.PengaturanDanKonfigurasi.Pendidikan.index', compact('pendidikans'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.Pendidikan.create');
    }

    public function store(Request $request)
    {
        // Send request to create a new pendidikan to Go microservice
        $response = Http::post('http://localhost:8083/pendidikan', $request->all());

        if ($response->successful()) {
            return redirect()->route('Pendidikan.index')->with('success', 'Pendidikan added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add pendidikan.')->withInput();
        }
    }

    public function edit($id)
    {
        // Fetch pendidikan by ID from Go microservice
        $response = Http::get("http://localhost:8083/pendidikan/$id");
        $pendidikan = $response->json();

        return view('admin.PengaturanDanKonfigurasi.Pendidikan.edit', compact('pendidikan'));
    }

    public function update(Request $request, $id)
    {
        // Send request to update pendidikan to Go microservice
        $response = Http::put("http://localhost:8083/pendidikan/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('Pendidikan.index')->with('success', 'Pendidikan updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update pendidikan.')->withInput();
        }
    }

    public function delete($id)
    {
        // Send request to delete pendidikan to Go microservice
        $response = Http::delete("http://localhost:8083/pendidikan/$id");

        if ($response->successful()) {
            return response()->json(['message' => 'Pendidikan deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Failed to delete pendidikan.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $educationData = DB::select('CALL view_Pendidikan_byId(' . $id . ')');
        $education = $educationData[0];

        if ($education) {
            return response()->json([
                'status' => 200,
                'education' => $education
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Pendidikan Tidak Ditemukan.'
            ]);
        }
    }
}
