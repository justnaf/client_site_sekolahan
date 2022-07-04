<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Jadwal;
use App\Model\Kelas;
use App\Model\Mapel;
use App\Model\Account;
use App\Model\TahunAjaran;
use App\Model\Semester;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {               
        $response = Http::withToken(session()->get('tokenUser'))
                            ->get(env("REST_API_ENDPOINT").'/api/jadwal');
        $dataResponse = json_decode($response);

        //dd($dataResponse);
        $this->data['jadwals'] = $dataResponse->data;

        return view('jadwal.index',$this->data);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $responseKelas = Http::withToken(session()->get('tokenUser'))
                                ->get(env("REST_API_ENDPOINT").'/api/kelas');

        $responseMapel = Http::withToken(session()->get('tokenUser'))
                                ->get(env("REST_API_ENDPOINT").'/api/mapel');

        $responseGuru = Http::withToken(session()->get('tokenUser'))
                                ->get(env("REST_API_ENDPOINT").'/api/guru');
        $dataKelas = json_decode($responseKelas);
        $dataMapel = json_decode($responseMapel);
        $dataGuru = json_decode($responseGuru);

        $this->data['dataKelas'] = $dataKelas->data;
        $this->data['dataGuru'] = $dataGuru->data;
        $this->data['dataMapel'] = $dataMapel->data;

        return view('jadwal.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Http::withToken(session('tokenUser'))
                                ->post(
                                    env("REST_API_ENDPOINT").'/api/jadwal',
                                    $request->except('_token')
                                );
        $data = json_decode($response);
            
        if ($data->status == true) {
            return redirect()->route('jadwal.index')->with('success','Data jadwal berhasil ditambahkan!');
        } else {
            return redirect()->route('jadwal.create')->with('validationErrors',$data->message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Http::withToken(session()->get('tokenUser'))
                    ->get(env("REST_API_ENDPOINT").'/api/jadwal/'.$id);
        $dataResponse = json_decode($response);

        $responseDataDepedenciesGuru = Http::withToken(session()->get('tokenUser'))
                                ->get(env("REST_API_ENDPOINT").'/api/guru');
        $dataDepedenciesGuru = json_decode($responseDataDepedenciesGuru);

        $responseDataDepedenciesKelas = Http::withToken(session()->get('tokenUser'))
                                ->get(env("REST_API_ENDPOINT").'/api/kelas');
        $dataDepedenciesKelas = json_decode($responseDataDepedenciesKelas);

        $responseDataDepedenciesMapel = Http::withToken(session()->get('tokenUser'))
                                ->get(env("REST_API_ENDPOINT").'/api/mapel');
        $dataDepedenciesMapel = json_decode($responseDataDepedenciesMapel);

        if ($dataResponse->status == true) {
            $jadwal = $dataResponse->data;
            //dd($jadwal);
            $this->data['jadwals'] = $jadwal;
            $this->data['dataKelas'] = $dataDepedenciesKelas->data;
            $this->data['dataMapel'] = $dataDepedenciesMapel->data;
            $this->data['dataGuru'] = $dataDepedenciesGuru->data;

            return view('jadwal.edit',$this->data);
        } else {
            return redirect()->route('jadwal.index')->with('danger','Data jadwal tidak ditemukan!');
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = Http::withToken(session('tokenUser'))
                    ->put(env("REST_API_ENDPOINT").'/api/jadwal/'.$id,
                    $request->except(['_token','_method'])
                );
        $data = json_decode($response);

        if ($data->status == true) {
            return redirect()->route('jadwal.index')->with('success','Data jadwal Berhasil diubah!');
        } else {
            return redirect()->route('jadwal.edit',$id)->with('ValidationErrors',$data->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
    }
}
