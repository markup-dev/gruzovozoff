<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required', 'string', 'min:6', 'unique:users,login', 'regex:/^[а-яёА-ЯЁ]+$/u'],
            'fio' => ['required', 'string', 'regex:/^[а-яёА-ЯЁ\s]+$/u'],
            'phone' => ['required', 'string', 'regex:/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'login.required' => 'Логин обязателен для заполнения',
            'login.min' => 'Логин должен содержать минимум 6 символов',
            'login.unique' => 'Такой логин уже существует',
            'login.regex' => 'Логин должен содержать только кириллицу',
            'fio.required' => 'ФИО обязательно для заполнения',
            'fio.regex' => 'ФИО должно содержать только кириллицу и пробелы',
            'phone.required' => 'Телефон обязателен для заполнения',
            'phone.regex' => 'Телефон должен быть в формате +7(XXX)-XXX-XX-XX',
            'email.required' => 'Email обязателен для заполнения',
            'email.email' => 'Email должен быть в правильном формате',
            'email.unique' => 'Такой email уже зарегистрирован',
            'password.required' => 'Пароль обязателен для заполнения',
            'password.min' => 'Пароль должен содержать минимум 6 символов',
        ]);

        $user = User::create([
            'login' => $validated['login'],
            'name' => $validated['login'],
            'fio' => $validated['fio'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('applications.index')->with('success', 'Регистрация успешна!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Логин обязателен для заполнения',
            'password.required' => 'Пароль обязателен для заполнения',
        ]);

        // Проверка для администратора
        if ($credentials['login'] === 'admin' && $credentials['password'] === 'gruzovik2024') {
            $admin = User::where('login', 'admin')->first();
            if (!$admin) {
                $admin = User::create([
                    'login' => 'admin',
                    'name' => 'admin',
                    'fio' => 'Администратор',
                    'phone' => '+7(999)-999-99-99',
                    'email' => 'admin@gruzovozoff.ru',
                    'password' => Hash::make('gruzovik2024'),
                ]);
            }
            Auth::login($admin);
            return redirect()->route('admin.dashboard')->with('success', 'Добро пожаловать, администратор!');
        }

        $user = User::where('login', $credentials['login'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('applications.index')->with('success', 'Вы успешно вошли в систему');
        }

        return back()->withErrors([
            'login' => 'Неверный логин или пароль',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login')->with('success', 'Вы вышли из системы');
    }
}