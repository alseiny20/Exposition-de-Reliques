<?php
/*
 * Gère le stockage de relique dans une base données en ligne
 */
class ReliqueStorageMySQL implements ReliqueStorage
{
    /* Construit une nouvelle instance, qui utilise la base de donneeSQL
     * en paramètre. */
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $this->reinit();
    }
    /**
     *fonction de lecture d'une relique dans la base
     * @param int $id identifiant de la relique
     *
     * @return  Relique renvoie la relique ou null si elle n'existe pas
     */
    public function read($id)
    {
        //preparation de la requete de recherche
        $req = "SELECT * from reliques where id=:id";
        $stmt =$this->pdo->prepare($req);
        $data = array(
            ':id' => $id,
            );
        $stmt->execute($data);
        $value = $stmt->fetch(PDO::FETCH_OBJ);
        if ($value==true) {
            return new Relique($value->name, $value->pouvoir, $value->creation, $value->proprietaire, $value->liens);
        } else {
            return null;
        }
    }

    /**
     *fonction de lecture de toute les reliques de la bases
     * @return mixed un tableau (id -> Relique) des données de la base
     */
    public function readAll()
    {
        //requette de lecture
        $requet = 'SELECT * from reliques';
        $stmt =$this->pdo->query($requet);
        $donnesBrute =$stmt->fetchAll(PDO::FETCH_OBJ);
        //reconstruction des données
        $donnes =null;
        foreach ($donnesBrute as $key => $value) {
            $donnes[$value->id]=new Relique($value->name, $value->pouvoir, $value->creation, $value->proprietaire, $value->liens, $value->id);
        }
        return $donnes;
    }

    /**
     * fonction de d'insertion d'une relique dans la base
     * @param Relique $relique
     * @return l'identifiant de la relique creer, null sinon
     */
    public function create(Relique $relique)
    {
        //construction d'une requette preparer
        $req = "INSERT INTO reliques(name, pouvoir, creation, proprietaire, liens) VALUES (:name, :pouvoir, :creation, :proprietaire, :liens)";
        $stmt =$this->pdo->prepare($req);
        $data = array(
            ':name' => $relique->getNom(),
            ':pouvoir' => $relique->getPouvoir(),
            ':creation' => $relique->getCreation(),
            ':proprietaire' => $relique->getProprietaire(),
            ':liens' => $relique->getLiens(),
          );
        //execution de la requette
        $succes = $stmt->execute($data);
        if ($succes) {
            return $this->pdo->lastInsertId();
        } else {
            return null;
        }
    }

    /**
     * Supprime l'objet d'identifiant $id de la base.
     * @param mixed $id
     * @return bool True si la supression a reussi, false sinon
     */
    public function delete($id)
    {
        if ($this->read($id)) {
            $req = "DELETE FROM reliques where id=:id";
            $stmt = $this->pdo->prepare($req);
            $data = array(
                ':id' => $id,
              );
            $r =$stmt->execute($data);
            return true;
        }
        return false;
    }

    /**
     * Remplace l'objet d'identifiant $id dans la base
     * par celui passé en paramètre.
     *
     * @param mixed $id
     * @param Relique $c
     * @return Boolean true si la mise a jour a reussi, false sinon
     */
    public function update($id, Relique $relique)
    {
        //verification de l'existance de la relique dans la base
        if ($this->read($id)) {
            //preparation de la requette
            $req ="UPDATE reliques SET id=:id,name=:name,pouvoir=:pouvoir,creation=:creation,proprietaire=:proprietaire,liens=:liens WHERE id=:id";
            $stmt = $this->pdo->prepare($req);
            $data = array(
                ':id' => $id,
                ':name' => $relique->getNom(),
                ':pouvoir' => $relique->getPouvoir(),
                ':creation' => $relique->getCreation(),
                ':proprietaire' => $relique->getProprietaire(),
                ':liens' => $relique->getLiens(),
              );
            //execution de la requette
            $stmt->execute($data);
            return true;
        }
        return false;
    }

    /**fonction de Truc de la base de données
     * vide toute la base
     */
    public function deleteAll()
    {
        $req = "TRUNCATE TABLE reliques";
        $stmt = $this->pdo->prepare($req);
        $r =$stmt->execute();
        return true;
    }

    /**fonct de reunitialisation de la base de données */
    public function reinit()
    {
        //supression de toute les ellement
        $this->deleteAll();
        //chargement de donnee initial
        $donnees = array(
            'vibranium' => array('Vibranium', 'une MatierePremier',"1940","Wakanda","im1"),
            'mjolnir' => array('Mjølnir', 'le Marteau de THOR',"1900", "Thor","im2"),
            'Tesseract' => array('Tesseract', 'Récipient de confinement ', "1942", "Asgardiens","im3"),
        );
        foreach ($donnees as $key => $value) {
            //demande de creation de relique via donnees
            $this->create(new Relique($donnees[$key][0], $donnees[$key][1], $donnees[$key][2], $donnees[$key][3], $donnees[$key][4]));
        }
    }
}
