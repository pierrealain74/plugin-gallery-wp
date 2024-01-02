<?php

/**
*
*Template Name: Objet
*
*/


/* const RESULT_WINNER = 1;
const RESULT_LOSER = -1;
const RESULT_DRAW = 0;
const RESULT_POSSIBILITIES = [RESULT_WINNER, RESULT_LOSER, RESULT_DRAW];

function probabilityAgainst(int $levelPlayerOne, int $againstLevelPlayerTwo)
{
    return 1/(1+(10 ** (($againstLevelPlayerTwo - $levelPlayerOne)/400)));
}

function setNewLevel(int &$levelPlayerOne, int $againstLevelPlayerTwo, int $playerOneResult)
{
    if (!in_array($playerOneResult, RESULT_POSSIBILITIES)) {
        trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', RESULT_POSSIBILITIES)));
    }

    $levelPlayerOne += (int) (32 * ($playerOneResult - probabilityAgainst($levelPlayerOne, $againstLevelPlayerTwo)));
}

$greg = 400;
$jade = 800;

echo sprintf(
    'Greg à %.2f%% chance de gagner face a Jade',
    probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
setNewLevel($greg, $jade, RESULT_WINNER);
setNewLevel($jade, $greg, RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $greg,
    $jade
);

exit(0);
 */



/*
*/











/* 
declare(strict_types=1);




class Vehicule{


    private string $indice = 'ch';
    private string $modele;
    private int $boite;
    private int $vitessemax;

    public function setVitesseMax(int $vitessemax): void
    {

        if($vitessemax < 100){
            trigger_error('Vitessemax doit etre supérieur ou egale à 100 ', E_USER_ERROR);
        }
        $this->vitessemax = $vitessemax;
    }
    public function getVitesseMax(): int
    {
        return $this->vitessemax;
    }



    public function setModele(string $modele): void
    {

        if($modele == ''){
            trigger_error('Modele est vide ', E_USER_ERROR);
        }

        $this->modele = $modele;
    }





    public function getModele(): string
    {
        return $this->modele;
    }


    public function setBoite(int $boite): void
    {

        if($boite < 1){
            trigger_error('La valeur de la boite est trop courte. (min 1)', E_USER_ERROR);
        }
        $this->boite = $boite;
    }
    public function getBoite(): int
    {
        return $this->boite;
    }

    public function PerformanceVehicule(): string
    {

        return($this->boite * $this->vitessemax) . $this->indice;

    }

    
}

$perfRenaut = new Vehicule;

$perfRenaut->setModele("Renault");
$perfRenaut->setBoite(2);
$perfRenaut->setVitesseMax(200);

echo sprintf(
    'Le modele de voiture %1$s à un indice de performance de %2$s', $perfRenaut->getModele(),
    $perfRenaut->PerformanceVehicule()
); */






/* 
Code pour tester les variables statics
declare(strict_types=1);

//Compter le nombre de personnes qui travesent les ponts

class Pont{


    public static int $pers = 0;

    public function comptePers()
    {
        self::$pers++;
    }


}

$pontLondon = new Pont;
$pontLondon ->comptePers();

$pontParis = new Pont; 
$pontParis->comptePers();

echo Pont::$pers;

 */














/*  declare(strict_types=1);

class Tablier{

    public function __construct(public float $long, public float $larg)
    {

        echo $this->long * $this->larg;

    }



}

class Pont
{

    public function __construct(public string $name, protected Tablier $tablier)
    {


        
    }

    public function __clone(){
        $this->tablier = clone $this->tablier;
    }

    public function __toString(){

        return sprintf
        (
            'Le tablier à une longeur de %d et une largeur de %d ', $this->tablier->long, $this->tablier->larg 
        );
    }


}

$pont = new Pont('paris', new Tablier(252.2, 35.2));

$result = $pont->__toString();
echo $result; */








/* declare(strict_types=1);

//créer un nouveau tableau de mots commencant par la lettre G à partir d'un tableau de mots

class TrouveMotG
{

    public function __construct(private string $letter)
    {

    }

    public function __invoke(string $chaine)
    {
        return str_starts_with($chaine, $this->letter);
    }


}

var_dump(
    array_filter
    (
        ['chat', 'gateau', 'gerit', 'chien', 'porte'], new TrouveMotG('g')

    )
);
 */






/* declare(strict_types=1);

class Tablier
{
    public function __construct(public float $larg, public float $long)
    {

    }
}

class Pont
{

    public function __construct(public string $name, public Tablier $tablier)
    {

    }

    public function __serialize()
    {
        return[
            'name' => $this->name,
            'largeur' => $this->tablier->larg

        ];
    }

}

$pont = new Pont('paris', new Tablier(552.3, 55.2));

$chaine = serialize($pont);
echo $chaine . PHP_EOL; */







/*
class Encounter
 {
    public const RESULT_WINNER = 1;
    public const RESULT_LOSER = -1;
    public const RESULT_DRAW = 0;
    public const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW];


    public static function probabilityAgainst(Player $playerOne, Player $playerTwo): float
    {
        return 1/(1+(10 ** (($playerTwo->level - $playerOne->level)/400)));
    }

    public static function setNewLevel(Player $playerOne, Player $playerTwo, int $playerOneResult): void
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
        }

        $playerOne->level += round(32 * ($playerOneResult - self::probabilityAgainst($playerOne, $playerTwo)));
    }
}

class Player
{

    public function __construct(public int $level){
        $this->level = $level;
    }

    public function getLevel(): int
    {

        return $this->level;
    }    
    
}



$greg = new Player(400);
$jade = new Player(600);
/* 
$greg->level = 400;
$jade->level = 800; 
*/
/*
echo sprintf(
        'Greg à %.2f%% chance de gagner face a Jade',
        Encounter::probabilityAgainst($greg, $jade)*100
    ).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
Encounter::setNewLevel($greg, $jade, Encounter::RESULT_WINNER);
Encounter::setNewLevel($jade, $greg, Encounter::RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $greg->level,
    $jade->level
);

exit(0); */

declare(strict_types=0);

class A { 
    public function __construct(private int $peugeot = 33) { } 
    public function dites33() { echo $this->peugeot; }
}

(new A)->dites33(66); 

?>