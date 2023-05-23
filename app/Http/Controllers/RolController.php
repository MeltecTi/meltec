<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rols as Role;
use Illuminate\Support\Facades\Auth;
use App\Permissons as Permission;

class RolController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|borrar-rol', ['only' => ['index']]);
        $this->middleware('permission:crear-rol', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-rol', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-rol', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission = Permission::get();

        $title = 'Roles y Permisos';
        return view('roles.index', [
            'title' => $title,
            'permission' => $permission,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $title = 'Agregar nuevos roles y Permisos';
        // $permission = Permission::get();
        // return view('roles.new', compact('permission', 'title'));
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
                throw new AuthorizationException('Error de violacion de seguridad', 423);
            }

            $this->validate($request, ['name' => 'required', 'permission' => 'required']);
            $role = Role::create(['name' => $request->input('name')]);

            if (!$role) {
                throw new Exception('Hubo un error al ingresar los datos', 500);
            }
            $role->syncPermissions($request->input('permission'));


            return response()->json([
                'success' => true,
                'message' => 'Rol Agregado correctamente',
                'data' => $role,
            ], 201);
        } catch (\Exception $e) {

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
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        $title = 'Editar el rol ' . $role->name;
        $permission = Permission::get();
        
        $rolePermission = RolePermission::where('role_id', $id)
            ->pluck('permission_id', 'permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermission', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $user = Auth::user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token) {
                throw new AuthorizationException('Error de violacion de seguridad', 423);
            }
            $rol = Role::find($id);
            $deleted = $rol->delete();

            if (!$deleted) {
                throw new Exception('Hubo un error al procesar la Solicitud', 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Rol Eliminado correctamente',
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
                'message' => 'Error de violacion de seguridad',
                'code' => $e->getCode(),
            ], 401);
        }
    }

    public function roles(Request $request)
    {

        try {
            $user = auth()->user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                abort(403);
            }

            $roles = Role::all();

            if ($roles->isEmpty()) {
                throw new Exception('No hay registros en la base de datos', 404);
            }

            return response()->json([
                'success' => true,
                'roles' => $roles,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 404);
        }
    }
}
