<?php

namespace App\Http\Controllers\admin;

use Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    protected $rules = [
        'status' => 'required',
        'id_jenis_status' => 'required|exists:jenis_status,id_jenis_status',
        'keterangan' => 'nullable'
    ];

    protected $messages = [
        'status.required' => 'Status field is required.',
        'id_jenis_status.required' => 'Jenis Status field is required.',
        'id_jenis_status.exists' => 'The selected Jenis Status is invalid.'
    ];

    public function index()
    {
        // Fetch all statuses from Go microservice
        $response = Http::get('http://localhost:8085/status');
        $statuses = $response->json();

        return view('admin.PengaturanDanKonfigurasi.Status.index', compact('statuses'));
    }

    public function create()
    {
        // Fetch all jenis statuses to populate the dropdown
        $jenisStatusesResponse = Http::get('http://localhost:8084/jenis_status');
        $jenisStatuses = $jenisStatusesResponse->successful() ? $jenisStatusesResponse->json() : [];

        return view('admin.PengaturanDanKonfigurasi.Status.create', compact('jenisStatuses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Ensure id_jenis_status is an integer
            $data = $request->all();
            $data['id_jenis_status'] = (int) $data['id_jenis_status'];

            // Log the request data for debugging
            \Log::info('Request data:', [$data]);

            // Send request to create a new status to Go microservice
            $response = Http::post('http://localhost:8085/status', $data);

            // Check if the response is successful
            if ($response->successful()) {
                \Log::info('Response from microservice (successful):', [$response->json()]);
                return redirect()->route('Status.index')->with('success', 'Status added successfully!');
            } else {
                // Log the response for debugging
                \Log::error('Response from microservice (error):', ['status' => $response->status(), 'body' => $response->body()]);
                return redirect()->back()->with('error', 'Failed to add status.')->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Error adding status:', ['exception' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while adding the status. Please try again.')->withInput();
        }
    }

    public function edit($id)
    {
        // Fetch status by ID from Go microservice
        $statusResponse = Http::get("http://localhost:8085/status/$id");
        $status = $statusResponse->successful() ? $statusResponse->json() : null;

        // Fetch all jenis statuses to populate the dropdown
        $jenisStatusesResponse = Http::get('http://localhost:8084/jenis_status');
        $jenisStatuses = $jenisStatusesResponse->successful() ? $jenisStatusesResponse->json() : [];

        return view('admin.PengaturanDanKonfigurasi.Status.edit', compact('status', 'jenisStatuses'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();
            $data['id_jenis_status'] = (int) $data['id_jenis_status'];

            \Log::info('Request data:', [$data]);

            $response = Http::put("http://localhost:8085/status/$id", $data);

            if ($response->successful()) {
                \Log::info('Response from microservice (successful):', [$response->json()]);
                return redirect()->route('Status.index')->with('success', 'Status updated successfully!');
            } else {
                \Log::error('Response from microservice (error):', ['status' => $response->status(), 'body' => $response->body()]);
                return redirect()->back()->with('error', 'Failed to update status.')->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Error updating status:', ['exception' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while updating the status. Please try again.')->withInput();
        }
    }

    public function delete($id)
    {
        // Send request to delete status to Go microservice
        $response = Http::delete("http://localhost:8085/status/$id");

        if ($response->successful()) {
            return response()->json(['message' => 'Status deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Failed to delete status.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $statusData = DB::select('CALL view_Status_byId(?)', [$id]);

        if (!empty($statusData)) {
            $status = $statusData[0];
            return response()->json([
                'status' => 200,
                'status' => $status
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Status Tidak Ditemukan.'
            ]);
        }
    }
}
