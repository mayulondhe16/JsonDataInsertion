<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <form action="{{ url('/')}}/store_data" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="mb-3">
            <label for="formFileDisabled" class="form-label">Choose Json File</label><br><br>
            <input class="form-control" type="file" id="formFile" name="file"><br></br>
            <input type="submit" class="btn btn-success">
          </div>
        </form>
    </body>
</html>
