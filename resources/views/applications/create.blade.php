@extends('layouts.app')

@section('title', 'Создание заявки')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Создание заявки на перевозку</h1>

    <form action="{{ route('applications.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="transport_datetime" class="block text-sm font-medium text-gray-700 mb-1">Дата и время перевозки</label>
            <input type="datetime-local" id="transport_datetime" name="transport_datetime" value="{{ old('transport_datetime') }}" placeholder="Выберите дату и время"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('transport_datetime') border-red-500 @enderror" required>
            @error('transport_datetime')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Вес груза (кг, приблизительный)</label>
            <input type="number" id="weight" name="weight" step="0.01" min="0.01" value="{{ old('weight') }}" placeholder="100.5"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('weight') border-red-500 @enderror" required>
            @error('weight')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-1">Габариты груза</label>
            <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions') }}" placeholder="Например: 100x50x30 см"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('dimensions') border-red-500 @enderror" required>
            @error('dimensions')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cargo_type" class="block text-sm font-medium text-gray-700 mb-1">Тип груза</label>
            <select id="cargo_type" name="cargo_type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cargo_type') border-red-500 @enderror" required>
                <option value="">Выберите тип груза</option>
                <option value="хрупкое" {{ old('cargo_type') === 'хрупкое' ? 'selected' : '' }}>Хрупкое</option>
                <option value="скоропортящееся" {{ old('cargo_type') === 'скоропортящееся' ? 'selected' : '' }}>Скоропортящееся</option>
                <option value="требуется рефрижератор" {{ old('cargo_type') === 'требуется рефрижератор' ? 'selected' : '' }}>Требуется рефрижератор</option>
                <option value="животные" {{ old('cargo_type') === 'животные' ? 'selected' : '' }}>Животные</option>
                <option value="жидкость" {{ old('cargo_type') === 'жидкость' ? 'selected' : '' }}>Жидкость</option>
                <option value="мебель" {{ old('cargo_type') === 'мебель' ? 'selected' : '' }}>Мебель</option>
                <option value="мусор" {{ old('cargo_type') === 'мусор' ? 'selected' : '' }}>Мусор</option>
            </select>
            @error('cargo_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="from_address" class="block text-sm font-medium text-gray-700 mb-1">Адрес отправления</label>
            <input type="text" id="from_address" name="from_address" value="{{ old('from_address') }}" placeholder="г. Москва, ул. Ленина, д. 1"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('from_address') border-red-500 @enderror" required>
            @error('from_address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="to_address" class="block text-sm font-medium text-gray-700 mb-1">Адрес доставки</label>
            <input type="text" id="to_address" name="to_address" value="{{ old('to_address') }}" placeholder="г. Санкт-Петербург, ул. Невский, д. 10"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('to_address') border-red-500 @enderror" required>
            @error('to_address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium">
                Отправить заявку
            </button>
            <a href="{{ route('applications.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 text-center font-medium">
                Отмена
            </a>
        </div>
    </form>
</div>
@endsection
