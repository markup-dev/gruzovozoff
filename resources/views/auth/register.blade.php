@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Регистрация</h1>

    <form action="{{ route('auth.register') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Логин (кириллица, не менее 6 символов)</label>
            <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="Введите логин"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('login') border-red-500 @enderror" required>
            @error('login')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="fio" class="block text-sm font-medium text-gray-700 mb-1">ФИО</label>
            <input type="text" id="fio" name="fio" value="{{ old('fio') }}" placeholder="Иванов Иван Иванович"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fio') border-red-500 @enderror" required>
            @error('fio')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Телефон (+7(XXX)-XXX-XX-XX)</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+7(999)-123-45-67"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" required>
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="example@email.com"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" required>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Пароль (минимум 6 символов)</label>
            <input type="password" id="password" name="password" placeholder="Введите пароль"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" required>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium">
            Зарегистрироваться
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Уже есть аккаунт? <a href="{{ route('auth.login') }}" class="text-blue-600 hover:text-blue-800">Войти</a>
    </p>
</div>
@endsection
