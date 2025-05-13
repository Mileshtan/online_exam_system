<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['title']}}</title>
</head>
<body>
    <p>
        <b>Hello, {{$data['name']}},</b> Your Exam {{$data['exam_name']}} review passed,
        So now you can check your marks. 
    </p>
    <a href="{{$data['url']}}">CLick here view Result</a>
    <p>Thank you</p>
</body>
</html>