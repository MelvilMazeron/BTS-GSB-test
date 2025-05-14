<?php
// La fonction trim() est utilisée pour supprimer les espaces blancs (ou autres caractères définis) 
// au début et à la fin d'une chaîne. Cela permet de nettoyer les données saisies par l'utilisateur 
// en supprimant les espaces inutiles qui pourraient causer des erreurs lors de la validation ou du traitement.
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $specialite = trim($_POST['specialite']);
    $description = trim($_POST['description']);
    $cabinet = trim($_POST['cabinet']);
    $adresse = trim($_POST['adresse']);
    $codepostal = trim($_POST['codepostal']);
    $ville = trim($_POST['ville']);
    $region = filter_input(INPUT_POST, 'region', FILTER_VALIDATE_INT);

    // Vérification des champs obligatoires
    if ($email && $specialite && $description && $cabinet && $adresse && $codepostal && $ville && $region) {
        try {
            $pdo = getDatabaseConnection();
            $stmt = $pdo->prepare("
                INSERT INTO practicien (
                    EmailPracticien, 
                    SpecialiteMedecin, 
                    DescriptionMedecin, 
                    Cabinet, 
                    AdressePracticien, 
                    CodePostalPracticien, 
                    VillePracticien, 
                    IdRegion
                ) VALUES (
                    :email, 
                    :specialite, 
                    :description, 
                    :cabinet, 
                    :adresse, 
                    :codepostal, 
                    :ville, 
                    :region
                )
            ");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':specialite', $specialite);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':cabinet', $cabinet);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':codepostal', $codepostal);
            $stmt->bindParam(':ville', $ville);
            $stmt->bindParam(':region', $region);

            if ($stmt->execute()) {
                echo "<script>
                    alert('Praticien ajouté avec succès !');
                    window.location.href = '../../Frontend/Add/ajout.php';
                </script>";
                exit;
            } else {
                throw new Exception('Échec de l\'insertion des données dans la base.');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "<script>
                alert('Erreur : " . addslashes($e->getMessage()) . "');
                window.location.href = '../../Frontend/ajout.php';
            </script>";
            exit;
        }
    } else {
        echo "<script>
            alert('Tous les champs sont obligatoires.');
            window.location.href = '../../Frontend/Add/Practicien.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('Méthode non autorisée.');
        window.location.href = '../../Frontend/ajout.php';
    </script>";
    exit;
}
?>