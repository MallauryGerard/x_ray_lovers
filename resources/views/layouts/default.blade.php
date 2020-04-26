<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Plateforme x-ray-lovers" />
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Custom global CSS -->
        <link rel="stylesheet" href="/style.css" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">X-ray lovers</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('patient.create') }}">
                            <i class="fas fa-user-plus"></i> Ajouter un patient
                        </a>
                    </li>
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Rendez-vous
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item py-2" href="{{ route('appointment.indexAgenda') }}">
                                <i class="far fa-calendar-alt"></i> Agenda des rendez-vous
                            </a>
                            <a class="dropdown-item py-2" href="{{ route('appointment.create') }}">
                                <i class="fas fa-plus"></i> Ajouter un rendez-vous
                            </a>
                            <a class="dropdown-item py-2" href="{{ route('appointment.index') }}">
                                <i class="fas fa-search"></i> Rechercher un rendez-vous
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container my-5 pb-5">
            @include('includes.flashMessage')
            @yield('content')
        </div>
        <script type="application/javascript">
            $('#flash-message').delay(3000).fadeOut('slow');
        </script>
    </body>
</html>