@extends('admin.template')

@section('title', ucfirst($action).' Sponsor')

@section('css')
    {{ HTML::style('assets/js/jquery/jquery.datetimepicker.css') }}
    {{ HTML::style('assets/admin/pages/add-or-edit.css') }}
@stop

@section('js')
    {{ HTML::script('assets/js/ckeditor/ckeditor.js') }}
    {{ HTML::script('assets/admin/pages/add-or-edit.js') }}
    {{ HTML::script('assets/js/jquery/jquery.datetimepicker.js') }}
    <script>
        $(document).ready(function() {
            // KCFinder browsing
            $('.fileBrowse').click(function() {
                var $input = $(this).parent().prev().children('input');
                window.KCFinder = {};
                window.KCFinder.callBack = function(url) {
                    url = url.substring(1);
                    $input.val(url);
                    window.KCFinder = null;
                };
                window.open('/assets/js/kcfinder/browse.php?type=files', 'file_browser', 'width=1000,height=600');
            });
        });
    </script>
@stop

@section('content')
    <h1>{{ ucfirst($action) }} Sponsor</h1>
    @if ($action == 'edit')
        @if (!$sponsor->deleted_at)
            {{ Form::open(array('role'=>'form',
                                'url'=>'admin/sponsors/delete/'.$sponsor->id,
                                'style'=>'margin-bottom:15px;')) }}
                <input type="submit" class="btn btn-sm btn-danger" value="Delete" />
            {{ Form::close() }}
        @else
            {{ Form::open(array('role'=>'form',
                                'url'=>'admin/sponsors/hard-delete/'.$sponsor->id,
                                'class'=>'deleteForm',
                                'data-confirm'=>'Delete this sponsor forever?  This action cannot be undone!')) }}
                <input type="submit" class="btn btn-sm btn-danger" value="Delete Forever" />
            {{ Form::close() }}
            <a href="{{ url('admin/sponsors/restore/'.$sponsor->id) }}" class="btn btn-sm btn-success">Restore</a>
        @endif
    @endif

    @if ($action == 'edit')
        {{ Form::model($sponsor) }}
    @elseif ($action == 'add')
        {{ Form::open(array('role'=>'form', 'method'=>'post')) }}
    @endif

    <div class="row">
        <div class="col-md-9">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>
                            {{ Form::label('name', 'Name') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('url', 'URL') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::text('url', null, array('class'=>'form-control', 'placeholder'=>'URL')) }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('banner', 'Banner Image') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::text('banner', null, array('class'=>'form-control', 'placeholder'=>'Banner Image')) }}
                            </div>
                            <div class="text-right pad" style="width:300px">
                                <button type="button" class="btn btn-default fileBrowse">Browse...</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('video', 'Video (Embed Code)') }}
                        </td>
                        <td>
                            {{ Form::textarea('video', null, array('class' => 'form-control', 'placeholder' => 'Video (Embed Code)')) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('description', 'Description') }}
                        </td>
                        <td>
                            {{ Form::textarea('description', null, array('class'=>'ckeditor')) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>{{-- Left Column --}}
        <div class="col-md-3">
            <div class="expandBelow">
                <span class="glyphicon glyphicon-chevron-down"></span> Publish
            </div>
            <div class="expander">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('published', 1, true) }} Published
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('published_range', 1, false, array('class'=>'showID', 'data-id'=>'dateRange')) }} Specific Date Range
                    </label>
                </div>
                <div id="dateRange">
                    <div class="form-group">
                        {{ Form::label('published_start', 'Start Publication') }}
                        {{ Form::text('published_start', null, array('class'=>'form-control date-time')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('published_end', 'End Publication') }}
                        {{ Form::text('published_end', null, array('class'=>'form-control date-time')) }}
                    </div>
                </div>
            </div>{{-- Right Column --}}
        </div>
    </div>{{-- Row --}}
    <div class="text-right pad">
        <input type="submit" class="btn btn-primary" value="Save" />
    </div>
    {{ Form::close() }}
@stop
