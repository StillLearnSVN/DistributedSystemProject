<?php

use App\Http\Controllers\admin\BaptisController;
use App\Http\Controllers\admin\BidangPendidikanController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\DetailPindahController;
use App\Http\Controllers\admin\DistrictsController;
use App\Http\Controllers\admin\DistrikController;
use App\Http\Controllers\admin\GerejaController;
use App\Http\Controllers\admin\HeadPindahController;
use App\Http\Controllers\admin\HubunganKeluargaController;
use App\Http\Controllers\admin\JemaatController;
use App\Http\Controllers\admin\JenisGerejaController;
use App\Http\Controllers\admin\PendidikanController;
use App\Http\Controllers\admin\JenisStatusController;
use App\Http\Controllers\admin\MajelisController;
use App\Http\Controllers\admin\MajelisLingkunganController;
use App\Http\Controllers\admin\MeninggalController;
use App\Http\Controllers\admin\PekerjaanController;
use App\Http\Controllers\admin\PelayanGerejaController;
use App\Http\Controllers\admin\PelayanNonTahbisanController;
use App\Http\Controllers\admin\PernikahanController;
use App\Http\Controllers\admin\PernikahanJemaatController;
use App\Http\Controllers\admin\ProvinceController;
use App\Http\Controllers\admin\RessortController;
use App\Http\Controllers\admin\SidiController;
use App\Http\Controllers\admin\StatusController;
use App\Http\Controllers\admin\SubdistrictsController;
use App\Http\Controllers\admin\WijkController;
//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route for bidang-pendidikan
Route::prefix("admin")->group(function () {
    Route::get("/bidang-pendidikan", [BidangPendidikanController::class, 'index'])->name('BidangPendidikan.index');
    Route::post("/bidang-pendidikan/simpan", [BidangPendidikanController::class, 'store'])->name('BidangPendidikan.store');
    Route::get("/bidang-pendidikan/tambah", [BidangPendidikanController::class, 'create'])->name('BidangPendidikan.create');
    Route::get("/bidang-pendidikan/edit/{id}", [BidangPendidikanController::class, 'edit'])->name('BidangPendidikan.edit');
    Route::post("/bidang-pendidikan/update/{id}", [BidangPendidikanController::class, 'update'])->name('BidangPendidikan.update');
    Route::get('/bidang-pendidikan/detail', [BidangPendidikanController::class, 'detail'])->name('BidangPendidikan.detail');
    Route::delete('/bidang-pendidikan/hapus', [BidangPendidikanController::class, 'delete'])->name('BidangPendidikan.delete');
})->middleware('auth');

// Route for Pendidikan
Route::prefix("admin")->group(function () {
    Route::get("/pendidikan", [PendidikanController::class, 'index'])->name('Pendidikan.index');
    Route::post("/pendidikan/simpan", [PendidikanController::class, 'store'])->name('Pendidikan.store');
    Route::get("/pendidikan/tambah", [PendidikanController::class, 'create'])->name('Pendidikan.create');
    Route::get("/pendidikan/edit/{id}", [PendidikanController::class, 'edit'])->name('Pendidikan.edit');
    Route::post("/pendidikan/update/{id}", [PendidikanController::class, 'update'])->name('Pendidikan.update');
    Route::get("/pendidikan/detail", [PendidikanController::class, 'detail'])->name('Pendidikan.detail');
    Route::delete("/pendidikan/hapus/{id}", [PendidikanController::class, 'delete'])->name('Pendidikan.delete');
})->middleware('auth');

// Route for Pekerjaan
Route::prefix("admin")->group(function () {
    Route::get("/pekerjaan", [PekerjaanController::class, 'index'])->name('Pekerjaan.index');
    Route::post("/pekerjaan/simpan", [PekerjaanController::class, 'store'])->name('Pekerjaan.store');
    Route::get("/pekerjaan/tambah", [PekerjaanController::class, 'create'])->name('Pekerjaan.create');
    Route::get("/pekerjaan/edit/{id}", [PekerjaanController::class, 'edit'])->name('Pekerjaan.edit');
    Route::post("/pekerjaan/update/{id}", [PekerjaanController::class, 'update'])->name('Pekerjaan.update');
    Route::get("/pekerjaan/detail", [PekerjaanController::class, 'detail'])->name('Pekerjaan.detail');
    Route::delete("/pekerjaan/hapus/{id}", [PekerjaanController::class, 'delete'])->name('Pekerjaan.delete');
})->middleware('auth');

// Route untuk Jenis Status
Route::prefix("admin")->group(function () {
    Route::get("/jenis-status", [JenisStatusController::class, 'index'])->name('JenisStatus.index');
    Route::post("/jenis-status/simpan", [JenisStatusController::class, 'store'])->name('JenisStatus.store');
    Route::get("/jenis-status/tambah", [JenisStatusController::class, 'create'])->name('JenisStatus.create');
    Route::get("/jenis-status/edit/{id}", [JenisStatusController::class, 'edit'])->name('JenisStatus.edit');
    Route::post("/jenis-status/update/{id}", [JenisStatusController::class, 'update'])->name('JenisStatus.update');
    Route::get("/jenis-status/detail", [JenisStatusController::class, 'detail'])->name('JenisStatus.detail');
    Route::delete("/jenis-status/hapus/{id}", [JenisStatusController::class, 'delete'])->name('JenisStatus.delete');
})->middleware('auth');

// Route untuk Status
Route::prefix("admin")->group(function () {
    Route::get("/status", [StatusController::class, 'index'])->name('Status.index');
    Route::post("/status/simpan", [StatusController::class, 'store'])->name('Status.store');
    Route::get("/status/tambah", [StatusController::class, 'create'])->name('Status.create');
    Route::get("/status/edit/{id}", [StatusController::class, 'edit'])->name('Status.edit');
    Route::post("/status/update/{id}", [StatusController::class, 'update'])->name('Status.update');
    Route::get("/status/detail", [StatusController::class, 'detail'])->name('Status.detail');
    Route::delete("/status/hapus/{id}", [StatusController::class, 'delete'])->name('Status.delete');
})->middleware('auth');

// Route for HubunganKeluarga
Route::prefix("admin")->group(function () {
    Route::get("/hubungan-keluarga", [HubunganKeluargaController::class, 'index'])->name('HubunganKeluarga.index');
    Route::post("/hubungan-keluarga/simpan", [HubunganKeluargaController::class, 'store'])->name('HubunganKeluarga.store');
    Route::get("/hubungan-keluarga/tambah", [HubunganKeluargaController::class, 'create'])->name('HubunganKeluarga.create');
    Route::get("/hubungan-keluarga/edit/{id}", [HubunganKeluargaController::class, 'edit'])->name('HubunganKeluarga.edit');
    Route::post("/hubungan-keluarga/update/{id}", [HubunganKeluargaController::class, 'update'])->name('HubunganKeluarga.update');
    Route::get("/hubungan-keluarga/detail", [HubunganKeluargaController::class, 'detail'])->name('HubunganKeluarga.detail');
    Route::delete("/hubungan-keluarga/hapus/{id}", [HubunganKeluargaController::class, 'delete'])->name('HubunganKeluarga.delete');
})->middleware('auth');

// Route for Country
Route::prefix("admin")->group(function () {
    Route::get("/country", [CountryController::class, 'index'])->name('Country.index');
    Route::post("/country/simpan", [CountryController::class, 'store'])->name('Country.store');
    Route::get("/country/tambah", [CountryController::class, 'create'])->name('Country.create');
    Route::get("/country/edit/{id}", [CountryController::class, 'edit'])->name('Country.edit');
    Route::post("/country/update/{id}", [CountryController::class, 'update'])->name('Country.update');
    Route::get("/country/detail", [CountryController::class, 'detail'])->name('Country.detail');
    Route::delete("/country/hapus/{id}", [CountryController::class, 'delete'])->name('Country.delete');
})->middleware('auth');

// Route for Province
Route::prefix("admin")->group(function () {
    Route::get("/province", [ProvinceController::class, 'index'])->name('Province.index');
    Route::post("/province/simpan", [ProvinceController::class, 'store'])->name('Province.store');
    Route::get("/province/tambah", [ProvinceController::class, 'create'])->name('Province.create');
    Route::get("/province/edit/{id}", [ProvinceController::class, 'edit'])->name('Province.edit');
    Route::post("/province/update/{id}", [ProvinceController::class, 'update'])->name('Province.update');
    Route::get("/province/detail", [ProvinceController::class, 'detail'])->name('Province.detail');
    Route::delete("/province/hapus", [ProvinceController::class, 'delete'])->name('Province.delete');
})->middleware('auth');

// Route for City
Route::prefix("admin")->group(function () {
    Route::get("/city", [CityController::class, 'index'])->name('City.index');
    Route::post("/city/simpan", [CityController::class, 'store'])->name('City.store');
    Route::get("/city/tambah", [CityController::class, 'create'])->name('City.create');
    Route::get("/city/edit/{id}", [CityController::class, 'edit'])->name('City.edit');
    Route::post("/city/update/{id}", [CityController::class, 'update'])->name('City.update');
    Route::get("/city/detail", [CityController::class, 'detail'])->name('City.detail');
    Route::delete("/city/hapus", [CityController::class, 'delete'])->name('City.delete');
})->middleware('auth');

// Route for Districts
Route::prefix("admin")->group(function () {
    Route::get("/districts", [DistrictsController::class, 'index'])->name('Districts.index');
    Route::post("/districts/simpan", [DistrictsController::class, 'store'])->name('Districts.store');
    Route::get("/districts/tambah", [DistrictsController::class, 'create'])->name('Districts.create');
    Route::get("/districts/edit/{id}", [DistrictsController::class, 'edit'])->name('Districts.edit');
    Route::post("/districts/update/{id}", [DistrictsController::class, 'update'])->name('Districts.update');
    Route::get("/districts/detail", [DistrictsController::class, 'detail'])->name('Districts.detail');
    Route::delete("/districts/hapus", [DistrictsController::class, 'delete'])->name('Districts.delete');
})->middleware('auth');

// Route for Subdistricts
Route::prefix("admin")->group(function () {
    Route::get("/subdistricts", [SubdistrictsController::class, 'index'])->name('Subdistricts.index');
    Route::post("/subdistricts/simpan", [SubdistrictsController::class, 'store'])->name('Subdistricts.store');
    Route::get("/subdistricts/tambah", [SubdistrictsController::class, 'create'])->name('Subdistricts.create');
    Route::get("/subdistricts/edit/{id}", [SubdistrictsController::class, 'edit'])->name('Subdistricts.edit');
    Route::post("/subdistricts/update/{id}", [SubdistrictsController::class, 'update'])->name('Subdistricts.update');
    Route::get("/subdistricts/detail", [SubdistrictsController::class, 'detail'])->name('Subdistricts.detail');
    Route::delete("/subdistricts/hapus", [SubdistrictsController::class, 'delete'])->name('Subdistricts.delete');
})->middleware('auth');

// Route for Distrik
Route::prefix("admin")->group(function () {
    Route::get("/distrik", [DistrikController::class, 'index'])->name('Distrik.index');
    Route::post("/distrik/simpan", [DistrikController::class, 'store'])->name('Distrik.store');
    Route::get("/distrik/tambah", [DistrikController::class, 'create'])->name('Distrik.create');
    Route::get("/distrik/edit/{id}", [DistrikController::class, 'edit'])->name('Distrik.edit');
    Route::post("/distrik/update/{id}", [DistrikController::class, 'update'])->name('Distrik.update');
    Route::get("/distrik/detail", [DistrikController::class, 'detail'])->name('Distrik.detail');
    Route::delete("/distrik/hapus", [DistrikController::class, 'delete'])->name('Distrik.delete');
})->middleware('auth');

// Route for Ressort
Route::prefix("admin")->group(function () {
    Route::get("/ressort", [RessortController::class, 'index'])->name('Ressort.index');
    Route::post("/ressort/simpan", [RessortController::class, 'store'])->name('Ressort.store');
    Route::get("/ressort/tambah", [RessortController::class, 'create'])->name('Ressort.create');
    Route::get("/ressort/edit/{id}", [RessortController::class, 'edit'])->name('Ressort.edit');
    Route::post("/ressort/update/{id}", [RessortController::class, 'update'])->name('Ressort.update');
    Route::get("/ressort/detail", [RessortController::class, 'detail'])->name('Ressort.detail');
    Route::delete("/ressort/hapus", [RessortController::class, 'delete'])->name('Ressort.delete');
})->middleware('auth');

// Route for Gereja
Route::prefix("admin")->group(function () {
    Route::get("/gereja", [GerejaController::class, 'index'])->name('Gereja.index');
    Route::post("/gereja/simpan", [GerejaController::class, 'store'])->name('Gereja.store');
    Route::get("/gereja/tambah", [GerejaController::class, 'create'])->name('Gereja.create');
    Route::get("/gereja/edit/{id}", [GerejaController::class, 'edit'])->name('Gereja.edit');
    Route::post("/gereja/update/{id}", [GerejaController::class, 'update'])->name('Gereja.update');
    Route::get("/gereja/detail", [GerejaController::class, 'detail'])->name('Gereja.detail');
    Route::delete("/gereja/hapus", [GerejaController::class, 'delete'])->name('Gereja.delete');
})->middleware('auth');

// Route for Jemaat
Route::prefix("admin")->group(function () {
    Route::get("/jemaat", [JemaatController::class, 'index'])->name('Jemaat.index');
    Route::post("/jemaat/simpan", [JemaatController::class, 'store'])->name('Jemaat.store');
    Route::get("/jemaat/tambah", [JemaatController::class, 'create'])->name('Jemaat.create');
    Route::get("/jemaat/edit/{id}", [JemaatController::class, 'edit'])->name('Jemaat.edit');
    Route::post("/jemaat/update/{id}", [JemaatController::class, 'update'])->name('Jemaat.update');
    Route::get("/jemaat/detail", [JemaatController::class, 'detail'])->name('Jemaat.detail');
    Route::delete("/jemaat/hapus", [JemaatController::class, 'delete'])->name('Jemaat.delete');
})->middleware('auth');

// Route for Majelis
Route::prefix("admin")->group(function () {
    Route::get("/majelis", [MajelisController::class, 'index'])->name('Majelis.index');
    Route::post("/majelis/simpan", [MajelisController::class, 'store'])->name('Majelis.store');
    Route::get("/majelis/tambah", [MajelisController::class, 'create'])->name('Majelis.create');
    Route::get("/majelis/edit/{id}", [MajelisController::class, 'edit'])->name('Majelis.edit');
    Route::post("/majelis/update/{id}", [MajelisController::class, 'update'])->name('Majelis.update');
    Route::get("/majelis/detail", [MajelisController::class, 'detail'])->name('Majelis.detail');
    Route::delete("/majelis/hapus", [MajelisController::class, 'delete'])->name('Majelis.delete');
})->middleware('auth');

// Route for MajelisLingkungan
Route::prefix("admin")->group(function () {
    Route::get("/majelis-lingkungan", [MajelisLingkunganController::class, 'index'])->name('MajelisLingkungan.index');
    Route::post("/majelis-lingkungan/simpan", [MajelisLingkunganController::class, 'store'])->name('MajelisLingkungan.store');
    Route::get("/majelis-lingkungan/tambah", [MajelisLingkunganController::class, 'create'])->name('MajelisLingkungan.create');
    Route::get("/majelis-lingkungan/edit/{id}", [MajelisLingkunganController::class, 'edit'])->name('MajelisLingkungan.edit');
    Route::post("/majelis-lingkungan/update/{id}", [MajelisLingkunganController::class, 'update'])->name('MajelisLingkungan.update');
    Route::get("/majelis-lingkungan/detail", [MajelisLingkunganController::class, 'detail'])->name('MajelisLingkungan.detail');
    Route::delete("/majelis-lingkungan/hapus", [MajelisLingkunganController::class, 'delete'])->name('MajelisLingkungan.delete');
})->middleware('auth');

// Route for PelayanGereja
Route::prefix("admin")->group(function () {
    Route::get("/pelayan-gereja", [PelayanGerejaController::class, 'index'])->name('PelayanGereja.index');
    Route::post("/pelayan-gereja/simpan", [PelayanGerejaController::class, 'store'])->name('PelayanGereja.store');
    Route::get("/pelayan-gereja/tambah", [PelayanGerejaController::class, 'create'])->name('PelayanGereja.create');
    Route::get("/pelayan-gereja/edit/{id}", [PelayanGerejaController::class, 'edit'])->name('PelayanGereja.edit');
    Route::post("/pelayan-gereja/update/{id}", [PelayanGerejaController::class, 'update'])->name('PelayanGereja.update');
    Route::get("/pelayan-gereja/detail", [PelayanGerejaController::class, 'detail'])->name('PelayanGereja.detail');
    Route::delete("/pelayan-gereja/hapus", [PelayanGerejaController::class, 'delete'])->name('PelayanGereja.delete');
})->middleware('auth');

// Route for PelayanNonTahbisan
Route::prefix("admin")->group(function () {
    Route::get("/pelayan-nontahbisan", [PelayanNonTahbisanController::class, 'index'])->name('PelayanNonTahbisan.index');
    Route::post("/pelayan-nontahbisan/simpan", [PelayanNonTahbisanController::class, 'store'])->name('PelayanNonTahbisan.store');
    Route::get("/pelayan-nontahbisan/tambah", [PelayanNonTahbisanController::class, 'create'])->name('PelayanNonTahbisan.create');
    Route::get("/pelayan-nontahbisan/edit/{id}", [PelayanNonTahbisanController::class, 'edit'])->name('PelayanNonTahbisan.edit');
    Route::post("/pelayan-nontahbisan/update/{id}", [PelayanNonTahbisanController::class, 'update'])->name('PelayanNonTahbisan.update');
    Route::get("/pelayan-nontahbisan/detail", [PelayanNonTahbisanController::class, 'detail'])->name('PelayanNonTahbisan.detail');
    Route::delete("/pelayan-nontahbisan/hapus", [PelayanNonTahbisanController::class, 'delete'])->name('PelayanNonTahbisan.delete');
})->middleware('auth');

// Route for Sidi
Route::prefix("admin")->group(function () {
    Route::get("/sidi", [SidiController::class, 'index'])->name('Sidi.index');
    Route::post("/sidi/simpan", [SidiController::class, 'store'])->name('Sidi.store');
    Route::get("/sidi/tambah", [SidiController::class, 'create'])->name('Sidi.create');
    Route::get("/sidi/edit/{id}", [SidiController::class, 'edit'])->name('Sidi.edit');
    Route::post("/sidi/update/{id}", [SidiController::class, 'update'])->name('Sidi.update');
    Route::get("/sidi/detail", [SidiController::class, 'detail'])->name('Sidi.detail');
    Route::delete("/sidi/hapus", [SidiController::class, 'delete'])->name('Sidi.delete');
})->middleware('auth');

// Route for Baptis
Route::prefix("admin")->group(function () {
    Route::get("/baptis", [BaptisController::class, 'index'])->name('Baptis.index');
    Route::post("/baptis/simpan", [BaptisController::class, 'store'])->name('Baptis.store');
    Route::get("/baptis/tambah", [BaptisController::class, 'create'])->name('Baptis.create');
    Route::get("/baptis/edit/{id}", [BaptisController::class, 'edit'])->name('Baptis.edit');
    Route::post("/baptis/update/{id}", [BaptisController::class, 'update'])->name('Baptis.update');
    Route::get("/baptis/detail", [BaptisController::class, 'detail'])->name('Baptis.detail');
    Route::delete("/baptis/hapus", [BaptisController::class, 'delete'])->name('Baptis.delete');
})->middleware('auth');

// Route for Pernikahan
Route::prefix("admin")->group(function () {
    Route::get("/pernikahan", [PernikahanController::class, 'index'])->name('Pernikahan.index');
    Route::post("/pernikahan/simpan", [PernikahanController::class, 'store'])->name('Pernikahan.store');
    Route::get("/pernikahan/tambah", [PernikahanController::class, 'create'])->name('Pernikahan.create');
    Route::get("/pernikahan/edit/{id}", [PernikahanController::class, 'edit'])->name('Pernikahan.edit');
    Route::post("/pernikahan/update/{id}", [PernikahanController::class, 'update'])->name('Pernikahan.update');
    Route::get("/pernikahan/detail", [PernikahanController::class, 'detail'])->name('Pernikahan.detail');
    Route::delete("/pernikahan/hapus", [PernikahanController::class, 'delete'])->name('Pernikahan.delete');
})->middleware('auth');

// Route for PernikahanJemaat
Route::prefix("admin")->group(function () {
    Route::get("/pernikahan-jemaat", [PernikahanJemaatController::class, 'index'])->name('PernikahanJemaat.index');
    Route::post("/pernikahan-jemaat/simpan", [PernikahanJemaatController::class, 'store'])->name('PernikahanJemaat.store');
    Route::get("/pernikahan-jemaat/tambah", [PernikahanJemaatController::class, 'create'])->name('PernikahanJemaat.create');
    Route::get("/pernikahan-jemaat/edit/{id}", [PernikahanJemaatController::class, 'edit'])->name('PernikahanJemaat.edit');
    Route::post("/pernikahan-jemaat/update/{id}", [PernikahanJemaatController::class, 'update'])->name('PernikahanJemaat.update');
    Route::get("/pernikahan-jemaat/detail", [PernikahanJemaatController::class, 'detail'])->name('PernikahanJemaat.detail');
    Route::delete("/pernikahan-jemaat/hapus", [PernikahanJemaatController::class, 'delete'])->name('PernikahanJemaat.delete');
})->middleware('auth');

// Route for JenisGereja
Route::prefix("admin")->group(function () {
    Route::get("/jenis-gereja", [JenisGerejaController::class, 'index'])->name('JenisGereja.index');
    Route::post("/jenis-gereja/simpan", [JenisGerejaController::class, 'store'])->name('JenisGereja.store');
    Route::get("/jenis-gereja/tambah", [JenisGerejaController::class, 'create'])->name('JenisGereja.create');
    Route::get("/jenis-gereja/edit/{id}", [JenisGerejaController::class, 'edit'])->name('JenisGereja.edit');
    Route::post("/jenis-gereja/update/{id}", [JenisGerejaController::class, 'update'])->name('JenisGereja.update');
    Route::get("/jenis-gereja/detail", [JenisGerejaController::class, 'detail'])->name('JenisGereja.detail');
    Route::delete("/jenis-gereja/hapus/{id}", [JenisGerejaController::class, 'delete'])->name('JenisGereja.delete');
})->middleware('auth');

// Route for Wijk
Route::prefix("admin")->group(function () {
    Route::get("/wijk", [WijkController::class, 'index'])->name('Wijk.index');
    Route::post("/wijk/simpan", [WijkController::class, 'store'])->name('Wijk.store');
    Route::get("/wijk/tambah", [WijkController::class, 'create'])->name('Wijk.create');
    Route::get("/wijk/edit/{id}", [WijkController::class, 'edit'])->name('Wijk.edit');
    Route::post("/wijk/update/{id}", [WijkController::class, 'update'])->name('Wijk.update');
    Route::get("/wijk/detail", [WijkController::class, 'detail'])->name('Wijk.detail');
    Route::delete("/wijk/hapus", [WijkController::class, 'delete'])->name('Wijk.delete');
})->middleware('auth');

// Route for Detail Pindah
Route::prefix("admin")->group(function () {
    Route::get("/detail-pindah", [DetailPindahController::class, 'index'])->name('DetailPindah.index');
    Route::post("/detail-pindah/simpan", [DetailPindahController::class, 'store'])->name('DetailPindah.store');
    Route::get("/detail-pindah/tambah", [DetailPindahController::class, 'create'])->name('DetailPindah.create');
    Route::get("/detail-pindah/edit/{id}", [DetailPindahController::class, 'edit'])->name('DetailPindah.edit');
    Route::post("/detail-pindah/update/{id}", [DetailPindahController::class, 'update'])->name('DetailPindah.update');
    Route::get("/detail-pindah/detail", [DetailPindahController::class, 'detail'])->name('DetailPindah.detail');
    Route::delete("/detail-pindah/hapus", [DetailPindahController::class, 'delete'])->name('DetailPindah.delete');
})->middleware('auth');

// Route for Head Pindah
Route::prefix("admin")->group(function () {
    Route::get("/head-pindah", [HeadPindahController::class, 'index'])->name('HeadPindah.index');
    Route::post("/head-pindah/simpan", [HeadPindahController::class, 'store'])->name('HeadPindah.store');
    Route::get("/head-pindah/tambah", [HeadPindahController::class, 'create'])->name('HeadPindah.create');
    Route::get("/head-pindah/edit/{id}", [HeadPindahController::class, 'edit'])->name('HeadPindah.edit');
    Route::post("/head-pindah/update/{id}", [HeadPindahController::class, 'update'])->name('HeadPindah.update');
    Route::get("/head-pindah/detail", [HeadPindahController::class, 'detail'])->name('HeadPindah.detail');
    Route::delete("/head-pindah/hapus", [HeadPindahController::class, 'delete'])->name('HeadPindah.delete');
})->middleware('auth');

// Route for Meninggal
Route::prefix("admin")->group(function () {
    Route::get("/meninggal", [MeninggalController::class, 'index'])->name('Meninggal.index');
    Route::post("/meninggal/simpan", [MeninggalController::class, 'store'])->name('Meninggal.store');
    Route::get("/meninggal/tambah", [MeninggalController::class, 'create'])->name('Meninggal.create');
    Route::get("/meninggal/edit/{id}", [MeninggalController::class, 'edit'])->name('Meninggal.edit');
    Route::post("/meninggal/update/{id}", [MeninggalController::class, 'update'])->name('Meninggal.update');
    Route::get("/meninggal/detail", [MeninggalController::class, 'detail'])->name('Meninggal.detail');
    Route::delete("/meninggal/hapus", [MeninggalController::class, 'delete'])->name('Meninggal.delete');
})->middleware('auth');
