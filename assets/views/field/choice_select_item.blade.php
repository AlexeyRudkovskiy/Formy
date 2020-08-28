<option value="{{ $idResolver !== null ? $idResolver($item) : $item }}">
    {{ $valueResolver !== null ? $valueResolver($item) : $item }}
</option>
