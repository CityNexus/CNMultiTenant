@extends('layouts.master')

@section('title', 'Create New Importer')
@section('header', 'Create New Importer')

@include('import.aws_uploader')

@section('content')

    <!-- PROGRESSBAR WIZARD -->
    <div class="col-lg-12">
        <div class="card-box p-b-0">
            <div id="progressbarwizard" class="pull-in">
                <ul>
                    <li><a href="#account-2" data-toggle="tab">Account</a></li>
                    <li><a href="#profile-tab-2" data-toggle="tab">Profile</a></li>
                    <li><a href="#finish-2" data-toggle="tab">Finish</a></li>
                </ul>

                <div class="tab-content b-0 m-b-0">

                    <div id="bar" class="progress progress-striped progress-bar-primary-alt active">
                        <div class="bar progress-bar progress-bar-primary"></div>
                    </div>

                    <div class="tab-pane p-t-10 fade" id="account-2">
                        <div class="row">
                            <button class="btn btn-primary" onclick="loadImportType('file')">
                                Import From File <br>
                                <i class="fa fa-file-excel-o fa-3X"></i>
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane p-t-10 fade" id="profile-tab-2">
                        <div class="row">
                            <div id="file" class="importType hidden">
                                <div class="center-block">
                                    <!-- Direct Upload to S3 Form -->
                                    <form action="<?php echo $s3FormDetails['url']; ?>"
                                          method="POST"
                                          enctype="multipart/form-data"
                                          class="direct-upload">

                                        <?php foreach ($s3FormDetails['inputs'] as $name => $value) { ?>
                                        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
                                    <?php } ?>

                                    <!-- Key is the file's name on S3 and will be filled in with JS -->
                                        <input type="hidden" name="key" value="">
                                        <input type="file" name="file" multiple>

                                        <!-- Progress Bars to show upload completion percentage -->
                                        <div class="progress-bar-area progress-bar-striped" style="height: 25px"></div>
                                        <textarea class="hidden" id="uploaded"></textarea>

                                    </form>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-2 control-label" for="name1"> First name *</label>
                                <div class="col-lg-10">
                                    <input id="name1" name="name" type="text" class="required form-control">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-lg-2 control-label " for="surname1"> Last name *</label>
                                <div class="col-lg-10">
                                    <input id="surname1" name="surname" type="text" class="required form-control">

                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="col-lg-2 control-label " for="email1">Email *</label>
                                <div class="col-lg-10">
                                    <input id="email1" name="email" type="text" class="required email form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane p-t-10 fade" id="finish-2">
                        <div class="row">
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="checkbox checkbox-primary">
                                        <input id="checkbox-h1" type="checkbox">
                                        <label for="checkbox-h1">
                                            I agree with the Terms and Conditions.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="pager m-b-0 wizard">
                        <li class="previous first" style="display:none;"><a href="#">First</a>
                        </li>
                        <li class="previous"><a href="#" class="btn btn-primary waves-effect waves-light">Previous</a></li>
                        <li class="next last" style="display:none;"><a href="#">Last</a></li>
                        <li class="next"><a href="#" class="btn btn-primary waves-effect waves-light">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->

    @endsection

@push('javascript')
    <script src="/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>

    <script type="text/javascript">

        function loadImportType(type)
        {
            $('.importType').addClass('hidden');
            $("#" + type).removeClass('hidden');
        }
        $(document).ready(function() {
            $('#progressbarwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#progressbarwizard').find('.bar').css({width:$percent+'%'});
            },
                'tabClass': 'nav nav-tabs navtab-wizard nav-justified bg-muted'});

            $('#btnwizard').bootstrapWizard({'tabClass': 'nav nav-tabs navtab-wizard nav-justified bg-muted','nextSelector': '.button-next', 'previousSelector': '.button-previous', 'firstSelector': '.button-first', 'lastSelector': '.button-last'});

            var $validator = $("#commentForm").validate({
                rules: {
                    emailfield: {
                        required: true,
                        email: true,
                        minlength: 3
                    },
                    namefield: {
                        required: true,
                        minlength: 3
                    },
                    urlfield: {
                        required: true,
                        minlength: 3,
                        url: true
                    }
                }
            });
        });

    </script>
    @endpush