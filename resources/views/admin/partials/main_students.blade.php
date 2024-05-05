<div class="filter-bar">
    <div class="filter">
        <form hx-get="{{ route('admin.filterStudents') }}"
              hx-swap="innerHTML"
              hx-target=".table-responsive"
              hx-push-url="true"
              hx-indicator="#loader-two">
            <div class="filter-item-society">
                <label for="filter_societe">Filtrer par société:</label>
                <select
                    name="parcours_id"
                    id="filter_parcours"
                    class=""
                >
                    <option value="">Tous</option>
                    @foreach($parcours as $p)
                        <option
                            value="{{ $p->id }}"
                            @if(isset($p_id) && $p_id == $p->id ) selected @endif
                        >{{ $p->name }}</option>
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
                            @if(isset($diplome_prepare_id) && $diplome_prepare_id == $diplome->id ) selected @endif
                        >{{ $diplome->name }}</option>
                    @endforeach
                </select>
            </div>

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
                    <th class="text-truncate">Matricule</th>
                    <th class="text-truncate">Filière</th>
                    <th class="text-truncate">Diplôme à preparé</th>
                    <th class="text-truncate">Contact</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-truncate">{{ $user->full_name }}</td>
                        <td class="text-truncate">{{ $user->serial_number }}</td>
                        <td class="text-truncate">{{ $user->parcours->name }}</td>
                        <td class="text-truncate">{{ $user->diplome_prepare->name }}</td>
                        <td class="text-truncate">{{ $user->phone_number }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
