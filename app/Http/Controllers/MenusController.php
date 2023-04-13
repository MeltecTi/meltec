<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\Gallery;
use App\Models\Menu;
use Illuminate\Http\Request;

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
        return view('menus.add', compact('title', 'opciones', 'galleries', 'advantage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'content' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $menuModel = new Menu();
        $inputData = $request->all();
        $parentData = $inputData['parent'];
        $countOrder = $menuModel->orderMenu($parentData);
        $inputData['order'] = $countOrder;

        if (isset($inputData['image'])) {
            $fileName = $inputData['image']->hashName();
            $moveImage = $inputData['image']->move(storage_path('app/public/img/pages/'), $fileName);

            if ($moveImage) {
                $inputData['image'] = $fileName;
            }
        }

        
        $menuGeneral = Menu::create($inputData);
        $menuGeneral->galleries()->sync($request->input('galleries', []));
        $menuGeneral->advantages()->sync($request->input('advantages', []));
        return redirect()->route('menus.index');
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
