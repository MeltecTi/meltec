<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Menu;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $title =  'Galeria de Imagenes Meltec' ;
       $gallery = Gallery::paginate(10);
       
       return view('gallery.index', compact('title', 'gallery'));
    }

    public function gallery()
    {
        $images = Gallery::all();
        return response()->json([
            'images' => $images,
        ]);
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

        $file = $request->file('file');
        $fileName = uniqid(). $file->getClientOriginalName();
        $file->move(storage_path('app/public/img/gallery/'), $fileName);

        $fileUpload = new Gallery();
        $fileUpload->file = $fileName;
        $fileUpload->save();
        return response()->json(['success' => $fileName]);

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

        $image = Gallery::find($id);

        if($image->delete()) {
            return response()->json([
                'message' => 'ok'
            ]);
        }

        return response()->json([
            'message' => 'error',
        ]);
    }
}
