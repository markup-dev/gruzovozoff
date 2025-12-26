<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Проверка, что пользователь - администратор
        if (Auth::user()->login !== 'admin') {
            return redirect()->route('applications.index')->with('error', 'Доступ запрещен');
        }

        $query = Application::with('user');

        // Фильтр по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Поиск по ID, имени пользователя, email или адресу
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('fio', 'like', "%{$search}%")
                                ->orWhere('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhere('from_address', 'like', "%{$search}%")
                  ->orWhere('to_address', 'like', "%{$search}%");
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.dashboard', compact('applications'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        if (Auth::user()->login !== 'admin') {
            return redirect()->route('applications.index')->with('error', 'Доступ запрещен');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:Новая,В работе,Отменена'],
        ]);

        $application->update(['status' => $validated['status']]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Статус заявки обновлен');
    }

    public function destroy(Application $application)
    {
        if (Auth::user()->login !== 'admin') {
            return redirect()->route('applications.index')->with('error', 'Доступ запрещен');
        }

        $application->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Заявка удалена');
    }
}
