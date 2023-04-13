<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use Illuminate\Http\Request;

class AdvantagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title =  'Ventajas';
        $advantage =  Advantage::paginate(10);

        return view('advantage.index', compact('title', 'advantage'));
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
        $data = $request->all();

        if(Advantage::create($data)){
            return response()->json([
                'message' => 'ok',
                'data' => Advantage::latest()->first()
            ]);
        }

        return response()->json([
            'message' => 'error',
        ]);
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
        $advantage =  Advantage::find($id);

        return response()->json([
            'data' => $advantage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $advantage = Advantage::find($id);
        
        if($advantage->update($data)) {
            return response()->json([
                'message' => 'ok'
            ]);
        }
        return response()->json([
            'message' => 'error'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Advantage::find($id)->delete()){
            return response()->json([
                'message' => 'ok',
            ]);
        }

        return response()->json([
            'message' => 'error',
        ]);
    }

    public function allAdvantages()
    {
        $advantage = Advantage::all();

        return response()->json($advantage);
    }
}
