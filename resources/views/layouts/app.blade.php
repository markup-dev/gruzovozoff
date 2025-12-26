<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Грузовозофф')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('applications.index') }}" class="text-xl font-bold text-gray-900">
                        Грузовозофф
                    </a>
                </div>
                <!-- Desktop меню -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        @if(Auth::user()->login === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Панель администратора
                            </a>
                        @endif
                        <a href="{{ route('applications.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Мои заявки
                        </a>
                        <a href="{{ route('applications.create') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Новая заявка
                        </a>
                        <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Выйти
                            </button>
                        </form>
                    @else
                        <a href="{{ route('auth.login') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Войти
                        </a>
                        <a href="{{ route('auth.register') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">
                            Регистрация
                        </a>
                    @endauth
                </div>

                <!-- Мобильная кнопка меню -->
                <div class="md:hidden flex items-center">
                    <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-gray-900 focus:outline-none focus:text-gray-900 p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Мобильное меню -->
    <div id="mobile-menu" class="md:hidden hidden absolute top-16 left-0 right-0 bg-white border-b shadow-lg z-50">
        <div class="px-4 py-2 space-y-1">
            @auth
                @if(Auth::user()->login === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        Панель администратора
                    </a>
                @endif
                <a href="{{ route('applications.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Мои заявки
                </a>
                <a href="{{ route('applications.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Новая заявка
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('auth.login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Войти
                </a>
                <a href="{{ route('auth.register') }}" class="block px-3 py-2 rounded-md text-base font-medium bg-blue-600 text-white hover:bg-blue-700">
                    Регистрация
                </a>
            @endauth
        </div>
    </div>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>

