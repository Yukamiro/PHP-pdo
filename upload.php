<?php
if (isset($_FILES['image']) and $_FILES['image']['error'] == 0) {
    // Etape 2
    if ($_FILES['image']['size'] <= 1000000) {
        //Etape 3
        $extension = $_FILES['image']['type'];
        $extensions_autorisees = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
        if (in_array($extension, $extensions_autorisees)) {
            //Etape 4
            $image_url = uniqid() . $_FILES['image']['name'];

            if (move_uploaded_file($_FILES['image']['tmp_name'], '../img/' . $image_url)) {

                echo "L'envoi a bien été effectué !";
            }
        } else {
            echo ('J\'accepte que les jpg, jpeg, gif, png');
        }
    } else {
        echo ('le fichier est trop lourd 1MB max');
    }
}
