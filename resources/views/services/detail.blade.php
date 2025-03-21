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
                    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
    
                        <!-- Name (Readonly) -->
                        <div class="form-group mb-2">
                            <label for="serviceName">Service Name</label>
                            <input type="text" id="serviceName" class="form-control" value="{{ $service->name }}" readonly>
                        </div>
    
                        <!-- Min (Editable) -->
                        <div class="form-group mb-2">
                            <label for="min">Minimum</label>
                            <input type="number" id="min" name="min" class="form-control" value="{{ $service->min }}">
                        </div>
    
                        <!-- Max (Editable) -->
                        <div class="form-group mb-2">
                            <label for="max">Maximum</label>
                            <input type="number" id="max" name="max" class="form-control" value="{{ $service->max }}">
                        </div>
    
                        <!-- Price (Editable) -->
                        <div class="form-group mb-2">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ $service->price }}">
                        </div>
    
                        <!-- Refill Status (Editable) -->
                        <div class="form-group mb-2">
                            <label for="refill">Refill</label>
                            <select id="refill" name="refill" class="form-control">
                                <option value="1" {{ $service->refill ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$service->refill ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
    
                        <!-- Other fields as Readonly -->
                        <div class="form-group mb-2">
                            <label for="serviceType">Type</label>
                            <input type="text" id="serviceType" class="form-control" value="{{ $service->type }}" readonly>
                        </div>
    
                        <div class="form-group mb-2">
                            <label for="serviceCode">Service Code</label>
                            <input type="text" id="serviceCode" class="form-control" value="{{ $service->service_code }}" readonly>
                        </div>
    
                        <!-- Submit button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
