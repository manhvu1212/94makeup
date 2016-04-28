@extends('layout.backend.master')

@section('style')
    <link href="/public/components/dropzone/dist/dropzone.css" rel="stylesheet">
@endsection

@section('script')
    <script src="/public/components/dropzone/dist/dropzone.js" type="text/javascript"></script>
    <script src="/public/js/backend/media.js" type="text/javascript"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Thư viện
            <small>preview of simple tables</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin::dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Thư viện</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <select class="form-control form-control-media" onchange="if (this.value) window.location.href=this.value">
                            <option>Lọc theo tháng</option>
                            @foreach($filters as $filter)
                                <option value="{!! route('admin::media::index', [$filter->year, $filter->month]) !!}">
                                    {!! Date::createFromDate($filter->year, $filter->month, null)->format('F Y') !!}
                                </option>
                            @endforeach
                        </select>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="MEDIA.openUploadMedia()" class="btn btn-danger">Thêm</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="MEDIA.deleteMultiple()" class="btn btn-default">Xóa ảnh đã chọn</button>
                    </div>
                    <div class="box-body">

                        <form action="{!! route('admin::media::add') !!}" id="formUploadMedia" class="dropzone" hidden>
                            {!! csrf_field() !!}
                            <i class="fa fa-times" onclick="MEDIA.closeUploadMedia()"></i>
                            <div class="dz-message needsclick">
                                <h3>Kéo thả các các file vào đây để tải lên.</h3>
                                <h6>hoặc</h6>
                                <button type="button" class="btn btn-default btn-lg">Chọn tệp tin</button>
                                <br>
                                <small>Kích thước tối đa 8Mb.</small>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Chọn tất cả
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="media">
                            {!! csrf_field() !!}
                            @foreach($media as $img)
                                <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 box-media">
                                    <div class="media-item">
                                        <input type="checkbox" name="check" value="{!! $img['id'] !!}">
                                        <a href="#">
                                            <img src="{!! $img['thumbnail'] !!}" alt="{!! isset($img['alt']) ? $img['alt'] : $img['filename'] !!}"
                                                 class="img-responsive img-bordered-sm">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
    </section><!-- /.content -->

@endsection