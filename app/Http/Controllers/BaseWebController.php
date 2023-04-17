<?php

namespace App\Http\Controllers;

use App\Models\BaseWeb;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseWebController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:crear-base|editar-base|borrar-base', ['only' => ['index']]);
        $this->middleware('permission:crear-base', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-base', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-base', ['only' => ['destroy']]);
    }
    /**
     * API listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $token = $token = str_replace('Bearer ', '', $request->header('Authorization'));

        if ($user->api_token !== $token || !$user->isAdmin()) {
            return response()->json([
                'error' => 'Acceso no autorizado al recurso, se informara al Administrador',
                'user' => $user,
            ], 403);
        }

        $resouces = BaseWeb::all();

        return response()->json([
            'message' => 'ok',
            'data' => $resouces,
            'success' => 'true',
        ], 200);
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $user = Auth::user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new AuthorizationException('Error de Autorización', 403);
            }

            $resource = BaseWeb::find($id);
            $data = $request->json()->all();

            if (Str::contains(json_encode($data), 'component')) {
                $resource->component = urldecode($data['component']);
            } else if (Str::contains(json_encode($data), 'content')) {
                $resource->content = urldecode($data['content']);
            } else if(Str::contains(json_encode($data), 'type')){
                $resource->type_component = urldecode($data['type']);
            }

            $update = $resource->update();

            if (!$update) {
                throw new Exception('Error al almacenar los nuevos datos');
            }

            return response()->json([
                'success' => true,
                'message' => 'Cambios agregados correctamente',
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);

        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 403);
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
