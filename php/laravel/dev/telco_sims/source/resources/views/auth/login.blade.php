@extends('auth.layouts')

@section('content')
    <div class="flex justify-center mt-10">

        <div class="w-full md:w-2/3">

            <div class="border rounded shadow-lg">
                <div class="bg-gray-100 p-4 font-bold">Login</div>
                <div class="p-6">
                    <form action="{{ route('authenticate') }}" method="post">
                        @csrf
                        <div class="mb-4 flex flex-wrap">
                            <label for="region_code" class="w-1/3 md:w-1/4 text-right md:text-right px-4">Region Code</label>
                            <div class="w-2/3 md:w-1/2">
                                <input type="region_code"
                                    class="w-full p-2 border rounded @error('region_code') border-red-500 @enderror"
                                    id="region_code" name="region_code" value="{{ old('region_code') }}">
                                @if ($errors->has('region_code'))
                                    <span class="text-danger">{{ $errors->first('region_code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="username" class="col-md-4 col-form-label text-md-end text-start">User Name</label>
                            <div class="col-md-6">
                                <input type="username" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
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
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Login">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
