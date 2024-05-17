<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('favicon_import')
    @vite(['resources/css/style_register.css', 'resources/js/script_register.js'])
</head>

<body>
    <div class="container-form">
        <div class="couvercle">
            <div class="container">
                <form action="{{ url('/student/register') }}" method="post">
                    @csrf
                    <div class="form_head">
                        <div class="title">
                            <h1 class="h1">Inscription</h1>
                            <div class="step__circles">
                                <p class="circle active">1</p>
                                <p class="circle">2</p>
                            </div>
                        </div>
                        <p class="p11"> Avez vous un compte?
                            <a href="{{ url('/student/login') }}" class="inscription">Connexion</a>
                        </p>
                    </div>
                    <div class="form_body">
                        <div class="form_container step_1  current">
                            <div class="input-box @error('full_name') error @enderror">
                                <input type="text" required autocomplete="off" name="full_name" id="full_name" value="{{ old('full_name') }}">
                                <label for="full_name">Nom & Prénom*</label>
                                @error('full_name')
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
                            <div class="input-box @error('serial_number') error @enderror">
                                <input type="text" maxlength="7" required name='serial_number' id="serial_number" autocomplete="off" value="{{ old('serial_number') }}">
                                <label for="serial_number">Matricule*</label>
                                @error('serial_number')
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
                            <div class="input-box @error('phone_number') error @enderror">
                                <input type="tel" maxlength="10" required autocomplete="off" name="phone_number" id="phone_number" value="{{ old('phone_number') }}">
                                <label for="phone_number">Numero de téléphone*</label>
                                @error('phone_number')
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
                            <div class="input-box @if ($errors->has('email')) error @endif">
                                <input type="text" required name="email" id="email" autocomplete="off" value="{{ old('email') }}">
                                <label for="email" class="@if ($errors->has('email')) error @endif @error('phone_number') error @enderror">Adresse e-mail*</label>
                                @if ($errors->has('email'))
                                <span class="error">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>
                            <div class="input-box @error('password') error @enderror">
                                <input type="password" minlength="4" required autocomplete="off" name="password" id="password" class="input_field">
                                <label for="password">Mot de passe*</label>
                                <img src="{{ asset('img/eye-off.svg') }}" alt="show_password" width="26" class="show_password">
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

                            <button class="next" type="button">Continuer<ion-icon name="arrow-forward-outline"></ion-icon></button>
                        </div>

                        <div class="form_container step_2 ">
                            <div class="select-group @error('parcours_id') error @enderror">
                                <label for="parcours">Parcours</label>
                                <select name="parcours_id" id="parcours">
                                    <option value="">Sélectionner votre filière</option>
                                    @foreach ($parcours as $p)
                                    <option value="{{ $p->id }}" @if(old('parcours_id')==$p->id)
                                        selected
                                        @endif>{{ $p->name }}</option>
                                    @endforeach
                                </select>

                                @error('parcours_id')
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

                            <div class="select-group @error('diplome_prepare_id') error @enderror">
                                <label for="diplome">Diplôme préparé</label>
                                <select name="diplome_prepare_id" id="diplome">
                                    <option value="">Sélectionner votre diplome à preparé</option>
                                    @foreach ($d_preparé as $d)
                                    <option value="{{ $d->id }}" @if(old('diplome_prepare_id')==$d->id)
                                        selected
                                        @endif>{{ $d->name }}</option>
                                    @endforeach
                                </select>

                                @error('diplome_prepare_id')
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

                            <div class="diplome_obtenu">
                                <h4>Diplôme(s) obtenu(s)</h4>
                                <div class="list_choice">
                                    <div class="choice">
                                        <p>
                                            <input type="checkbox" id="bac" name="bac_option">
                                            <label for="bac">BAC</label>
                                        </p>
                                        <input type="text" placeholder="Date d'admission" name="bac">
                                    </div>
                                    <div class="choice">
                                        <p>
                                            <input type="checkbox" id="bts" name="bts_option">
                                            <label for="bts">BTS</label>
                                        </p>
                                        <input type="text" placeholder="Date d'admission" name="bts">
                                    </div>
                                    <div class="choice">
                                        <p>
                                            <input type="checkbox" id="licence" name="licence_option">
                                            <label for="licence">LICENCE</label>
                                        </p>
                                        <input type="text" placeholder="Date d'admission" name="licence">
                                    </div>
                                    <div class="choice">
                                        <p>
                                            <input type="checkbox" id="master" name="master_option">
                                            <label for="master">MASTER</label>
                                        </p>
                                        <input type="text" placeholder="Date d'admission" name="master">
                                    </div>
                                </div>
                            </div>

                            <div class="btn_box">
                                <button class="previous" type="button"><ion-icon name="arrow-back-outline"></ion-icon>Revenir</button>
                                <button type="submit">S'inscrire</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{ url('js/script_register.js') }}"></script>
    <script>
        let showPassword = document.querySelector(".show_password");
        let inputPassword = document.querySelector(".input_field");

        showPassword.addEventListener("click", (e) => {
            e.preventDefault();

            inputPassword.setAttribute(
                "type",
                inputPassword.getAttribute("type") === "password" ? "text" : "password"
            );

            showPassword.setAttribute(
                "src",
                inputPassword.getAttribute("type") === "password" ?
                "{{ asset('img/eye-off.svg') }}" :
                "{{ asset('img/eye.svg') }}"
            );
        });
    </script>
</body>

</html>