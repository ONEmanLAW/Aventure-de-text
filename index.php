<?php

// Pour lancer le script (le jeu) faire php index.php dans le terminal.
include "blackjack.php";

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

$scenesParcourues = [];

function afficherTexteAvecDelai($texte, $couleurs, $couleur = 'reset') {
  echo "\n";
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


function genererMarkdown($scenesParcourues, $nomSauvegarde, $resultat) {
  global $dossierSauvegardes;
  $cheminMarkdown = "$dossierSauvegardes/$nomSauvegarde.md";
  $markdown = "# Aventure Interactif - $nomSauvegarde\n\n";


  if ($resultat === 'victoire') {
    $markdown .= "🎉 **Félicitations, vous avez gagné !** 🏆\n\n";
    $markdown .= "Voici votre aventure en détail, avec des choix intéressants.\n";
  } else {
    $markdown .= "😞 **Vous avez perdu !** 💀\n\n";
    $markdown .= "Vous avez fait de votre mieux, mais voici comment l'histoire s'est terminée.\n";
  }


  foreach ($scenesParcourues as $scene) {
    $markdown .= "## " . ucfirst(str_replace('_', ' ', $scene['id'])) . "\n";
    $markdown .= $scene['text'] . "\n\n";
  }


  file_put_contents($cheminMarkdown, $markdown);

  echo "\nLe fichier Markdown a été généré et est maintenant ouvert dans votre éditeur par défaut.\n";
  system("start $cheminMarkdown");
}


function jouerScene($sceneId, $couleurs, $nomSauvegarde) {
  global $aventure, $scenesParcourues;

  sauvegarderProgression($sceneId, $nomSauvegarde);
  clearScreen();
  
  $scene = $aventure['scenes'][$sceneId];

  if ($scene['text'] === "blackjack") {
    startBlackjack();
  }elseif ($scene['text'] === "tirer") {
    tirer();
  }elseif ($scene['text'] === "Refuser") {
   refuser();
  }else{
    afficherTexteAvecDelai($scene['text'], $couleurs, 'bleu');
  }
  
  pause(); 

  $scenesParcourues[] = ['id' => $sceneId, 'text' => $scene['text'], 'image' => isset($scene['image']) ? $scene['image'] : null];

  if (isset($scene['end']) && $scene['end'] === true) {
    if ($sceneId === 'victory') {
      afficherTexteAvecDelai("FÉLICITATIONS ! VOUS AVEZ GAGNÉ !", $couleurs, 'vert');
      pause();
      $resultat = 'victoire';
    } else {
      afficherTexteAvecDelai("C FINI RENTRE CHEZ TOI.", $couleurs, 'rouge');
      $resultat = 'defaite';
    }

    afficherTexteAvecDelai("Pour visualiser les choix que vous avez faits pendant l'histoire, consultez le fichier Markdown généré : '$nomSauvegarde.md'.", $couleurs, 'jaune');
    
    genererMarkdown($scenesParcourues, $nomSauvegarde, $resultat);
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
    $choix = trim(fgets(STDIN));
    
    switch ($choix) {
      case '1':
        echo "\nSauvegardes disponibles :\n";
        foreach ($sauvegardes as $index => $nomSauvegarde) {
          afficherTexteAvecDelai(($index + 1) . ". " . ucfirst($nomSauvegarde), $couleurs, 'vert');
        }
        echo "\nChoisis une sauvegarde à charger : ";
        $choixSauvegarde = trim(fgets(STDIN));
        $index = (int) $choixSauvegarde - 1;
        if (isset($sauvegardes[$index])) {
          $sauvegarde = chargerSauvegarde($sauvegardes[$index]);
          if ($sauvegarde) {
            afficherTexteAvecDelai("Sauvegarde chargée. Reprise du jeu...", $couleurs, 'vert');
            jouerScene($sauvegarde['sceneId'], $couleurs, $sauvegardes[$index]);
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
