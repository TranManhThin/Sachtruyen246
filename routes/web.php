<?php

use App\Http\Controllers\AccountUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use Intervention\Image\Laravel\Facades\Image;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/test', function () {
    // $image = Image::read('C:\Users\Tran Thin\Pictures\600.jpg')->resize(300,300);
    // $width = $image->width();
    // $height = $image->height();
    // echo $width.$height;
    return view('cssChop');


});
Route::get('/dang-ky', [AccountUserController::class,'dangKy'])->name('dangKy');
Route::post('/dang-ky-tai-khoan', [AccountUserController::class,'dangKyTaiKhoan'])->name('dangKyTK');
Route::get('/dang-nhap', [AccountUserController::class,'dangNhap'])->name('dangNhap');
Route::post('/dang-nhap-tai-khoan', [AccountUserController::class,'dangNhapTaiKhoan'])->name('dangNhapTK');
Route::get('/dang-xuat', [AccountUserController::class,'dangXuat'])->name('dangXuat');
Route::get('/', [HomeController::class,'trangChu'])->name('trangchu');
Route::get('/alphabet', [HomeController::class,'alphabet'])->name('alphabet');
Route::post('/alphabetSearch', [HomeController::class,'alphabetSearch'])->name('alphabetSearch');
Route::get('/logout', [AdminLoginController::class,'logout'])->name('admin.logout');
Route::get('/truyen', [HomeController::class,'index'])->name('home');
Route::get('/sach', [HomeController::class, 'sachIndex'])->name('sach');
Route::post('/xem-sach-nhanh', [HomeController::class, 'xemSachNhanh'])->name('xem-sach-nhanh');
Route::post('/tim-kiem', [HomeController::class,'timKiem'])->name('timKiem');
Route::post('/tabs-danh-muc',[HomeController::class,'tabsDanhMuc'])->name('tabsDanhMuc');
Route::post('/tim-kiem_ajax', [HomeController::class,'timKiemAjax'])->name('timKiemAjax');
Route::get('/danh-muc/{slugDM}', [HomeController::class,'danhMucTruyen'])->name('danhmuc');
Route::get('/the-loai/{slugTL}', [HomeController::class,'theLoaiTruyen'])->name('theloai');
Route::get('/tu-khoa/{slugTK}', [HomeController::class,'tuKhoaTruyen'])->name('tukhoa');
// Route::get('/xem-truyen/{slug}', [HomeController::class,'read_story'])->name('xemtruyen');
Route::prefix('xem-truyen/{slug}')->group(function (){
    Route::get('/', [HomeController::class,'read_story'])->name('xemtruyen');
    Route::get('/{slugChapter}',[HomeController::class,'read_chapter'])->name('xemchuong');
});

Route::get('/admin/login', [AdminLoginController::class,'login'])->name('admin.login');
Route::post('/admin/authenticate', [AdminLoginController::class , 'authenticate'])->name('admin.authenticate');
Route::post('/cap-nhat-truyen-hot', [StoryController::class,'capNhatTruyenHot'])->name('capNhatTruyenHot');
Route::post('editor/image_upload', 'EditorController@upload')->name('upload');
Route::prefix('admin')->middleware('admin')->group(function (){
    Route::get('/dashboard', function (){
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('category', CategoryController::class);
    Route::resource('story', StoryController::class);
    Route::resource('chapter', ChapterController::class);
    Route::resource('genre', GenreController::class);
    Route::resource('book', BookController::class);

});
