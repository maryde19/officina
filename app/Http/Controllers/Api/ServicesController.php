<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Services;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{

    const ROWS_PER_PAGE = 15;
	public function __construct()
	{
	}

    /**
     * Lista interventi
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServices(Request $request)
    {
        $services = Services::with('vehicle')
            ->when($request->client_id != null, function ($query) use ($request) {
                return $query->whereHas('vehicle', function ($q) use ($request) {
                    $q->where('client_id', $request->client_id);
                });
            })
            ->when($request->search != null, function ($query) use ($request) {
                return $query->whereHas('vehicle', function ($q) use ($request) {
                    $q->where('brand', 'like', '%' . $request->search . '%')
                        ->orWhere('model', 'like', '%' . $request->search . '%')
                        ->orWhere('license_plate', 'like', '%' . $request->search . '%');
                })
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('date', 'like', '%' . $request->search . '%');
            })
            ->orderByDesc('date')
            ->paginate(self::ROWS_PER_PAGE);

        return response()->json($services);
    }

    /**
     * Salvataggio intervento
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'vehicle_id' => 'required|integer|exists:vehicles,id',
                'description' => 'required|string|max:255',
                'cost' => 'required',
            ];

            $messages = [
                'description.required' => 'La descrizione è obbligatoria.',
                'description.string' => 'La descrizione deve essere un testo.',
                'description.max' => 'La descrizione non può superare i 255 caratteri.',

                'cost.required' => 'Il costo è obbligatorio.',
            ];


            $validation = $request->validate($rules,$messages);
            $service = Services::create([
                'vehicle_id' => $request->vehicle_id,
                'description' => $request->description,
                'cost' => round($request->cost*100),
                'date' => Date::createFromFormat('d/m/Y',$request->date)->format('Y-m-d'),
            ]);

            DB::commit();
            return ['success'=>true,'result'=>$service->toArray()];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success'=>false,'message'=> $e->getMessage()];
        }

    }

    /**
     * Eliminazione intervento
     * @param $id
     * @return array|true[]
     */
    public function destroy($id)
    {
        try {
            $service = Services::find($id);
            $service->delete();

            return ['success'=>true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success'=>false,'message'=> $e->getMessage()];
        }

    }

}
