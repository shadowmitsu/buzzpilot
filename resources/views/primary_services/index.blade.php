@extends('layouts.app')
@section('title', 'Data Services')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Primary Services</h4>
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
                            <h4 class="title">Primary Services</h4>
                        </div>
                    </div>
                    <form action="{{ route('primary_services.index') }}">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row justify-content-between g-3 align-items-center">
                            <div class="col-lg-6">
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <label for="search-select" class="form-label">Search</label>
                                        <div class="position-relative">
                                            <input type="text" name="search" value="{{ request('search') }}" class="form-control ps-4"
                                                placeholder="Search Original Service">
                                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y ms-2"></i>
                                        </div>
                                    </div>
                    
                                    <div class="col-lg-4">
                                        <label for="platform-select" class="form-label">Platforms</label>
                                        <select class="form-select" id="platform-select" name="platform_id">
                                            <option value="All" {{ request('platform_id') == 'All' ? 'selected' : '' }}>All</option>
                                            @foreach ($digitals as $dig)
                                                <option value="{{ $dig->id }}"
                                                    {{ request('platform_id') == $dig->id ? 'selected' : '' }}>
                                                    {{ $dig->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                    
                                    <div class="col-lg-4">
                                        <label for="interaction-select" class="form-label">Interactions</label>
                                        <select class="form-select" id="interaction-select" name="interaction_id">
                                            <option value="All" {{ request('interaction_id') == 'All' ? 'selected' : '' }}>All</option>
                                            @foreach ($interactions as $inter)
                                                <option value="{{ $inter->id }}"
                                                    {{ request('interaction_name') == $inter->id ? 'selected' : '' }}>
                                                    {{ $inter->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-lg-6 text-lg-end">
                                <button type="submit" class="btn btn-dark waves-effect waves-light mt-3 mt-lg-0">
                                    <i class="ti ti-filter me-1"></i> Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Platform</th>
                                <th>Interaction</th>
                                <th>Old Price</th>
                                <th>Price</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Status</th>
                                <th class="pe-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strlen($service->name) > 50 ? substr($service->name, 0, 50) . '...' : $service->name }}
                                    </td>
                                    <td>{{ $service->digitalPlatform->name }}</td>
                                    <td>{{ $service->interactionType->name }}</td>
                                    <td>{{ $service->old_price }}</td>
                                    <td>{{ $service->price }}</td>
                                    <td>{{ $service->min }}</td>
                                    <td>{{ $service->max }}</td>
                                    <td>{{ $service->status ? 'Active' : 'Inactive' }}</td>
                                    <td class="pe-3 text-center">
                                        <div>
                                            <a href="{{ route('primary_services.detail', $service->id) }}" class="btn btn-sm btn-primary">
                                                Detail
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
