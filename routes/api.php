<?php

use App\Models\MeetingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\RolController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\FlokzuController;
use App\Http\Controllers\BaseWebController;
use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\GoogleApiController;
use App\Http\Controllers\AdvantagesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SuccessCasesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/usuarios/{email}', [UsersController::class, 'emailExist']);
Route::get('/ventajas', [AdvantagesController::class, 'allAdvantages']);
Route::get('/ventajas/edit/{id}', [AdvantagesController::class, 'edit']);
Route::post('/ventajas/{id}', [AdvantagesController::class, 'update']);
Route::get('/gallery', [GalleriesController::class, 'gallery']);

/**
 * Api para datos fuera del dashboard, pagina principal
 */
Route::post('/formulario', [FrontController::class, 'email']);


// Uso del Middelware de Autenticacion
/**
 * Requerido @param $user->api_token
 */

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/city', [CitiesController::class, 'cities'])->middleware('auth:api');
    Route::get('/city/edit/{id}', [CitiesController::class, 'edit'])->middleware('auth:api');
    Route::get('/audition/{id}', [AuditController::class, 'audition'])->middleware('auth:api');
    Route::get('/roles', [RolController::class, 'roles'])->middleware('auth:api');
    
    Route::get('/marks/{mark}', [MarksController::class, 'getMarkByName']);

    Route::post('/menus', [MenusController::class, 'store'] );
    
    Route::post('/usuarios', [UsersController::class, 'store']);

    Route::get('/successcases', [SuccessCasesController::class, 'data']);
    
    Route::post('/roles', [RolController::class, 'store'])->middleware('auth:api');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('auth:api');
    Route::post('/city', [CitiesController::class, 'store'])->middleware('auth:api');
    Route::post('/city/edit/{id}', [CitiesController::class, 'update'])->middleware('auth:api');
    
    Route::delete('/roles/{id}', [RolController::class, 'destroy'])->middleware('auth:api');
    Route::resource('/recursos', BaseWebController::class)->middleware('auth:api');
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        $user = $request->user();
        $isAdmin = $user->isAdmin();
    
        return response()->json([
            'user' => $user,
            'admin' => $isAdmin,
        ]);
    });
    
    Route::get('/budgets', [BudgetsController::class, 'getData'])->middleware('auth:api');
    Route::put('/budgets/edit/{id}', [BudgetsController::class, 'update'])->middleware('auth:api');
    Route::delete('/budget/{id}', [BudgetsController::class, 'destroy'])->middleware('auth:api');

});

/**
 * Rutas de Sap
 */

Route::get('/sapData', function () {
    $data = file_get_contents(env('LOCALHOST_NODEJS'));
    return response($data)->header('Content-Type', 'application/json');
});

Route::get('/ventasDia', function () {
    $data = file_get_contents('http://localhost:3000/ventasDia');
    return response($data)->header('Content-Type', 'application/json');
});

Route::get('/ventasDiaAnterior', function () {
    $data = file_get_contents('http://localhost:3000/ventasDiaAnterior');
    return response($data)->header('Content-Type', 'application/json');
});

Route::get('/ventasSemanales', function () {
    $data = file_get_contents('http://localhost:3000/ventasSemanales');
    return response($data)->header('Content-Type', 'application/json');
});

Route::get('/ventasSemanaAnteriorPasada', function () {
    $data = file_get_contents('http://localhost:3000/ventasSemanaAnteriorAnterior');;
    return response($data)->header('Content-Type', 'application/json');
});


/**
 * Rutas de prueba
 */

Route::post('/pruebaFlokzu', [FlokzuController::class, 'respuestaFlokzu']);

Route::get('/reservasSala', function () {
    $data = MeetingRoom::all();

    return response()->json($data);
});


/**
 * Pruebas
 */

Route::post('/calendar/create', [GoogleApiController::class, 'prueba'])->middleware('auth:api');
