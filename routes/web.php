<?php

// Models
use App\Models\Blog;
use App\Models\City;
use App\Models\Menu;
use App\Models\User;

// Controllers
use App\Models\BaseWeb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\HomeController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\LogoutController;
// Supports
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\GalleriesController;

// Socialite
use App\Http\Controllers\AdvantagesController;
use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\CalendarEventsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GoogleApiController;
use App\Http\Controllers\LogoutService;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuccessCasesController;
use App\Models\Product;

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


/**
 * Todas las rutas Normales a las que puede acceder el publico sin necesidad de estar autenticado, rutas y datos dinamicos traidos desde el MenuController
 */

Route::get('/whatsapp-send-message', [WhatsAppController::class, 'sendMessages']);
Route::get('/webhook-whatsapp', [WhatsAppController::class, 'webhookWhatsapp']);
Route::post('/webhook-whatsapp', [WhatsAppController::class, 'processWebhook']);



Route::get('/', function () {
    return redirect('/home');
});


// Route::get('blogs/{id}', function ($id) {
//     $baseWeb = new BaseWeb();
//     $instagramUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('instagram'));
//     $facebookUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('facebook'));
//     $youtubeUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('youtube'));
//     $linkedinUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('linkedin'));
//     $twitterUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('twitter'));

//     $blog = Blog::find($id);
//     $title = $blog->title;
//     return view('blogs.blog', compact('blog', 'title', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
// });

// Rutas de autenticacion
Auth::routes();

/**
 * Autenticacion de Google
 */

Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-callback', [GoogleApiController::class, 'loginGoogle']);


Route::get('/home', [HomeController::class, 'index'])->name('home');


/**
 * Administrador del sitio web, rutas del Dashboard controladas por el Controlador
 * Rutas Protegidas por autenticacion
 */

Route::group(['middleware' => ['auth']], function () {
    //Recursos de rutas
    Route::resource('home/roles', RolController::class);
    Route::resource('home/usuarios', UsersController::class);
    Route::resource('home/blogs', BlogsController::class);
    Route::resource('home/categorias', CategoriesController::class);
    Route::resource('home/menus', MenusController::class);
    Route::resource('home/gallery', GalleriesController::class);
    Route::resource('home/ventajas', AdvantagesController::class);
    Route::resource('home/ciudades', CitiesController::class);
    Route::resource('home/budgets', BudgetsController::class);
    Route::resource('home/calendarEvents', CalendarEventsController::class);
    Route::resource('/home/products', ProductsController::class);
    Route::resource('/home/casosdeexito', SuccessCasesController::class);
    
    // Metodos especificos
    // Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
    Route::post('/logout', LogoutService::class)->name('logout');
    Route::get('home/auditoria', [AuditController::class, 'index'])->name('auditory.index');
    Route::get('/exports', [BudgetsController::class, 'export'])->name('budgets.export');
    Route::get('/exportTemplate', [BudgetsController::class, 'template'])->name('budgets.exportTemplate');
    Route::get('/home/employes', [UsersController::class, 'employes']);
    /**
     * Rutas de Reportes de SAP
     */

    Route::get('home/reports', function () {
        return view('reports.index', [
            'title' => 'Informe de reportes SAP'
        ]);
    });

    /**
     * Rutas de Informes PRIVADOS (SI es necesario loggearse)
     */

    Route::get('reportesSapMeltec/reports/ventas' . date('Y'), function () {
        return view('reports.ventas', [
            'title' => 'Reporte de Ventas Año ' . date('Y')
        ]);
    });
});



/**
 * Condicional para la visualizacion del sitio web en front
 */

// Route::get('/{slug?}', function ($slug) {
//     $menu = new Menu();
//     $baseWeb = new BaseWeb();
//     $page = $menu->getIdByNamePage($slug);
    
//     if ($page === null || !$page) {
//         abort(404);
//     }
    
//     $instagramUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('instagram'));
//     $facebookUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('facebook'));
//     $youtubeUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('youtube'));
//     $linkedinUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('linkedin'));
//     $twitterUrl = str_replace(FORMATED_REPLACE, '', $baseWeb->getContentByName('twitter'));

//     $dataExtra = Menu::with('galleries', 'advantages')->find($page->id);
//     $parentPages = $menu->getElementsParentMenu($page->id);



//     if ($page->name === PAGE_CONTACT) {
//         $cities = City::all();

//         return view('contact', compact('page', 'cities', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
//     }

//     if ($page->name === 'Blogs') {
//         $blogsAll = Blog::get()->sortByDesc('created_at');
//         $title = 'Blog y Noticias Meltec';
//         return view('blogs', compact('blogsAll', 'title', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
//     }

//     switch ($page->template_id) {
//         case 1:
//             $products = $page->mark->products;
//             return view($page->template->routeTemplate, compact('page', 'products', 'dataExtra', 'parentPages', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
//             break;

//         default:
//             return view('page', compact('page', 'dataExtra', 'parentPages', 'instagramUrl', 'facebookUrl', 'youtubeUrl', 'linkedinUrl', 'twitterUrl'));
//             break;
//     }
// });
