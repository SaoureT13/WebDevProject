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
