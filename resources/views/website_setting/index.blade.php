@extends('layouts.app')
@section('title', 'Website Setting')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Website Setting</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-0 fw-semibold text-uppercase">Website Setting & Third Api :</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('website-settings.saveOrUpdate') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="web_name">Website Name</label>
                            <input type="text" name="web_name" class="form-control"
                                value="{{ old('web_name', $setting->web_name ?? '') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="web_description">Website Description</label>
                            <input type="text" name="web_description" class="form-control"
                                value="{{ old('web_description', $setting->web_description ?? '') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="web_logo">Website Logo</label>
                            <input type="file" name="web_logo" class="form-control">
                            @if ($setting && $setting->web_logo)
                                <img src="{{ asset('storage/'.$setting->web_logo) }}" alt="Website Logo"
                                    style="max-width: 100px;" class="mt-2">
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="web_favicon">Website Favicon</label>
                            <input type="file" name="web_favicon" class="form-control">
                            @if ($setting && $setting->web_favicon)
                                <img src="{{ asset('storage/'.$setting->web_favicon) }}" alt="Website Favicon"
                                    style="max-width: 32px;" class="mt-2">
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="irvan_url">Irvan URL</label>
                            <input type="text" name="irvan_url" class="form-control"
                                value="{{ old('irvan_url', $setting->irvan_url ?? '') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="irvan_app_id">Irvan App ID</label>
                            <input type="text" name="irvan_app_id" class="form-control"
                                value="{{ old('irvan_app_id', $setting->irvan_app_id ?? '') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="irvan_app_key">Irvan App Key</label>
                            <input type="text" name="irvan_app_key" class="form-control"
                                value="{{ old('irvan_app_key', $setting->irvan_app_key ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
