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

        .container{
            height: 640px;
        }

        .container form .form_container .input-box .error{
            position: absolute;
            bottom: -20px;
            display: flex;
            align-items: center;
            gap: 5px;
            color: red;
            font-size: .8em;
        }
    </style>
</head>

<body>
    <div class="position-relative">
        <div class="couvercle">
            <div class="container">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <div class="form_head">
                        <div class="logo">
                            <img src="{{ asset('img/logo-pg.png') }}" alt="logo" width="200px">
                        </div>
                        <h1 class="h1"> Réinitialiser votre mot de passe </h1>
                        <p>Saisissez votre adresse e-mail associer à votre compte et votre nouveau mot de passe.</p>
                    </div>
                    <div class="form_body">
{{--                        <!-- @if ( Session::has('status') )--}}
{{--                        <span class="alert alert-error">{{ Session::get('status') }}</span>--}}
{{--                        @endif--}}
                        @error('email')
                        <span class="alert alert-error">{{ $message }}</span>
                        @enderror
                        <div class="form_container">
                            <input type="hidden" value="{{ $token }}" name="token">
                            <div class="input-box @error('email') error @enderror">
                                <input type="text" name="email" id="email" required>
                                <label for="email">Adresse Email</label>

                                @error('email')
                                <span class="error">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>
                                    {{ $message }}
                                </span> 
                                @enderror
                            </div>


                            <div class="input-box @error('password') error @enderror">
                                <input type="password" name="password" id="password" class="input-password" required>
                                <label for="password">Mot de passe</label>
                                <img src="{{ asset('img/eye-off.svg') }}" width="26" class="show_password" alt="show-password">

                                @error('password')
                                <span class="error">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>

                            <div class="input-box @error('password_confirmation') error @enderror">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="input-password" required>
                                <label for="password_confirmation">Confirmer votre mot de passe</label>
                                <img src="{{ asset('img/eye-off.svg') }}" width="26" class="show_password" alt="show-password">

                                @error('password_confirmation')
                                <span class="error">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>


                            <button class="next" type="submit">Continuer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const showPasswords = document.querySelectorAll('.show_password')

        showPasswords.forEach((show) => {
            show.addEventListener('click', (e)=>{
                const parent = e.currentTarget.parentElement;
                const currentInput = parent.querySelector('.input-password')


                currentInput.setAttribute(
                    "type",
                    currentInput.getAttribute("type") === "password" ? "text" : "password"
                )

                e.currentTarget.setAttribute(
                    "src",
                    currentInput.getAttribute("type") === "password" ?
                        "{{ asset('img/eye-off.svg') }}" :
                        "{{ asset('img/eye.svg') }}"
                );
            })
        })

    </script>
</body>

</html>
