<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Mark;
use App\Models\Gallery;
use App\Models\Template;
use App\Models\Advantage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

const PARENT_MARKS = 'Soluciones';

class MenusController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-pagina|crear-pagina|editar-pagina|borrar-pagina', ['only' => ['index']]);
        $this->middleware('permission:crear-pagina', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-pagina', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-pagina', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Administrador de Paginas';
        $menus = Menu::paginate(10);

        return view('menus.index', compact('title', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Crear nueva Pagina';
        $menus = Menu::all()->where('parent', 0);
        $opciones = [];

        $galleries = Gallery::select('id', 'file')->get();

        $advantage = Advantage::select('id', 'title')->get();

        $colection = Menu::query()->get()->where('parent', 0);
        $submenus = $colection->pluck('name', 'id');
        foreach ($submenus as $id => $name) {
            $opciones[$id] = $name;
        }
        $templatesAll = Template::all();
        $templates = $templatesAll->pluck('templateName', 'id');
        return view('menus.add', compact('title', 'templates', 'opciones', 'galleries', 'advantage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $user = Auth::user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));


            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new UnauthorizedException('Acceso no autorizado', 403);
            }
            $data = $request->except('contentMark', 'markName');

            switch ($data['template_id']) {
                case '1':

                    // Validando si la pagina esta habilitada
                    $enabledPage = $request->input('enabled');
                    $enabledPage === 'on' ? $data['enabled'] = 1 : $data['enabled'] = 0;

                    $slug = strtolower($data['name']);
                    $verifySlug = Menu::where('slug', $slug)->get();

                    if ($verifySlug->count() > 0) {
                        throw new Exception('La pagina ya existe!!', 400);
                    }
                    $data['slug'] = $slug;
                    $data['subtitle'] = 'Pagina de ' . $data['name'];

                    $mark = Mark::where('name', $data['name'])->get();
                    $data['mark_id'] = $mark->first()->id;

                    // Validando si hay una Imagen de Logo
                    isset($data['markLogo']) ? $logo = $data['markLogo'] : $logo = null;

                    if ($logo) {
                        $filename = $logo->hashName();
                        $moveImage = $logo->move(storage_path('app/public/img/pages/'), $filename);

                        if ($moveImage) {
                            $data['logo'] = $filename;
                            $data['image'] = $filename;
                        }
                    }


                    $parent = Menu::where('name', PARENT_MARKS)->get();
                    $data['parent'] = $parent->first()->id;


                    break;

                default:
                    # code...
                    break;
            }

            $page = Menu::create($data);

            if (!$page) {
                throw new Exception('Error al crear la pagina, contacte con el administrador', 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pagina creada Correctamente',
            ], 200);
        } catch (UnauthorizedException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], $e->getCode());
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 400);
        }
        // request()->validate([
        //     'name' => 'required',
        //     'slug' => 'required',
        //     'content' => 'required',
        //     'image' => 'required|mimes:jpg,jpeg,png,webp|max:5120',
        // ]);

        // $menuModel = new Menu();
        // $inputData = $request->all();
        // $parentData = $inputData['parent'];
        // $countOrder = $menuModel->orderMenu($parentData);
        // $inputData['order'] = $countOrder;

        // if (isset($inputData['image'])) {
        //     $fileName = $inputData['image']->hashName();
        //     $moveImage = $inputData['image']->move(storage_path('app/public/img/pages/'), $fileName);

        //     if ($moveImage) {
        //         $inputData['image'] = $fileName;
        //     }
        // }


        // $menuGeneral = Menu::create($inputData);
        // $menuGeneral->galleries()->sync($request->input('galleries', []));
        // $menuGeneral->advantages()->sync($request->input('advantages', []));
        // return redirect()->route('menus.index');
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
    public function edit(String $id)
    {

        $menuFind = Menu::find($id);
        $title = 'Editar la Pagina ' . $menuFind->name;

        $menus = Menu::all();
        $opciones = [];

        $galleries = Gallery::select('id', 'file')->get();
        $advantage = Advantage::select('id', 'title')->get();

        $colection = Menu::query()->get()->where('parent', 0);
        $submenus = $colection->pluck('name', 'id');
        foreach ($submenus as $id => $name) {
            $opciones[$id] = $name;
        }


        return view('menus.edit', compact('menuFind', 'title', 'opciones', 'galleries', 'advantage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {

        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'content' => 'required',
        ]);

        $data = $request->all();

        if (isset($data['image'])) {

            if ($menu->image != '') {
                if (file_exists(storage_path('app/public/img/pages/' . $menu->image))) {
                    $oldFilename = $menu->image;
                    unlink(storage_path('app/public/img/pages/' . $oldFilename));
                }
            }

            $fileName = $data['image']->hashName();
            $moveImage = $data['image']->move(storage_path('app/public/img/pages/'),  $fileName);

            if ($moveImage) {
                $data['image'] = $fileName;
            }
        }

        $menu->update($data);
        $menu->galleries()->syncWithoutDetaching($request->input('galleries', []));
        $menu->advantages()->syncWithoutDetaching($request->input('advantages', []));

        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->galleries()->detach();
        $menu->delete();
        return redirect()->route('menus.index');
    }
}
