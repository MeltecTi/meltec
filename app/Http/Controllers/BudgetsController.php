<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Budget;
use Illuminate\Http\Request;
use App\Imports\ImportBudgets;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\UnauthorizedException;

class BudgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Presupuesto Meltec ' . date('Y');
        return view('budget.index', compact('title'));
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
        if ($request->hasFile('excel')) {
            Excel::import(new ImportBudgets, $request->file('excel'));

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Budget::find($id);
        $title = 'Editar Unidad de Negocio ' . $data->businessUnit;
        return view('budget.edit', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = Auth::user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if($user->api_token !== $token || !$user->isAdmin()){
                throw new UnauthorizedException('Accion no permitida, no tiene los permisos necesarios para realizar esta accion', 401);
            }

            $budget = Budget::find($id);

            if(!$budget) {
                throw new Exception('La unidad de venta no existe', 404);
            }

            $update = $budget->update($request->all());

            if(!$update) {
                throw new Exception('Error al Actualizar los datos', 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Datos Actualizados correctamente',
            ]);

        } catch (UnauthorizedException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Import to the Excel 
     */
    public function getData(Request $request)
    {
        try {
            $user = Auth::user();
            $token = $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw  new UnauthorizedException('Acceso no autorizado', 401);
            }

            $budgets = Budget::all();

            if (!empty($budgets) || count($budgets) > 0) {
                return response()->json([
                    'success' => true,
                    'data' => $budgets,
                ], 200);
            }

            throw new Exception('No existen datos en la base de datos', 404);
        } catch (UnauthorizedException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        }
    }
}
