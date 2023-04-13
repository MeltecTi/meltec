<?php

namespace App\Http\Controllers;

use App\Events\RegenerateApiToken;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;

class BlogsController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-blog|crear-blog|editar-blog|borrar-blog', ['only' => ['index']]);
        $this->middleware('permission:crear-blog', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-blog', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-blog', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();

        $categories = Category::get();
        $blogs = $user->isAdmin() ? Blog::paginate(10) : $user->blogs()->paginate(10) ;
        return view('blogs.index', [
            'blogs' => $blogs,
            'title' => 'Blog',
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $categories = Category::get();
        $users =  User::get();
        return view('blogs.new', [
            'title' => 'Nuevo Blog',
            'categories' => $categories,
            'authors' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {     
        
        $user = auth()->user();
        
        if(!$user->isAdmin()){
            $request->merge(['user_id' => auth()->id()]);
        } 

        request()->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $data = $request->all();
        

        if( isset($data['image']) ){

            $fileName = $data['image']->hashName();
            $moveImage = $data['image']->move(public_path('img/blogsImg'),  $fileName);

            if($moveImage) {
                $data['image'] = $fileName;
            }
            
        }

        Blog::create($data);
        return redirect()->route('blogs.index');
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
    public function edit(Blog $blog)
    {
        $authors = User::pluck('name', 'id')->all();
        $categories = Category::pluck('name', 'id')->all();
        $title = 'Editar '. $blog->title;
        return view('blogs.edit', [
            'blog' => $blog,
            'authors' => $authors,
            'categories' => $categories, 
            'title' => $title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {

        $user = auth()->user();
        
        if(!$user->isAdmin()){
            $request->merge(['user_id' => auth()->id()]);
        } 

        request()->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        $data = $request->all();
        
        if( isset($data['image']) ){

            if(file_exists(public_path('img/blogsImg/'.$blog->image))){
                $oldFilename = $blog->image;
                unlink(public_path('img/blogsImg/'. $oldFilename));
            }
            
            $fileName = $data['image']->hashName();
            $moveImage = $data['image']->move(public_path('img/blogsImg'),  $fileName);

            if($moveImage) {
                $data['image'] = $fileName;
            }
            
        }


        $blog->update($data);
        return redirect()->route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index');
    }
}
