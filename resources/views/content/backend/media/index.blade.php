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
                        <select class="form-control form-control-media">
                            <option>Lọc theo tháng</option>
                            <option>Tháng hai 2016</option>
                            <option>Tháng ba 2016</option>
                            <option>Tháng tư 2016</option>
                            <option>Tháng năm 2016</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" onclick="MEDIA.openUploadMedia()" class="btn btn-danger">Thêm</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-default">Xóa ảnh đã chọn</button>
                    </div>
                    <div class="box-body">

                        <form action="{!! route('admin::media::add') !!}" id="formUploadMedia" class="dropzone" hidden>
                            {!! csrf_field() !!}
                            <i class="fa fa-times" onclick="MEDIA.closeUploadMedia()"></i>
                            <div class="dz-message needsclick">
                                <h3>Kéo thả các các file vào đây để tải lên.</h3>
                                <h6>hoặc</h6>
                                <button type="button" class="btn btn-default btn-lg">Chọn tệp tin</button>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 box-media">
                                <div class="media-item">
                                    <input type="checkbox" name="check">
                                    <a href="#">
                                        <img src="/public/uploads/12292884_1520540574924516_477675486_n.jpg"
                                             class="img-responsive img-bordered-sm">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 box-media">
                                <div class="media-item">
                                    <input type="checkbox" name="check">
                                    <a href="#">
                                        <img src="/public/uploads/12292884_1520540574924516_477675486_n.jpg"
                                             class="img-responsive img-bordered-sm">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 box-media">
                                <div class="media-item">
                                    <input type="checkbox" name="check">
                                    <a href="#">
                                        <img src="/public/uploads/12292884_1520540574924516_477675486_n.jpg"
                                             class="img-responsive img-bordered-sm">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 box-media">
                                <div class="media-item">
                                    <input type="checkbox" name="check">
                                    <a href="#">
                                        <img src="/public/uploads/12292884_1520540574924516_477675486_n.jpg"
                                             class="img-responsive img-bordered-sm">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 box-media">
                                <div class="media-item">
                                    <input type="checkbox" name="check">
                                    <a href="#">
                                        <img src="/public/uploads/12292884_1520540574924516_477675486_n.jpg"
                                             class="img-responsive img-bordered-sm">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 box-media">
                                <div class="media-item">
                                    <input type="checkbox" name="check">
                                    <a href="#">
                                        <img src="/public/uploads/12292884_1520540574924516_477675486_n.jpg"
                                             class="img-responsive img-bordered-sm">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 box-media">
                                <div class="media-item">
                                    <input type="checkbox" name="check">
                                    <a href="#">
                                        <img src="/public/uploads/12292884_1520540574924516_477675486_n.jpg"
                                             class="img-responsive img-bordered-sm">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 box-media">
                                <div class="media-item">
                                    <input type="checkbox" name="check">
                                    <a href="#">
                                        <img src="/public/uploads/12292884_1520540574924516_477675486_n.jpg"
                                             class="img-responsive img-bordered-sm">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
    </section><!-- /.content -->

@endsection