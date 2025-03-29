@extends('layouts.app')
@section('title', 'Data users')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">User Managements</h4>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom border-light">
                    <h4 class="title">User Managements</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Full Name</th>
                                <th>Whatsapp Number</th>
                                <th>Balance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->whatsapp_number }}</td>
                                    <td>{{ $user->userBalance->balance }}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer d-flex align-items-center justify-content-end">
                    <ul class="pagination justify-content-center mb-0">
                        <!-- Pagination links -->
                        <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                            <a href="{{ $users->previousPageUrl() }}" class="page-link"><i class="ti ti-chevrons-left"></i></a>
                        </li>
                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                <a href="{{ $users->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                            <a href="{{ $users->nextPageUrl() }}" class="page-link"><i class="ti ti-chevrons-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
