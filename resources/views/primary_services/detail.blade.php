@extends('layouts.app')
@section('title', 'Detail '.$service->name)
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Service {{ $service->name }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-0 fw-semibold text-uppercase">Detail Service :</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('primary_services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                
                        <div class="form-group mb-2">
                            <label for="service_name">Service Name</label>
                            <input type="text" id="service_name" name="service_name" class="form-control" value="{{ $service->name }}" disabled>
                        </div>
                
                        <div class="form-group mb-2">
                            <label for="old_price">Old Price</label>
                            <input type="text" id="old_price" name="old_price" class="form-control" value="{{ $service->old_price }}" readonly>
                        </div>
                
                        <div class="form-group mb-2">
                            <label for="price">Price</label>
                            <input type="text" id="price" name="price" class="form-control" value="{{ $service->price }}" disabled>
                        </div>
                
                        <div class="form-group mb-2">
                            <label for="min_service">Min</label>
                            <input type="text" id="min_service" name="min_service" class="form-control" value="{{ $service->min }}" disabled>
                        </div>
                
                        <div class="form-group mb-2">
                            <label for="max_service">Max</label>
                            <input type="text" id="max_service" name="max_service" class="form-control" value="{{ $service->max }}" disabled>
                        </div>
                
                        <div class="form-group mb-2">
                            <label for="service_type">Tipe</label>
                            <select name="service_type" class="form-control" id="service_type" disabled>
                                <option value="hemat" {{ $service->type == 'hemat' ? 'selected' : '' }}>Hemat</option>
                                <option value="sultan" {{ $service->type == 'sultan' ? 'selected' : '' }}>Sultan</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-2">
                            <label for="service_status">Tipe</label>
                            <select name="service_status" class="form-control" id="service_status" disabled>
                                <option value="1" {{ $service->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $service->status == '0' ? 'selected' : '' }}>InActive</option>
                            </select>
                        </div>
                
                        <div class="form-group mb-2">
                            <button type="button" id="edit_button" class="btn btn-secondary">Edit</button>
                            <button type="button" id="cancel_button" class="btn btn-danger" style="display: none;">Cancel</button>
                            <button type="submit" id="update_button" class="btn btn-primary" disabled>Update Service</button>
                        </div>
                    </form>
                </div>
                
                <script>
                    const initialData = {
                        serviceName: document.getElementById('service_name').value,
                        price: document.getElementById('price').value,
                        minService: document.getElementById('min_service').value,
                        maxService: document.getElementById('max_service').value,
                        serviceType: document.getElementById('service_type').value,
                        serviceStatus: document.getElementById('service_status').value,
                    };
                
                    document.getElementById('edit_button').addEventListener('click', function() {
                        // Enable all inputs except for Old Price
                        document.getElementById('service_name').disabled = false;
                        document.getElementById('price').disabled = false;
                        document.getElementById('min_service').disabled = false;
                        document.getElementById('max_service').disabled = false;
                        document.getElementById('service_type').disabled = false;
                        document.getElementById('service_status').disabled = false;
                
                        // Enable submit button and show cancel button
                        document.getElementById('update_button').disabled = false;
                        document.getElementById('cancel_button').style.display = 'inline-block';
                
                        // Hide edit button
                        document.getElementById('edit_button').style.display = 'none';
                    });
                
                    document.getElementById('cancel_button').addEventListener('click', function() {
                        // Reset all fields to initial values
                        document.getElementById('service_name').value = initialData.serviceName;
                        document.getElementById('price').value = initialData.price;
                        document.getElementById('min_service').value = initialData.minService;
                        document.getElementById('max_service').value = initialData.maxService;
                        document.getElementById('service_type').value = initialData.serviceType;
                        document.getElementById('service_status').value = initialData.serviceStatus;
                
                        // Disable all inputs except Old Price
                        document.getElementById('service_name').disabled = true;
                        document.getElementById('price').disabled = true;
                        document.getElementById('min_service').disabled = true;
                        document.getElementById('max_service').disabled = true;
                        document.getElementById('service_type').disabled = true;
                        document.getElementById('service_status').disabled = true;
                
                        // Reset buttons
                        document.getElementById('update_button').disabled = true;
                        document.getElementById('edit_button').style.display = 'inline-block';
                        document.getElementById('cancel_button').style.display = 'none';
                    });
                </script>
                
            </div>
        </div>
    </div>
    
@endsection
