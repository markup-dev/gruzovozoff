@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Вход</h1>
    
    <form action="{{ route('auth.login') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Логин</label>
            <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="Введите логин"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('login') border-red-500 @enderror" required>
            @error('login')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Пароль</label>
            <input type="password" id="password" name="password" placeholder="Введите пароль"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" required>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium">
            Войти
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Нет аккаунта? <a href="{{ route('auth.register') }}" class="text-blue-600 hover:text-blue-800">Зарегистрироваться</a>
    </p>
</div>
@endsection
