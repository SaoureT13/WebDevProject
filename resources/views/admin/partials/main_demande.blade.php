<div class="filter-bar">
    <div class="filter">
        <form hx-get="{{ route('admin.filterRequests') }}" hx-swap="innerHTML" hx-target=".table-responsive" hx-push-url="true" hx-indicator="#loader-two">
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
        <button type="button" class="reload-btn" hx-get="{{ route('admin.viewRequestsAll') }}" hx-swap="innerHTML" hx-target="#main" hx-push-url="true" hx-indicator="#container-loader">
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