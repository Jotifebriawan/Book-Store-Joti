<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Minggu 06 : Latihan 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{route('m6.lat2.action')}}">
                    @csrf
                    <div class="mb-3">
                        <label>nama</label>
                        <input type="text" class="form-control" name="nama" value="{{ old('nama') }}"/>
                    </div>
                    <div class="mb-3">
                        <label>Nilai</label>
                        <input type="text" class="form-control" name="nilai" value="{{ old('nilai, 0')}}"/>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>