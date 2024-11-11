<?php
//    $file = 'savegame.txt';
//    $texte = file_get_contents($file);
//    $texte .= $choixUtilisateur;
//    file_put_contents($file, $texte);
//    print_r($scene);

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
$file = 'savegame.txt';


function afficherTexteAvecDelai($texte, $couleurs, $couleur = 'reset') {
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
  global $file;

  clearScreen();
  $scene = $aventure['scenes'][$sceneId];
  afficherTexteAvecDelai($scene['text'], $couleurs, 'bleu');
//  print($sceneId);
  $texte = $sceneId;
  file_put_contents($file, $texte);

  if (isset($scene['end']) && $scene['end'] === true) {
    afficherTexteAvecDelai("C FINI RENTRE CHEZ TOI.", $couleurs, 'rouge');
    unlink($file);
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
//jouerScene('start', $couleurs);
function chooseSave(){
    global $file;
    global $couleurs;
    if (file_exists($file)){
        echo "1. Reprendre la partie en cours ";
        echo "\n2. Nouvelle partie";
        echo "\nChoisir 1 ou 2...";
        $menuChoice = trim(fgets(STDIN));
        if($menuChoice == 1){
            $savedData = file_get_contents($file);
            jouerScene($savedData, $couleurs);
        }else if ($menuChoice == 2){
            jouerScene('start', $couleurs);
            unlink($file);
        };
    }elseif (!file_exists($file)){
        jouerScene('start', $couleurs);
    };
};

chooseSave()
?>