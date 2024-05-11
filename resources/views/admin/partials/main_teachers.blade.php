<div class="filter-bar">
    <div class="filter">
        <form hx-get="{{ route('admin.filterTeachers') }}" hx-swap="innerHTML" hx-target=".table-responsive" hx-push-url="true" hx-indicator="#loader-two" {{--                                    hx-history="false"--}}>
            <div class="filter-item-teacher">
                <label for="filter_teachers">Filtrer par affiliation:</label>
                <select name="filter_teachers" id="filter_teachers" class="">
                    <option value="">Tous</option>
                    <option value="1">Affilié</option>
                    <option value="00">Non affilié</option>
                </select>
            </div>

            {{-- <div class="filter-item-parcours">--}}
            {{-- <label for="filter_parcours">Filtrer par parcours:</label>--}}
            {{-- <select--}}
            {{-- name="parcours_id"--}}
            {{-- id="filter_parcours"--}}
            {{-- class=""--}}
            {{-- >--}}
            {{-- <option value="">Tous</option>--}}
            {{-- @foreach($parcours as $p)--}}
            {{-- <option--}}
            {{-- value="{{ $p->id }}"--}}
            {{-- @if(isset($p_id) && $p_id == $p->id ) selected @endif--}}
            {{-- >{{ $p->name }}</option>--}}
            {{-- @endforeach--}}
            {{-- </select>--}}
            {{-- </div>--}}

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
            @if ($teachers->isEmpty())
            <div class="not-found-data">
                <img src="{{ asset('img/nodata-found.png') }}" alt="no-data-found" width="100%">
            </div>
            @else
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
                    @foreach($teachers as $teacher)
                    <tr>
                        <td class="text-truncate">{{ $teacher->full_name }}</td>
                        <td class="text-truncate">{{ $teacher->course }}</td>
                        <td class="text-truncate">{{ $teacher->contact }}</td>
                        <td class="text-truncate">@if($teacher->users->count() == 0)
                            Aucun
                            @else
                            {{ $teacher->users()->count() }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>