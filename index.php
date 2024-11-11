<?php

// Pour lancer le script (le jeu) faire php index.php dans le terminal.

$couleurs = [
  'rouge' => "\033[31m",
  'vert' => "\033[32m",
  'jaune' => "\033[33m",
  'bleu' => "\033[34m",
  'reset' => "\033[0m"
];

$json = file_get_contents('aventure.json');
$aventure = json_decode($json, true);
$dossierSauvegardes = 'sauvegardes';

if (!file_exists($dossierSauvegardes)) {
  mkdir($dossierSauvegardes);
}

function afficherTexteAvecDelai($texte, $couleurs, $couleur = 'reset') {
  $texteColorise = $couleurs[$couleur] . $texte . $couleurs['reset'];
  foreach (str_split($texteColorise) as $caractere) {
    echo $caractere;
    usleep(5000);
  }
  echo "\n";
}

function clearScreen() {
  echo "\033[2J\033[;H";
}

function pause() {
  echo "\nAppuie sur Entrée pour continuer...";
  fgets(STDIN);
}

function sauvegarderProgression($sceneId, $nomSauvegarde) {
  global $dossierSauvegardes;
  $cheminSauvegarde = "$dossierSauvegardes/sauvegarde_$nomSauvegarde.json";
  file_put_contents($cheminSauvegarde, json_encode(['sceneId' => $sceneId]));
}

function chargerSauvegarde($nomSauvegarde) {
  global $dossierSauvegardes;
  $cheminSauvegarde = "$dossierSauvegardes/sauvegarde_$nomSauvegarde.json";
  if (file_exists($cheminSauvegarde)) {
    return json_decode(file_get_contents($cheminSauvegarde), true);
  }
  return null;
}

function supprimerSauvegarde($nomSauvegarde) {
  global $dossierSauvegardes;
  $cheminSauvegarde = "$dossierSauvegardes/sauvegarde_$nomSauvegarde.json";
  if (file_exists($cheminSauvegarde)) {
    unlink($cheminSauvegarde);
  }
}

function listerSauvegardes() {
  global $dossierSauvegardes;
  $fichiers = glob("$dossierSauvegardes/sauvegarde_*.json");
  return array_map(function($fichier) {
    return str_replace(['sauvegardes/sauvegarde_', '.json'], '', $fichier);
  }, $fichiers);
}

function jouerScene($sceneId, $couleurs, $nomSauvegarde) {
  global $aventure;

  sauvegarderProgression($sceneId, $nomSauvegarde);
  clearScreen();
  
  $scene = $aventure['scenes'][$sceneId];
  afficherTexteAvecDelai($scene['text'], $couleurs, 'bleu');
  pause();

  if (isset($scene['end']) && $scene['end'] === true) {
    afficherTexteAvecDelai("C FINI RENTRE CHEZ TOI.", $couleurs, 'rouge');
    supprimerSauvegarde($nomSauvegarde);
    return;
  }

  if (isset($scene['next_scene'])) {
    jouerScene($scene['next_scene'], $couleurs, $nomSauvegarde);
  } elseif (isset($scene['options'])) {
    $options = array_keys($scene['options']);

    for ($i = 0; $i < count($options); $i++) {
      afficherTexteAvecDelai(($i + 1) . ". " . ucfirst($options[$i]), $couleurs, 'vert');
    }

    afficherTexteAvecDelai("Fais ton choix (1 à " . count($options) . ") ou tape 'exit' pour quitter : ", $couleurs, 'jaune');
    $choixUtilisateur = trim(fgets(STDIN));

    if (strtolower($choixUtilisateur) === "exit") {
      afficherTexteAvecDelai("TROP triste que tu partent !", $couleurs, 'rouge');
      exit;
    }

    if (!is_numeric($choixUtilisateur) || $choixUtilisateur < 1 || $choixUtilisateur > count($options)) {
      afficherTexteAvecDelai("Choix invalide, essaie encore.", $couleurs, 'rouge');
      jouerScene($sceneId, $couleurs, $nomSauvegarde);
    } else {
      $choixSuivant = $options[$choixUtilisateur - 1];
      jouerScene($scene['options'][$choixSuivant], $couleurs, $nomSauvegarde);
    }
  }
}

function demarrerJeu($couleurs) {
  $sauvegardes = listerSauvegardes();
  
  afficherTexteAvecDelai("Bienvenue dans l'aventure !", $couleurs, 'jaune');
  if (count($sauvegardes) > 0) {
    afficherTexteAvecDelai("\nDes sauvegardes sont disponibles. Que veux-tu faire ?", $couleurs, 'jaune');
    echo "---------------------------------\n";
    afficherTexteAvecDelai("1. Jouer une sauvegarde existante", $couleurs, 'vert');
    afficherTexteAvecDelai("2. Supprimer une sauvegarde", $couleurs, 'rouge');
    afficherTexteAvecDelai("3. Créer une nouvelle partie", $couleurs, 'bleu');
    echo "---------------------------------\n";
    echo "Choisis une option (1, 2 ou 3) : ";
    $choix = trim(fgets(STDIN));

    switch ($choix) {
      case '1':
        echo "\nSauvegardes disponibles : \n";
        foreach ($sauvegardes as $index => $nomSauvegarde) {
          afficherTexteAvecDelai(($index + 1) . ". " . ucfirst($nomSauvegarde), $couleurs, 'vert');
        }
        echo "\nChoisis une sauvegarde par numéro : ";
        $choixSauvegarde = trim(fgets(STDIN));
        $index = (int) $choixSauvegarde - 1;
        if (isset($sauvegardes[$index])) {
          $nomSauvegarde = $sauvegardes[$index];
          $sauvegarde = chargerSauvegarde($nomSauvegarde);
          if ($sauvegarde) {
            jouerScene($sauvegarde['sceneId'], $couleurs, $nomSauvegarde);
          } else {
            afficherTexteAvecDelai("Erreur de chargement de la sauvegarde.", $couleurs, 'rouge');
          }
        } else {
          afficherTexteAvecDelai("Choix invalide.", $couleurs, 'rouge');
        }
        break;

      case '2':
        echo "\nSauvegardes disponibles pour suppression :\n";
        foreach ($sauvegardes as $index => $nomSauvegarde) {
          afficherTexteAvecDelai(($index + 1) . ". " . ucfirst($nomSauvegarde), $couleurs, 'vert');
        }
        echo "\nChoisis une sauvegarde à supprimer par numéro : ";
        $choixSauvegarde = trim(fgets(STDIN));
        $index = (int) $choixSauvegarde - 1;
        if (isset($sauvegardes[$index])) {
          supprimerSauvegarde($sauvegardes[$index]);
          afficherTexteAvecDelai("Sauvegarde supprimée.", $couleurs, 'rouge');
          demarrerJeu($couleurs);
        } else {
          afficherTexteAvecDelai("Choix invalide.", $couleurs, 'rouge');
          demarrerJeu($couleurs);
        }
        break;

      case '3':
        echo "Entrez un nom pour la nouvelle partie : ";
        $nomSauvegarde = trim(fgets(STDIN));
        jouerScene('start', $couleurs, $nomSauvegarde);
        break;

      default:
        afficherTexteAvecDelai("Choix invalide.", $couleurs, 'rouge');
        demarrerJeu($couleurs);
    }
  } else {
    echo "Aucune sauvegarde trouvée. Entrez un nom pour la nouvelle partie : ";
    $nomSauvegarde = trim(fgets(STDIN));
    jouerScene('start', $couleurs, $nomSauvegarde);
  }
}

demarrerJeu($couleurs);

?>
