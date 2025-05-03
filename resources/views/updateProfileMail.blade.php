<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['title']}}</title>
</head>
<body>
    <table>
        <tr>
            <th>Name</th>
            <th>{{$data['name']}}</th>
        </tr>
        <tr>
            <th>Email</th>
            <th>{{$data['email']}}</th>
        </tr>
    </table>
    <p><b>Note:- You can use your old password </b></p>
    <a href="{{$data['url']}}">Click Here To Login Your Account</a>
    <p>Thank you</p>
</body>
</html>