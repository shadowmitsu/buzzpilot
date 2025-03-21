@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar">
                                    <div class="avatar-title rounded bg-primary bg-gradient">
                                        <i class="mdi mdi-wallet fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Saldo Anda</p>
                                <h4 class="mb-0">Rp {{ number_format(Auth::user()->userBalance->balance, 0, '.', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar">
                                    <div class="avatar-title rounded bg-primary bg-gradient">
                                        <i class="mdi mdi-cart-outline fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Pesanan Anda Bulan Ini</p>
                                <h4 class="mb-0">Rp {{ number_format($subtotalThisMonth, 0, '.', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom border-light">
                    <div class="row justify-content-between g-3">
                        <div class="col-lg-6">
                            <h4 class="title">Recommend Services</h4>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Refill</th>
                                <th>Status</th>
                                <th class="pe-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->price }}</td>
                                    <td>{{ $service->min }}</td>
                                    <td>{{ $service->max }}</td>
                                    <td>{{ $service->refill ? 'Yes' : 'No' }}</td>
                                    <td>{{ $service->status ? 'Active' : 'Inactive' }}</td>
                                    <td class="pe-3 text-center">
                                        <div class="hstack gap-1 justify-content-end">
                                            <!-- Tombol Order -->
                                            <a href=""
                                                class="btn btn-soft-success btn-icon btn-sm rounded-circle">
                                                <i class="ti ti-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
@endsection
