<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapters = Chapter::with('story')->paginate(5);

        return view('admin.chapters.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $story = Story::latest()->get();
        return view('admin.chapters.create', compact('story'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:chapters,name',
            'desc' => 'required',
            'content' => 'required'
        ],[
            'name.required' => 'Tên chương không được phép trống!',
            'name.unique' => 'Tên chương đã tồn tại!',
            'desc.required' => 'Mô tả không được phép trống!',
            'content' => 'Cần nhập nội dung chương!'
        ]);

        $chapter = new Chapter();
        $chapter->name = $data['name'];
        $chapter->description = $data['desc'];
        $chapter->content = $data['content'];
        $chapter->active = $request->active;
        $chapter->story_id = $request->story_id;
        $chapter->slug = $request->slug;
        $chapter->save();


        return redirect()->back()->with('success', 'Thêm chương thành công!');
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
        $story = Story::latest()->get();
        $chapter = Chapter::find($id);
        return view('admin.chapters.edit', compact('story','chapter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'desc' => 'required',
            'content' => 'required'
        ],[
            'name.required' => 'Tên chương không được phép trống!',
            'desc.required' => 'Mô tả không được phép trống!',
            'content' => 'Cần nhập nội dung chương!'
        ]);

        $chapter = Chapter::find($id);
        $chapter->name = $data['name'];
        $chapter->description = $data['desc'];
        $chapter->content = $data['content'];
        $chapter->active = $request->active;
        $chapter->story_id = $request->story_id;
        $chapter->slug = $request->slug;
        $chapter->save();


        return redirect()->route('chapter.index')->with('success', 'Cập nhật chương thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Chapter::find($id)->delete();
        return redirect()->back()->with('success','Xóa chương thành công!');

    }
}
