@if($childsField !== null)
    @php($childs = $item->{$childsField})
    @if(count($childs) > 0)
        <optgroup label="{{ $valueResolver($item) }}">
        @foreach($childs as $child)
            @component('formy::field.choice_select_item_or_group', [
                'childsField' => $childsField,
                'item' => $child,
                'idResolver' => $idResolver,
                'valueResolver' => $valueResolver
            ])@endcomponent
        @endforeach
        </optgroup>
    @else
        @component('formy::field.choice_select_item', [
            'item' => $item,
            'idResolver' => $idResolver,
            'valueResolver' => $valueResolver
        ])@endcomponent
    @endif
@else
    @component('formy::field.choice_select_item', [
        'item' => $item,
        'idResolver' => $idResolver,
        'valueResolver' => $valueResolver
    ])@endcomponent
@endif
