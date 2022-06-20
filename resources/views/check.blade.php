<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table width="100%" border="1">
    <tr>
        <td> name</td>
        <td> level</td>
    </tr>
    <tr>
        <td> ahmed</td>
        <td> 4</td>
    </tr>
    <tr>
        <td> mohammed</td>
        <td> 5</td>
    </tr>
    @foreach($classes as $class)
        <tr>
            <td> {{$class->name}}</td>
            <td> {{$class->level}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
