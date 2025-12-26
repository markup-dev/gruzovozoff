@extends('layouts.app')

@section('title', 'Панель администратора')

@section('content')
<div class="px-4 sm:px-0">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Панель администратора</h1>

    <!-- Фильтры и поиск -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-0">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Поиск</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       placeholder="ID, имя, email, телефон, адрес..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-48">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                <select id="status" name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Все статусы</option>
                    <option value="Новая" {{ request('status') === 'Новая' ? 'selected' : '' }}>Новая</option>
                    <option value="В работе" {{ request('status') === 'В работе' ? 'selected' : '' }}>В работе</option>
                    <option value="Отменена" {{ request('status') === 'Отменена' ? 'selected' : '' }}>Отменена</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Фильтровать
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.dashboard') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Сбросить
                    </a>
                @endif
            </div>
        </form>
    </div>

    @if($applications->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-600">Нет заявок</p>
        </div>
    @else
        <!-- Карточки заявок -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($applications as $application)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200 border border-gray-200">
                    <div class="p-6">
                        <!-- Заголовок карточки -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-blue-600">#{{ $application->id }}</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $application->user->fio ?? $application->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $application->user->email }}</p>
                                </div>
                            </div>

                            <!-- Статус -->
                            <div class="flex-shrink-0">
                                <form action="{{ route('admin.applications.update-status', $application) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                            class="text-xs rounded-full border-0 font-medium
                                            @if($application->status === 'Новая') bg-yellow-100 text-yellow-800
                                            @elseif($application->status === 'В работе') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800
                                            @endif px-3 py-1">
                                        <option value="Новая" {{ $application->status === 'Новая' ? 'selected' : '' }}>Новая</option>
                                        <option value="В работе" {{ $application->status === 'В работе' ? 'selected' : '' }}>В работе</option>
                                        <option value="Отменена" {{ $application->status === 'Отменена' ? 'selected' : '' }}>Отменена</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <!-- Информация о заявке -->
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10h8V11h-2M8 7h8"></path>
                                </svg>
                                {{ $application->transport_datetime->format('d.m.Y H:i') }}
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ $application->cargo_type }} • {{ $application->weight }} кг
                            </div>

                            <div class="flex items-start text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Откуда:</div>
                                    <div>{{ $application->from_address }}</div>
                                </div>
                            </div>

                            <div class="flex items-start text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Куда:</div>
                                    <div>{{ $application->to_address }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Действия -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Создано: {{ $application->created_at->format('d.m.Y H:i') }}</span>
                                <form action="{{ route('admin.applications.destroy', $application) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить эту заявку?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="mt-8 flex justify-center">
            {{ $applications->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
