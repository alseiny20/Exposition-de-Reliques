<?php
/*
 * Gère le stockage de relique dans un fichier.
 * Plus simple que l'utilisation d'une base de données,
 * car notre application est très simple.
 */

class ReliqueStorageFile implements ReliqueStorage
{
    /* le ObjectFileDB dans lequel l'instance est enregistrée */
    private $db;

    /* Construit une nouvelle instance, qui utilise le fichier donné
     * en paramètre. */
    public function __construct($file)
    {
        $this->db = new ObjectFileDB($file);
        // $this->reinit();
        // echo "life tims";

        // $this->deleteAll();
    }

    /* Insère une nouvelle couleur dans la base. Renvoie l'identifiant
     * de la nouvelle couleur. */
    public function create(Relique $c)
    {
        return $this->db->insert($c);
    }

    /* Renvoie la couleur d'identifiant $id, ou null
     * si l'identifiant ne correspond à aucune couleur. */
    public function read($id)
    {
        if ($this->db->exists($id)) {
            return $this->db->fetch($id);
        } else {
            return null;
        }
    }

    /* Renvoie un tableau associatif id => Relique
     * contenant toutes les relique de la base. */
    public function readAll()
    {
        return $this->db->fetchAll();
    }

    /* Met à jour une couleur dans la base. Renvoie
     * true si la modification a été effectuée, false
     * si l'identifiant ne correspond à aucune couleur. */
    public function update($id, Relique $c)
    {
        if ($this->db->exists($id)) {
            $this->db->update($id, $c);
            return true;
        }
        return false;
    }

    /* Supprime une couleur. Renvoie
     * true si la suppression a été effectuée, false
     * si l'identifiant ne correspond à aucune couleur. */
    public function delete($id)
    {
        if ($this->db->exists($id)) {
            $this->db->delete($id);
            return true;
        }
        return false;
    }

    /* Vide la base. */
    public function deleteAll()
    {
        $this->db->deleteAll();
    }

    public function reinit()
    {
        $this->deleteAll();
        //$this->readAll();
        $donnees = array(
            'vibranium' => array('Vibranium', 'une MatierePremier',"1940","Wakanda","www.google.com"),
            'mjolnir' => array('Mjølnir', 'le Marteau de THOR',"___", "Thor",""),
            'Tesseract' => array('Tesseract', 'Récipient de confinement ', "1942", "Asgardiens",""),
        );
        foreach ($donnees as $key => $value) {
            $this->create(new Relique($donnees[$key][0], $donnees[$key][1], $donnees[$key][2], $donnees[$key][3], $donnees[$key][4]));
        }
    }
}
