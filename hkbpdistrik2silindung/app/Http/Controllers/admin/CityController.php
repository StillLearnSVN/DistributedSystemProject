<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    protected $rules = [
        'prov_id' => 'required|exists:province,prov_id',
        'city_name' => 'required',
    ];


    protected $messages = [
        'prov_id.required' => 'Province ID field is required.',
        'city_name.required' => 'City name field is required.',
    ];

    public function index()
    {
        $cities = DB::select('CALL viewAll_City()');
        return view('admin.PengaturanDanKonfigurasi.City.index', compact('cities'));
    }

    public function create()
    {
        $provinces = DB::select('CALL viewAll_Province()');
        return view('admin.PengaturanDanKonfigurasi.City.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $city = json_encode([
            'prov_id' => $request->prov_id,
            'city_name' => $request->city_name,
        ]);

        DB::statement('CALL insert_city(?)', [$city]);

        return redirect()->route('City.index')->with('success', 'City added successfully!');
    }

    public function edit($id)
    {
        $city = DB::select('CALL view_City_byId(?)', [$id]);

        if (empty($city)) {
            return redirect()->route('City.index')->with('error', 'City not found!');
        }

        $city = $city[0];
        $provinces = DB::select('CALL viewAll_Province()');
        return view('admin.PengaturanDanKonfigurasi.City.edit', compact('city', 'provinces'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $city = json_encode([
            'city_id' => $id,
            'prov_id' => $request->prov_id,
            'city_name' => $request->city_name,
        ]);

        DB::statement('CALL update_city(?)', [$city]);

        return redirect()->route('City.index')->with('success', 'City updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $city = DB::select('CALL view_City_byId(?)', [$id]);

        if (empty($city)) {
            return response()->json([
                'status' => 404,
                'message' => 'City not found.'
            ]);
        }

        DB::statement('CALL delete_city(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'City deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $cityData = DB::select('CALL view_City_byId(?)', [$id]);

        if (!empty($cityData)) {
            $city = $cityData[0];
            return response()->json([
                'status' => 200,
                'city' => $city
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'City data not found.'
            ]);
        }
    }
}
