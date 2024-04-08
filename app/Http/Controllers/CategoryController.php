<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = Category::latest()->paginate(7);
        return view('admin.categories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'name' => 'required|max:255',
        //     'desc' => 'required|max:255',
        // ]);
        $validate = Validator::make($request->all(),[
            'name' => 'required|max:255|unique:categories,name',
            'desc' => 'required'
        ],[
            'name.required' => 'Tên danh mục không được phép trống!',
            'name.unique' => 'Tên danh mục đã tồn tại!',
            'desc.required' => 'Mô tả không được phép trống!'
        ]);

        if ($validate->passes()) {
            $data = [
                'name' => $request->name,
                'description' => $request->desc,
                'active' => $request->active,
                'slug' => Str::slug($request->name)
            ];

            Category::create($data);
            return response()->json([
                'status'=>true,
                'message'=> 'Thêm dữ liệu thành công!'
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'errors'=> $validate->errors()
            ]);
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
        $categoryById = Category::find($id);
        return view('admin.categories.edit',compact('categoryById'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'desc' => 'required'
        ]);

        if ($validate->passes()) {
            $data = [
                'name' => $request->name,
                'description' => $request->desc,
                'active' => $request->active,
                'slug' => Str::slug($request->name)
            ];

            Category::find($id)->update($data);
            return response()->json([
                'status'=>true,
                'message'=> 'Chỉnh sửa dữ liệu thành công!'
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'errors'=> $validate->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::find($id)->delete();
        return response()->json([
            'code'=> 200,
            'message'=> 'Xóa thành công'
        ]);
    }
}
