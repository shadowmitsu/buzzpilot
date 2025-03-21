@extends('layouts.app')
@section('title', 'Data Services')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Services</h4>
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
                            <h4 class="title">Service Categories</h4>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Type</th>
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
                                    <td>{{ strlen($service->name) > 50 ? substr($service->name, 0, 50) . '...' : $service->name }}</td>
                                    <td>{{ strlen($service->category->category_name) > 50 ? substr($service->category->category_name, 0, 50) . '...' : $service->category->category_name }}</td>
                                    <td>{{ $service->type }}</td>
                                    <td>{{ $service->price }}</td>
                                    <td>{{ $service->min }}</td>
                                    <td>{{ $service->max }}</td>
                                    <td>{{ $service->refill ? 'Yes' : 'No' }}</td>
                                    <td>{{ $service->status ? 'Active' : 'Inactive' }}</td>
                                    <td class="pe-3 text-center">
                                        <div class="hstack gap-1 justify-content-end">
                                            <a href="{{ route('services.detail', $service->id) }}"
                                                class="btn btn-soft-primary btn-icon btn-sm rounded-circle">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-danger btn-icon btn-sm rounded-circle">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer d-flex align-items-center justify-content-end">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item {{ $services->onFirstPage() ? 'disabled' : '' }}">
                            <a href="{{ $services->previousPageUrl() }}" class="page-link"><i
                                    class="ti ti-chevrons-left"></i></a>
                        </li>
                        @for ($i = 1; $i <= 3; $i++)
                            @if ($i <= $services->lastPage())
                                <li class="page-item {{ $i == $services->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $services->url($i) }}" class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor

                        @if ($services->currentPage() > 4)
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        @endif

                        @for ($i = max(4, $services->currentPage() - 1); $i <= min($services->lastPage() - 3, $services->currentPage() + 1); $i++)
                            <li class="page-item {{ $i == $services->currentPage() ? 'active' : '' }}">
                                <a href="{{ $services->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($services->currentPage() < $services->lastPage() - 3)
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        @endif

                        @for ($i = $services->lastPage() - 2; $i <= $services->lastPage(); $i++)
                            @if ($i > 3)
                                <li class="page-item {{ $i == $services->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $services->url($i) }}" class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        <li class="page-item {{ $services->hasMorePages() ? '' : 'disabled' }}">
                            <a href="{{ $services->nextPageUrl() }}" class="page-link"><i
                                    class="ti ti-chevrons-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
