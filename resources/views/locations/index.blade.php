<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
<ul>
    @foreach($locations as $location)
        <li><a href="locations/{{$location->id}}">{{$location->place}}</a></li>
    @endforeach
</ul>
</body>
</html>
