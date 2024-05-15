<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    protected $rules = [
        'country_code' => 'required',
        'country_name' => 'required',
        'code' => 'required'
    ];

    protected $messages = [
        'country_code.required' => 'Country code field is required.',
        'country_name.required' => 'Country name field is required.',
        'code.required' => 'Code field is required.'
    ];

    public function index()
    {
        // Fetch all countries from Go microservice
        $response = Http::get('http://localhost:8086/country');
        $countries = $response->json();

        return view('admin.PengaturanDanKonfigurasi.Country.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.Country.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Log the request data for debugging
        \Log::info('Country store request data: ', [$request->all()]);

        // Send request to create a new country to Go microservice
        $response = Http::post('http://localhost:8086/country', $request->all());

        // Log the response from the microservice for debugging
        \Log::info('Country store response: ', [$response->json()]);

        if ($response->successful()) {
            return redirect()->route('Country.index')->with('success', 'Country added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add country.')->withInput();
        }
    }



    public function edit($id)
    {
        // Fetch country by ID from Go microservice
        $response = Http::get("http://localhost:8086/country/$id");
        $country = $response->json();

        return view('admin.PengaturanDanKonfigurasi.Country.edit', compact('country'));
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), $this->rules, $this->messages);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Log the request data for debugging
    \Log::info('Country update request data: ', [$request->all()]);

    // Send request to update country to Go microservice
    $response = Http::put("http://localhost:8086/country/$id", $request->all());

    // Log the response from the microservice for debugging
    \Log::info('Country update response: ', [$response->json()]);

    if ($response->successful()) {
        return redirect()->route('Country.index')->with('success', 'Country updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Failed to update country.')->withInput();
    }
}


    public function delete($id)
    {
        // Send request to delete country to Go microservice
        $response = Http::delete("http://localhost:8086/country/$id");

        if ($response->successful()) {
            return response()->json(['message' => 'Country deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Failed to delete country.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $countryData = DB::select('CALL view_Country_byId(' . $id . ')');
        $country = $countryData[0];

        if ($country) {
            return response()->json([
                'status' => 200,
                'country' => $country
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Country not found.'
            ]);
        }
    }
}
