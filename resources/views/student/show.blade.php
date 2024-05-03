<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    @vite(['resources/css/style_student_home.css', 'resources/css/style_student_home_details.css', 'resources/js/app.js'])
</head>

<body>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Nouvelle demande <span class="info">(Vous pouvez faire une demande à deux, veuillez choisir votre
                    partenaire si c'est le cas)</span></h2>
            <form action="{{ url('/student/request') }}" method="post">
                @csrf

                <div class="input-box">
                    <label for="partner">Partenaire:</label><br>
                    <select name="partner_id" id="partner">
                        <option value="">-- Choisir un partenaire --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-box @error('theme') error @enderror">
                    <label for="theme">Theme:</label><br>
                    <input type="text" id="theme" name="theme" value="{{ old('theme') }}"><br>
                    @error('theme')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est
                            obligatoire</span>
                    @enderror
                </div>
                <div class="input-box @error('memory_problems') error @enderror">
                    <label for="memory_problems">Problématique:</label><br>
                    <input type="text" id="memory_problems" name="memory_problems"
                        value="{{ old('memory_problems') }}"><br>
                    @error('memory_problems')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est
                            obligatoire</span>
                    @enderror
                </div>
                <div class="input-box @error('global_objective') error @enderror">
                    <label for="global_objective">Objectif global:</label><br>
                    <input type="text" id="global_objective" name="global_objective"
                        value="{{ old('global_objective') }}"><br>
                    @error('global_objective')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est
                            obligatoire</span>
                    @enderror
                </div>
                <div class="input-box @error('specific_objective') error @enderror">
                    <label for="specific_objective">Objectif spécifique:</label><br>
                    <input type="text" id="specific_objective" name="specific_objective"
                        value="{{ old('specific_objective') }}"><br>
                    @error('specific_objective')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est
                            obligatoire</span>
                    @enderror
                </div>

                <div class="input-box @error('expected_result') error @enderror">
                    <label for="expected_result">Résultat attendu:</label><br>
                    <input type="text" id="expected_result" name="expected_result"
                        value="{{ old('expected_result') }}"><br>
                    @error('expected_result')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs obligatoire</span>
                    @enderror
                </div>

                <h3>Information sur la société</h3>
                <div class="input-box @error('societe_id') error @enderror">
                    <label for="societe_id">Société:</label><br>
                    <select name="societe_id" id="societe_id">
                        <option value="0">-- Choisir une société --</option>
                        @foreach ($societes as $societe)
                            <option value="{{ $societe->id }}">{{ $societe->name }}</option>
                        @endforeach
                    </select>
                    @error('societe_id')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs obligatoire</span>
                    @enderror
                </div>

                <div class="choice-box">
                    <input type="checkbox" id="choice" name="choice">
                    <label for="choice">Entrer les données de ma société</label>
                </div>


                <div class="societe-box">
                    <div class="input-box">
                        <label for="company_name">Nom société:</label><br>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                            placeholder="Nom de la société"><br>
                    </div>
                    <div class="input-box">
                        <label for="company_contact">Contact société:</label><br>
                        <input type="text" id="company_contact" name="company_contact"
                            value="{{ old('company_contact') }}" placeholder="Contact de la société"><br>
                    </div>
                </div>

                <button type="submit" class="btn-submit" style="margin-top: 10px">Soumettre</button>
            </form>
        </div>
    </div>


    <div class="modal_request">
        <button class="new_request">
            Faire une nouvelle demande
            <ion-icon name="add-circle-outline"></ion-icon>
        </button>
    </div>


    <div class="layout-wrapper">
        <div class="layout-container">
            <header class="header">
                <div class="navigation">
                    <div class="logo">
                        <a href="#">
                            <img src="{{ asset('img/logo-pg.png') }}" alt="logo" width="140" height="44" />
                        </a>
                    </div>

                    <div class="menu">
                        <div class="burger_menu">
                            <ion-icon name="menu-outline"></ion-icon>
                        </div>

                        <div class="navbar_overlay">
                        </div>
                        <div class="user">
                            @auth
                                <p>Bonjour, {{ Auth::guard('web')->user()->full_name }}</p>
                            @endauth

                            <form action="{{ url('/student/logout') }}" method="post">
                                @csrf
                                <button type="submit">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="main" id="main">
              <div class="details-container">
                @if (Session::has('success'))
                    <div class="toast">
                        <svg width="30" height="30" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.7986 10.1111C19.7986 15.4614 15.4614 19.7986 10.1111 19.7986C4.76081 19.7986 0.423584 15.4614 0.423584 10.1111C0.423584 4.76081 4.76081 0.423584 10.1111 0.423584C15.4614 0.423584 19.7986 4.76081 19.7986 10.1111ZM8.99054 15.2405L16.178 8.05304C16.4221 7.80898 16.4221 7.41323 16.178 7.16917L15.2942 6.2853C15.0501 6.0412 14.6544 6.0412 14.4103 6.2853L8.54858 12.1469L5.8119 9.41026C5.56784 9.1662 5.1721 9.1662 4.928 9.41026L4.04413 10.2941C3.80007 10.5382 3.80007 10.9339 4.04413 11.178L8.10663 15.2405C8.35073 15.4846 8.74644 15.4846 8.99054 15.2405V15.2405Z"
                                fill="#55B938" fill-opacity="0.7" />
                        </svg>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
                <div class="details">
                    <div class="detail-item">
                        <label><u><strong>Thème :</strong></u> <span class="response">{{ $demande->theme }}</span></label>
                    </div>
                    <div class="detail-item">
                        <label><u><strong>Problèmes de mémoire :</strong></u>
                            <span
                                class="response">{{ $demande->memory_problems }}</span></label>
                    </div>
                    <div class="detail-item">
                        <label><u><strong>Objectif global :</strong></u> <span
                                class="response">{{ $demande->global_objective }}</span></label>
                    </div>
                    <div class="detail-item">
                        <label><u><strong>Objectif spécifique :</strong></u> <span
                                id="response">{{ $demande->specific_objective }}</span></label>
                    </div>
                    <div class="detail-item">
                        <label><u><strong>Résultat attendu :</strong></u> <span
                                id="response">{{ $demande->expected_result }}</span></label>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item">
                            <label><u><strong>Date de dépôt :</strong></u> <span
                                    id="response">{{ $demande->deposit_date }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><u><strong>Statut de la demande :</strong></u>
                                <span
                                    class="badge-status
                              @if (is_null($demande->request_status)) pending
                              @elseif($demande->request_status == 1) validated
                              @else rejected @endif">
                                    @if (is_null($demande->request_status))
                                        En attente
                                    @elseif($demande->request_status == 1)
                                        Validé
                                    @else
                                        Refusé
                                    @endif
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <a hx-get="/dashboard/demandes" hx-swap="innerHTML" hx-target="#main" hx-trigger="click"
                    hx-push-url="true" class="back">Retour</a>
              </div>
            </main>

            <footer class="footer"></footer>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        @if ($errors->any())
            document.getElementById('myModal').classList.add('active');
        @endif
    </script>
</body>

</html>
