<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::where('user_id', Auth::id())
            ->with('review')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transport_datetime' => ['required', 'date', 'after:now'],
            'weight' => ['required', 'numeric', 'min:0.01'],
            'dimensions' => ['required', 'string'],
            'from_address' => ['required', 'string'],
            'to_address' => ['required', 'string'],
            'cargo_type' => ['required', 'string', 'in:хрупкое,скоропортящееся,требуется рефрижератор,животные,жидкость,мебель,мусор'],
        ], [
            'transport_datetime.required' => 'Дата и время перевозки обязательны',
            'transport_datetime.after' => 'Дата и время должны быть в будущем',
            'weight.required' => 'Вес груза обязателен',
            'weight.numeric' => 'Вес должен быть числом',
            'weight.min' => 'Вес должен быть больше 0',
            'dimensions.required' => 'Габариты груза обязательны',
            'from_address.required' => 'Адрес отправления обязателен',
            'to_address.required' => 'Адрес доставки обязателен',
            'cargo_type.required' => 'Тип груза обязателен',
            'cargo_type.in' => 'Выберите тип груза из списка',
        ]);

        $application = Application::create([
            'user_id' => Auth::id(),
            'transport_datetime' => $validated['transport_datetime'],
            'weight' => $validated['weight'],
            'dimensions' => $validated['dimensions'],
            'from_address' => $validated['from_address'],
            'to_address' => $validated['to_address'],
            'cargo_type' => $validated['cargo_type'],
            'status' => 'Новая',
        ]);

        return redirect()->route('applications.index')
            ->with('success', 'Заявка успешно создана и отправлена на рассмотрение администратору');
    }

    public function storeReview(Request $request, Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            return redirect()->route('applications.index')->with('error', 'Доступ запрещен');
        }

        $validated = $request->validate([
            'review_text' => ['required', 'string', 'min:10'],
        ], [
            'review_text.required' => 'Текст отзыва обязателен',
            'review_text.min' => 'Отзыв должен содержать минимум 10 символов',
        ]);

        Review::updateOrCreate(
            ['application_id' => $application->id, 'user_id' => Auth::id()],
            ['review_text' => $validated['review_text']]
        );

        return redirect()->route('applications.index')
            ->with('success', 'Отзыв успешно сохранен');
    }
}
