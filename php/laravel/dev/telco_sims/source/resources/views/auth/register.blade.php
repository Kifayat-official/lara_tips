{{-- @extends('auth.layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form action="{{ route('store') }}" method="post">
                        @csrf

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

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection --}}


@extends('auth.layouts')

@section('content')
    <div class="flex justify-center mt-5">
        <div class="w-full md:w-8/12">

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="text-xl font-bold mb-4">Register</div>
                <div class="mb-4">
                    <form action="{{ route('store') }}" method="post">
                        @csrf

                        <div class="mb-4 flex flex-col md:flex-row">
                            <label for="username" class="md:w-4/12 md:text-right mb-2 md:mb-0">User Name</label>
                            <input type="username"
                                class="w-full p-2 border rounded @error('username') border-red-500 @enderror" id="username"
                                name="username" value="{{ old('username') }}">
                            @if ($errors->has('username'))
                                <span class="text-red-500">{{ $errors->first('username') }}</span>
                            @endif
                        </div>

                        <div class="mb-4 flex flex-col md:flex-row">
                            <label for="region_code" class="md:w-4/12 md:text-right mb-2 md:mb-0">Region Code</label>
                            <input type="text"
                                class="w-full p-2 border rounded @error('region_code') border-red-500 @enderror"
                                id="region_code" name="region_code" value="{{ old('region_code') }}">
                            @if ($errors->has('region_code'))
                                <span class="text-red-500">{{ $errors->first('region_code') }}</span>
                            @endif
                        </div>

                        <div class="mb-4 flex flex-col md:flex-row">
                            <label for="region_name" class="md:w-4/12 md:text-right mb-2 md:mb-0">Region Name</label>
                            <input type="text"
                                class="w-full p-2 border rounded @error('region_name') border-red-500 @enderror"
                                id="region_name" name="region_name" value="{{ old('region_name') }}">
                            @if ($errors->has('region_name'))
                                <span class="text-red-500">{{ $errors->first('region_name') }}</span>
                            @endif
                        </div>

                        <div class="mb-4 flex flex-col md:flex-row">
                            <label for="password" class="md:w-4/12 md:text-right mb-2 md:mb-0">Password</label>
                            <input type="password"
                                class="w-full border-4 border-gray-300 rounded p-2 @error('password') border-red-500 @enderror"
                                id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-red-500">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="mb-4 flex flex-col md:flex-row">
                            <label for="password_confirmation" class="md:w-4/12 md:text-right mb-2 md:mb-0">Confirm
                                Password</label>
                            <input type="password" class="w-full border-4 border-gray-300 rounded p-2"
                                id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="mb-4 flex justify-center">
                            <input type="submit"
                                class="w-1/3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                value="Register">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
