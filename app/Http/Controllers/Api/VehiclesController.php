<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiclesController extends Controller
{

    const ROWS_PER_PAGE = 1;

    /**
     * Lista veicoli
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVehicles(Request $request)
    {
        $vehicles = Vehicles::with('client')
            ->when($request->client_id != null, function ($query) use ($request) {
                return $query->where('client_id',$request->client_id);
            })
            ->when($request->search != null, function ($query) use ($request) {
                return $query->whereHas('client', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%'); // Filtra per nome cliente
                })
                    ->orWhere('brand', 'like', '%' . $request->search . '%')
                    ->orWhere('model', 'like', '%' . $request->search . '%')
                    ->orWhere('year', 'like', '%' . $request->search . '%')
                    ->orWhere('license_plate', 'like', '%' . $request->search . '%');
            })
            ->orderByDesc('year')
            ->paginate(self::ROWS_PER_PAGE);


        return response()->json($vehicles);
    }

    /**
     * Salvataggio veicoli
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'client_id' => 'required|integer|exists:clients,id',
                'license_plate' => 'required|string|unique:vehicles,license_plate',
            ];

            $messages = [
                'license_plate.required' => 'Il campo Targa è obbligatorio.',
                'license_plate.string' => 'La Targa deve essere un testo.',
                'license_plate.unique' => 'La Targa è già registrata nel sistema.',
            ];

            $validation = $request->validate($rules,$messages);
            $vehicle = Vehicles::create([
                'client_id' => $request->client_id,
                'brand' => $request->brand,
                'model' => $request->model,
                'year' => $request->year,
                'license_plate' => $request->license_plate,
            ]);

            DB::commit();
            return ['success'=>true,'result'=>$vehicle->toArray()];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success'=>false,'message'=> $e->getMessage()];
        }

    }

    /**
     * Eliminazione veicoli
     * @param $id
     * @return array|true[]
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicles::find($id);
            $vehicle->delete();

            return ['success'=>true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success'=>false,'message'=> $e->getMessage()];
        }

    }

}
