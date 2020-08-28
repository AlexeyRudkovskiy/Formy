@php($type = $multiple ? 'checkbox' : 'radio')
<div class="form-group">
    <label>{{ $name }}</label>
    <div class="checkbox-group">
        @foreach($items as $item)
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
</div>
