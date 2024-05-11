<div class="details-container">
    @if (Session::has('success'))
    <div class="toast">
        <svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.7986 10.1111C19.7986 15.4614 15.4614 19.7986 10.1111 19.7986C4.76081 19.7986 0.423584 15.4614 0.423584 10.1111C0.423584 4.76081 4.76081 0.423584 10.1111 0.423584C15.4614 0.423584 19.7986 4.76081 19.7986 10.1111ZM8.99054 15.2405L16.178 8.05304C16.4221 7.80898 16.4221 7.41323 16.178 7.16917L15.2942 6.2853C15.0501 6.0412 14.6544 6.0412 14.4103 6.2853L8.54858 12.1469L5.8119 9.41026C5.56784 9.1662 5.1721 9.1662 4.928 9.41026L4.04413 10.2941C3.80007 10.5382 3.80007 10.9339 4.04413 11.178L8.10663 15.2405C8.35073 15.4846 8.74644 15.4846 8.99054 15.2405V15.2405Z" fill="#55B938" fill-opacity="0.7" />
        </svg>
        <p>{{ Session::get('success') }}</p>
    </div>
    @endif
    <div class="details">
        <div class="detail-item">
            <label><strong>Thème :</strong> <span class="response">{{ $demande->theme }}</span></label>
        </div>
        <div class="detail-item">
            <label><strong>Problèmes de mémoire :</strong>
                <span class="response">{{ $demande->memory_problems }}</span></label>
        </div>
        <div class="detail-item">
            <label><strong>Objectif global :</strong> <span class="response">{{ $demande->global_objective }}</span></label>
        </div>
        <div class="detail-item">
            <label><strong>Objectif spécifique :</strong> <span id="response">{{ $demande->specific_objective }}</span></label>
        </div>
        <div class="detail-item">
            <label><strong>Résultat attendu :</strong> <span id="response">{{ $demande->expected_result }}</span></label>
        </div>
        <div class="detail-item">
            <div class="detail-item">
                <label><strong>Date de dépôt :</strong> <span id="response">{{ $demande->deposit_date }}</span></label>
            </div>
            <div class="detail-item">
                <label><strong>Statut de la demande :</strong>
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
                </label>
            </div>
        </div>
    </div>

    <div class="details comments">
        <h2>Commentaire sur ma demande</h2>
        <div class="detail-item">
            <label><strong>Thème :</strong> <span class="response">{{ $demande->commentaire->comment_theme }}</span></label>
        </div>
        <div class="detail-item">
            <label><strong>Problèmes de mémoire :</strong>
                <span class="response">{{ $demande->commentaire->comment_problems }}</span></label>
        </div>
        <div class="detail-item">
            <label><strong>Objectif global :</strong> <span class="response">{{ $demande->commentaire->comment_global_obj }}</span></label>
        </div>
        <div class="detail-item">
            <label><strong>Objectif spécifique :</strong> <span id="response">{{ $demande->commentaire->comment_specific_obj }}</span></label>
        </div>
        <div class="detail-item">
            <label><strong>Résultat attendu :</strong> <span id="response">{{ $demande->commentaire->comment_result_expected }}</span></label>
        </div>
    </div>
    <a hx-get="{{ route('backHome') }}" hx-swap="innerHTML" hx-target="#main" hx-trigger="click" hx-push-url="true" hx-indicator="#container-loader" class="back">Retour</a>
</div>