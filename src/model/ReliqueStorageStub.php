<?php

require_once("model/Relique.php");
require_once("model/ReliqueStorage.php");

/* Une classe de démo de l'architecture. Une vraie BD ne contiendrait
 * évidemment pas directement des instances de Poem, il faudrait
 * les construire lors de la lecture en BD. */
class ReliqueStorage implements ReliqueStorage
{
    protected $base;

    /* Construit une instance avec 4 poèmes. */
    public function __construct()
    {
        $donnees = array(
            'vibranium' => array('Vibranium', 'une MatierePremier',"1940","Wakanda",""),
            'mjolnir' => array('Mjølnir', 'le Marteau de THOR',"___", "Thor",""),
            'Tesseract' => array('Tesseract', 'Récipient de confinement ', "1942", "Asgardiens",""),
        );
        $this->base=[];
        foreach ($donnees as $key => $value) {
            $this->base[$key]=new Relique($donnees[$key][0], $donnees[$key][1], $donnees[$key][2], $donnees[$key][3], $donnees[$key][3]);
        }
    }

    /**
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function read($id)
    {
        if (key_exists($id, $this->base)) {
            return $this->base[$id];
        }
        return null;
    }

    /**
     *
     * @return mixed
     */
    public function readAll()
    {
        return $this->base;
    }
}
