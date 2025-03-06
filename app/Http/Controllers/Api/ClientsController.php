<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{

    const ROWS_PER_PAGE = 15;
	public function __construct()
	{
	}

    /**
     * Lista clienti
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClients(Request $request)
    {
        $clients = Clients::when($request->search != null, function ($query) use($request){
                                return $query->where('name', 'like', '%'.$request->search.'%')
                                    ->orWhere('phone', 'like', '%'.$request->search.'%')
                                    ->orWhere('email', 'like', '%'.$request->search.'%')
                                    ->orWhere('address', 'like', '%'.$request->search.'%');
                            })
                            ->orderBy('name')
                            ->paginate(self::ROWS_PER_PAGE);
        return response()->json($clients);
    }

    /**
     * Salvataggio cliente
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'name' => 'required|min:3',
                'email' => 'sometimes|nullable|email',
            ];

            $messages = [
                'name.required' => 'Il nome è obbligatorio.',
                'name.min' => 'Il nome deve avere almeno 3 caratteri.',
                'email.email' => 'Inserisci un indirizzo email valido.',
            ];

            $validation = $request->validate($rules,$messages);
            $client = Clients::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ]);

            DB::commit();
            return ['success'=>true,'result'=>$client->toArray()];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success'=>false,'message'=> $e->getMessage()];
        }

    }

    /**
     * Modifica cliente
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'name' => 'required|min:3',
                'email' => 'sometimes|nullable|email',
            ];

            $messages = [
                'name.required' => 'Il nome è obbligatorio.',
                'name.min' => 'Il nome deve avere almeno 3 caratteri.',
                'email.email' => 'Inserisci un indirizzo email valido.',
            ];
            $validation = $request->validate($rules,$messages);

            $client = Clients::find($id);

            $client->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ]);

            DB::commit();
            return ['success'=>true,'result'=>$client->toArray()];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success'=>false,'message'=> $e->getMessage()];
        }
    }

    /**
     * Eliminazione cliente
     * @param $id
     * @return array|true[]
     */
    public function destroy($id)
    {
        try {
            $client = Clients::find($id);
            $client->delete();

            return ['success'=>true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success'=>false,'message'=> $e->getMessage()];
        }

    }



}
