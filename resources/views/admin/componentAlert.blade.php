@php
    $showErrors = $errors->getBags();
    if ( ! empty($errorType)) {
        $showErrors = [$errorType => $errors->getBag($errorType)];
    }
@endphp

@foreach ($showErrors as $errorType => $showError)
    @foreach ($showError->messages() as $key => $messages)
        @foreach ($messages as $message)
<div class="alert alert-{{ ! empty($errorLevel) ? $errorLevel : 'danger' }} alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{--<strong>{{ $key }}: </strong>--}} {{ $message }}
</div>
        @endforeach
    @endforeach
@endforeach
