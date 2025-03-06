<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Services;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
	public function index()
    {
        /*** info card ***/
        $clients_count = Clients::count();
        $vehicles_count = Vehicles::count();
        $services_today = Services::where('date',Date::create('now')->format('Y-m-d'))->count();
        $services_cost_month = Services::whereMonth('date', Date::now()->month)
            ->whereYear('date', Date::now()->year)
            ->sum('cost');
        $services_month = Services::whereMonth('date', Date::now()->month)
            ->whereYear('date', Date::now()->year)
            ->count();

        /*** grafico ***/
        $monthly_costs = Services::selectRaw('MONTH(date) as month, SUM(cost) as total_cost')
            ->whereYear('date', Date::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_cost', 'month');
        $monthly_data = array_fill(1, 12, 0);
        foreach ($monthly_costs as $month => $total_cost) {
            if($total_cost > 0) {
                $total_cost = $total_cost / 100;
            }
            $monthly_data[$month] = $total_cost;
        }
        $monthly_data = array_values($monthly_data);

        return view('dashboard', [
            'clients_count' => $clients_count,
            'vehicles_count' => $vehicles_count,
            'services_today' => $services_today,
            'services_cost_month' => $services_cost_month,
            'services_month' => $services_month,
            'monthly_data' => $monthly_data,
        ]);
    }

    /**
     * funzione api per prendere gli interventi nell'intervallo di date passato da full calendar
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventsCalendar(Request $request)
    {
        $data_da = $request->input('data_da', Date::now()->startOfMonth()->format('Y-m-d'));
        $data_a = $request->input('data_a', Date::now()->endOfMonth()->format('Y-m-d'));

        $services = Services::with('vehicle')
            ->whereBetween('date', [$data_da, $data_a])
            ->get();

        $events = [];
        foreach ($services as $service) {
            $events[] = [
                'title' => $service->vehicle->client->name . ' - ' . $service->vehicle->license_plate . " - " . $service->description,
                'start' => $service->date,
                'url' => route('clients.show',$service->vehicle->client_id),
            ];
        }

        return response()->json($events);
    }

}
