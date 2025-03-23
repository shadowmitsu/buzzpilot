@extends('layouts.app')
@section('title', 'Digital Platforms Management')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Digital Platforms</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header border-bottom border-light">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-lg-6">
                            <h4 class="title">Digital Platforms</h4>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal"
                                data-bs-target="#addDigitalPlatformModal">
                                Add Digital Platform
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($digitalPlatforms as $platform)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $platform->name }}</td>
                                    <td><img src="{{ asset('storage/'.$platform->icon) }}" alt="{{ $platform->name }} icon"
                                            style="width: 50px;"></td>

                                    <td>{{ $platform->status ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editDigitalPlatformModal"
                                            onclick="setEditModalData({{ $platform->id }}, '{{ $platform->name }}', '{{ $platform->icon }}', {{ $platform->status }})">
                                            Edit
                                        </button>

                                        <form action="{{ route('digital_platforms.destroy', $platform->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header border-bottom border-light">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-lg-6">
                            <h4 class="title">Interaction Types</h4>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal"
                                data-bs-target="#addInteractionTypeModal">
                                Add Intercation Type
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($interactionTypes as $interaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $interaction->name }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editInteractionTypeModal"
                                            onclick="setEditModalDataInteraction({{ $interaction->id }}, '{{ $interaction->name }}')">
                                            Edit
                                        </button>

                                        <form action="{{ route('interaction_types.destroy', $interaction->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('digital_platforms.modal_digital')
    @include('digital_platforms.modal_intercation')


    <script>
        function setEditModalData(id, name, icon, status) {
            document.getElementById('name_edit').value = name;
            document.getElementById('icon_edit').value = icon;
            document.getElementById('status_edit').value = status;

            document.getElementById('editDigitalPlatformForm').action = `/digital-platforms/${id}/update`;
        }
    </script>

    <script>
        function setEditModalDataInteraction(id, name, icon, status) {
            document.getElementById('name_interaction').value = name;

            document.getElementById('editInteractionTypeForm').action = `/interaction-types/${id}/update`;
        }
    </script>
@endsection
