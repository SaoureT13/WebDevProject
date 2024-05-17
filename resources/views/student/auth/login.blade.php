<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('favicon_import')
    @vite(['resources/css/style_login.css'])
</head>

<body>
    <div class="position-relative">
        <div class="couvercle">
            <div class="container">
                <form action="{{ url('/student/login') }}" method="POST">
                    @csrf
                    <div class="form_head">
                        <h1 class="h1">Connexion</h1>
                        <p class="p11"> Vous n'avez pas de compte?
                            <a href="{{ url('/student/register') }}" class="inscription">Inscription</a>
                        </p>
                    </div>

                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (Session::has('status'))
                        <div class="alert alert-success">{{ Session::get('status') }}</div>
                    @endif

                    <div class="form_body">
                        @if(session('error'))
                        <div class="alert alert-error"> {{ session('error') }}</div>
                        @endif
                        @if ($errors->has('email'))
                        <div class="alert alert-error">{{ $errors->first('email') }}</div>
                        @endif
                        <div class="form_container">
                            <div class="input-box @if ($errors->has('email')) error @endif">
                                <input type="text" name="email" value="{{ old('email') }}" id="email" required>
                                <label for="email" class="@if ($errors->has('email')) error @endif">Email</label>
                            </div>
                            <div class="input-box  @if ($errors->has('email')) error @endif">
                                <input type="password" name="password" id="password" required class="input_password">
                                <label for="password" class="@if ($errors->has('password')) error @endif">Mot de
                                    passe</label>
                                <img src="{{ asset('img/eye-off.svg') }}" width="26" class="show_password">
                                <div class="forgot-password-info">
                                    <p>J'ai oublié <a href="{{ route('student.forgotPassword') }}" class="underline">mon mot de passe</a> ?</p>
                                </div>
                            </div>


                            <button class="next" type="submit">Connexion</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const showPassword = document.querySelector('.show_password')
        const inputPassword = document.querySelector('.input_password')

        showPassword.addEventListener("click", (e) => {
            e.preventDefault();

            inputPassword.setAttribute(
                "type",
                inputPassword.getAttribute("type") === "password" ? "text" : "password"
            );

            e.target.setAttribute(
                "src",
                inputPassword.getAttribute("type") === "password" ?
                "{{ asset('img/eye-off.svg') }}" :
                "{{ asset('img/eye.svg') }}"
            );
        });
    </script>
</body>

</html>
