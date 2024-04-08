<div class="mt-5">
    <h3 style="font-family: 'Dancing Script', cursive">SÁCH HAY</h3>
    <div class="owl-carousel owl-theme">
        @foreach ($sachNew as $sach)
        <div class="item" style="border: 2mm ridge rgb(112, 47, 47);">
            <div class="card shadow-sm">
                <span class="text-overlay bg-red rounded">Sách mới</span>
                <img style="width: 195px; height: 250px;" class="card-img-top" src="{{ $sach->image }}" alt="{{ $sach->name }}">
            </div>
        </div>
        @endforeach
    </div>
</div>
<hr>

{{-- <div class="item" style="border: 2mm ridge rgb(112, 47, 47);">
    <div class="card shadow-sm">
        <span class="text-overlay bg-red rounded">Sách mới</span>
        <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
    </div>
</div>
<div class="item" style="border: 2mm ridge rgb(112, 47, 47);">
    <div class="card shadow-sm">
        <span class="text-overlay bg-red rounded">Sách mới</span>
        <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
    </div>
</div>
<div class="item" style="border: 2mm ridge rgb(112, 47, 47);">
    <div class="card shadow-sm">
        <span class="text-overlay bg-red rounded">Sách mới</span>
        <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
    </div>
</div>
<div class="item" style="border: 2mm ridge rgb(112, 47, 47);">
    <div class="card shadow-sm">
        <span class="text-overlay bg-red rounded">Sách mới</span>
        <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
    </div>
</div>
<div class="item" style="border: 2mm ridge rgb(112, 47, 47);">
    <div class="card shadow-sm">
        <span class="text-overlay bg-red rounded">Sách mới</span>
        <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
    </div>
</div> --}}
