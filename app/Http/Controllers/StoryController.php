<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use App\Models\Genre;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteImageTrait;
class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use StorageImageTrait;
    use DeleteImageTrait;
    public function index()
    {

        $story = Story::with("category","genre")->orderBy('id','desc')->paginate(5);
        Carbon::setLocale("vi");
        return view('admin.stories.index', compact('story'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $genres = Genre::all();
        return view('admin.stories.create', compact('categories', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required|max:255|unique:stories,name',
            'desc' => 'required',
            'image_path' => 'required'

        ],[
            'name.required' => 'Tên truyện không được phép trống!',
            'name.unique' => 'Tên truyện đã tồn tại!',
            'desc.required' => 'Mô tả không được phép trống!',
            'image_path.required' => 'Cần chọn hình ảnh!'

        ]);

        $data = $request->validate([
            'name' => 'required|max:255|unique:stories,name',
            'desc' => 'required',
            'image_path' => 'required',
            'author' => 'required'
        ],[
            'name.required' => 'Tên truyện không được phép trống!',
            'name.unique' => 'Tên truyện đã tồn tại!',
            'desc.required' => 'Mô tả không được phép trống!',
            'image_path.required' => 'Cần chọn hình ảnh!',
            'author.required' => 'Tên tác giả không được trống!'
        ]);




        $keyword = implode(',', $request->keywords);

        $dataImage = $this->storageTraitUpload($request,'image_path','stories');
        if (!empty($dataImage)) {
            $data['image'] = $dataImage['filePath'];
        }
        $story = new Story();
        $story->name = $data['name'];
        $story->description = $data['desc'];
        $story->active = $request->active;
        $story->story_hot = $request->story_hot;
        $story->slug = $request->slug;
        $story->category_id = $request->category_id;
        $story->image = $data['image'];
        $story->author = $data['author'];
        $story->genre_id = $request->genre_id;
        $story->keyword = $keyword;
        $story->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $story->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $story->save();

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
        $genres = Genre::all();
        $storyById = Story::find($id);
        $category = Category::all();
        return view('admin.stories.edit', compact('storyById','category','genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'desc' => 'required',
            'author' => 'required'

        ],[
            'name.required' => 'Tên truyện không được phép trống!',
            'desc.required' => 'Mô tả không được phép trống!',
            'author.required' => 'Tên tác giả không được trống!'

        ]);
        $storyID = Story::find($id);
        if ($request->image_path == '' || $request->image_path == NULL) {
            $data['image'] = $storyID->image;
        }
        else{
            unlink(public_path($storyID->image));
            $dataImage = $this->storageTraitUpload($request,'image_path','stories');
            if (!empty($dataImage)) {
                $data['image'] = $dataImage['filePath'];
            }
        }

        $keyword = implode(',', $request->keywords);

        $story = Story::find($id);
        $story->name = $data['name'];
        $story->description = $data['desc'];
        $story->active = $request->active;
        $story->story_hot = $request->story_hot;
        $story->slug = $request->slug;
        $story->category_id = $request->category_id;
        $story->image = $data['image'];
        $story->keyword = $keyword;
        $story->author = $data['author'];
        $story->genre_id = $request->genre_id;
        $story->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $story->save();
        return redirect()->route('story.index')->with('success', 'Sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $storyDel = Story::find($id);

        if($storyDel->image != NULL){
            unlink(public_path($storyDel->image));
         }
        $storyDel->delete();
        return response()->json([
            'code'=> 200,
            'message'=> 'Xóa thành công'
        ]);
    }

    public function capNhatTruyenHot(Request $request){
        $data = $request->all();
        $truyenID = Story::find($data['story_id']);
        $truyenID->story_hot = $data['story_hot'];
        $truyenID->save();
        return response()->json([
            'code'=> 200,
            'message'=> 'Cập nhật truyện hot thành công!'
        ]);
    }
}
