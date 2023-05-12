<?php

// Models
use App\Models\Blog;
use App\Models\Menu;
use App\Models\City;
use App\Models\BaseWeb;

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
use App\Http\Controllers\WhatsAppController;
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
 * Constantes declaradas
 */

const FORMATED_REPLACE = ['<p>', '</p>', '<a>', '</a>'];
const PAGE_CONTACT = 'Contáctanos';

/**
 * Todas las rutas Normales a las que puede acceder el publico sin necesidad de estar autenticado, rutas y datos dinamicos traidos desde el MenuController
 */


Route::get('/', function () {
    $baseWeb = new BaseWeb();
    $instagramUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('instagram'));
    $facebookUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('facebook'));
    $youtubeUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('youtube'));
    $linkedinUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('linkedin'));
    $twitterUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('twitter'));
    return view('index', compact('instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
});


Route::get('blogs/{id}', function ($id) {
    $baseWeb = new BaseWeb();
    $instagramUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('instagram'));
    $facebookUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('facebook'));
    $youtubeUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('youtube'));
    $linkedinUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('linkedin'));
    $twitterUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('twitter'));

    $blog = Blog::find($id);
    $title = $blog->title;
    return view('blogs.blog', compact('blog', 'title', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
});

// Rutas de autenticacion
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


/**
 * Administrador del sitio web, rutas del Dashboard controladas por el Controlador
 * Rutas Protegidas por autenticacion
 */

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
    Route::get('home/auditoria', [AuditController::class, 'index'])->name('auditory.index');
    Route::resource('home/roles', RolController::class);
    Route::resource('home/usuarios', UsersController::class);
    Route::resource('home/blogs', BlogsController::class);
    Route::resource('home/categorias', CategoriesController::class);
    Route::resource('home/menus', MenusController::class);
    Route::resource('home/gallery', GalleriesController::class);
    Route::resource('home/ventajas', AdvantagesController::class);
    Route::resource('home/ciudades', CitiesController::class);

    /**
     * Rutas de Reportes de SAP
     */

    Route::get('home/reports', function () {
        return view('reports.index', [
            'title' => 'Informe de reportes SAP'
        ]);
    });
});

/**
 * Rutas de Informes (No es necesario loggearse)
 */

Route::get('reportesSapMeltec/reports/ventas'.date('Y'), function () {
    return view('reports.ventas', [
        'title' => 'Reporte de Ventas Año ' . date('Y')
    ]);
});


/**
 * Condicional para la visualizacion del sitio web en front
 */

Route::get('/{slug?}', function ($slug) {
    $menu = new Menu();
    $baseWeb = new BaseWeb();
    $page = $menu->getIdByNamePage($slug);

    $instagramUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('instagram'));
    $facebookUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('facebook'));
    $youtubeUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('youtube'));
    $linkedinUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('linkedin'));
    $twitterUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('twitter'));

    $dataExtra = Menu::with('galleries', 'advantages')->find($page->id);
    $parentPages = $menu->getElementsParentMenu($page->id);

    if ($page === null) {
        abort(404);
    }

    if ($page->name === PAGE_CONTACT) {
        $cities = City::all();

        return view('contact', compact('page', 'cities', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
    }

    if ($page->name === 'Blogs') {
        $blogsAll = Blog::get()->sortByDesc('created_at');
        $title = 'Blog y Noticias Meltec';
        return view('blogs', compact('blogsAll', 'title', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
    }



    return view('page', compact('page', 'dataExtra', 'parentPages', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
});
