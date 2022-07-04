@extends('layouts/main-admin')

@section('title', 'Presensi')

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
                <li class="breadcrumb-item active">Presensi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="container-fluid">
    <div class="card">
        @include ('includes.flash')
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h1>Absensi</h1>
              <label for="exampleInputJK">Kelas</label>
                <select class="form-control kelas" name="kelas" id="kelas" required>
                  @foreach($datakelas as $kelas)
                  <option value="{{$kelas->id}} " >{{$kelas->nama_kelas}}</option>
                  @endforeach
                </select>
                <a href="{{ route('presensi.create', $kelas->id) }}">
                    <button class="btn btn-success mt-1" data-toggler="tooltip" data-placement="top" title="Ubah">
                         <i class="fa fa-edit"></i>
                     </button>
                </a>
              </div>
              <div class="col border-left">
              <h1>Rekap Absensi</h1>
              <label for="exampleInputJK">Kelas</label>
              <select class="form-control kelas" name="kelas" id="kelas" required>
                @foreach($datakelas as $kelas)
                <option value="{{$kelas->id}} " >{{$kelas->nama_kelas}}</option>
                @endforeach
              </select>
              <a href="{{ route('presensi.create', $kelas->id) }}">
                  <button class="btn btn-success mt-1" data-toggler="tooltip" data-placement="top" title="Ubah">
                       <i class="fa fa-edit"></i>
                   </button>
              </a>
            </div>
          </div>
        </div>
    </div>
</section>


@include ('includes.scripts')
@endsection