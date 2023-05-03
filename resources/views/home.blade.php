@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <?php
                use Illuminate\Support\Facades\Auth;
                use Illuminate\Support\Facades\DB;

                $user_id = Auth::user()->id;
                $role_id = Auth::user()->role_id;
                $data = DB::table('users')
                    ->leftJoin(
                        'katalog_role',
                        'users.role_id',
                        'katalog_role.id'
                    )
                    ->select('katalog_role.deskripsi as role_user')
                    ->where('users.id', $user_id)
                    ->first();
                ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="m-0">{{ __('Kamu berhasil login sebagai ') }} {{ $data->role_user }}</h5>
                </div>
                <hr>
                @if($role_id == 1)
                <!--JIKA ROLE USER PENJUAL-->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header text-white bg-primary">{{ __('Input Produk') }}</div>
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <p class="card-text">{{ __('Input produk anda di sini') }}</p>
                                <a href="{{ url('input_produk') }}" class="btn btn-info">{{ __('Input') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header text-white bg-success">{{ __('Report Input Produk') }}</div>
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <p class="card-text">{{ __('Lihat produk anda di sini') }}</p>
                                <a href="{{ url('report_produk') }}" class="btn btn-warning">{{ __('Report') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($role_id == 2)
                <!--MENU UNTUK PEMBELI-->
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection