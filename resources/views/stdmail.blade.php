<!DOCTYPE html>
<html lang="en">
<head>

    <title>{{ $data['title'] }}</title>
</head>
<body>
    <table>
        <tr>
            <td>Name</td>
            <td>{{ $data['name'] }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $data['email'] }}</td>
        </tr>
        <tr>
            <td>Password</td>
            <td>{{ $data['password'] }}</td>
        </tr>
    </table>
    <a href="{{ $data['url']  }}">Click here to login</a>
</body>
</html>