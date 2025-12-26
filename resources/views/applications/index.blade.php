@extends('layouts.app')

@section('title', 'Мои заявки')

@section('content')
<div class="px-4 sm:px-0">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Мои заявки</h1>
        <a href="{{ route('applications.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">
            Создать заявку
        </a>
    </div>

    @if($applications->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-600 mb-4">У вас пока нет заявок</p>
            <a href="{{ route('applications.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">
                Создать первую заявку
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($applications as $application)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Заявка #{{ $application->id }}</h3>
                            <p class="text-sm text-gray-600">Создана: {{ $application->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($application->status === 'Новая') bg-yellow-100 text-yellow-800
                            @elseif($application->status === 'В работе') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $application->status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Дата и время перевозки:</p>
                            <p class="font-medium">{{ $application->transport_datetime->format('d.m.Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Тип груза:</p>
                            <p class="font-medium">{{ $application->cargo_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Вес груза:</p>
                            <p class="font-medium">{{ $application->weight }} кг</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Габариты:</p>
                            <p class="font-medium">{{ $application->dimensions }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Откуда:</p>
                            <p class="font-medium">{{ $application->from_address }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Куда:</p>
                            <p class="font-medium">{{ $application->to_address }}</p>
                        </div>
                    </div>

                    @if($application->review)
                        <div class="mt-4 p-4 bg-gray-50 rounded-md">
                            <p class="text-sm font-medium text-gray-700 mb-2">Ваш отзыв:</p>
                            <p class="text-gray-600">{{ $application->review->review_text }}</p>
                        </div>
                    @elseif(in_array($application->status, ['Отменена', 'В работе']))
                        <div class="mt-4">
                            <form action="{{ route('applications.review', $application) }}" method="POST">
                                @csrf
                                <label for="review_text_{{ $application->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                    Оставить отзыв о качестве услуг
                                </label>
                                <textarea id="review_text_{{ $application->id }}" name="review_text" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('review_text') border-red-500 @enderror"
                                          required>{{ old('review_text') }}</textarea>
                                @error('review_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="mt-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-medium text-sm">
                                    Отправить отзыв
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

