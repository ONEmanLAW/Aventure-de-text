<?php

$json = file_get_contents('aventure.json');
$aventure = json_decode($json, true);

function jouerScene($sceneId) {
  global $aventure;

  $scene = $aventure['scenes'][$sceneId];
  echo $scene['text'] . "\n\n";

  if (isset($scene['end']) && $scene['end'] === true) {
    echo "L'aventure est terminée.\n";
    return;
  }

  if (isset($scene['next_scene'])) {
    jouerScene($scene['next_scene']);
  } elseif (isset($scene['options'])) {
    $options = array_keys($scene['options']);

    for ($i = 0; $i < count($options); $i++) {
      echo ($i + 1) . ". " . ucfirst($options[$i]) . "\n";
    }

    echo "\nFais ton choix (1 à " . count($options) . ") ou tape 'exit' pour quitter : ";
    $choixUtilisateur = trim(fgets(STDIN));

    if (strtolower($choixUtilisateur) === 'exit') {
      echo "Tu as quitté le jeu.\n";
      exit;
    }

    if (!is_numeric($choixUtilisateur) || $choixUtilisateur < 1 || $choixUtilisateur > count($options)) {
      echo "Choix invalide, essaie encore.\n";
      jouerScene($sceneId);
    } else {
      $choixSuivant = $options[$choixUtilisateur - 1];
      jouerScene($scene['options'][$choixSuivant]);
    }
  }
}

jouerScene('start');

?>
