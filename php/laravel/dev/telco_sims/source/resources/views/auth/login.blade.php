@extends('auth.layouts')

@section('content')
    <div class="flex justify-center mt-10">
        <div class="w-full md:w-2/3">
            <div class="border border-gray-300 rounded shadow-lg">
                <div class="bg-gray-100 p-4 font-bold">Login</div>
                <div class="p-6">
                    <form action="{{ route('authenticate') }}" method="post">
                        @csrf
                        <div class="mb-4 flex flex-wrap">
                            <label for="region_code" class="w-1/3 md:w-1/4 text-left md:text-left px-4">Region Code</label>
                            <div class="w-2/3 md:w-1/2">
                                <input type="region_code"
                                    class="border-2 border-gray-300 focus:border-gray-500 focus:outline-none w-full rounded p-2 @error('region_code') border-red-500 @enderror"
                                    id="region_code" name="region_code" value="{{ old('region_code') }}">
                                @if ($errors->has('region_code'))
                                    <span class="text-red-500">{{ $errors->first('region_code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 flex flex-wrap">
                            <label for="username" class="w-1/3 md:w-1/4 text-left md:text-left px-4">User Name</label>
                            <div class="w-2/3 md:w-1/2">
                                <input type="username"
                                    class="border-2 border-gray-300 focus:border-gray-500 focus:outline-none w-full rounded p-2 @error('username') border-red-500 @enderror"
                                    id="username" name="username" value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <span class="text-red-500">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 flex flex-wrap">
                            <label for="password" class="w-1/3 md:w-1/4 text-left md:text-left px-4">Password</label>
                            <div class="w-2/3 md:w-1/2">
                                <input type="password"
                                    class="border-2 border-gray-300 focus:border-gray-500 focus:outline-none w-full rounded p-2 @error('password') border-red-500 @enderror"
                                    id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-red-500">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-center mt-4">
                            <input type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
