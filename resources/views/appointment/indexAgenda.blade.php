@extends('layouts.default')

@section('content')
<link rel="stylesheet" href="/fullcalendar/core/main.css" />
<link rel="stylesheet" href="/fullcalendar/daygrid/main.css" />
<link rel="stylesheet" href="/fullcalendar/timegrid/main.css" />
<link rel="stylesheet" href="/fullcalendar/list/main.css" />
<link rel="stylesheet" href="/fullcalendar/interaction/main.css" />
<link rel="stylesheet" href="/fullcalendar/style.css" />


<h2>Rendez-vous</h2>
<p>
Urgence:
<span class="badge faible">faible</span>
<span class="badge modérée">modérée</span>
<span class="badge élevée">élevée</span>
</p>
<div id="calendar"></div>

<script>
    let appointments = {!! $appointments !!}
    ;
</script>
<script src="/fullcalendar/core/main.js"></script>
<script src="/fullcalendar/daygrid/main.js"></script>
<script src="/fullcalendar/timegrid/main.js"></script>
<script src="/fullcalendar/list/main.js"></script>
<script src="/fullcalendar/interaction/main.js"></script>
<script src="/fullcalendar/js.js"></script>
@endsection