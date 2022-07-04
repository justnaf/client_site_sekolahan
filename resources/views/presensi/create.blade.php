@extends('layouts/main-admin')

@section('title', 'Tambah Presensi')

@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 text-dark">Presensi</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Tambah Jadwal</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
        @include ('includes.flash')
        <div class="card-body">
            <div class="mb-1">
                <a class="text-md">Mapel</a> | 
                <a class="text-md">Guru</a> | 
                <a class="text-md">Jam</a>
            </div>
            @csrf
            @method('put')
            <form role="form" method="post" action="#" enctype="multipart/form-data">
            <table id="data-admin" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th width="40">NO</th>
                    <th>NAMA SISWA</th> 
                    <th>KELAS</th> 
                    <th class="text-center">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                {{-- looping data mapel --}}
                    @if (count($datajadwal))
                        @foreach($datajadwal as $key => $jadwals)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>PAIJO</td>
                        <td>1B</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Status" id="inlineRadio1" value="option1">
                                <label class="form-check-label" for="inlineRadio1">Hadir</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Status" id="inlineRadio2" value="option2">
                                <label class="form-check-label" for="inlineRadio2">Terlambat</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Status" id="inlineRadio3" value="option2">
                                <label class="form-check-label" for="inlineRadio3">Sakit</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="Status" id="inlineRadio4" value="option2">
                                <label class="form-check-label" for="inlineRadio4">Tidak Masuk</label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </form>
        </div>
    </div>
</section>
@include ('includes.scripts')
@endsection