<?php

// Contrôleur du site des reliques.

class Controller
{
    protected $view;
    protected $data;

    /** contructeur d'un controller  */
    public function __construct(View $view, ReliqueStorage $reliqueStorage)
    {
        $this->data = $reliqueStorage;
        $this->view = $view;
    }

    /**
     * fonction d'affichage d'une relique
     * @param mixed id es l'identifiant de la relique
    **/
    public function showRelique($id)
    {
        //recuperation de la relique de la base via son identifieant
        if (key_exists($id, $this->data->readAll())) {
            //demande de la page d'affichage des detaille de la relique
            $this->view->makeRelique($this->data->read($id), $id);
        } else {
            //relique inexistante

            $this->view->makeUnknowReliquePage();
        }
    }

    // fonction d'affichage de l'ensembles des reliques
    public function showList()
    {
        $this->view->makeListPage($this->data->readAll());
    }

    /**
     * fonction de sauvegarde d'une relique
     * @param Array $data c'est le information texte de la relique
     * @param Array $file c'est l'image de la relique
     */
    public function saveNewRelique(array $data, array $file=null)
    {
        $data['file']= $file;
        $reliqueBuilder = new ReliqueBuilder($data);
        //verification la validité de la relique
        if ($reliqueBuilder->isValid()) {
            // destruction du currentRelique la session courante
            unset($_SESSION['currentNewRelique']);
            //construcction de la nouvelle  relique
            $id = $this->data->create($reliqueBuilder->createRelique());
            // redirection vers une page d'affichage
            $this->view->displayReliqueCreationSuccess($id);
        } else {
            // enregistrement  l'erreur dans la cession
            $_SESSION['currentNewRelique'] = $reliqueBuilder;
            //redirection sur la page de creation
            $this->view->displayReliqueCreationFailure();
        }
    }

    /** fonction de affichage du formulaire de creation d'une relique */
    public function newRelique()
    {
        //chargement la relique courante s'il existe
        if (key_exists('currentNewRelique', $_SESSION)) {
            $this->view->makeReliqueCreation($_SESSION['currentNewRelique']);
        } else {
            //affichage du formulaire par defaut
            $this->view->makeReliqueCreation(new ReliqueBuilder(null));
        }
    }

    /**
     * fonction de demande de supression d'une relique
     * @param mixed $id l'identifiant de la relique a suprimer
     */
    public function askReliqueDeletion($id)
    {
        //verification de l'existance de la relique
        if (key_exists($id, $this->data->readAll())) {
            //demande de supression defenitive
            $this->view->makeReliqueDeletionPage($id, $this->data->read($id));
        } else {
            $this->view->makeUnknowReliquePage();
        }
    }

    /**
     * fonction supression définitive d'une relique
     * @param mixed $id l'identifiant de la relique a suprimer
     */
    public function deleteRelique($id)
    {
        $succes = $this->data->delete($id);
        if ($succes) {
            //supression reussi, redirection
            $this->view->makeReliqueDelationSuccess();
        } else {
            //probleme inconue
            $this->view->makeUnknowReliquePage();
        }
    }

    /**
     * fonction de demande de modification d'une relique
     * elle teste si la modification est possible
     * @param mixed $id l'identifiant de la relique a modifé
     */
    public function modifyrelique($id)
    {
        $reliqueBuild =null;
        //verification de l'existance d'une last edition
        if (key_exists('currentModifyRelique', $_SESSION)) {
            //chargement de la dernier edition de la relique si elle existe
            if (key_exists($id, $_SESSION["currentModifyRelique"])) {
                $reliqueBuild = $_SESSION["currentModifyRelique"][$id];
            }
        }
        //s'il n'y a pas une ancien edition de la relique
        //on charge les donnnées de la relique via la base
        if ($reliqueBuild===null) {
            $relique = $this->data->read($id);
            $reliqueBuild = ReliqueBuilder::buildFromRelique($relique);
            //recuperation de la relique dans la base
        }

        if ($reliqueBuild == null) {
            //relique inexistant page
            $this->view->makeUnknowReliquePage();
        } else {
            //page de modification de la relique
            $this->view->makeReliqueModify($reliqueBuild, $id);
        }
    }

    /**
     * fonction de sauvegarde definitive de la mise a jour d'une relique
     * @param int $reliqueId l'identifiant de la relique a modifé
     * @param Array $data   nouvelle tableau d'information de la relique
     * @param Array $file  nouvelle image de la relique de type
     */
    public function saveReliqueModifications($reliqueId, array $data, $file=null)
    {
        $data['file']=$file;
        /* On récupère en BD la relique à modifier */
        $relique = $this->data->read($reliqueId);
        if ($relique === null) {
            /* La relique n'existe pas en BD */
            $this->view->makeUnknowReliquePage();
        } else {
            $reliqueBuild = new reliqueBuilder($data);
            /* Validation des données */
            if ($reliqueBuild->isValid()) {
                /* Modification de la relique */
                $reliqueBuild->updateRelique($relique);
                /* On essaie de mettre à jour en BD.
                * Normalement ça devrait marcher (on vient de
                * récupérer la relique). */
                $ok = $this->data->update($reliqueId, $relique);
                //$this->view->displayeliqueUpdate();
                //var_dump($data);
                if (!$ok) {
                    throw new Exception("Identifier has disappeared?!");
                }
                /* Préparation de la page de la relique */
                //$this->view->makeRelique($relique, $reliqueId);
                $this->view->displayReliqueModifySuccess($reliqueId);
            } else {
                $_SESSION["currentModifyRelique"][$reliqueId] = $reliqueBuild;
                $this->view->displayReliqueModifyFailure($reliqueId);
                //$this->view->makeReliqueModify($reliqueBuild, $reliqueId );
            }
        }
    }
}
