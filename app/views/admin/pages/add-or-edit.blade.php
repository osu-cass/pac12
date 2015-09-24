@extends('admin.template')

@section('title', ucfirst($action).' Page')

@section('css')
	{{ HTML::style('assets/js/jquery/jquery.datetimepicker.css') }}
	{{ HTML::style('assets/admin/pages/add-or-edit.css?v=' . VERSION) }}
@stop

@section('js')
	{{ HTML::script('assets/js/ckeditor/ckeditor.js') }}
	{{ HTML::script('assets/js/jquery/jquery.datetimepicker.js') }}
	{{ HTML::script('assets/admin/pages/add-or-edit.js?v=' . VERSION) }}
@stop

@section('content')
	<h1>{{ ucfirst($action) }} Page</h1>
	@if ($action == 'edit')
		@if (!$page->deleted_at)
			{{ Form::open(array('role'=>'form',
								'url'=>'admin/pages/delete/'.$page->id,
								'style'=>'margin-bottom:15px;')) }}
				<input type="submit" class="btn btn-sm btn-danger" value="Delete" />
			{{ Form::close() }}
		@else
			{{ Form::open(array('role'=>'form',
								'url'=>'admin/pages/hard-delete/'.$page->id,
								'class'=>'deleteForm',
								'data-confirm'=>'Delete this page forever?  This action cannot be undone!')) }}
				<input type="submit" class="btn btn-sm btn-danger" value="Delete Forever" />
			{{ Form::close() }}
			<a href="{{ URL::to('admin/pages/restore/'.$page->id) }}" class="btn btn-sm btn-success">Restore</a>
		@endif
	@endif

	@if ($action == 'edit')
		{{ Form::model($page) }}
	@elseif ($action == 'add')
		{{ Form::open(array('role'=>'form', 'method'=>'post')) }}
	@endif

	@if (isset($menu_id))
		{{ Form::hidden('menu_id', $menu_id) }}
	@endif

	<div class="row">
		<div class="col-md-9">
			<table class="table table-striped">
				<tbody>
					<tr>
						<td>
							{{ Form::label('language_id', 'Language') }}
						</td>
						<td>
							<div style="width:300px">
								{{ Form::select('language_id', $language_drop, $active_language->id, array('class' => 'form-control')) }}
							</div>
						</td>
					</tr>
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
							{{ Form::label('html', 'HTML') }}
						</td>
						<td>
							{{ Form::textarea('html', null, array('class'=>'ckeditor')) }}
						</td>
					</tr>
					<tr>
						<td>
							<b>Modules</b>
							<div class="checkbox">
								<label>
									<input type="checkbox" class="showID" data-id="modules" checked /> Show
								</label>
							</div>
						</td>
						<td id="modules">
							<div class="modules">
								@if ($action == 'edit')
									@foreach($page->modules as $module)
										<div class="module" data-num="{{ $module->number }}">
											<p><b>Module {{ $module->number }}</b>
												<a href="/admin/pages/delete-module/{{ $module->id }}" class="btn btn-xs btn-danger" style="float: right;">
													<span class="glyphicon glyphicon-remove"></span>
												</a>
											</p>
											<textarea class="ckeditor" name="modules[{{ $module->number }}]">
												{{ $module->html }}
											</textarea>
										</div>
									@endforeach
								@endif
								@if ($action == 'add' || !count($page->modules))
									<div class="module" data-num="1">
										<p><b>Module 1</b></p>
										<textarea class="ckeditor" name="modules[1]"></textarea>
									</div>
								@endif
							</div>
							<div class="pad">
								<button type="button" class="btn btn-sm btn-default add-module">
									<span class="glyphicon glyphicon-plus"></span>
									Add
								</button>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							{{ Form::label('js', 'JavaScript') }}
							<div class="checkbox">
								<label>
									<input type="checkbox" class="showID" data-id="js" /> Show
								</label>
							</div>
						</td>
						<td>
							{{ Form::textarea('js', null, array('id'=>'js', 'spellcheck'=>'false', 'class'=>'form-control allowTab')) }}
						</td>
					</tr>
					<tr>
						<td>
							{{ Form::label('css', 'CSS') }}
							<div class="checkbox">
								<label>
									<input type="checkbox" class="showID" data-id="css" /> Show
								</label>
							</div>
						</td>
						<td>
							{{ Form::textarea('css', null, array('id'=>'css', 'spellcheck'=>'false', 'class'=>'form-control allowTab')) }}
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
			</div>
			<div class="expandBelow">
				<span class="glyphicon glyphicon-chevron-down"></span> Meta
			</div>
			<div class="expander">
				<div class="form-group">
					{{ Form::label('title', 'Title') }}
					{{ Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Title')) }}
				</div>
				<div class="form-group">
					{{ Form::label('meta_description', 'Description') }}
					{{ Form::textarea('meta_description', null, array('class'=>'form-control', 'placeholder'=>'description')) }}
				</div>
				<div class="form-group">
					{{ Form::label('meta_keywords', 'Keywords') }}
					{{ Form::textarea('meta_keywords', null, array('class'=>'form-control', 'placeholder'=>'keywords')) }}
				</div>
			</div>
			<div class="expandBelow">
				<span class="glyphicon glyphicon-chevron-down"></span> FB Open Graph
			</div>
			<div class="expander">
				<div class="form-group">
					{{ Form::label('og_type', 'og:type') }}
					{{ Form::text('og_type', null, array('class'=>'form-control input-sm', 'placeholder'=>'og:type')) }}
				</div>
				<div class="form-group">
					{{ Form::label('og_image', 'og:image') }}
					{{ Form::text('og_image', null, array('class'=>'form-control input-sm', 'placeholder'=>'og:image')) }}
					<div class="text-right pad">
						<button type="button" class="btn btn-default imageBrowse">Browse...</button>
					</div>
				</div>
			</div>
			<div class="expandBelow">
				<span class="glyphicon glyphicon-chevron-down"></span> Twitter Cards
			</div>
			<div class="expander">
				<div class="form-group">
					{{ Form::label('twitter_card', 'twitter:card') }}
					{{ Form::text('twitter_card', null, array('class'=>'form-control input-sm', 'placeholder'=>'twitter:card')) }}
				</div>
				<div class="form-group">
					{{ Form::label('twitter_image', 'twitter:image') }}
					{{ Form::text('twitter_image', null, array('class'=>'form-control input-sm', 'placeholder'=>'twitter:image')) }}
					<div class="text-right pad">
						<button type="button" class="btn btn-default imageBrowse">Browse...</button>
					</div>
				</div>
			</div>
			@if ($action == 'edit')
				<div class="expandBelow">
					<span class="glyphicon glyphicon-chevron-down"></span> Change Log
				</div>
				<div class="expander changesExpander">
					@if (!count($changes))
						<p><em>No changes yet.</em></p>
					@else
						<table class="table table-striped">
							<tbody>
								@foreach ($changes as $change)
									<tr>
										<td>
											<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#changeModal{{ $change->id }}">
												<span class="glyphicon glyphicon-eye-open"></span>
											</button>
											<div class="modal fade" id="changeModal{{ $change->id }}" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Change Details</h4>
														</div>
														<div class="modal-body">
															<table class="table table-striped">
																<tbody>
																	<tr>
																		<td><strong>Date</strong></td>
																		<td>{{ $change->created_at }}</td>
																	</tr>
																	<tr>
																		<td><strong>User</strong></td>
																		<td>{{ $change->user->full_name() }}</td>
																	</tr>
																	<tr>
																		<td><strong>Email</strong></td>
																		<td>{{ $change->user->email }}</td>
																	</tr>
																</tbody>
															</table>
															@foreach (json_decode($change->changes) as $column=>$this_change)
																<div class="panel panel-info">
																	<div class="panel-heading">
																		<strong>{{ $column }}</strong>
																	</div>
																	<table class="table table-bordered">
																		<thead>
																			<tr>
																				<th class="text-center">Before</th>
																				<th class="text-center">After</th>
																			</tr>
																		</thead>
																		<tbody>
																			<tr>
																				<td>{{ $this_change->old }}</td>
																				<td>{{ $this_change->new }}</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															@endforeach
														</div>{{-- Modal --}}
													</div>{{-- Modal --}}
												</div>{{-- Modal --}}
											</div>{{-- Modal --}}
										</td>
										<td>
											{{ $change->created_at }}
										</td>
									</tr>{{-- Change Row --}}
								@endforeach
							</tbody>
						</table>{{-- Changes Table --}}
					@endif
				</div>{{-- Changes Expander --}}
			@endif
		</div>{{-- Right Column --}}
	</div>{{-- Row --}}
	<div class="text-right pad">
		<input type="submit" class="btn btn-primary" value="Save" />
	</div>
	{{ Form::close() }}
@stop