@extends('layouts.app')

@section('content')
<div class="container-lg rounded p-3 shadow-lg" style="background-color: #f8f9fa">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-header bg-primary text-white rounded-top">Report Produk</div>
            <div class="card-body">
                <div class="row mb-2">
                    @if (\Session::has('message'))
                        <div class="alert alert-success">
                            { \Session::get('message') }
                        </div>
                    @elseif(\Session::has('error'))
                        <div class="alert alert-danger">
                            { \Session::get('error') }
                        </div>
                    @endif
                </div>
                <div class="responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="bg-primary text-white" align="center">
                                <th class="align-middle">No</th>
                                <th class="align-middle">Gambar Produk</th>
                                <th class="align-middle">Nama Produk</th>
                                <th class="align-middle">Stok</th>
                                <th class="align-middle">Deskripsi</th>
                                <th class="align-middle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($data_produk as $row)
                            <tr>
                                <td class="align-middle">{{ $no++ }}</td>
                                <td align="center">
                                    <img class="img-fluid rounded shadow-sm"
                                        src="{{ asset('gambar/gambar_produk/'.$row->gambar_produk) }}"
                                        style="width: 90px; height:90px"
                                        alt="Gambar Produk">
                                    </td>
                                    <td class="align-middle">{{ $row->nama_produk }}</td>
                                    <td class="align-middle">{{ $row->stok }}</td>
                                    <td class="align-middle">{{ $row->deskripsi_produk }}</td>
                                    <td class="align-middle text-center">
                                        <a href="{{ url('/edit_produk/'.$row->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="{{ url('/hapus_produk/'.$row->id) }}" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                        <a href="{{ url('/home') }}" class="btn btn-sm btn-secondary">
                                            <i class="bi bi-arrow-left-circle"></i> Kembali
                                        </a>
                                    </td>
                                </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
