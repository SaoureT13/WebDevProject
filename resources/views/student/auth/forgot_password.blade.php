<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('favicon_import')
    @vite(['resources/css/style_login.css'])
    <style>
        /* .logo{
            text-align: center;
        } */
        
    </style>
</head>

<body>
    <div class="position-relative">
        <div class="couvercle">
            <div class="container">
                <form action="{{ route('student.forgotPassword') }}" method="POST">
                    @csrf
                    <div class="form_head">
                        <div class="logo">
                            <img src="{{ asset('img/logo-pg.png') }}" alt="logo" width="200px">
                        </div>
                        <h1 class="h1">Aide avec le mot de passe </h1>
                        <p>Saisissez votre adresse e-mail associer à votre compte.</p>
                    </div>
                    <div class="form_body">
                        @if ( Session::has('status') )
                        <span class="alert alert-success">{{ Session::get('status') }}</span>
                        @endif
                        @error('email')
                        <span class="alert alert-error">{{ $message }}</span>
                        @enderror
                        <div class="form_container">
                            <div class="input-box">
                                <input type="email" name="email" id="email" required>
                                <label for="email">Adresse Email</label>
                            </div>

                            <button class="next" type="submit">Continuer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>