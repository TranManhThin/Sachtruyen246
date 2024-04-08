<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\Story;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        $truyenMoi = Story::latest()->where('active',1)->take(6)->get();
        $chuongDauMoiTruyen = [];
        for($i=0;$i<count($truyenMoi);$i++){
            $chuongDauMoiTruyen[$i] = Chapter::with('story')->where('active',1)->where('story_id',$truyenMoi[$i]->id)->oldest()->first();
        }

        return view('pages.home', compact('danhmucTruyen','truyenMoi','theLoai','chuongDauMoiTruyen'));
    }

    public function trangChu(){
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        $truyenMoi = Story::latest()->where('active',1)->take(6)->get();
        $chuongDauMoiTruyen = [];
        $sachNew = Book::latest()->where('active',1)->take(7)->get();
        for($i=0;$i<count($truyenMoi);$i++){
            $chuongDauMoiTruyen[$i] = Chapter::with('story')->where('active',1)->where('story_id',$truyenMoi[$i]->id)->oldest()->first();
        }

        return view('pages.homepage', compact('danhmucTruyen','truyenMoi','theLoai','chuongDauMoiTruyen','sachNew'));
    }

    public function alphabet(){
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();

        return view('pages.alphabet', compact('danhmucTruyen','theLoai'));
    }

    public function alphabetSearch(Request $request){
        $requestData = $request->all();
        $theLoai = $requestData['theLoai'];
        $kyTu = $requestData['kyTu'];
        $data = [];
        $output = '';
        if($theLoai == 'truyen'){
            $data = Story::with('category','genre')->where('active',1)->where('name','LIKE',$kyTu.'%')->get();
            foreach($data as $key => $value){
                $output .= '<div class="col">
                <div class="card shadow-sm">
                    <span class="text-overlay bg-red rounded">Truyện mới</span>
                    <a href="'.route('xemtruyen',['slug' => $value->slug]).'">
                        <img style="border: 2px solid black; width: 100%;height: 280px;" class="card-img-top"
                            src="'.$value->image.'" alt="">
                    </a>
                    <div class="card-body">
                        <div class="card-title">
                            <span
                                style="font-family: '.'Patrick Hand'.', cursive; font-size: 25px; white-space: normal;">'.$value->name.'</span>
                        </div>
                        <p class="card-text summary">'.$value->description.'</p>
                        <hr>
                        <span class="text-light bg-dark rounded">'.$value->category->name.'</span>
                        <span class="text-light bg-dark rounded">'.$value->genre->name.'</span>
                        <hr>';
                        // $tagsKey = explode(',', $value->keyword);
                        // foreach( $tagsKey as $key2 => $value2 ){
                        //     $output .= ' <span class="text-light bg-primary rounded">'.$value2.'</span>';
                        // }


                        $output .= '<hr>
                    </div>
                </div>
            </div>';
            }
        }
        else{
            $data = Book::where('active',1)->where('name','LIKE',$kyTu.'%')->get();
            foreach($data as $key => $value){
                $output .= '<div class="col">
                <div class="card shadow-sm">
                    <span class="text-overlay bg-red rounded">Truyện mới</span>

                        <img style="border: 2px solid black; width: 100%;height: 280px;" class="card-img-top"
                            src="'.$value->image.'" alt="">

                    <div class="card-body">
                        <div class="card-title">
                            <span
                                style="font-family: '.'Patrick Hand'.', cursive; font-size: 25px; white-space: normal;">'.$value->name.'</span>
                        </div>

                        <hr>';
                        $tagsKey = explode(',', $value->keyword);
                        foreach( $tagsKey as $key2 => $value2 ){
                            $output .= ' <span class="text-light bg-primary rounded">'.$value2.'</span>';
                        }
                        $output .= '<hr>';
                        $output .= '<div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <form action="">';
                            $token = csrf_token();
                            $output .= '<input type="hidden" name="_token" value="'.$token.'" autocomplete="off">';
                            $output .= '<button type="button" id="'.$value->id.'" class="btn btn-primary watch_book" data-toggle="modal"
                                data-target="#staticBackdrop">
                                Đọc ngay
                            </button>
                            <button disabled class="btn btn btn-outline-secondary"
                                                style="text-align: center; opacity: 1.0;"><i class="fa-solid fa-eye"
                                                    style="text-align: center"></i> 3521
                                                </button>
                                            </form>
                                        </div>

                                    </div>';
                    $output .= '</div>
                </div>
            </div>';
            }

        }



        echo $output;
    }

    public function sachIndex(){
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        $sach = Book::latest()->where('active',1)->take(12)->get();
        return view('pages.books', compact('danhmucTruyen','sach','theLoai'));
    }

    public function xemSachNhanh(Request $request){
        $book_id = $request->book_id;
        $book = Book::find($book_id);
        $output['tieudesach'] = $book->name;
        $output['noidungsach'] = $book->content;

        return response()->json($output);

    }

    public function tabsDanhMuc(Request $request){
        $dataRequest = $request->all();
        $output = '';
        $truyen = Story::with('category')->where('active',1)->where('category_id', $dataRequest['danhmucid'])->get();
        $chuongDauMoiTruyen = [];
        for($i=0;$i<count($truyen);$i++){
            $chuongDauMoiTruyen[$i] = Chapter::with('story')->where('active',1)->where('story_id',$truyen[$i]->id)->orderBy('id','asc')->first();
        }
        foreach($truyen as $key => $value){
            $output .= '<div class="col">
            <div class="card shadow-sm">
                <span class="text-overlay bg-red rounded">Truyện mới</span>
                <a href="'.route('xemtruyen',['slug' => $value->slug]).'">
                    <img style="border: 2px solid black; width: 100%;height: 280px;" class="card-img-top"
                        src="'.$value->image.'" alt="">
                </a>
                <div class="card-body">
                    <div class="card-title">
                        <span
                            style="font-family: '.'Patrick Hand'.', cursive; font-size: 25px; white-space: normal;">'.$value->name.'</span>
                    </div>
                    <p class="card-text summary">'.$value->description.'</p>
                    <hr>
                    <span class="text-light bg-dark rounded">'.$value->category->name.'</span>
                    <span class="text-light bg-dark rounded">'.$value->genre->name.'</span>
                    <hr>';
                    // $tagsKey = explode(',', $value->keyword);
                    // foreach( $tagsKey as $key2 => $value2 ){
                    //     $output .= ' <span class="text-light bg-primary rounded">'.$value2.'</span>';
                    // }


                    $output .= '<hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">';
                         if($chuongDauMoiTruyen[$key] == null){
                            $output .= ' <button class="btn btn-danger" disabled>Đọc thêm</button>';
                         }
                         else{
                            $output .= '<a class="btn btn-danger"
                            href="'.route('xemchuong',['slug'=>$value->slug,'slugChapter'=>$chuongDauMoiTruyen[$key]->slug]).'"
                            class="btn btn-sm btn-outline-secondary">Đọc
                            ngay</a>';
                         }


                            $output .= '<button disabled class="btn btn btn-outline-secondary"
                                style="text-align: center; opacity: 1.0;"><i class="fa-solid fa-eye"
                                    style="text-align: center"></i> 3521</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>';
        }
        echo $output;

    }

    public function timKiem(Request $request){
        $keyword = $request->get('keyword');
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        $truyenTim = Story::with('category','genre')->where('name','LIKE','%'.$keyword.'%')->orWhere('author','LIKE','%'.$keyword.'%')->get();
        $chuongDauMoiTruyen = [];
        for($i=0;$i<count($truyenTim);$i++){
            $chuongDauMoiTruyen[$i] = Chapter::with('story')->where('active',1)->where('story_id',$truyenTim[$i]->id)->oldest()->first();
        }

        return view('pages.search', compact('danhmucTruyen','theLoai','truyenTim','keyword','chuongDauMoiTruyen'));

    }

    public function timKiemAjax(Request $request){
        $data = $request->all();
        if($data['query']){
            $truyen = Story::where("active",1)->where("name","LIKE","%".$data['query']."%")->orWhere("author","LIKE","%".$data['query']."%")->get();
            $output =  '<ul class="dropdown-menu" style="display: block;">';

            foreach($truyen as $key => $value){
                $output .= '<li class="li_search_ajax"><a href="#">'.$value->name.'</a></li>';
            }
            $output .= '</ul>';

            echo $output;
        }



    }

    public function tuKhoaTruyen($slugTK){
        $tuKhoaTim = explode('-', $slugTK);
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        $truyenTim = Story::with('category','genre')->where('active',1)->where(
            function($query) use ($tuKhoaTim) {
                for($i=0;$i<count($tuKhoaTim);$i++){
                    $query->orWhere('keyword','LIKE','%'.$tuKhoaTim[$i].'%');
                }
            })->get();
        return view('pages.tag', compact('danhmucTruyen','theLoai','truyenTim','slugTK'));
    }

    public function danhMucTruyen($slugDM){
        $danhmucTruyen = Category::all();
        $danhmucID = Category::where('slug', $slugDM)->where('active',1)->first()->id;
        $danhmucName = Category::where('slug', $slugDM)->where('active',1)->first()->name;
        $truyenTheoDanhMuc = Story::where('category_id', $danhmucID)->get();
        $theLoai = Genre::all();
        $chuongDauMoiTruyen = [];
        for($i=0;$i<count($truyenTheoDanhMuc);$i++){
            $chuongDauMoiTruyen[$i] = Chapter::with('story')->where('active',1)->where('story_id',$truyenTheoDanhMuc[$i]->id)->oldest()->first();
        }

        return view('pages.category', compact('danhmucTruyen', 'truyenTheoDanhMuc','theLoai','danhmucName','chuongDauMoiTruyen'));

    }

    public function theLoaiTruyen($slugTL){
        $danhmucTruyen = Category::all();
        $theloaiID = Genre::where('slug', $slugTL)->where('active',1)->first()->id;
        $theloaiName = Genre::where('slug', $slugTL)->where('active',1)->first()->name;
        $truyenTheoTheLoai = Story::where('genre_id', $theloaiID)->get();
        $theLoai = Genre::all();
        $chuongDauMoiTruyen = [];
        for($i=0;$i<count($truyenTheoTheLoai);$i++){
            $chuongDauMoiTruyen[$i] = Chapter::with('story')->where('active',1)->where('story_id',$truyenTheoTheLoai[$i]->id)->oldest()->first();
        }
        return view('pages.genre', compact('danhmucTruyen', 'truyenTheoTheLoai','theLoai','theloaiName','chuongDauMoiTruyen'));
    }

    public function read_story($slug){
        try {
            $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        $truyenNoiBat = Story::where('active', 1)->where('story_hot',1)->take(20)->get();
        $truyenXemNhieu = Story::where('active', 1)->where('story_hot',2)->take(20)->get();
        $truyen = Story::with('category','genre')->where('active',1)->where('slug',$slug)->first();
        $chapter = Chapter::with('story')->where('active',1)->where('story_id',$truyen->id)->oldest()->get();
        $chapterDau = Chapter::with('story')->where('active',1)->where('story_id',$truyen->id)->orderBy('id','asc')->first();
        $chapterCuoi = Chapter::with('story')->where('active',1)->where('story_id',$truyen->id)->orderBy('id','desc')->first();
        $truyenCungDanhMuc = Story::with('category','genre')->where('category_id',$truyen->category->id)->whereNotIn('id',[$truyen->id])->latest()->get();
        return view('pages.story', compact('truyenNoiBat','truyenXemNhieu','danhmucTruyen','truyen','chapter','truyenCungDanhMuc','chapterDau','theLoai','chapterCuoi'));
        } catch (\Exception $exp) {
            return view('errors.404');
        }
    }
    public function read_chapter($slug,$slugChapter){
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        $truyen = Story::with('category')->where('active',1)->where('slug',$slug)->first();
        $chapter = Chapter::with('story')->where('active',1)->where('story_id',$truyen->id)->oldest()->get();
        $truyenCungDanhMuc = Story::where('category_id',$truyen->category_id)->whereNotIn('id',[$truyen->id])->latest()->get();
        $chapterTruyen = $chapter->where('slug',$slugChapter)->first();
        return view('pages.chapter',compact('danhmucTruyen','truyen','chapterTruyen','chapter','theLoai'));
    }

}
