@extends('layouts.master')

@section('content')
<div class="page-heading">
    <div class="row">
        <div class="col-6">
            <h3>Laporan Bulanan</h3>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <div class="btn-group me-1 mb-1">
                <div class="dropdown">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #435ebe;">
                        <i class="bi bi-person-circle"></i> {{Auth::user()->nama}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="padding: 7px;">
                        <h6>Kelola Akun</h6>
                        <a href="{{ route('users.profile') }}" class="dropdown-item">Profile</a>
                        <hr />
                        <a href="{{ route('auth.logout') }}" style="color: red;" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <section class="row">
        <!-- page section -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Laporan Permintaan Barang Dalam 1 Bulan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <input type="month" id="bulan-column" class="form-control" placeholder="Bulan" name="bunan">
                                </div>
                            </div>
                            <div class="col-md-2"><button class=" btn btn-primary" onclick="unduhBulanan()">Unduh</button></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end page section -->
    </section>
</div>
<script src="{{asset('assets/compiled/js/app.js')}}"></script>
<script src="{{asset('assets/compiled/js/jquery-3.7.1.js')}}"></script>
<script>
    function unduhBulanan() {
        location.href = "{{route('laporan_bulanan.unduh')}}"
    }
</script>

@endsection