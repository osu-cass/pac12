@extends('admin.template')

@section('title', ucfirst($action).' Challenge')

@section('css')
    {{ HTML::style('assets/js/jquery/jquery.datetimepicker.css') }}
@stop

@section('js')
    {{ HTML::script('assets/js/ckeditor/ckeditor.js') }}

    {{ HTML::script('assets/js/jquery/jquery.datetimepicker.js') }}
    <script>
        $(document).ready(function() {
            // Date / time picker
            $('.date').datetimepicker({
                format: 'Y-m-d',
                timepicker: false
            });

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
    <h1>{{ ucfirst($action) }} Challenge</h1>
    @if ($action == 'edit')
        @if (!$challenge->deleted_at)
            {{ Form::open(array('role'=>'form',
                                'url'=>'admin/challenges/delete/'.$challenge->id,
                                'style'=>'margin-bottom:15px;')) }}
                <input type="submit" class="btn btn-sm btn-danger" value="Delete" />
            {{ Form::close() }}
        @else
            {{ Form::open(array('role'=>'form',
                                'url'=>'admin/challenges/hard-delete/'.$challenge->id,
                                'class'=>'deleteForm',
                                'data-confirm'=>'Delete this challenge forever?  This action cannot be undone!')) }}
                <input type="submit" class="btn btn-sm btn-danger" value="Delete Forever" />
            {{ Form::close() }}
            <a href="{{ url('admin/challenges/restore/'.$challenge->id) }}" class="btn btn-sm btn-success">Restore</a>
        @endif
    @endif

    @if ($action == 'edit')
        {{ Form::model($challenge) }}
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
                            {{ Form::label('published_start', 'Start Date') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::text('published_start', null, array('class'=>'form-control date', 'placeholder'=>'Start Date')) }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ Form::label('published_end', 'End Date') }}
                        </td>
                        <td>
                            <div style="width:300px">
                                {{ Form::text('published_end', null, array('class'=>'form-control date', 'placeholder'=>'End Date')) }}
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
                    {{ Form::hidden('published', '1') }}
                </tbody>
            </table>
        </div>{{-- Left Column --}}
    </div>{{-- Row --}}
    <div class="text-right pad">
        <input type="submit" class="btn btn-primary" value="Save" />
    </div>
    {{ Form::close() }}

@if ($action == 'edit')
    {{ Form::open(array('role'=>'form', 'method'=>'post', 'url' => 'images/upload_challenge', 'files' => true )) }}
    <h1>Images</h1>
    <div class="row">
        <div class="col-md-9">
            <div class="images col-md-9">
                @foreach (Image::where('challenge_id', '=', $challenge->id)->get() as $image)
                <div class="col-xs-3">
                    <a href="{{ $image->url() }}" target="_blank">
                        <img src="{{ $image->url() }}" style="width:100%;" />
                    </a>
                </div>
                @endforeach
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td><b>Add Image</b></td>
                        <td>
                            <input id="imageInput" type="file" name="image" />
                            <input type="hidden" name="challenge_id" value="<?php echo $challenge->id ?>"/>
<!--                            </form>-->
                        </td>
                        <td><input type="submit" class="btn btn-primary" value="Add" /></td>
                    </tr>
                </tbody>
            </table>
        </div>{{-- Left Column --}}
    </div>{{-- Row --}}
    <div class="text-right pad">
@endif
    </div>
    {{ Form::close() }}
@stop
