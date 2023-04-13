<?php

namespace App\Http\Controllers;

use App\Models\BaseWeb;
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

        if($user->api_token !== $token || !$user->isAdmin()) {
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
        $user = Auth::user();
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        if($user->api_token !== $token || !$user->isAdmin() ){
            return response()->json([
                'error' => 'No autorizado',
            ], 403);
        }

        $resource = BaseWeb::find($id);
        $data = $request->json()->all();

        if(Str::contains(json_encode($data), 'component')) {
            $resource->component = urldecode($data['component']);
        } else {
            $resource->content = urldecode($data['content']);
        }


        dd($resource->update());

        
        // return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
