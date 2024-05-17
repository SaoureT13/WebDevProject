<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('favicon_import')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/style_admin_dashboard.css', 'resources/css/style_admin_dashboard_details.css', 'resources/js/script_admin_dashboard.js'])
</head>

<body>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Confirmation de déconnexion</h2>
            <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
            <form action="{{ route('admin.logout') }}" method="post">
                @csrf
                <button type="submit" id="logout">Déconnexion</button>
            </form>
        </div>
    </div>


    <div class="layout-wrapper">
        <div class="layout-container">
            <aside class="vertical-menu">
                <div class="logo">
                    <a href="#"><img src="{{ asset('img/logo-pg.png') }}" alt="logo-pg" width="150"></a>
                </div>
                <ul class="menu">
                    <li class="active menu-item">
                        <a href="" class="menu-link" hx-get="/dashboard/demandes" hx-swap="innerHTML" hx-target="#main" hx-trigger="click" hx-push-url="true" hx-indicator='#container-loader' {{--                       hx-history="false" --}}>
                            <ion-icon name="mail-outline"></ion-icon>
                            Demandes
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link" hx-get="{{ route('admin.viewStudents') }}" hx-swap="innerHTML" hx-target="#main" hx-trigger="click" hx-push-url="true" hx-indicator='#container-loader' {{--                        hx-history="false" --}}>
                            <ion-icon name="people-outline"></ion-icon>
                            Étudiants
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link" hx-get="{{ route('admin.viewTeachers') }}" hx-swap="innerHTML" hx-target="#main" hx-trigger="click" hx-push-url="true" hx-indicator='#container-loader'>
                            <ion-icon name="person-outline"></ion-icon>
                            Professeurs
                        </a>
                    </li>
                    <li class="item-deconnexion">
                        <button class="btn-deconnexion" id="modalButton">
                            <ion-icon name="log-out-outline" role="img" title="deconnexion"></ion-icon>
                            Deconnexion
                        </button>
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

                    <span class="container-loader htmx-indicator" id="container-loader">
                        <div class="loader"></div>
                    </span>

                    <main class="main" id="main">
                        <div class="filter-bar">
                            <div class="filter">
                                <form hx-get="{{ route('admin.filterRequests') }}" hx-swap="innerHTML" hx-target=".table-responsive" hx-push-url="true" hx-indicator="#loader-two" {{--                                  hx-history="false" --}}>
                                    <div class="filter-item-society">
                                        <label for="filter_societe">Filtrer par société:</label>
                                        <select name="societe_id" id="filter_societe" class="">
                                            <option value="">Tous</option>
                                            @foreach ($societes as $societe)
                                            <option value="{{ $societe->id }}" @if (isset($societe_id) && $societe_id==$societe->id) selected @endif>
                                                {{ $societe->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="filter-item-diplome">
                                        <label for="filter_diplome">Filtrer par diplôme:</label>
                                        <select name="diplome_prepare_id" id="filter_diplome" class="">
                                            <option value="">Tous</option>
                                            @foreach ($diplomes as $diplome)
                                            <option value="{{ $diplome->id }}" @if (isset($diplome_prepare_id) && $diplome_prepare_id==$diplome->id) selected @endif>
                                                {{ $diplome->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="filter-item-diplome">
                                        <label for="filter_diplome">Filtrer par status:</label>
                                        <select name="request_status" id="filter_status" class="">
                                            <option value="">Tous</option>
                                            <option value="2" @if (isset($request_status) && $request_status==2) selected @endif>En
                                                attente
                                            </option>
                                            <option value="1" @if (isset($request_status) && $request_status==1) selected @endif>
                                                Validé
                                            </option>
                                            <option value="00" @if (isset($request_status) && $request_status==0) selected @endif>
                                                Refusé
                                            </option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn">Filtrer</button>
                                </form>
                            </div>
                        </div>
                        <div class="reload-data">
                            <div>
                                <button 
                                    type="button" 
                                    class="reload-btn" 
                                    hx-get="{{ route('admin.viewRequestsAll') }}" 
                                    hx-swap="innerHTML" 
                                    hx-target="#main" 
                                    hx-push-url="true"
                                    hx-indicator="#container-loader">
                                    <ion-icon name="reload-circle-outline"></ion-icon>
                                    Actualiser les données
                                </button>
                            </div>
                        </div>
                        <div class="content">
                            <div class="container-loader htmx-indicator" id="loader-two">
                                <div class="loader"></div>
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    @if ($demandes->isEmpty())
                                    <div class="not-found-data">
                                        <img src="{{ asset('img/nodata-found.png') }}" alt="no-data-found" width="100%">
                                    </div>
                                    @else
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
                                            @foreach ($demandes as $demande)
                                            <tr hx-get="{{ route('admin.viewRequest', ['demande' => $demande->id]) }}" hx-target=".main" hx-swap="innerHTML" hx-push-url="true" hx-indicator="#container-loader" {{--                                            hx-history="false" --}}>
                                                <td class="text-truncate">
                                                    @if (count($demande->users) >= 2)
                                                    {{ $demande->users[0]->full_name }} <strong>&</strong>
                                                    {{ $demande->users[1]->full_name }}
                                                    @else
                                                    {{ $demande->users->first()->full_name }}
                                                    @endif
                                                </td>
                                                <td class="text-truncate">
                                                    @if (count($demande->users) >= 2)
                                                    {{ $demande->users[0]->serial_number }} <strong>&</strong>
                                                    {{ $demande->users[1]->serial_number }}
                                                    @else
                                                    {{ $demande->users->first()->serial_number }}
                                                    @endif
                                                </td>
                                                <td class="text-truncate">
                                                    {{ $demande->users->first()->diplome_prepare->name }}
                                                </td>
                                                <td class="text-truncate">{{ $demande->theme }}</td>
                                                <td class="text-truncate">{{ $demande->societe->name }}</td>
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
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
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