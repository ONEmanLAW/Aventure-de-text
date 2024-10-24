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

function jouerScene($sceneId, $couleurs) {
  global $aventure;

  $scene = $aventure['scenes'][$sceneId];
  echo $couleurs['bleu'] . $scene['text'] . $couleurs['reset'] . "\n\n";

  if (isset($scene['end']) && $scene['end'] === true) {
    echo $couleurs['rouge'] . "C FINI RENTRE CHEZ TOI." . $couleurs['reset'] . "\n";
    return;
  }

  if (isset($scene['next_scene'])) {
    jouerScene($scene['next_scene'], $couleurs);
  } elseif (isset($scene['options'])) {
    $options = array_keys($scene['options']);

    for ($i = 0; $i < count($options); $i++) {
      echo $couleurs['vert'] . ($i + 1) . ". " . ucfirst($options[$i]) . $couleurs['reset'] . "\n";
    }

    echo "\nFais ton choix (1 à " . count($options) . ") ou tape 'exit' pour quitter TAPETTE : ";
    $choixUtilisateur = trim(fgets(STDIN));

    if (strtolower($choixUtilisateur) === "exit") {
      echo $couleurs['rouge'] . "TROP triste que tu partent !" . $couleurs['reset'] . "\n";
      exit;
    }

    if (!is_numeric($choixUtilisateur) || $choixUtilisateur < 1 || $choixUtilisateur > count($options)) {
      echo $couleurs['rouge'] . "T CON OU QUOI Choix invalide, essaie encore." . $couleurs['reset'] . "\n";
      jouerScene($sceneId, $couleurs);
    } else {
      $choixSuivant = $options[$choixUtilisateur - 1];
      jouerScene($scene['options'][$choixSuivant], $couleurs);
    }
  }
}

jouerScene('start', $couleurs);

?>
