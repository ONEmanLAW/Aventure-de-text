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


function afficherTexteAvecDelai($texte, $couleurs, $couleur = 'reset') {
  echo "\n";
  $texteColorise = $couleurs[$couleur] . $texte . $couleurs['reset'];
  foreach (str_split($texteColorise) as $caractere) {
    echo $caractere;
    usleep(10000);
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

function jouerScene($sceneId, $couleurs) {
  global $aventure;

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
  

  if (isset($scene['end']) && $scene['end'] === true) {
    afficherTexteAvecDelai("C FINI RENTRE CHEZ TOI.", $couleurs, 'rouge');
    return;
  }

  if (isset($scene['next_scene'])) {
    pause();
    jouerScene($scene['next_scene'], $couleurs);
  } elseif (isset($scene['options'])) {
    $options = array_keys($scene['options']);

    for ($i = 0; $i < count($options); $i++) {
      afficherTexteAvecDelai(($i + 1) . ". " . ucfirst($options[$i]), $couleurs, 'vert');
    }

    afficherTexteAvecDelai("Fais ton choix (1 à " . count($options) . ") ou tape 'exit' pour quitter TAPETTE : ", $couleurs, 'jaune');
    $choixUtilisateur = trim(fgets(STDIN));

    if (strtolower($choixUtilisateur) === "exit") {
      afficherTexteAvecDelai("TROP triste que tu partent !", $couleurs, 'rouge');
      exit;
    }

    if (!is_numeric($choixUtilisateur) || $choixUtilisateur < 1 || $choixUtilisateur > count($options)) {
      afficherTexteAvecDelai("T CON OU QUOI Choix invalide, essaie encore.", $couleurs, 'rouge');
      jouerScene($sceneId, $couleurs);
    } else {
      $choixSuivant = $options[$choixUtilisateur - 1];
      jouerScene($scene['options'][$choixSuivant], $couleurs);
      
    }
  }
}

// Démarrer l'aventure
jouerScene('start', $couleurs);

?>
