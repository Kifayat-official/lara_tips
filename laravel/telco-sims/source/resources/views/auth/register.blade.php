@extends('auth.layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form action="{{ route('store') }}" method="post">
                        @csrf
                        {{-- <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div> --}}
                        <div class="mb-3 row">
                            <label for="username" class="col-md-4 col-form-label text-md-end text-start">User Name</label>
                            <div class="col-md-6">
                                <input type="username" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="region_code" class="col-md-4 col-form-label text-md-end text-start">Region
                                Code</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('region_code') is-invalid @enderror"
                                    id="region_code" name="region_code" value="{{ old('region_code') }}">
                                @if ($errors->has('region_code'))
                                    <span class="text-danger">{{ $errors->first('region_code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="region_name" class="col-md-4 col-form-label text-md-end text-start">Region
                                Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('region_name') is-invalid @enderror"
                                    id="region_name" name="region_name" value="{{ old('region_name') }}">
                                @if ($errors->has('region_name'))
                                    <span class="text-danger">{{ $errors->first('region_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password_confirmation"
                                class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Register">
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
