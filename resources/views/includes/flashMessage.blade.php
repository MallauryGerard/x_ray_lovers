@if ($message = session('success'))
<div id="flash-message" role="alert">
    <div class="alert alert-success" style="">
        {!! $message !!}
    </div>
</div>
@elseif ($message = session('error'))
<div id="flash-message" role="alert">
    <div class="alert alert-danger" style="">
        {!! $message !!}
    </div>
</div>
@elseif ($message = session('warning'))
<div id="flash-message" role="alert">
    <div class="alert alert-warning" style="">
        {!! $message !!}
    </div>
</div>
@elseif ($message = session('info'))
<div id="flash-message" role="alert">
    <div class="alert alert-info" style="">
        {!! $message !!}
    </div>
</div>
@endif