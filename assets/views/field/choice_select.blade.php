<div class="form-group">
    <label for="{{ $name }}">{{ $name }}</label>
    <select @if($multiple) name="{{ $formName }}[{{ $name }}]@if($multiple)[]@endif" @else name="{{ $formName }}[{{ $name }}]" @endif @if($multiple) multiple @endif>
        @foreach($items as $item)
            @component('formy::field.choice_select_item_or_group', [
                'childsField' => $childsField,
                'item' => $item,
                'idResolver' => $idResolver,
                'valueResolver' => $valueResolver
            ])@endcomponent
        @endforeach
    </select>
</div>
