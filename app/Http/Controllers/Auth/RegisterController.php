<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Validation\ValidationException;

 use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {

        return view('auth.register');
    }

    public function createUserStore(Request $request)
{
    try {
        // Валидация данных, полученных из запроса
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'], // Добавляем правило unique
            'password' => ['required', 'string'],
        ]);

        // Создание нового пользователя
        $user = new User([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);

        // Сохранение пользователя в базе данных
        $user->save();

        // Другая логика (например, отправка подтверждения по электронной почте и т.д.)

        // Перенаправление после успешной регистрации
        return redirect('/home')->with('success', 'Регистрация успешно завершена!');
    } catch (ValidationException $e) {
        // Обработка ошибок валидации (например, если данные не прошли валидацию)
        return redirect()->back()->withInput()->withErrors($e->errors());
    } catch (UniqueConstraintViolationException $e) {
        // Обработка ошибки уникальности email
        return redirect()->back()->withInput()->withErrors(['email' => 'Такой пользователь уже существует.']);
    } catch (QueryException $e) {
        // Обработка других исключений базы данных, если необходимо
        return redirect()->back()->withInput()->withErrors(['error' => 'Произошла ошибка при регистрации.']);
    }
}

}