<?php

namespace App\Http\Controllers;

use App\Models\SuccessCase;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class SuccessCasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Casos de Exito';
        return view('cases.index', compact('title'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function data(Request $request)
    {
        try {
            $user = auth()->user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new UnauthorizedException('Error de violacion de seguridad', 401);
            }

            $cases = SuccessCase::with('mark')->get();

            if($cases->count() == 0) {
                return response()->json([
                    'success' => true, 
                    'message' => 'No se encontraron registos!'
                ], 204);
            }

            return response()->json([
                'success' => true, 
                'data' => $cases,
            ], 200);

        } catch (UnauthorizedException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
