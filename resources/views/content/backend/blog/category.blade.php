@extends('layout.backend.master')

@section('style')

@endsection

@section('script')
    <script src="/public/js/backend/category.js" type="text/javascript"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Bài viết
            <small>danh mục</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin::dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{!! route('admin::blog::index') !!}">Bài viết</a></li>
            <li class="active">Danh mục</li>
        </ol>
    </section>

    <section ng-controller="BlogCategory" class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-7 col-md-push-5">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <form method="get">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="s" placeholder="Tìm kiếm danh mục">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info btn-flat">Go!</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="box-body">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-md-pull-7">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thêm</h3>
                    </div>

                    <form method="post" action="{!! route('admin::category::save') !!}">
                        {!! csrf_field() !!}
                        <input type="hidden" value="blog" name="type">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" class="form-control" name="name" ng-required="true">
                            </div>
                            <div class="form-group">
                                <label>Cha</label>
                                <select class="form-control" name="parent">
                                    <option>Trống</option>
                                    @foreach($categories as $category)
                                        <option value="{!! $category['id'] !!}">{!! $category['name'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <img ng-src="/public/@{{ imageCategory.thumbnail }}" ng-click="openMediaPopup(1)"
                                     class="img-responsive img-thumbnail">
                                <input type="hidden" name="image" value="@{{ imageCategory.id }}">
                                <a href="javascript:void(0)" ng-click="removeImageCategory()">xóa</a>
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" rows="3" name="description"></textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm danh mục mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection