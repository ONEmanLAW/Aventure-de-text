<?php
include "index.php";
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
  global $yoHand, $nestorHand, $couleurs,$nomSauvegarde;
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
    jouerScene("gagne", $couleurs,$nomSauvegarde);
  }else if (countValues("you")===21){
    jouerScene("perd", $couleurs,$nomSauvegarde);
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
  global $yoHand, $nestorHand, $couleurs, $nomSauvegarde;
  echo "Main de Nestor : ";
  foreach ($nestorHand as $el) {
    echo $el;
  }
  echo "\n\n Votre main : ";
  foreach ($yoHand as $e) {
    echo $e;
  }
  if (countValues("Nestor")<countValues("you")) {
    jouerScene("gagne", $couleurs,$nomSauvegarde);
  }else{
    jouerScene("perd", $couleurs,$nomSauvegarde);
  }
}
?>
