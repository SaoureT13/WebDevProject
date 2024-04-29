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
                        <li class="sub-item active"><a href="#">Toutes les demandes</a></li>
                        <li class="sub-item"><a href="#">Demandes en attente</a></li>
                        <li class="sub-item"><a href="#">Demandes traité</a></li>
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

                <main class="main">
                    <div class="details-container">
                        @if(Session::has('success'))
                            <div class="toast">
                                <svg width="30" height="30" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.7986 10.1111C19.7986 15.4614 15.4614 19.7986 10.1111 19.7986C4.76081 19.7986 0.423584 15.4614 0.423584 10.1111C0.423584 4.76081 4.76081 0.423584 10.1111 0.423584C15.4614 0.423584 19.7986 4.76081 19.7986 10.1111ZM8.99054 15.2405L16.178 8.05304C16.4221 7.80898 16.4221 7.41323 16.178 7.16917L15.2942 6.2853C15.0501 6.0412 14.6544 6.0412 14.4103 6.2853L8.54858 12.1469L5.8119 9.41026C5.56784 9.1662 5.1721 9.1662 4.928 9.41026L4.04413 10.2941C3.80007 10.5382 3.80007 10.9339 4.04413 11.178L8.10663 15.2405C8.35073 15.4846 8.74644 15.4846 8.99054 15.2405V15.2405Z"
                                          fill="#55B938" fill-opacity="0.7"/>
                                </svg>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        <div class="owner-info">
                            <p><strong>Propriétaire : </strong> <span
                                        id="owner">{{ $demande->users->first()->full_name }}</span></p>
                            <p><strong>Société :</strong> <span id="company">{{ $demande->societe->name }}</span></p>
                        </div>
                        <div class="details">
                            <div class="detail-item">
                                <label>Thème : <span class="response">{{ $demande->theme }}</span></label>
                            </div>
                            <div class="detail-item">
                                <label>Problèmes de mémoire : <span
                                            class="response">{{ $demande->memory_problems }}</span></label>
                            </div>
                            <div class="detail-item">
                                <label>Objectif global : <span class="response">{{ $demande->global_objective }}</span></label>
                            </div>
                            <div class="detail-item">
                                <label>Objectif spécifique : <span
                                            id="response">{{ $demande->specific_objective }}</span></label>
                            </div>
                            <div class="detail-item">
                                <label>Résultat attendu : <span
                                            id="response">{{ $demande->expected_result }}</span></label>
                            </div>
                            <div class="detail-item">
                                <div class="detail-item">
                                    <label>Date de dépôt : <span
                                                id="response">{{ $demande->deposit_date }}</span></label>
                                </div>
                                <div class="detail-item">
                                    <label>Statut de la demande :
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
                                    </label>
                                </div>
                            </div>
                            @if(is_null($demande->request_status))
                                <div class="actions">
                                    <button
                                            class="btn validate"
                                            hx-post="{{ route('admin.update', ['demande' => $demande->id, 'status' => 'validated']) }}"
                                            hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                                            hx-target=".main"
                                            hx-swap="innerHTML"
                                    >Valider
                                    </button>
                                    <button
                                            class="btn refuse"
                                            hx-post="{{ route('admin.update', ['demande' => $demande->id, 'status' => 'rejected']) }}"
                                            hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                                            hx-target=".main"
                                            hx-swap="innerHTML"
                                    >Refuser
                                    </button>
                                </div>
                            @endif
                        </div>
                        @if(is_null($demande->commentaire_id) && !is_null($demande->request_status))
                            <div class="comment-section">
                                <h2>Laissez un commentaire</h2>
                                <form
                                        id="comment-form"
                                        hx-post="{{ route('admin.commentRequest', ['demande_id' => $demande->id]) }}"
                                        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                                        hx-target=".main"
                                        hx-swap="innerHTML"
                                >
                                    <div class="input-group @error('comment_theme') error @enderror">
                                        <label for="comment_theme">Thème</label>
                                        <input id="comment_theme" name="comment_theme">
                                        @error('comment_theme')
                                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est obligatoire</span>
                                        @enderror
                                    </div>

                                    <div class="input-group @error('comment_problems') error @enderror">
                                        <label for="comment_problems">Problématique</label>
                                        <input id="comment_problems" name="comment_problems">
                                        @error('comment_problems')
                                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est obligatoire</span>
                                        @enderror
                                    </div>
                                    <div class="input-group @error('comment_global_obj') error @enderror">
                                        <label for="comment_global_obj">Objectif global</label>
                                        <input id="comment_global_obj" name="comment_global_obj">
                                        @error('comment_global_obj')
                                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est obligatoire</span>
                                        @enderror
                                    </div>
                                    <div class="input-group @error('comment_specific_obj') error @enderror">
                                        <label for="comment_specific_obj">Objectif spécifique</label>
                                        <input id="comment_specific_obj" name="comment_specific_obj">
                                        @error('comment_specific_obj')
                                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est obligatoire</span>
                                        @enderror
                                    </div>
                                    <div class="input-group @error('comment_result_expected') error @enderror">
                                        <label for="comment_result_expected">Résultat attendu</label>
                                        <input id="comment_result_expected" name="comment_result_expected">
                                        @error('comment_result_expected')
                                        <span class="alert"><ion-icon name="alert-circle-outline"></ion-icon>Ce champs est obligatoire</span>
                                        @enderror
                                    </div>
                                    <button type="submit">Soumettre</button>
                                </form>
                            </div>
                        @endif
                        <a href="#" class="back">Retour</a>
                    </div>

                </main>

            </div>

        </div>
    </div>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    // Fonction pour rafraîchir la page après une action htmx
    function refreshPage() {
        window.location.reload(); // Rafraîchir la page
    }
</script>
</body>

</html>
