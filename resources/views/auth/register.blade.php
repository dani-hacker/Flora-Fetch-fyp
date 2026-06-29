@extends('layouts.app')
@section('title', 'Sign Up — FloraFetch')
@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="text-center mb-8">
        <span class="text-5xl">🌱</span>
        <h1 class="text-2xl font-bold text-gray-800 mt-3">Create Your Account</h1>
        <p class="text-gray-500 text-sm mt-1">Join FloraFetch and find your green companion</p>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Min 8 characters with letters and numbers</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
            </div>

            <button type="submit"
                    class="w-full bg-flora-600 text-white py-3 rounded-xl font-semibold hover:bg-flora-700 transition">
                🌿 Create Account
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            Already have an account?
            <a href="{{ route('login') }}" class="text-flora-600 font-medium hover:underline">Log in</a>
        </p>
    </div>
</div>
@endsection
