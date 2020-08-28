@if($childsField !== null)
    @php($childs = $item->{$childsField})
    @if(count($childs) > 0)
        <label class="checkbox-group-item">
            <input type="{{ $type }}" name="{{ $formName }}[{{ $name }}]@if($multiple)[]@endif" value="{{ $idResolver($item) }}" @if(in_array($idResolver($item), $selected)) checked @endif />
            <span>{{ $valueResolver($item) }}</span>
        </label>
        <div class="checkbox-group">
            @foreach($childs as $item)
                @component('formy::field.choice_inputs_item_or_group', [
                    'item' => $item,
                    'idResolver' => $idResolver,
                    'valueResolver' => $valueResolver,
                    'type' => $type,
                    'childsField' => $childsField,
                    'formName' => $formName,
                    'name' => $name,
                    'selected' => $selected,
                    'multiple' => $multiple
                ])@endcomponent
            @endforeach
        </div>
    @else
        <label class="checkbox-group-item">
            <input type="{{ $type }}" name="{{ $formName }}[{{ $name }}]@if($multiple)[]@endif" value="{{ $idResolver($item) }}" @if(in_array($idResolver($item), $selected)) checked @endif />
            <span>{{ $valueResolver($item) }}</span>
        </label>
    @endif
@else
    <label class="checkbox-group-item">
        <input type="{{ $type }}" name="{{ $formName }}[{{ $name }}]@if($multiple)[]@endif" value="{{ $idResolver($item) }}" @if(in_array($idResolver($item), $selected)) checked @endif />
        <span>{{ $valueResolver($item) }}</span>
    </label>
@endif
