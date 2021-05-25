<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
    <ul>
        @foreach($locations as $location)
            <li>{{$location->plz}} {{$location->place}}</li>
        @endforeach
    </ul>
</body>
</html>
