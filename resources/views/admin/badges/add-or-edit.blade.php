@extends('admin.template')

@section('title', ucfirst($action).' Badge')

@section('css')
@stop

@section('js')
    {{ HTML::script('assets/js/ckeditor/ckeditor.js') }}
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
                window.open('/assets/js/kcfinder/browse.php?type=images', 'file_browser', 'width=1000,height=600');
            });
        });
    </script>
@stop

@section('content')
    <h1>{{ ucfirst($action) }} Badge</h1>
    @if ($action == 'edit')
        @if (!$badge->deleted_at)
            {{ Form::open(array('role'=>'form',
                                'url'=>'admin/badges/delete/'.$badge->id,
                                'style'=>'margin-bottom:15px;')) }}
                <input type="submit" class="btn btn-sm btn-danger" value="Delete" />
            {{ Form::close() }}
        @else
            {{ Form::open(array('role'=>'form',
                                'url'=>'admin/badges/hard-delete/'.$badge->id,
                                'class'=>'deleteForm',
                                'data-confirm'=>'Delete this badge forever?  This action cannot be undone!')) }}
                <input type="submit" class="btn btn-sm btn-danger" value="Delete Forever" />
            {{ Form::close() }}
            <a href="{{ url('admin/badges/restore/'.$badge->id) }}" class="btn btn-sm btn-success">Restore</a>
        @endif
    @endif

    @if ($action == 'edit')
        {{ Form::model($badge) }}
    @elseif ($action == 'add')
        {{ Form::open(array('role'=>'form', 'method'=>'post')) }}
    @endif

    @if (isset($menu_id))
        {{ Form::hidden('menu_id', $menu_id) }}
    @endif

    <?php
        $types = array(
            '' => 'Select Type...',
            'cardio' => 'Cardio',
            'strength' => 'Strength/Resistance Training',
            'mind' => 'Mind/Body',
            'sports' => 'Sports & Fitness',
        );
    ?>
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
                            {{ Form::label('icon', 'Icon') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::text('icon', null, array('class'=>'form-control', 'placeholder'=>'Icon')) }}
                            </div>
                            <div class="text-right pad" style="width:300px">
                                <button type="button" class="btn btn-default fileBrowse">Browse...</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('category', 'Category') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::select('category', $types, null, array('class'=>'form-control', 'placeholder'=>'Category')) }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('minutes', 'Minutes') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::text('minutes', null, array('class'=>'form-control', 'placeholder'=>'Minutes')) }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('description', 'Description') }}
                        </td>
                        <td>
                            {{ Form::textarea('description', null, array('class'=>'form-control')) }}
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