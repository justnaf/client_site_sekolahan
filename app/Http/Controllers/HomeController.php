<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */    
    public function index()
    {
        if (session()->get('userLogged') != null) {            
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    }

    public function dashboard()
    {          
        $responseGuru = Http::withToken(session()->get('tokenUser'))
            ->get(env("REST_API_ENDPOINT") . '/api/guru');
        $dataResponseGuru = json_decode($responseGuru);
        
        $responseSiswa = Http::withToken(session()->get('tokenUser'))
            ->get(env("REST_API_ENDPOINT") . '/api/siswa');
        $dataResponseSiswa = json_decode($responseSiswa);

        $responseKelas = Http::withToken(session()->get('tokenUser'))
            ->get(env("REST_API_ENDPOINT") . '/api/kelas');
        $dataResponseKelas = json_decode($responseKelas);

        $responseMapel = Http::withToken(session()->get('tokenUser'))
            ->get(env("REST_API_ENDPOINT") . '/api/mapel');
        $dataResponseMapel = json_decode($responseMapel);

        $responseJadwal = Http::withToken(session()->get('tokenUser'))
            ->get(env("REST_API_ENDPOINT") . '/api/jadwal');
        $dataResponseJadwal = json_decode($responseJadwal);

        $siswacounted = collect($dataResponseSiswa->data)->count();
        $gurucounted =  collect($dataResponseGuru->data)->count();
        $kelascounted =  collect($dataResponseKelas->data)->count();
        $mapelcounted =  collect($dataResponseMapel->data)->count();
        $jadwalcounted =  collect($dataResponseJadwal->data)->count();
        //dd($siswacounted);

        $this->data ['gurucounted'] = $gurucounted;
        $this->data ['siswacounted'] = $siswacounted;
        $this->data ['kelascounted'] = $kelascounted;
        $this->data ['mapelcounted'] = $mapelcounted;
        $this->data ['jadwalcounted'] = $jadwalcounted;

        return view('admin.dashboard',$this->data);
    }

    public function not_found()
    {
        return view('not_found');
    }
}
