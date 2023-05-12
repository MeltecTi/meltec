<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Rols as Role;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Access\AuthorizationException;

class UsersController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-todos-los-usuarios', ['only' => ['index']]);
        $this->middleware('permission:crear-usuarios', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-usuario', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-usuario', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::paginate(10);

        $title = 'Usuarios';
        
        return view('users.index', [
            'usuarios' => $usuarios,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Crear nuevo Usuario';
        $roles = Role::pluck('name', 'name')->all();
        return view('users.new', compact('roles', 'title'));
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
                throw new AuthorizationException('Error de violacion de seguridad', 401);
            }

            $input = $request->except('confirm-password');
            $input['password'] = Hash::make($input['password']);

            if (isset($input['image'])) {
                $filename = $input['image']->hashName();
                $moveImageUser = $input['image']->move(storage_path('app/public/img'), $filename);

                if ($moveImageUser) {
                    $input['image'] = $filename;
                }
            }

            $user = User::create($input);

            if ($user) {
                $user->assignRole($request->input('roles'));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario creado con exito',
                    'code' => 200,
                ], 200);

            } else {
                throw new Exception('Hubo un error al ingresar el usuario, Pongase en contacto con el administrador del sitio', 500);
            }
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
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
        $user = User::find($id);
        $title = 'Editar Usuario ' . $user->name;
        $roles = Role::pluck('name', 'name')->all();

        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $user = User::find($id);
        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        if (isset($input['image'])) {

            if (file_exists(storage_path('app/public/img/' . $user->image))) {
                $oldFilename = $user->image;
                unlink(storage_path('app/public/img/' . $oldFilename));
            }

            $fileName = $input['image']->hashName();
            $moveImage = $input['image']->move(storage_path('app/public/img'),  $fileName);

            if ($moveImage) {
                $input['image'] = $fileName;
            }
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        try {
            $user->delete();
            return response()->json([
                'message' => 'Delete',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al Eliminar al Usuario',
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ],
            ], 500);
        }
    }

    /**
     * Verificar si el email ya esta registrado
     */

    public function emailExist(string $email)
    {
        $userExist = User::where('email', $email)->first();

        if ($userExist) {
            return response()->json([
                'message' => 'error'
            ]);
        }

        return response()->json([
            'message' => 'ok'
        ]);
    }
}
