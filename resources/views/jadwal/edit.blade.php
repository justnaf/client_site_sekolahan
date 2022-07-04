@extends('layouts/main-admin')

@section('title', 'Edit Jadwal')

@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 text-dark">JADWAL</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Edit Jadwal</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="container-fluid">
    <div class="card">
        @include ('includes.flash')
        <div class="card-body">
            <form role="form" method="post" action="{{ route('jadwal.update',$jadwals->id)}}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-body">                    
                    <div class="form-group">
                        <label for="exampleInputJK">Kelas</label>
                        <select class="form-control" name="kelas_id" id="kelas_id" required>
                            @foreach ($dataKelas as $kelas)
                            <option value="{{$kelas->id}}" @if($kelas->id == $jadwals->kelas_id)
                                selected=""
                                @endif> {{$kelas->nama_kelas}}
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputJK">Mata Pelajaran</label>
                        <select class="form-control" name="mapel_id" id="mapel_id" required>
                            @foreach ($dataMapel as $mapel)
                            <option value="{{$mapel->id}}" @if($mapel->id == $jadwals->mapel_id)
                                selected=""
                                @endif> {{$mapel->nama_mapel}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputJK">Guru Pengampu</label>
                        <select class="form-control" name="guru_id" id="guru_id" required>
                            @foreach ($dataGuru as $guru)
                            <option value="{{$guru->id}}" @if($guru->id == $jadwals->guru_id)
                                selected=""
                                @endif> {{$guru->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputJK">Hari</label>
                        <select class="form-control" name="hari" id="hari" required>
                            <option value="">Pilih Hari</option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu" >Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Jam Pelajaran</label>
                        <input type="text" class="form-control" name="jam_pelajaran" id="jam_pelajaran" value="{{$jadwals->jam_pelajaran}}" required>
                    </div>                                                         
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@include ('includes.scripts')
@endsection