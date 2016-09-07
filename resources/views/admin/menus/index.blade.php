@extends('admin.template')

@section('title', 'Menus')

@section('css')
    {{ HTML::style('assets/admin/menus/index.css?v=' . VERSION) }}
@stop

@section('js')
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js') }}
    <script>
        var linkable_models = {{ json_encode($linkable_models) }};
    </script>
    {{ HTML::script('assets/admin/menus/index.js?v=' . VERSION) }}
@stop

@section('content')
    <div class="row pad">
        <div class="col-sm-8 pad">
            <h1>Menus</h1>
            <a class="btn btn-sm btn-primary" href="{{ URL::to('admin/menus/add') }}">
                <span class="glyphicon glyphicon-plus"></span>
                Add
            </a>
        </div>
    </div>
    <div class="row text-center">
        {{ $links }}
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width:60px;"></th>
                <th style="width:80px;">ID</th>
                <th style="width:200px;">Name</th>
                <th>Links</th>
            </tr>
            </thead>
            <tbody>
            @foreach($menus as $menu)
            <tr{{ $menu->deleted_at ? ' class="deleted"' : '' }}>
                <td>
                    <a href="{{ URL::to('admin/menus/edit/' . $menu->id) }}" class="btn btn-xs btn-default">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
                <td>{{ $menu->id }}</td>
                <td>{{ $menu->name }}</td>
                <td data-id="{{ $menu->id }}">
                    @if (!$menu->deleted_at)
                        @include('admin.menus.menu-items')
                        <button class="btn btn-xs btn-primary showWizard" data-toggle="modal" data-target="#wizard">
                            <span class="glyphicon glyphicon-plus"></span>
                            Add Link
                        </button>
                    @else
                        <em>Restore to view</em>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row text-center">
        {{ $links }}
    </div>

    {{-- Wizard --}}
    <div class="modal fade" id="wizard" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Link Wizard</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => 'admin/menus/item-add', 'role'=>'form', 'method'=>'post')) }}
                        <div class="wizSlide">
                            <p>Where would you like your link to point to?</p>
                            <div class="form-group">
                                {{ $model_select }}
                            </div>
                            <p class="text-right">
                                <button type="button" class="btn btn-info wizNext">Next</button>
                            </p>
                        </div>
                        <div class="wizSlide">
                            <p>What kind of <span class="model"></span> would you like your link to point to?</p>
                            <div class="radio">
                                <label>
                                    {{ Form::radio('modelType', 'existing', true, array('class'=>'modelType')) }}
                                    Existing <span class="model"></span>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    {{ Form::radio('modelType', 'new', null, array('class'=>'modelType')) }}
                                    Create New <span class="model"></span>
                                </label>
                            </div>
                            <p class="text-right">
                                <button type="button" class="btn btn-info wizNext" id="existingNext">Next</button>
                                <a href="" class="btn btn-info" id="newNext">Next</a>
                            </p>
                        </div>
                        <div class="wizSlide">
                            <p>Which existing <span class="model"></span> would you like your link to point to?</p>
                            <div id="existingModelWrap" class="form-group"></div>
                            {{ Form::hidden('menu_id') }}
                            {{ Form::hidden('order') }}
                            <p class="text-right">
                                <button type="submit" class="btn btn-success">Add Link</button>
                            </p>
                        </div>
                    {{ Form::close() }}
                </div>{{-- Modal --}}
            </div>{{-- Modal --}}
        </div>{{-- Modal --}}
    </div>{{-- Modal --}}
@stop