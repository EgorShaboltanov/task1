<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        // $hashedPassword = bcrypt('Egor.Shaboltanov2020@gmail.com');
        // dd($hashedPassword);
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


            public function store(Request $request)
        {

            // Валидация данных, полученных из запроса
            $credintials = $request->validate([
                'email' => ['required', 'string', 'email'], // Поле "email" обязательно, должно быть строкой и соответствовать формату email
                'password' => ['required', 'string'], // Поле "password" обязательно и должно быть строкой
            ]);

            // Вывести содержимое массива $data для отладки
            var_dump($credintials);
            

            if (! Auth::attempt($credintials, $request->boolean('remember'))) {
                throw ValidationException::withMessages([
                    'email' => 'Неверный email!',
                    'password' => 'Неверный пароль!',
                ]);
            }


            $request->session()->regenerate();
            return redirect()->intended('/home');
        }
          
            // ---------------------------------------------------------------------------

             // $request->authenticate();

        // // $request->session()->regenerate();

        // // return redirect(RouteServiceProvider::HOME);

          // В данной части кода, которая закомментирована, обычно выполняется следующее:
            
            // 1. $request->authenticate(): Этот метод пытается аутентифицировать пользователя на основе предоставленных данных.
            //    Если данные верны, пользователь считается аутентифицированным, и создается сеанс для него.
            
            // 2. $request->session()->regenerate(): Этот метод обычно вызывается после успешной аутентификации, чтобы обновить сеанс.
            //    Это помогает предотвратить атаки, связанные с уязвимостями в сеансах.
            
            // 3. return redirect(RouteServiceProvider::HOME): Если аутентификация прошла успешно, пользователь перенаправляется на защищенную страницу,
            //    определенную в RouteServiceProvider::HOME (обычно это главная страница после входа в систему).

    


    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
    // Выход пользователя из системы начинается здесь.

    // 1. Auth::guard('web')->logout();
    // Эта строка вызывает метод logout() для аутентификационной группы 'web'.
    // Это означает, что текущий пользователь ('web') будет выведен из системы.

    Auth::guard('web')->logout();

    // 2. $request->session()->invalidate();
    // Этот код вызывает метод invalidate() для сеанса пользователя, хранящегося в объекте $request.
    // Это гарантирует, что текущий сеанс пользователя будет завершен и больше не будет действителен.

    $request->session()->invalidate();

    // 3. $request->session()->regenerateToken();
    // Эта строка вызывает метод regenerateToken() для объекта сеанса пользователя.
    // Она генерирует новый CSRF-токен (Cross-Site Request Forgery) для защиты от CSRF-атак.

    $request->session()->regenerateToken();

    // 4. return redirect('/');
    // После успешного выхода пользователя, происходит перенаправление на главную страницу ('/').

    return redirect('/');
}

}