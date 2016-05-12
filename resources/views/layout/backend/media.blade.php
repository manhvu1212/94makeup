<div class="modal fade" tabindex="-1" id="select-media">
    <div class="modal-dialog modal-media">
        <div class="modal-content">
            <div class="row">
                <div class="col-xs-6 col-sm-7 col-md-8 col-lg-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation">
                                <a href="#upload" aria-controls="upload" role="tab" data-toggle="tab">Tải lên</a>
                            </li>
                            <li role="presentation" class="active">
                                <a href="#select" aria-controls="select" role="tab" data-toggle="tab">Thư viện</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane" id="upload">
                                <form dropzone="uploadImagePopup" class="dropzone">
                                    {!! csrf_field() !!}
                                    <div class="dz-message needsclick">
                                        <h3>Kéo thả các các file vào đây để tải lên.</h3>
                                        <h6>hoặc</h6>
                                        <button type="button" class="btn btn-default btn-lg">Chọn tệp tin</button>
                                        <br>
                                        <small>Kích thước tối đa 8Mb.</small>
                                    </div>
                                </form>
                                <div class="row show-media">
                                    <div ng-repeat="newImg in newMedia"
                                         class="col-xs-6 col-sm-4 col-md-3 col-lg-2 box-media">
                                        <a href="javascript:void(0)" ng-click="selectImage(newImg)">
                                            <img ng-src="/public/@{{ newImg.thumbnail }}" alt="@{{ newImg.alt }}"
                                                 class="img-responsive img-bordered-sm">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane active" id="select">
                                <div when-element-scroll-ends="loadMoreMedia()" class="row show-media">
                                    <div ng-repeat="img in media"
                                         class="col-xs-6 col-sm-4 col-md-3 col-lg-2 box-media">
                                        <a href="javascript:void(0)" ng-click="selectImage(img)">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-5 col-md-4 col-lg-3 ">
                    <div class="nav-tabs-custom media-detail">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="javascript:void(0)">Ảnh đã chọn</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <img ng-src="/public/@{{ imageSelected.crop }}" ng-show="imageSelected.length != 0" class="img-responsive">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-flat" data-dismiss="modal" aria-label="Close">Đóng</button>
                        <button type="button" ng-show="imageSelected.length != 0" ng-click="imageSelected = []" class="btn btn-flat btn-danger">Bỏ ảnh</button>
                        <button type="button" ng-show="imageSelected.length != 0" class="btn btn-flat btn-info">Chèn ảnh</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
