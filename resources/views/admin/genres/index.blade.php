@extends('admin.layout.admin')
@section('title', 'Thể loại truyện')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    <!-- Font Awesome -->
@endsection
@section('js')
    <script >
        $(function() {
    $(document).on('click', '#actionDelete', actionDelete)
});

function actionDelete(event) {
    let dataUrl = $(this).data('url');
    let thisBu = $(this);
    event.preventDefault();
    Swal.fire({
        title: "Xác nhận?",
        text: "Bạn chắc chắn xóa thể loại này!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE',
                url: dataUrl,
                success: ()=>{
                    return true;
                },
                error: function() {

                }
            });

        }
    });
}

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('page-content')

    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thể loại truyện</h6>
        </div>
        <div class="card-body ">
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_length" id="dataTable_length">
                           <form action="" class="form-inline" method="GET">
                            <label>
                                <input type="text" name="key">

                            </label>
                           </form>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <button type="button" class="btn btn-outline-secondary float-right" style="transform: scale(0.8)">Reset</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-hover text-nowrap" id="dataTable" width="100%"  cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 5%">ID</th>
                                    <th style="text-align: center; width: 25%">Tên thể loại</th>
                                    <th style="text-align: center; width: 40%">Mô tả</th>
                                    <th style="text-align: center; width: 10%">Trạng thái</th>
                                    <th style="text-align: center; width: 20%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                    <tr>
                                        <td style="text-align: center">{{ $value->id }}</td>
                                        <td style="text-align: center">{{ $value->name }}</td>
                                        <td style="text-align: center">{{ $value->description }}</td>
                                        <td style="text-align: center">
                                            @if ($value->active == 1)
                                                <svg class="text-success-500 h-6 w-6 text-success"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            <a href="{{ route('genre.edit',['genre'=>$value->id]) }}">
                                                <svg class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <a href="" data-url="{{ route('genre.destroy',['genre'=>$value->id]) }}" class="text-danger w-4 h-4 mr-1 actionDelete" id="actionDelete">
                                                <svg wire:loading.remove.delay="" wire:target=""
                                                    class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path ath fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        {{-- <div class="dataTables_info">
                                Show full category
                            </div> --}}
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection