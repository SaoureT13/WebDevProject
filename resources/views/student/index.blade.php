<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Document</title>
    @vite(['resources/css/style_student_home.css', 'resources/js/app.js'])
</head>

<body>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Nouvelle demande</h2>
        <form action="{{ url('/student/request') }}" method="post">
            @csrf
            <div class="input-box">
                <label for="theme">Theme:</label><br>
                <input type="text" id="theme" name="theme" value="{{ old('theme') }}"><br>
            </div>
            @error('theme')
            <span class="alert">{{ $message }}e</span>
            @enderror
            <div class="input-box">
                <label for="memory_problems">Problématique:</label><br>
                <input type="text" id="memory_problems" name="memory_problems" value="{{ old('memory_problems') }}"><br>
            </div>
            @error('memory_problems')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div class="input-box">
                <label for="global_objective">Objectif global:</label><br>
                <input type="text" id="global_objective" name="global_objective"
                       value="{{ old('global_objective') }}"><br>
            </div>
            @error('global_objective')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div class="input-box">
                <label for="specific_objective">Objectif spécifique:</label><br>
                <input type="text" id="specific_objective" name="specific_objective"
                       value="{{ old('specific_objective') }}"><br>
            </div>
            @error('specific_objective')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div class="input-box">
                <label for="expected_result">Résultat attendu:</label><br>
                <input type="text" id="expected_result" name="expected_result" value="{{ old('expected_result') }}"><br>
            </div>
            @error('expected_result')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div style="display: flex; width: 100%; justify-content: space-between">
                <div class="input-box" style="width: 45%">
                    <label for="company_name">Société:</label><br>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                           placeholder="Nom de la société"><br>
                </div>
                <div class="input-box" style="width: 45%">
                    <label for="company_contact">Contact société:</label><br>
                    <input type="text" id="company_contact" name="company_contact" value="{{ old('company_contact') }}"
                           placeholder="Contact de la société"><br>
                </div>
            </div>

            <button type="submit" class="btn-submit">Soumettre</button>
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
                        <img src="{{asset('img/logo-pg.png')}}" alt="logo" width="140" height="44"/>
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
                            <p>Bonjour, {{Auth::guard('web')->user()->full_name }}</p>
                        @endauth

                        <form action="{{ url('/student/logout') }}" method="post">
                            @csrf
                            <button type="submit">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="main">
            <div class="main__head">
                <div class="head_filter">
                    <div class="filter_request">
                        <div class="request">
                            All requests
                            <div class="dropdown_request">
                                <ul class="list_filter_request">
                                    <li><a href="#">All requests</a></li>
                                    <li><a href="#">Request pending</a></li>
                                    <li><a href="#">Request completed</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="card">
                    <div class="table-responsive">
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
                            @foreach($demandes as $demande)
                                <tr>
                                    <td class="text-truncate">{{ $demande->theme }}</td>
                                    <td class="text-truncate">{{ $demande->societe->name }}</td>
                                    <td class="text-truncate">{{ $demande->deposit_date }}</td>
                                    <td class="text-truncate">
                                         <span class="badge-status
                                                @if(is_null($demande->request_status)) pending
                                                @elseif($demande->request_status == 1) validated
                                                @else rejected @endif">
                                             @if(is_null($demande->request_status))
                                                 En attente
                                             @elseif($demande->request_status == 1)
                                                 Validé
                                             @else
                                                 Refusé
                                             @endif
                                        </span>
                                    </td>
                                    <td class="text-truncate">
                                        <button>Détails</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
</script>
</body>

</html>
