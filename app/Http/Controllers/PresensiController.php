<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Echo_;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $siswas = $dataResponseSiswa->data;
        $gurus =  $dataResponseGuru->data;
        $datakelas = $dataResponseKelas->data;
        $datamapel =  $dataResponseMapel->data;
        $datajadwal =  $dataResponseJadwal->data;

        //dd($datamapel);

        $this->data ['gurus'] = $gurus;
        $this->data ['siswas'] = $siswas;
        $this->data ['datakelas'] = $datakelas;
        $this->data ['datamapel'] = $datamapel;
        $this->data ['datajadwal'] = $datajadwal;

        return view('presensi.index',$this->data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $siswas = $dataResponseSiswa->data;
        $gurus =  $dataResponseGuru->data;
        $datakelas = $dataResponseKelas->data;
        $datamapel =  $dataResponseMapel->data;
        $datajadwal =  $dataResponseJadwal->data;

        //dd($datamapel);

        $this->data ['gurus'] = $gurus;
        $this->data ['siswas'] = $siswas;
        $this->data ['datakelas'] = $datakelas;
        $this->data ['datamapel'] = $datamapel;
        $this->data ['datajadwal'] = $datajadwal;

        return view('presensi.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ttl = explode('/', $request->tgl_lahir);
        $request->merge([
            'tgl_lahir' => $ttl[2] . '-' . $ttl[0] . '-' . $ttl[1]
        ]);
        $response = Http::withToken(session('tokenUser'))
            ->post(
                env("REST_API_ENDPOINT") . '/api/guru',
                $request->except('_token')
            );
        $data = json_decode($response);

        if ($data->status == true) {
            return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
        } else {
            return redirect()->route('guru.create')->with('validationErrors', $data->message);
        }
    }

    public function account_profile(Request $request)
    {
        // 
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
            ->get(env("REST_API_ENDPOINT") . '/api/guru/' . $id);
        $dataResponse = json_decode($response);

        $responseDataDependencies = Http::withToken(session()->get('tokenUser'))
            ->get(env("REST_API_ENDPOINT") . '/api/users');
        $dataDependencies = json_decode($responseDataDependencies);
        //dd($dataResponse);
        if ($dataResponse->status == true) {
            $guru = $dataResponse->data;
            $ttl = explode('-', $guru->tgl_lahir);
            $guru->tgl_lahir = $ttl[1] . '/' . $ttl[2] . '/' . $ttl[0];
            $this->data['guru'] = $guru;
            $this->data['dataUsers'] = $dataDependencies->data;
            //dd($dataDependencies);

            return view('guru.edit', $this->data);
        } else {
            return redirect()->route('guru.index')->with('danger', 'Data siswa tidak ditemukan!');
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
        $ttl = explode('/', $request->tgl_lahir);
        $request->merge([
            'tgl_lahir' => $ttl[2] . '-' . $ttl[0] . '-' . $ttl[1]
        ]);

        $response = Http::withToken(session('tokenUser'))
            ->put(
                env("REST_API_ENDPOINT") . '/api/guru/' . $id,
                $request->except(['_token', '_method'])
            );
        $data = json_decode($response);
        //dd($data);
        if ($data->status == true) {
            return redirect()->route('guru.index')->with('success', 'Data guru berhasil di otak atik!');
        } else {
            return redirect()->route('guru.edit', $id)->with('validationErrors', $data->message);
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
        $response = Http::withToken(session('tokenUser'))
                   ->delete(env("REST_API_ENDPOINT").'/api/guru/'.$id);
        $data = json_decode($response);

        if ($data->status == true) {
            return redirect()->route('guru.index')->with('success','Data guru berhasil dihapus!');
        } else {
            return redirect()->route('guru.index')->with('ValidationErrors',$data->message);
        }
    }

    public function account()
    {
         return view('guru.account');
    }

    public function account_save(Request $request)
    {
        // 
    }
}
