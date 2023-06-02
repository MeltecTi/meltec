<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Productos Meltec';
        $products = Product::all();
        return view('products.index', compact('title', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Añadir Producto';
        $marks = Mark::get();
        return view('products.new', compact('title', 'marks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $image = $data['image'];

        // dd($data);

        $filename = $image->hashName();
        $moveImage = $image->move(storage_path('app/public/img/gallery/'), $filename);

        if ($moveImage) {
            $data['routeImage'] = $filename;
        }

        $product = Product::create($data);

        if ($product) {
            return back();
        }
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
        //
    }
}
