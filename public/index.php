<?php
//Début des vérifications de sécurité...
$directory = 'UPLOAD/';

if(isset($_POST['nameToDelete'])) {
    $fileToDelete = $_POST['nameToDelete'];
    if (file_exists($directory . $fileToDelete)) {
        unlink('UPLOAD/' . $_POST['nameToDelete']);
    }
}

if(isset($_FILES['image'])) {

foreach ($_FILES['image']['name'] as $key => $imageName) {

    $imageType = $_FILES['image']['type'][$key];
    $imageTmp_name = $_FILES['image']['tmp_name'][$key];
    $imageSize = $_FILES['image']['size'][$key];



        $imageSize_maxi = 1048576;
        $extensions = array('png', 'gif', 'jpg', 'jpeg');
        $extension = pathinfo($imageName, PATHINFO_EXTENSION);

        //Si l'extension n'est pas dans le tableau
        if (!in_array($extension, $extensions)) {
            $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
        }

        if ($imageSize > $imageSize_maxi) {
            $erreur = 'Le fichier est trop gros...';
        }

        //S'il n'y a pas d'erreur, on upload
        if (!isset($erreur)) {

            //On formate le nom du fichier ici...
            $filename = 'image.' . uniqid() . '.' . $extension;

            //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            if (move_uploaded_file($imageTmp_name, 'UPLOAD/'.$filename)) {
                echo 'Upload effectué avec succès !';
            } else {
                echo 'Echec de l\'upload !';
            }
        } else {
            echo $erreur;
        }
    }
}




//List des fichiers contenus dans le UPLOAD
$images = scandir('UPLOAD');
array_splice($images, 0, 2);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <title>Mes rêves...</title>
</head>
<body>

<section class="container">
        <h1 class="text-center">Mes rêves...</h1>

    <div class="row">
        <?php foreach ( $images as $image) :?>
            <div class="card text-center">
                <img class="card-img-top img-fluid" src="/UPLOAD/<?= $image ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $image ?></h5>
                    <form method="post" action="" >
                        <input type="hidden" name="nameToDelete" value="<?= $image ?>">
                        <input type="submit" name="deleteImg" class="btn btn-danger" value="Delete">
                    </form>
                </div>
            </div>
        <?php endforeach;?>
    </div>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                    <label for="file"></label>
                    <input type="file" class="form-control-file" name="image[]" multiple="multiple" id="file"/>
                    <small id="fileHelpId" class="form-text text-muted">Fichier (JPG, PNG ou GIF | max 1 Mo)</small>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <input type="submit" name="submit" value="Send"/>
                </div>
            </div>
        </div>
    </form>
</section>

   <!-- Scripts-->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>
