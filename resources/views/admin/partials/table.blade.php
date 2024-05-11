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
        <tr hx-get="{{ route('admin.viewRequest', ['demande' => $demande->id]) }}" hx-target=".main" hx-swap="innerHTML" hx-push-url="true" hx-indicator="#container-loader">
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
            <td class="text-truncate">{{ $demande->users->first()->diplome_prepare->name }}</td>
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