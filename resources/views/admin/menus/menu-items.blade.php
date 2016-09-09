<table class="table table-striped linksTable">
    <thead>
        <tr>
            <th></th>
            <th style="width:100px">Module</th>
            @if (!$single_language)
                <th style="width:120px">Language</th>
            @endif
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $models = Menu::get_models($menu->menuItems);
        ?>
        @foreach ($menu->menuItems as $menu_item)
            <tr data-id="{{ $menu_item->id }}">
                <td style="width:120px;">
                    <button type="button" class="btn btn-xs btn-default handle">
                        <span class="glyphicon glyphicon-resize-vertical"></span>
                    </button>
                    <a href="{{ $models[$menu_item->order]->link() }}" class="btn btn-xs btn-info" target="_blank">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                    <button type="button" class="btn btn-xs btn-danger deleteLink">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
                <td>
                    {{ $models[$menu_item->order]->name_module() }}
                </td>
                @if (!$single_language)
                    <td>
                        {{ $models[$menu_item->order]->language->name }}
                    </td>
                @endif
                <td>
                    {{ Form::hidden(null, $menu_item->order, array('class'=>'orderInput')) }}
                    <a href="{{ $models[$menu_item->order]->link_edit() }}">
                        {{ $models[$menu_item->order]->name() }}
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>