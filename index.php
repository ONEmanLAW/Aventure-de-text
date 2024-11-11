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

$standH = 0;
$standC = 0;
$cardsN = [2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7, 8, 8, 8, 8, 9, 9, 9, 9, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, "A", "A", "A", "A"];
$cardsD = ["
	  .--------.
	  |2       |
	  |   ♣    |
	  |        |
	  |   ♣    |
	  |       2| 
	  \"--------'", 
	  "
	  .--------.
	  |2       |
	  |   ♠    |
	  |        |
	  |   ♠    |
	  |       2| 
	  \"--------'", 
	  "
	  .--------.
	  |2       |
	  |   ♥    |
	  |        |
	  |   ♥    |
	  |       2| 
	  \"--------'", 
	  "
	  .--------.
	  |2       |
	  |   ♦    |
	  |        |
	  |   ♦    |
	  |       2| 
	  \"--------'",
	  "
	  .--------.
	  |3       |
	  |   ♣    |
	  |   ♣    |
	  |   ♣    |
	  |       3| 
	  \"--------'", 
	  "
	  .--------.
	  |3       |
	  |   ♠    |
	  |   ♠    |
	  |   ♠    |
	  |       3| 
	  \"--------'", 
	  "
	  .--------.
	  |3       |
	  |   ♥    |
	  |   ♥    |
	  |   ♥    |
	  |       3| 
	  \"--------'", 
	  "
	  .--------.
	  |3       |
	  |   ♦    |
	  |   ♦    |
	  |   ♦    |
	  |       3| 
	  \"--------'",
	  "
	  .--------.
	  |4       |
	  |  ♣  ♣  |
	  |        |
	  |  ♣  ♣  |
	  |       4| 
	  \"--------'", 
	  "
	  .--------.
	  |4       |
	  |  ♠  ♠  |
	  |        |
	  |  ♠  ♠  |
	  |       4| 
	  \"--------'", 
	  "
	  .--------.
	  |4       |
	  |  ♥  ♥  |
	  |        |
	  |  ♥  ♥  |
	  |       4| 
	  \"--------'", 
	  "
	  .--------.
	  |4       |
	  |  ♦  ♦  |
	  |        |
	  |  ♦  ♦  |
	  |       4| 
	  \"--------'",
	  "
	  .--------.
	  |5       |
	  |  ♣  ♣  |
	  |    ♣   |
	  |  ♣  ♣  |
	  |       5| 
	  \"--------'", 
	  "
	  .--------.
	  |5       |
	  |  ♠  ♠  |
	  |    ♠   |
	  |  ♠  ♠  |
	  |       5| 
	  \"--------'", 
	  "
	  .--------.
	  |5       |
	  |  ♥  ♥  |
	  |    ♥   |
	  |  ♥  ♥  |
	  |       5| 
	  \"--------'", 
	  "
	  .--------.
	  |5       |
	  |  ♦  ♦  |
	  |    ♦   |
	  |  ♦  ♦  |
	  |       5| 
	  \"--------'",
	  "
	  .--------.
	  |6       |
	  |  ♣  ♣  |
	  |  ♣  ♣  |
	  |  ♣  ♣  |
	  |       6| 
	  \"--------'", 
	  "
	  .--------.
	  |6       |
	  |  ♠  ♠  |
	  |  ♠  ♠  |
	  |  ♠  ♠  |
	  |       6| 
	  \"--------'", 
	  "
	  .--------.
	  |6       |
	  |  ♥  ♥  |
	  |  ♥  ♥  |
	  |  ♥  ♥  |
	  |       6| 
	  \"--------'", 
	  "
	  .--------.
	  |6       |
	  |  ♦  ♦  |
	  |  ♦  ♦  |
	  |  ♦  ♦  |
	  |       6| 
	  \"--------'",
	  "
	  .--------.
	  |7       |
	  |  ♣   ♣ |
	  |  ♣ ♣ ♣ |
	  |  ♣   ♣ |
	  |       7| 
	  \"--------'", 
	  "
	  .--------.
	  |7       |
	  |  ♠   ♠ |
	  |  ♠ ♠ ♠ |
	  |  ♠   ♠ |
	  |       7| 
	  \"--------'", 
	  "
	  .--------.
	  |7       |
	  |  ♥   ♥ |
	  |  ♥ ♥ ♥ |
	  |  ♥   ♥ |
	  |       7| 
	  \"--------'", 
	  "
	  .--------.
	  |7       |
	  |  ♦   ♦ |
	  |  ♦ ♦ ♦ |
	  |  ♦   ♦ |
	  |       7| 
	  \"--------'",
	  "
	  .--------.
	  |8       |
	  |  ♣ ♣ ♣ |
	  |  ♣   ♣ |
	  |  ♣ ♣ ♣ |
	  |       8| 
	  \"--------'", 
	  "
	  .--------.
	  |8       |
	  |  ♠ ♠ ♠ |
	  |  ♠   ♠ |
	  |  ♠ ♠ ♠ |
	  |       8| 
	  \"--------'", 
	  "
	  .--------.
	  |8       |
	  |  ♥ ♥ ♥ |
	  |  ♥   ♥ |
	  |  ♥ ♥ ♥ |
	  |       8| 
	  \"--------'", 
	  "
	  .--------.
	  |8       |
	  |  ♦ ♦ ♦ |
	  |  ♦   ♦ |
	  |  ♦ ♦ ♦ |
	  |       8| 
	  \"--------'",
	  "
	  .--------.
	  |9       |
	  |  ♣ ♣ ♣ |
	  |  ♣ ♣ ♣ |
	  |  ♣ ♣ ♣ |
	  |       9| 
	  \"--------'", 
	  "
	  .--------.
	  |9       |
	  |  ♠ ♠ ♠ |
	  |  ♠ ♠ ♠ |
	  |  ♠ ♠ ♠ |
	  |       9| 
	  \"--------'", 
	  "
	  .--------.
	  |9       |
	  |  ♥ ♥ ♥ |
	  |  ♥ ♥ ♥ |
	  |  ♥ ♥ ♥ |
	  |       9| 
	  \"--------'", "
	  .--------.
	  |9       |
	  |  ♦ ♦ ♦ |
	  |  ♦ ♦ ♦ |
	  |  ♦ ♦ ♦ |
	  |       9| 
	  \"--------'",
	  "
	  .--------.
	  |10      |
	  | ♣ ♣ ♣ ♣|
	  |   ♣ ♣  |
	  | ♣ ♣ ♣ ♣|
	  |      10| 
	  \"--------'", 
	  "
	  .--------.
	  |10      |
	  | ♠ ♠ ♠ ♠|
	  |   ♠ ♠  |
	  | ♠ ♠ ♠ ♠|
	  |      10| 
	  \"--------'", 
	  "
	  .--------.
	  |10      |
	  | ♥ ♥ ♥ ♥|
	  |   ♥ ♥  |
	  | ♥ ♥ ♥ ♥|
	  |      10| 
	  \"--------'", 
	  "
	  .--------.
	  |10      |
	  | ♦ ♦ ♦ ♦|
	  |   ♦ ♦  |
	  | ♦ ♦ ♦ ♦|
	  |      10| 
	  \"--------'",
	  "
	  .--------.
	  |J \~~|  |
	  |♣ /'o   |
	  | ([ +)  |
	  |  o,|  ♣|
	  | |~~\  J|
	  \"--------'", 
	  "
	  .--------.
	  |J \~~|  |
	  |♠ /'o   |
	  | ({./)  |
	  |  o,|  ♠|
	  | |~~\  J|
	  \"--------'", 
	  "
	  .--------.
	  |J \~~|  |
	  |♥ /'o   |
	  | (/x )  |
	  |  o,|  ♥|
	  | |~~\  J|
	  \"--------'", 
	  "
	  .--------.
	  |J \~~|  |
	  |♦ /'o   |
	  | (/|\)  |
	  |  o,|  ♦|
	  | |~~\  J|
	  \"--------'",
	  "
	  .--------.
	  |Q \~~|  |
	  |♣ /'o   |
	  | ([ +)  |
	  |  o,|  ♣|
	  | |~~\  Q|
	  \"--------'", 
	  "
	  .--------.
	  |Q \~~|  |
	  |♠ /'o   |
	  | ({./)  |
	  |  o,|  ♠|
	  | |~~\  Q|
	  \"--------'", 
	  "
	  .--------.
	  |Q \~~|  |
	  |♥ /'o   |
	  | (/x )  |
	  |  o,|  ♥|
	  | |~~\  Q|
	  \"--------'", 
	  "
	  .--------.
	  |Q \~~|  |
	  |♦ /'o   |
	  | (/|\)  |
	  |  o,|  ♦|
	  | |~~\  Q|
	  \"--------'",
	  "
	  .--------.
	  |K \~~|  |
	  |♣ /'o   |
	  | ([ +)  |
	  |  o,|  ♣|
	  | |~~\  K|
	  \"--------'", 
	  "
	  .--------.
	  |K \~~|  |
	  |♠ /'o   |
	  | ({./)  |
	  |  o,|  ♠|
	  | |~~\  K|
	  \"--------'", 
	  "
	  .--------.
	  |K \~~|  |
	  |♥ /'o   |
	  | (/x )  |
	  |  o,|  ♥|
	  | |~~\  K|
	  \"--------'", 
	  "
	  .--------.
	  |K \~~|  |
	  |♦ /'o   |
	  | (/|\)  |
	  |  o,|  ♦|
	  | |~~\  K|
	  \"--------'",
	  "
	  .--------.
	  |A   _   |
	  |   ( )  |
	  |  (_x_) |
	  |    Y   |
	  |       A|
	  \"--------'", 
	  "
	  .--------.
	  |A       |
	  |   .    |
	  |  / \\  |
	  | (_,_)  |
	  |   I   A|
	  \"--------'", 
	  "
	  .--------.
	  |A _  _  |
	  | ( \\/ )|
	  |  \\  / |
	  |   \\/  |
	  |       A|
	  \"--------'",
	  "
	  .--------.          
	  |A       |
	  |   /\\  |
	  |  /  \\ |
	  |  \\  / |
	  |   \\/ A|
	  \"--------'"
];

$yoHand=[];
$nestorHand=[];
$randomNumbers=[];

function randomCard() {
  global $cardsD, $randomNumbers;
  $randomCard = rand(0,count($cardsD)-1);
  $randomNumbers[]=$randomCard;
  return $cardsD[$randomCard];
}
    
function startBlackjack() {
  global $yoHand, $nestorHand;
  echo "Main de Nestor : ";
  $nestorHand[] = randomCard();
  $nestorHand[] = randomCard();
  echo $nestorHand[0];
  echo "
	  .--------.
	  |XXXXXXXX|
	  |XXXXXXXX|
	  |XXXXXXXX|
	  |XXXXXXXX|
	  |XXXXXXXX| 
	  \`--------'";
  echo "\n\n Votre main : ";
  $yoHand[] = randomCard();
  $yoHand[] = randomCard();
  foreach ($yoHand as $e) {
    echo $e;
  }
}

function tirer() {
  global $yoHand, $nestorHand, $couleurs;
  echo "Main de Nestor : ";
  echo $nestorHand[0];
  echo "
	  .--------.
	  |XXXXXXXX|
	  |XXXXXXXX|
	  |XXXXXXXX|
	  |XXXXXXXX|
	  |XXXXXXXX| 
	  \`--------'";
  echo "\n\n Votre main : ";
  $yoHand[] = randomCard();
  foreach ($yoHand as $e) {
    echo $e;
  }
  if (countValues("you")>21) {
    jouerScene("gagne", $couleurs);
  }else if (countValues("you")===21){
    jouerScene("perd", $couleurs);
  }
}

function countValues($valueOfWho){
  global $cardsN, $randomNumbers;
  $value=0;
  $aces = 0;
  if ($valueOfWho==="Nestor") {
    for ($i=0; $i <=1; $i++) {
      if ($cardsN[$randomNumbers[$i]]!=="A") {
        $value += $cardsN[$randomNumbers[$i]];
      }elseif (($cardsN[$randomNumbers[$i]]=="A")) {
        $aces++;
        $value += 11;
      }else{
        $value += 1;
      }
      
    }
  }else{
    for ($i=2; $i < count($randomNumbers); $i++) {
      if ($cardsN[$randomNumbers[$i]]!=="A") {
        $value += $cardsN[$randomNumbers[$i]];
      }elseif (($cardsN[$randomNumbers[$i]]=="A")) {
        $aces++;
        $value += 11;
      }else{
        $value += 1;
      }
      
    }
  }
  
  while ($value > 21 && $aces > 0) {
    $value -= 10;
    $aces--;
  }

  return $value;
}

function refuser() {
  global $yoHand, $nestorHand, $couleurs;
  echo "Main de Nestor : ";
  foreach ($nestorHand as $el) {
    echo $el;
  }
  echo "\n\n Votre main : ";
  foreach ($yoHand as $e) {
    echo $e;
  }
  if (countValues("Nestor")<countValues("you")) {
    jouerScene("gagne", $couleurs);
  }else{
    jouerScene("perd", $couleurs);
  }
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
