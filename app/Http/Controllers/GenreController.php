<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $genre;
     public function __construct(Genre $genre){
        $this->genre = $genre;
     }
    public function index()
    {

        $data = $this->genre->paginate(10);
        return view('admin.genres.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=> 'required|unique:genres,name',
            'desc'=> 'required',
        ],[
            'name.required'=> 'Tên thể loại cần nhập!',
            'name.unique'=> 'Đã có tên thể loại',
            'desc.required'=> 'Cần nhập mô tả!',
        ]);

        $genreNew = new Genre();
        $genreNew->name = $data['name'];
        $genreNew->description = $data['desc'];
        $genreNew->active = $request->active;
        $genreNew->slug = $request->slug;
        $genreNew->save();

        return response()->json([
            'status'=>true,
            'message'=> 'Thêm dữ liệu thành công!'
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
        $genreById = $this->genre->find($id);
        return view('admin.genres.edit', compact('genreById'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'=> 'required|unique:genres,name',
            'desc'=> 'required',
        ],[
            'name.required'=> 'Tên thể loại cần nhập!',
            'name.unique'=> 'Đã có tên thể loại',
            'desc.required'=> 'Cần nhập mô tả!',
        ]);

        $genreNew = $this->genre->find($id);
        $genreNew->name = $data['name'];
        $genreNew->description = $data['desc'];
        $genreNew->active = $request->active;
        $genreNew->slug = $request->slug;
        $genreNew->save();

        return response()->json([
            'status'=>true,
            'message'=> 'Chỉnh sửa dữ liệu thành công!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->genre->destroy($id);
        return redirect()->back()->with('success','Xóa thể loại thành công!');
    }
}
