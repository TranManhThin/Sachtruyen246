<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\StorageImageTrait;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use StorageImageTrait;
    public function index()
    {
        $books = Book::latest()->paginate(7);
        return view("admin.books.index", compact("books"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:books,name',
            'desc' => 'required',
            'image_path' => 'required',
            'author' => 'required',
            'keywords' => 'required',
            'content' => 'required',
        ],[
            'name.required' => 'Tên sách không được phép trống!',
            'name.unique' => 'Tên sách đã tồn tại!',
            'keywords.required'=> 'Cần nhập từ khóa!',
            'desc.required' => 'Mô tả không được phép trống!',
            'image_path.required' => 'Cần chọn hình ảnh!',
            'author.required' => 'Tên tác giả không được trống!',
            'content.required'=> 'Cần nhập nội dung sách'
        ]);




        $keyword = implode(',', $request->keywords);

        $dataImage = $this->storageTraitUpload($request,'image_path','books');
        if (!empty($dataImage)) {
            $data['image'] = $dataImage['filePath'];
        }
        $book = new Book();
        $book->name = $data['name'];
        $book->description = $data['desc'];
        $book->active = $request->active;
        $book->slug = $request->slug;
        $book->image = $data['image'];
        $book->author = $data['author'];
        $book->keyword = $keyword;
        $book->content = $data['content'];
        $book->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $book->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $book->save();

        return redirect()->back()->with('success', 'Thêm thành công!');
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
        $bookId = Book::findOrFail($id);
        return view('admin.books.edit', compact('bookId'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'desc' => 'required',
            'author' => 'required',
            'content' => 'required',
        ],[
            'name.required' => 'Tên sách không được phép trống!',
            'desc.required' => 'Mô tả không được phép trống!',
            'author.required' => 'Tên tác giả không được trống!',
            'content.required'=> 'Cần nhập nội dung sách'
        ]);




        $keyword = implode(',', $request->keywords);
        $book = Book::find( $id );

        if ($request->image_path == '' || $request->image_path == NULL) {
            $data['image'] = $book->image;
        }
        else{
            unlink(public_path($book->image));
            $dataImage = $this->storageTraitUpload($request,'image_path','stories');
            if (!empty($dataImage)) {
                $data['image'] = $dataImage['filePath'];
            }
        }


        $book->name = $data['name'];
        $book->description = $data['desc'];
        $book->active = $request->active;
        $book->slug = $request->slug;
        $book->image = $data['image'];
        $book->author = $data['author'];
        $book->keyword = $keyword;
        $book->content = $data['content'];
        $book->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $book->save();

        return redirect()->route('book.index')->with('success', 'Chỉnh sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book::find($id)->delete();
        return redirect()->back()->with('success','Xóa thành công!');
    }
}
