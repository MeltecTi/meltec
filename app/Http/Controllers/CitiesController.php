<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Auth\Access\AuthorizationException;

class CitiesController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-ciudades|crear-ciudad|editar-ciudad|borrar-ciudad', ['only' => ['index']]);
        $this->middleware('permission:crear-ciudad', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-ciudad', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-ciudad', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cities.index', [
            'title' => 'Ubicaciones Meltec',
        ]);
    }

    public function cities(Request $request)
    {
        try {
            $user = auth()->user();
            $token = $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new AuthorizationException('Error al obtener el token de Autorizacion');
            }

            $cities = City::all();

            return response()->json([
                'cities' => $cities,
            ], 200);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));
            
            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new AuthorizationException('Error al obtener el token de Autorizacion');
            }
            
        
            $create = City::create($request->all());

            if(!$create) {
                throw new Exception('Error al guardar los datos');
            }

            return response()->json([
                'success' => true,
                'message' => 'Datos Guardados Correctamente',
            ], 201);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
        } catch(AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        try {
            $user = auth()->user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new AuthorizationException('Error al obtener el token de Autorizacion');
            }

            $city = City::find($id);

            $response = [
                'id' => $city->id,
                'name' => $city->name,
                'description' => $city->dataCity,
            ];

            if (!$city) {
                throw new Exception('La ciudad Seleccionada no existe en la Base de datos!!');
            }

            return response()->json($response, 200);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = auth()->user();
            $token = $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new AuthorizationException('Error al obtener el token de Autorizacion');
            }

            $city = City::find($id);

            if (!$city) {
                throw new Exception('No se encuentra la entrada en la base de datos!!');
            }

            $city->name = $request->input('name');
            $city->dataCity = $request->input('description');

            $city->update();

            if (!$city->update()) {
                throw new Exception('Hubo un error al actualizar los datos');
            }

            return response()->json([
                'success' => true,
                'message' => 'Datos Actualizados',

            ]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
