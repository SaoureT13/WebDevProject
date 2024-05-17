<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @include('favicon_import')
    @vite(['resources/css/style_student_home.css', 'resources/css/style_student_home_details.css', 'resources/js/app.js'])
</head>

<body>
    <div id="modal-deconnexion" class="modal-deconnexion">
        <div class="modal-content-deconnexion">
            <span class="close-button">&times;</span>
            <h2>Confirmation de déconnexion</h2>
            <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
            <form action="{{ route('student.logout') }}" method="post">
                @csrf
                <button type="submit" id="logout">Déconnexion</button>
            </form>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Nouvelle demande <span class="info">(Vous pouvez faire une demande à deux, veuillez choisir votre
                    partenaire si c'est le cas)</span></h2>
            <form action="{{ url('/student/request') }}" method="post">
                @csrf
                @if (session('error'))
                <div class="alert-request">
                    <p>{{ session('error') }}</p>
                </div>
                @endif
                <div class="input-box">
                    <label for="partner">Partenaire:</label><br>
                    <select name="partner_id" id="partner">
                        <option value="">-- Choisir un partenaire --</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->full_name }} ({{ $user->serial_number }})</option>
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
                    <input type="text" id="memory_problems" name="memory_problems" value="{{ old('memory_problems') }}"><br>
                    @error('memory_problems')
                    <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est
                        obligatoire</span>
                    @enderror
                </div>
                <div class="input-box @error('global_objective') error @enderror">
                    <label for="global_objective">Objectif global:</label><br>
                    <input type="text" id="global_objective" name="global_objective" value="{{ old('global_objective') }}"><br>
                    @error('global_objective')
                    <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est
                        obligatoire</span>
                    @enderror
                </div>
                <div class="input-box @error('specific_objective') error @enderror">
                    <label for="specific_objective">Objectif spécifique:</label><br>
                    <input type="text" id="specific_objective" name="specific_objective" value="{{ old('specific_objective') }}"><br>
                    @error('specific_objective')
                    <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est
                        obligatoire</span>
                    @enderror
                </div>

                <div class="input-box @error('expected_result') error @enderror">
                    <label for="expected_result">Résultat attendu:</label><br>
                    <input type="text" id="expected_result" name="expected_result" value="{{ old('expected_result') }}"><br>
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
                    <input type="checkbox" id="choice" name="choice" @if (old('choice')=='on' ) checked @endif>
                    <label for="choice">Entrer les données de ma société</label>
                </div>


                <div class="societe-box @if (old('choice') == 'on') active @endif">
                    <div class="input-box @error('company_name') error @enderror">
                        <label for=" company_name">Nom société:</label><br>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Nom de la société"><br>
                        @error('company_name')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs obligatoire</span>
                        @enderror
                    </div>
                    <div class="input-box @error('company_contact') error @enderror">
                        <label for=" company_contact">Contact société:</label><br>
                        <input type="text" maxlength="10" id="company_contact" name="company_contact" value="{{ old('company_contact') }}" placeholder="Contact de la société"><br>
                        @error('company_contact')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs obligatoire et doit être un numéro valide</span>
                        @enderror
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

    @php
    $full_name = Auth::guard('web')->user()->full_name;

    $name_table = explode(' ',$full_name);

    $short_name = implode(' ', array_slice($name_table, 0, 2));
    @endphp


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
                            <p>Bonjour, {{ $short_name }}</p>
                            @endauth

                            <button type="button" id="modalButton">Déconnexion</button>

                        </div>
                    </div>
                </div>
            </header>

            <div class="container-loader htmx-indicator" id="container-loader">
                <div class="loader"></div>
            </div>
            <main class="main" id="main">
                <div class="details-container">
                    @if (Session::has('success'))
                    <div class="toast">
                        <svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.7986 10.1111C19.7986 15.4614 15.4614 19.7986 10.1111 19.7986C4.76081 19.7986 0.423584 15.4614 0.423584 10.1111C0.423584 4.76081 4.76081 0.423584 10.1111 0.423584C15.4614 0.423584 19.7986 4.76081 19.7986 10.1111ZM8.99054 15.2405L16.178 8.05304C16.4221 7.80898 16.4221 7.41323 16.178 7.16917L15.2942 6.2853C15.0501 6.0412 14.6544 6.0412 14.4103 6.2853L8.54858 12.1469L5.8119 9.41026C5.56784 9.1662 5.1721 9.1662 4.928 9.41026L4.04413 10.2941C3.80007 10.5382 3.80007 10.9339 4.04413 11.178L8.10663 15.2405C8.35073 15.4846 8.74644 15.4846 8.99054 15.2405V15.2405Z" fill="#55B938" fill-opacity="0.7" />
                        </svg>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif
                    <div class="details">
                        <div class="detail-item">
                            <label><strong>Thème :</strong> <span class="response">{{ $demande->theme }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><strong>Problèmes de mémoire :</strong>
                                <span class="response">{{ $demande->memory_problems }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><strong>Objectif global :</strong> <span class="response">{{ $demande->global_objective }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><strong>Objectif spécifique :</strong> <span id="response">{{ $demande->specific_objective }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><strong>Résultat attendu :</strong> <span id="response">{{ $demande->expected_result }}</span></label>
                        </div>
                        <div class="detail-item two">
                            <div class="detail-item">
                                <label><strong>Date de dépôt :</strong> <span id="response">{{ $demande->deposit_date }}</span></label>
                            </div>
                            <div class="detail-item">
                                <label><strong>Statut de la demande :</strong>
                                    <span class="badge-status
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

                    @if ($demande->commentaire)
                    <div class="details comments">
                        <h2>Commentaire sur ma demande</h2>
                        <div class="detail-item">
                            <label><strong>Thème :</strong> <span class="response">{{ $demande->commentaire->comment_theme }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><strong>Problèmes de mémoire :</strong>
                                <span class="response">{{ $demande->commentaire->comment_problems }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><strong>Objectif global :</strong> <span class="response">{{ $demande->commentaire->comment_global_obj }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><strong>Objectif spécifique :</strong> <span id="response">{{ $demande->commentaire->comment_specific_obj }}</span></label>
                        </div>
                        <div class="detail-item">
                            <label><strong>Résultat attendu :</strong> <span id="response">{{ $demande->commentaire->comment_result_expected }}</span></label>
                        </div>

                        @if($demande->request_status == 1)
                            <div class="detail-item">
                                <label><strong>Professeur suiveur accordé :</strong> <span id="response">{{ $demande->users->first()->professeur->full_name }}</span></label>
                            </div>
                        @endif
                    </div>
                    @endif
                    <a hx-get="{{ route('backHome') }}" hx-swap="innerHTML" hx-target="#main" hx-trigger="click" hx-push-url="true" hx-indicator="#container-loader" class="back">Retour</a>
                </div>
            </main>

            <footer class="footer"></footer>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        @if($errors->any())
        document.getElementById('myModal').classList.add('active');
        @endif

        @if(session('error'))
        document.getElementById('myModal').classList.add('active');
        @endif
    </script>
</body>

</html>
