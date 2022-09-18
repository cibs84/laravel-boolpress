<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ciao Amministratore, un nuovo post è stato creato nel blog</h1>

    <div>Il titolo del nuovo post è: {{ $new_post->title }}</div>

    <a href="{{route('admin.posts.show', ['post' => $new_post->id])}}">Clicca qui per visualizzare il post</a>
</body>
</html>