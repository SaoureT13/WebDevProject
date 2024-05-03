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
                </td>
                <td class="text-truncate">
                    <button>Détails</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>