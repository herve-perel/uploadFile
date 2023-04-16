<?php


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $uploadDir = 'public/uploads/';

    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

    $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];

    $maxFileSize = 1000000;


    $errors = [];

    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
    }


    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    if (empty($errors)) {
        $unique_id = uniqid();
        $new_file_name =  $unique_id . '.' . $extension;
        $uploadFile = $uploadDir . $new_file_name;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
      }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="card">
    <ul>
    <?php if(!empty($errors)) 
         foreach ($errors as $error) : ?>
            <li> <?= $error ?> </li>
        <?php endforeach ?>
       
    </ul>
    <div class="card">
        <?php if (empty($errors)) : ?>
            <img src="<?= $uploadFile ?>" />
        <?php endif; ?>
        <ul>
            <p>firstname: Homer</p>
            <p>lastname: Simpson</p>
            <p>age: 67</p>
        </div>
    </div>
    <form method="post" enctype="multipart/form-data">

        <label for="imageUpload">Upload an profile image</label>

        <input type="file" name="avatar" id="imageUpload" />

        <button name="send">Send</button>

    </form>

</body>

</html>