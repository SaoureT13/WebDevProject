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
                    <a href="#"><img src="{{ asset('img/logo-pg.png') }}" alt="logo-pg" width="150"></a>
                </div>
                <ul class="menu">
                    <li class="menu-item">
                        <a href="" class="menu-link" hx-get="/dashboard/demandes" hx-swap="innerHTML"
                            hx-target="#main" hx-trigger="click" hx-push-url="true" hx-indicator='#container-loader' {{--                       hx-history="false" --}}>
                            <ion-icon name="mail-outline"></ion-icon>
                            Demandes
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link" hx-get="{{ route('admin.viewStudents') }}"
                            hx-swap="innerHTML" hx-target="#main" hx-trigger="click" hx-push-url="true" hx-indicator='#container-loader'
                            {{--                       hx-history="false" --}}>
                            <ion-icon name="people-outline"></ion-icon>
                            Étudiants
                        </a>
                    </li>
                    <li class="active menu-item">
                        <a href="" class="menu-link" hx-get="{{ route('admin.viewTeachers') }}"
                            hx-swap="innerHTML" hx-target="#main" hx-trigger="click" hx-push-url="true" hx-indicator='#container-loader'>
                            <ion-icon name="person-outline"></ion-icon>
                            Professeurs
                        </a>
                    </li>
                    <li class="item-deconnexion">
                        <form action="{{ route('admin.logout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn-deconnexion">
                                <ion-icon name="log-out-outline" role="img" title="deconnexion"></ion-icon>
                                Deconnexion
                            </button>
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

                    <span class="container-loader htmx-indicator" id="container-loader">
                        <div class="loader"></div>
                    </span>
                    <main class="main" id="main">
                        <div class="filter-bar">
                            <div class="filter">
                                <form hx-get="{{ route('admin.filterTeachers') }}" hx-swap="innerHTML"
                                    hx-target=".table-responsive" hx-push-url="true" hx-indicator="#loader-two"  {{--                                    hx-history="false" --}}>
                                    <div class="filter-item-teacher">
                                        <label for="filter-teachers">Filtrer par affiliation:</label>
                                        <select name="filter_teachers" id="filter_teacher" class="">
                                            <option value="">Tous</option>
                                            <option value="1">Affilié</option>
                                            <option value="00">Non affilié</option>
                                        </select>
                                    </div>

                                    {{--                                <div class="filter-item-parcours"> --}}
                                    {{--                                    <label for="filter_parcours">Filtrer par parcours:</label> --}}
                                    {{--                                    <select --}}
                                    {{--                                        name="parcours_id" --}}
                                    {{--                                        id="filter_parcours" --}}
                                    {{--                                        class="" --}}
                                    {{--                                    > --}}
                                    {{--                                        <option value="">Tous</option> --}}
                                    {{--                                        @foreach ($parcours as $p) --}}
                                    {{--                                            <option --}}
                                    {{--                                                value="{{ $p->id }}" --}}
                                    {{--                                                @if (isset($p_id) && $p_id == $p->id) selected @endif --}}
                                    {{--                                            >{{ $p->name }}</option> --}}
                                    {{--                                        @endforeach --}}
                                    {{--                                    </select> --}}
                                    {{--                                </div> --}}

                                    <button type="submit" class="btn">Filtrer</button>
                                </form>
                            </div>
                        </div>

                        <div class="content">
                            <div class="container-loader htmx-indicator" id="loader-two">
                                <div class="loader"></div>
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-truncate">Nom et prénoms</th>
                                                <th class="text-truncate">Filière</th>
                                                <th class="text-truncate">Contact</th>
                                                <th class="text-truncate">Nombre d'étudiant suivis</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($teachers as $teacher)
                                                <tr>
                                                    <td class="text-truncate">{{ $teacher->full_name }}</td>
                                                    <td class="text-truncate">{{ $teacher->course }}</td>
                                                    <td class="text-truncate">{{ $teacher->contact }}</td>
                                                    <td class="text-truncate">
                                                        @if ($teacher->users->count() == 0)
                                                            Aucun
                                                        @else
                                                            {{ $teacher->users()->count() }}
                                                        @endif
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
