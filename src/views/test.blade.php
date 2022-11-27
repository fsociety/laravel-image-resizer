<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Test</title>
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data" class="card container mt-1">
<div class="card-body">
    @csrf
    <div class="mb-3">
    <label for="formFile" class="form-label">Image</label>
    <input type="file" name="image" class="form-control" id="formFile">
    </div>
    <button type="submit" class="btn btn-dark">Submit</button>
</div>
</form>
<br>
<div class="container">
    @if($image)
    <div>
        {!! getPictures($image->directory) !!}
    </div>
    <div class="mt-1">
        <h2>$image Object</h2>
        <pre>
            {{ print_r($image,true) }}
        </pre>
        <h2>resizedImages() Helper</h2>
        <pre>
            {{ print_r(resizedImages($image->directory),true) }}
        </pre>
    </div>
    @endif
</div>
</body>
</html>
