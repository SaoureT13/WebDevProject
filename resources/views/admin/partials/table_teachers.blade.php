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
            <td class="text-truncate">{{ $teacher->parcours->name }}</td>
            <td class="text-truncate">{{ $teacher->contact }}</td>
            <td class="text-truncate">@if($teacher->users->count() == 0) Aucun @else {{ $teacher->users()->count() }} @endif</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif
