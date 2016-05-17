@extends('layout.backend.master')

@section('style')

@endsection

@section('script')

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

    <section ng-controller="MediaCtrl" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <select class="form-control form-control-media"
                                onchange="if (this.value) window.location.href=this.value">
                            <option value="{!! route('admin::media::index') !!}" {!! (Request::is('admin/media')) ? 'selected' : ''!!}>
                                Lọc theo tháng
                            </option>
                            @foreach($filters as $filter)
                                <option value="{!! route('admin::media::filter', [$filter->year, $filter->month]) !!}" {!! (Request::is('admin/media/' . $filter->year . '/' . $filter->month)) ? 'selected' : ''!!}>
                                    {!! Date::createFromDate($filter->year, $filter->month, null)->format('F Y') !!}
                                </option>
                            @endforeach
                        </select>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" ng-click="showDropzone = !showDropzone" class="btn btn-danger">Thêm
                        </button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" ng-disabled="loading" ng-click="deleteMultiple()" class="btn btn-default">
                            <span ng-hide="loading">Xóa ảnh đã chọn</span>
                            <img ng-show="loading" src="/public/glammy/images/circle-loading.gif"
                                 class="img-responsive">
                        </button>
                        <div class="checkbox form-control-media">
                            <label>
                                <input type="checkbox" name="check-all"> Chọn tất cả
                            </label>
                        </div>
                    </div>

                    <div class="box-body">
                        <form ng-show="showDropzone" dropzone="uploadImagePopup" class="dropzone">
                            {!! csrf_field() !!}
                            <div class="dz-message needsclick">
                                <h3>Kéo thả các các file vào đây để tải lên.</h3>
                                <h6>hoặc</h6>
                                <button type="button" class="btn btn-default btn-lg">Chọn tệp tin</button>
                                <br>
                                <small>Kích thước tối đa 8Mb.</small>
                            </div>
                        </form>

                        <div when-windows-scroll-ends="loadMoreMedia()"
                             ng-init="loadMoreMedia('{{  $year }}', '{{ $month }}')" class="row">
                            <div ng-repeat="(key, img) in media" class="col-xs-6 col-sm-4 col-md-3 col-lg-2 box-media">
                                <input type="checkbox" name="check" value="@{{ key }}">
                                <a href="javascript:void(0)" ng-click="selectMedia($event, img)">
                                    <img ng-src="/public/@{{ img.thumbnail }}" alt="@{{ img.alt }}"
                                         class="img-responsive img-bordered-sm">
                                </a>
                            </div>
                            <div ng-hide="paging == 0 || !loading" class="col-xs-12 text-center">
                                <button class="btn btn-flat load-more">
                                    <img src="/public/glammy/images/circle-loading.gif"
                                         class="img-responsive">
                                </button>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
    </section><!-- /.content -->

    <div class="modal fade" tabindex="-1" id="editMedia">
        <div class="modal-dialog modal-media">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Chỉnh sửa ảnh chi tiết</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 img-render">
                            <img ng-src="/public/@{{ mediaSelected[0].full }}" class="img-responsive">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 info-render">
                            <form ng-submit="saveMediaSelected()" class="form-horizontal">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Văn bản thay thế</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="alt" ng-model="mediaSelected[0].alt"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Chú thích</label>
                                        <div class="col-sm-9">
                                            <textarea ng-model="mediaSelected[0].description" class="form-control" name="description" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Tải lên bởi</label>
                                        <div class="col-sm-9">
                                            <label class="control-label">@{{ mediaSelected[0].nameAuthor }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Ngày tải lên</label>
                                        <div class="col-sm-9">
                                            <label class="control-label">@{{ mediaSelected[0].created_at | date: 'dd LLLL yyyy' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-flat" data-dismiss="modal" aria-label="Close">
                                        Đóng
                                    </button>
                                    <button type="submit" ng-disabled="loading" class="btn btn-flat btn-warning">
                                        <span ng-hide="loading">Lưu</span>
                                        <img ng-show="loading" src="/public/glammy/images/circle-loading.gif"
                                             class="img-responsive">
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection