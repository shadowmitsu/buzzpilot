@extends('layouts.app')
@section('title', 'Data Service Categories')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Service Categories</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('category-services.bulk-delete') }}" method="POST" id="bulkDeleteForm">
                    
                    @csrf
                    <div class="card-header border-bottom border-light">
                        <div class="row justify-content-between g-3">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="title mb-0">Service Categories</h4>
                                    <button type="submit" class="btn btn-danger">Bulk Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll"> <!-- Select all checkbox -->
                                    </th>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Icon</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $category->id }}" class="selectCategory">
                                        </td>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>
                                            @if ($category->icon_path)
                                                <img src="{{ asset($category->icon_path) }}" alt="Icon" width="30" height="30">
                                            @else
                                                <span class="text-muted">No Icon</span>
                                            @endif
                                        </td>
                                        <td>
                                            <h5 class="mb-0">
                                                <span class="badge {{ $category->status == 1 ? 'badge-soft-success' : 'badge-soft-warning' }} fs-11 p-1">
                                                    {{ $category->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </h5>
                                        </td>
                                        <td>{{ $category->created_at->format('d M Y') }}</td>
                                        <td class="pe-3 text-center">
                                            <div class="hstack gap-1 justify-content-end">
                                                <!-- Toggle Status Button -->
                                                <form action="{{ route('category-services.toggle-status', $category->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-soft-warning btn-icon btn-sm rounded-circle">
                                                        <i class="ti ti-refresh"></i>
                                                    </button>
                                                </form>
                
                                                <!-- Single Delete Button -->
                                                <form action="{{ route('category-services.delete', $category->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-soft-danger btn-icon btn-sm rounded-circle">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No categories available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
                <script>
                    document.getElementById('selectAll').addEventListener('change', function(e) {
                        const checkboxes = document.querySelectorAll('.selectCategory');
                        checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
                    });
                </script>

                <div class="card-footer d-flex align-items-center justify-content-end">
                    <ul class="pagination justify-content-center mb-0">
                        <!-- Previous Page Link -->
                        <li class="page-item {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                            <a href="{{ $categories->previousPageUrl() }}" class="page-link"><i
                                    class="ti ti-chevrons-left"></i></a>
                        </li>
                        @for ($i = 1; $i <= 3; $i++)
                            @if ($i <= $categories->lastPage())
                                <li class="page-item {{ $i == $categories->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $categories->url($i) }}" class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        @if ($categories->currentPage() > 4)
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        @endif
                        @for ($i = max(4, $categories->currentPage() - 1); $i <= min($categories->lastPage() - 3, $categories->currentPage() + 1); $i++)
                            <li class="page-item {{ $i == $categories->currentPage() ? 'active' : '' }}">
                                <a href="{{ $categories->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($categories->currentPage() < $categories->lastPage() - 3)
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        @endif
                        @for ($i = $categories->lastPage() - 2; $i <= $categories->lastPage(); $i++)
                            @if ($i > 3)
                                <li class="page-item {{ $i == $categories->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $categories->url($i) }}" class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        <li class="page-item {{ $categories->hasMorePages() ? '' : 'disabled' }}">
                            <a href="{{ $categories->nextPageUrl() }}" class="page-link"><i
                                    class="ti ti-chevrons-right"></i></a>
                        </li>
                    </ul>
                </div>


            </div>
        </div>
    </div>
@endsection
