<table>
    <thead>
    <tr>
        <th >Name</th>
        <th>Email</th>
        <th>Craeted At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ Carbon\Carbon::parse($user->created_at)->format('D-M-Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>