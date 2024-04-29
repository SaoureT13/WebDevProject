<tr>
    <td class="text-truncate">{{ $demande->theme }}</td>
    <td class="text-truncate">{{ $demande->societe->name}}</td>
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


