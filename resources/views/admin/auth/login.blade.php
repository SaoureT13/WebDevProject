<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/style_login.css'])
</head>

<body>
<div class="position-relative">
    <div class="couvercle">
        <div class="container">
            <form action="{{ url('/admin/login') }}" method="POST">
                @csrf
                <div class="form_head">
                    <h1 class="h1">Bienvenu Administrateur</h1>
                    <p class="p11">
                    </p>
                </div>

                <div class="form_body">
                    @if(session('error'))
                        <div class="alert">  {{ session('error') }}</div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert">{{ $errors->first('email') }}</div>
                    @endif
                    <div class="form_container">
                        <div class="input-box @if ($errors->has('email')) error @endif">
                            <input type="text" name="email" value="{{ old('email') }}" id="email" required>
                            <label for="email" class="@if ($errors->has('email')) error @endif">Email</label>
                        </div>
                        <div class="input-box  @if ($errors->has('email')) error @endif">
                            <input type="password" name="password" id="password" required
                                   class="input_field">
                            <label for="password" class="@if ($errors->has('password')) error @endif">Mot de
                                passe</label>
                            <img src="../eye-outline.svg" width="26" class="show_password" alt="show-password">
                        </div>

                        <button class="next" type="submit">Connexion<ion-icon
                                name="arrow-forward-outline"></ion-icon></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

</html>
