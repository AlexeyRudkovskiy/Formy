@php($pathAsString = implode('-', $path))
@php($pathWithDots = implode('.', $path))
<div class="form-group form-group-{{ $pathAsString }}">
    <label>{{ $label }}</label>
    <input type="{{ $type }}" @if($classes !== null) class="{{ implode(' ', $classes) }}" @endif placeholder="{{ $placeholder }}" value="{{ $value }}"
        name="{{ $formName }}[{{ $name }}]"
        @foreach($options ?? [] as $name => $value) @if(is_array($value) || is_object($value)) @continue @endif {{$name}}="{{$value}}" @endforeach
    />
    @php($fieldErrors = $errors->get($pathWithDots))
    @if(count($fieldErrors) > 0)
    <div class="errors-list">
    @foreach($fieldErrors as $error)
        <div class="errors-list-item">{{ $error }}</div>
    @endforeach
    </div>
    @endif
</div>
