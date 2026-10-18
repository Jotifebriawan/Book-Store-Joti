<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Minggu 05: Latihan 04</h1>
    <p>Halo, nama saya <b>{{ $nama }}</b> hobi saya antara lain:</p>
    <ul>
        @for ($i = 0; $i < count($hobi); $i++)
            <li>{{ $hobi[$i] }}</li>
        @endfor
    </ul>
    <p>Berikut skill yang saya miliki:</p>
    <ol>
        @foreach ($skill as $val)
            <li>{{ $val }}</li>
        @endforeach
    </ol>
</body>
</html>