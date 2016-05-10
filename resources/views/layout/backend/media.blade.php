<div class="modal fade" tabindex="-1" id="select-media">
    <div class="modal-dialog modal-media">
        <div class="modal-content">
            <div class="nav-tabs-custom">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <a href="#upload" aria-controls="upload" role="tab" data-toggle="tab">Tải ảnh lên</a>
                    </li>
                    <li role="presentation" class="active">
                        <a href="#select" aria-controls="select" role="tab" data-toggle="tab">Thư viện</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="upload">
                        <form action="{!! route('admin::media::add') !!}" id="uploadMedia" class="dropzone">
                            {!! csrf_field() !!}
                            <div class="dz-message needsclick">
                                <h3>Kéo thả các các file vào đây để tải lên.</h3>
                                <h6>hoặc</h6>
                                <button type="button" class="btn btn-default btn-lg">Chọn tệp tin</button>
                                <br>
                                <small>Kích thước tối đa 8Mb.</small>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="select">
                        <div class="row">
                            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">
                                <div class="row" id="show-media">

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
