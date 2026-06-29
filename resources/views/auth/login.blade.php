{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')
@section('title', 'Login — FloraFetch')
@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="text-center mb-8">
        <span class="text-5xl">🌿</span>
        <h1 class="text-2xl font-bold text-gray-800 mt-3">Welcome Back</h1>
        <p class="text-gray-500 text-sm mt-1">Sign in to your FloraFetch account</p>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox" name="remember" class="accent-flora-600"> Remember me
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-flora-600 text-white py-3 rounded-xl font-semibold hover:bg-flora-700 transition">
                Log In
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-flora-600 font-medium hover:underline">Sign up free</a>
        </p>
    </div>
</div>
@endsection
