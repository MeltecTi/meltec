<?php

// Models
use App\Models\Blog;
use App\Models\Menu;
use App\Models\City;

// Controllers
use App\Http\Controllers\AdvantagesController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GalleriesController;

// Supports
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Todas las rutas Normales a las que puede acceder el publico sin necesidad de estar autenticado, rutas y datos dinamicos traidos desde el MenuController
 */

Route::get('/', function () {
    return view('index');
});

Route::get('/contacto', function () {
    $menu = new Menu();
    $page = $menu->getIdByNamePage('Contacto');
    $cities = City::all();

    $marksid = $menu->getIdByNamePage('Marcas');
    $marcas = $menu->getElementsParentMenu($marksid->id);

    $marcaspluck = $marcas->pluck('name', 'name');

    $industryid = $menu->getIdByNamePage('Industrias');
    $industrias = $menu->getElementsParentMenu($industryid->id);

    $industrypluck = $industrias->pluck('name', 'name');

    return view('contact', compact('page', 'cities', 'marcaspluck', 'industrypluck'));
});

Route::get('/blogs', function () {
    $blogsAll = Blog::get()->sortByDesc('created_at');
    $title = 'Blog y Noticias Meltec';
    return view('blogs', compact('blogsAll', 'title'));
});

Route::get('blogs/{id}', function ($id) {
    $blog = Blog::find($id);
    $title = $blog->title;
    return view('blogs.blog', compact('blog', 'title'));
});

Route::get('/marcas', function() {
    $menu = new Menu();
    $page = $menu->getIdByNamePage('Marcas');
    $idPage = $page->id;

    $marksItems = $menu->getElementsParentMenu($idPage);

    return view('marks.index', compact('page', 'marksItems'));
});

Route::get('/marcas/{id}', function($id) {
    $page = Menu::with(['galleries'])->find($id) ;
    $title = $page->name;
    return view('marks.mark', compact('page', 'title'));
});

Route::get('/industrias', function() {
    $industrias = new Menu();
    $page = $industrias->getIdByNamePage('Industrias');
    $idPage = $page->id;
    $industriesItems = $industrias->getElementsParentMenu($idPage);
    return view('industry.index', compact('page', 'industriesItems'));

});

Route::get('industrias/{id}', function ($id) {
    $page = Menu::with(['galleries', 'advantages'])->find($id);
    $title = $page->name;
    return view('industry.page', compact('title', 'page'));
});

Route::get('/meltec', function() {
    $menu = new Menu();
    $page = $menu->getIdByNamePage('Meltec');
    $meltecItems = $menu->getElementsParentMenu($page->id);
    return view('meltec.index', compact('page', 'meltecItems'));
});


/**
 * Administrador del sitio web, rutas del Dashboard controladas por el Controlador
 * Rutas Protegidas por autenticacion
 */

 // Rutas de autenticacion
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [LogoutController::class, 'perform'] )->name('logout.perform');
    Route::get('home/auditoria', [AuditController::class, 'index'])->name('auditory.index');
    Route::resource('home/roles', RolController::class);
    Route::resource('home/usuarios', UsersController::class);
    Route::resource('home/blogs', BlogsController::class);
    Route::resource('home/categorias', CategoriesController::class);
    Route::resource('home/menus', MenusController::class);
    Route::resource('home/gallery', GalleriesController::class);
    Route::resource('home/ventajas', AdvantagesController::class);
    Route::resource('home/ciudades', CitiesController::class);
});




