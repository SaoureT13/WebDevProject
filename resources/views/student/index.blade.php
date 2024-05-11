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
                    <div class="input-box @error('company_name') error @enderror"">
                        <label for=" company_name">Nom société:</label><br>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Nom de la société"><br>
                        @error('company_name')
                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs obligatoire</span>
                        @enderror
                    </div>
                    <div class="input-box @error('company_contact') error @enderror"">
                        <label for=" company_contact">Contact société:</label><br>
                        <input type="text" id="company_contact" name="company_contact" value="{{ old('company_contact') }}" placeholder="Contact de la société"><br>
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
                @if ($demandes->isEmpty() && $filter == false)
                <div class="no-data">
                    <img src="{{ asset('img/nodata-found.png') }}" alt="no-found-data" width="100%">
                </div>
                @else
                <div class="main__head">
                    <h1>Mes demandes:</h1>
                    <form hx-get="{{ route('student.filterRequests') }}" hx-target="#table-responsive" hx-swap="innerHTML" hx-push-url="true" hx-indicator="#loader-two">
                        <div class="filter-request">
                            <label for="filter_diplome">Filtrer par status:</label>
                            <select name="request_status" id="filter_status" class="">
                                <option value="">Tous</option>
                                <option value="2" @if (isset($request_status) && $request_status==2) selected @endif>En
                                    attente
                                </option>
                                <option value="1" @if (isset($request_status) && $request_status==1) selected @endif>Validé
                                </option>
                                <option value="00" @if (isset($request_status) && $request_status==0) selected @endif>Refusé
                                </option>
                            </select>
                        </div>

                        <button type="submit">Filtrer</button>
                    </form>
                </div>

                <div class="content">
                    <div class="container-loader htmx-indicator" id="loader-two">
                        <div class="loader"></div>
                    </div>
                    <div class="card">
                        <div class="table-responsive" id="table-responsive">
                            @if ($demandes->isEmpty() && $filter == true)
                            <div class="no-data">
                                <img src="{{ asset('img/nodata-found.png') }}" alt="no-found-data" width="100%">
                            </div>
                            @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-truncate">Thème</th>
                                        <th class="text-truncate">Société</th>
                                        <th class="text-truncate">Date d'envoie</th>
                                        <th class="text-truncate" colspan="2">Statut</th>
                                    </tr>
                                </thead>
                                <tbody id="demandes" class="demandes">
                                    @foreach ($demandes as $demande)
                                    <tr>
                                        <td class="text-truncate">{{ $demande->theme }}</td>
                                        <td class="text-truncate">{{ $demande->societe->name }}</td>
                                        <td class="text-truncate">{{ $demande->deposit_date }}</td>
                                        <td class="text-truncate">
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
                                        </td>
                                        <td class="text-truncate" hx-get={{ route('student.viewRequest', ['demande' => $demande]) }} hx-target="#main" hx-swap="innerHTML" hx-push-url="true" hx-indicator="#container-loader">
                                            <button>Détails</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </main>

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