<?php

define("NAME_REF", "nom");
define("POUVOIR_REF", "pouvoir");
define("PROPRIETAIRE_REF", "proprietaire");
define("CREATION_REF", "creation");
define("LIENS_REF", "liens");

class ReliqueBuilder
{
    private $data;
    private $errors;

    /**
     * cette fonction Crée une nouvelle instance, avec les données passées en argument si
     * elles existent, et sinon avec
     * les valeurs par défaut des champs de création d'une relique.
     */
    public function __construct($data=null)
    {
        $this->data = $data;
        $this->errors = array();
    }

    // fonction de creation d'une reliques
    public function createRelique()
    {
        //recuperation du nom definie par php afin d'eviter d'utuliser le nom que l'utulisateur a fournie

        $nomFicher = preg_split("/php/", $this->data['file'][LIENS_REF]['tmp_name'])[1];
        move_uploaded_file($this->data['file'][LIENS_REF]['tmp_name'], "upload/".$nomFicher);
        return new Relique($this->data[NAME_REF], $this->data[POUVOIR_REF], $this->data[CREATION_REF], $this->data[PROPRIETAIRE_REF], $nomFicher);
    }

    /**
     * fonction de verifcation la validité des données envoyées par le client,
     * cree  un tableau des erreurs à corriger.
     *
     * @return boolean True s'il n'y a pas d'erreur, False sinon
     */

    public function isValid()
    {
        // on teste si tout les champs sont remplies
        $this->errors = array();
        if (!key_exists(NAME_REF, $this->data) || $this->data[NAME_REF] === "") {
            $this->errors[NAME_REF] = "Vous devez entrer un ".NAME_REF;
        }
        if (!key_exists(POUVOIR_REF, $this->data) || $this->data[POUVOIR_REF] === "") {
            $this->errors[POUVOIR_REF] = "Vous devez entrer un ".POUVOIR_REF;
        }
        if (!key_exists(CREATION_REF, $this->data) || $this->data[CREATION_REF] === "") {
            $this->errors[CREATION_REF] = "Vous devez entrer un ".CREATION_REF;
        }
        if (!key_exists(PROPRIETAIRE_REF, $this->data) || $this->data[PROPRIETAIRE_REF] === "") {
            $this->errors[PROPRIETAIRE_REF] = "Vous devez entrer un ".PROPRIETAIRE_REF;
        }
        if (!key_exists(LIENS_REF, $this->data['file']) || $this->data['file'][LIENS_REF]['error'] !=0) {
            $this->errors[LIENS_REF] = "Vous devez charger une image ".LIENS_REF;
        }
        //on verifie le type de l'image
        else {
            $link = $this->data['file'][LIENS_REF]['tmp_name'];
            if (exif_imagetype("$link") != IMAGETYPE_JPEG && exif_imagetype("$link")!= IMAGETYPE_PNG) {
                $this->errors[LIENS_REF] = "Format invalide (only jpeg,png)";
            }
        }
        //verifie s'il ya 0 erreur
        return count($this->errors) === 0;
    }

    /** cette Renvoie les donnnés de la classe( attribut data) . */
    public function getData()
    {
        return $this->data;
    }

    /** cette fonction renvoie les erreur figurant sur les donnés data */
    public function getError()
    {
        return $this->errors;
    }

    /**
     * cette fonction Renvoie une nouvelle instance de ReliqueBuilder avec les données
     * modifiables de la relique passée en argument.
     * @param Relique $relique la relique a deriveé
     */
    public static function buildFromRelique(Relique $relique)
    {
        return new ReliqueBuilder(array(
            NAME_REF => $relique->getNom(),
            POUVOIR_REF=> $relique->getPouvoir(),
            CREATION_REF=> $relique->getCreation(),
            PROPRIETAIRE_REF=> $relique->getProprietaire(),
            LIENS_REF=> $relique->getLiens(),
        ));
    }

    /** fonction de mise a jour d'une relique
     * @param Relique $relique la relique a mettre a jour
     */
    public function updateRelique(Relique $relique)
    {
        if (key_exists(NAME_REF, $this->data)) {
            $relique->setNom($this->data[NAME_REF]);
        }
        if (key_exists(POUVOIR_REF, $this->data)) {
            $relique->setPouvoir($this->data[POUVOIR_REF]);
        }
        if (key_exists(CREATION_REF, $this->data)) {
            $relique->setCreation($this->data[CREATION_REF]);
        }
        if (key_exists(PROPRIETAIRE_REF, $this->data)) {
            $relique->setProprietaire($this->data[PROPRIETAIRE_REF]);
        }
        //telechargement de la la nouvelle images
        $nomFicher = preg_split("/php/", $this->data['file'][LIENS_REF]['tmp_name'])[1];
        move_uploaded_file($this->data['file'][LIENS_REF]['tmp_name'], "upload/".$nomFicher);
        //supression de l'encienne images execpté les 3 images d'intialisation
        if ($relique->getLiens()!="im1" and $relique->getLiens()!= "im2" and $relique->getLiens()!= "im3") {
            unlink("upload/".$relique->getLiens());
        }
        if (key_exists(LIENS_REF, $this->data['file'])) {
            $relique->setLiens($nomFicher);
        }
    }
}
