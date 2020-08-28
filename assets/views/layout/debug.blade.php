@if($level === 0)
<form class="form form-{{ $cssClass }}" data-level="{{ $level }}" method="post" action="{{ $url }}">
    @csrf
    {{ $errors }}
@else
<div class="inner-form form-{{ $cssClass }}" data-level="{{ $level }}">
@endif
    @foreach($form->getFields() as $field)
        {{ $field->render() }}
    @endforeach
@if($level === 0)
</form>
@else
</div>
@endif
