<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/style_admin_dashboard.css', 'resources/css/style_admin_dashboard_details.css', 'resources/js/script_admin_dashboard.js'])
</head>

<body>
<div class="layout-wrapper">
    <div class="layout-container">
        <aside class="vertical-menu">
            <div class="logo">
                <a href="#"><img src="{{asset('img/logo-pg.png')}}" alt="logo-pg" width="150"></a>
            </div>
            <ul class="menu">
                <li class="active menu-item">
                    <div class="menu-link">
                        <ion-icon name="mail-outline"></ion-icon>
                        Demandes
                    </div>
                    <ul class="option-sub">
                        <li class="sub-item active">
                            <a
                                href=""
                                hx-get="/dashboard/demandes"
                                hx-swap="innerHTML"
                                hx-target=".table-responsive"
                                hx-trigger="click"
                                hx-push-url="true"
                            >Toutes les demandes</a>
                        </li>
                        <li class="sub-item">
                            <a
                                href=""
                                hx-get="{{ route('admin.viewRequestsPending') }}"
                                hx-swap="innerHTML"
                                hx-target=".table-responsive"
                                hx-trigger="click"
                                hx-push-url="true"
                            >Demandes en attente</a>
                        </li>
                        <li class="sub-item">
                            <a
                                href=""
                                hx-get="{{ route('admin.viewsRequestCompleted') }}"
                                hx-swap="innerHTML"
                                hx-target=".table-responsive"
                                hx-trigger="click"
                                hx-push-url="true"
                            >Demandes traité</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item">
                    <div class="menu-link">
                        <ion-icon name="people-outline"></ion-icon>
                        Etudiants
                    </div>
                    <ul class="option-sub">
                        <li class="sub-item"><a href="#">Etudiants inscrit</a></li>
                        <li class="sub-item"><a href="#">Etudiants avec thème validé</a></li>
                    </ul>
                </li>
                <li class="menu-item">
                    <div class="menu-link">
                        <ion-icon name="person-outline"></ion-icon>
                        Professeurs
                    </div>
                    <ul class="option-sub">
                        <li class="sub-item"><a href="#">Tous les professeurs</a></li>
                        <li class="sub-item"><a href="#">Professeurs affiliés</a></li>
                    </ul>
                </li>
                <li class="item-deconnexion">
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button
                            type="submit"
                            class="btn-deconnexion"
                        >
                            <ion-icon name="log-out-outline" role="img" title="deconnexion"></ion-icon>
                            Deconnexion</button>
                    </form>
                </li>
            </ul>
        </aside>

        <div class="overlay"></div>
        <div class="content-wrapper">
            <div class="container">
                <nav>
                    <div class="burger-menu">
                        <ion-icon name="menu-outline"></ion-icon>
                    </div>

                    <div class="navbar-right">
                        <div class="search-bar">
                            <ion-icon name="search-outline"></ion-icon>
                            <input type="text" placeholder="search">
                        </div>

                        <div class="user">
                            <div class="avatar">
                                <img src="{{ asset('img/1.png') }}" alt="" width="50">
                            </div>
                        </div>
                    </div>
                </nav>

                <main class="main" id="main">
                    <div class="filter-bar">
                        <div class="filter">
                            <form hx-get="{{ route('admin.filterRequests') }}"
                                  hx-swap="innerHTML"
                                  hx-target=".table-responsive"
                                    hx-push-url="true">
                                <div class="filter-item-society">
                                    <label for="filter_societe">Filtrer par société:</label>
                                    <select
                                        name="societe_id"
                                        id="filter_societe"
                                        class=""
                                    >
                                        <option value="">Tous</option>
                                        @foreach($societes as $societe)
                                            <option
                                                value="{{ $societe->id }}"
                                                @if(Session::has('societe_id') && Session::get('societe_id') == $societe->id ) selected @endif
                                            >{{ $societe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="filter-item-diplome">
                                    <label for="filter_diplome">Filtrer par diplôme:</label>
                                    <select
                                        name="diplome_prepare_id"
                                        id="filter_diplome"
                                        class=""
                                    >
                                        <option value="">Tous</option>
                                        @foreach($diplomes as $diplome)
                                            <option
                                                value="{{ $diplome->id }}"
                                                @if(Session::has('diplome_prepare_id') && Session::get('diplome_prepare_id') == $diplome->id ) selected @endif
                                            >{{ $diplome->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn">Filtrer</button>
                            </form>
                        </div>
                    </div>

                    <div class="content">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="text-truncate">Nom et prénoms</th>
                                        <th class="text-truncate">Matricule</th>
                                        <th class="text-truncate">Diplôme à préparé</th>
                                        <th class="text-truncate">Thème</th>
                                        <th class="text-truncate">Société</th>
                                        <th class="text-truncate">Statut</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($demandes as $demande)
                                        <tr hx-get="{{ route('admin.viewRequest', ['demande' => $demande->id]) }}"
                                            hx-target=".main" hx-swap="innerHTML" hx-push-url="true">
                                            <td class="text-truncate">{{ $demande->users->first()->full_name }}</td>
                                            <td class="text-truncate">{{ $demande->users->first()->serial_number }}</td>
                                            <td class="text-truncate">{{ $demande->users->first()->diplome_prepare->name}}</td>
                                            <td class="text-truncate">{{ $demande->theme }}</td>
                                            <td class="text-truncate">{{ $demande->societe->name }}</td>
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
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>

            </div>

        </div>
    </div>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
