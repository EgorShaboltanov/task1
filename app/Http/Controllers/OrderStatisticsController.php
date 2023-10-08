<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderStatisticsController extends Controller
{
    public function orderStatistics()
    {

        $user = Auth::user(); // Получаем текущего авторизованного пользователя

        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        $statistics = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as order_date'),
                DB::raw('earnings as total_earnings'),
                DB::raw('total_time as total_hours_worked')
            )
            ->where('status', 'confirmed')
            ->where('provider_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('order_date', 'asc') // Добавляем сортировку по дате
            ->get();

            // dd($statistics);
        return view('statistics.index', compact('statistics'));
        // return view('register');
    }
}
