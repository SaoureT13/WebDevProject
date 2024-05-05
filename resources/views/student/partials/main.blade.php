<div class="main__head">
  <h1>Mes demandes:</h1>
  <form hx-get="{{ route('student.filterRequests') }}" hx-target="#table-responsive"
      hx-swap="innerHTML" hx-push-url="true" hx-indicator="#loader-two">
      <div class="filter-request">
          <label for="filter_diplome">Filtrer par status:</label>
          <select name="request_status" id="filter_status" class="">
              <option value="">Tous</option>
              <option value="2" @if (isset($request_status) && $request_status == 2) selected @endif>En
                  attente
              </option>
              <option value="1" @if (isset($request_status) && $request_status == 1) selected @endif>Validé
              </option>
              <option value="00" @if (isset($request_status) && $request_status == 0) selected @endif>Refusé
              </option>
          </select>
      </div>

      <button type="submit">Filtrer</button>
  </form>
</div>

<div class="content">
  <div class="container-loader htmx-indicator" id="loader-two">
      <div class="loader"></div>
  </div>
  <div class="card">
      <div class="table-responsive" id="table-responsive">
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
                          <td class="text-truncate"
                              hx-get={{ route('student.viewRequest', ['demande' => $demande]) }}
                              hx-target="#main" hx-swap="innerHTML" hx-push-url="true" hx-indicator="#container-loader">
                              <button>Détails</button>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>
</div>