<?php

use function CommonMark\Render;

    class View
    {
        protected $title;
        protected $content;
        protected $menu;
        private $routeur;
        private $feedback;

        /**cree une instance de Vue, a partir du routeur recus en parametre */
        public function __construct($routeur, $feedback)
        {
            $this->title = null;
            $this->content = null;
            $this->routeur = $routeur;
            $this->feedback = $feedback;
            $this->menu=$this->getMenu();
        }

        /** methode render qui permet de generer la page final     */
        public function render()
        {
            if ($this->title!= null && $this->content!= null) {
                require_once("squelette.php");
            }
        }

        /** fonction de preparation de la page d'acceuil */
        public function makeHomePage()
        {
            $this->title = "Page d'accueil";
            ob_start();
            require_once("accueilView.php");
            $this->content = ob_get_clean();
        }

        /** fonction de preparation de l'affichage d'une relique
         * @param Relique $relique la relique a affiché
         * @param mixed $id l'identifiant de la relique
         */
        public function makeRelique($relique, $id)
        {
            //on inculue la page dans contente
            $this->title = self::htmlesc($relique->getNom());
            ob_start();
            require_once('reliqueView.php');
            $this->content = ob_get_clean();
        }

        /** fonction de preparation de l'affichage de la page de supression
         * @param mixed $id identifiant de la relique
         * @param relique $relique la relique a supprimer
         */
        public function makeReliqueDeletionPage($id, Relique $relique)
        {
            //on inclue la page dans contente en attandant le render
            $cname = self::htmlesc($relique->getNom());
            $this->title = "Suppression de la relique";
            ob_start();
            require_once("squeletteDel.php");
            $this->content = ob_get_clean();
        }

        /** fonciton de notification de page inconue */
        public function makeUnknowReliquePage()
        {
            $this->title = "errror";
            $this->content = "La relique demander n'existe pas";
        }

        /** fonction d'affichage de la liste des reliques */
        public function makeListPage($donnes)
        {
            //on inclue le fichier d'affichage dans contente en attendant le rendu
            $this->title = "Liste des reliques";
            ob_start();
            require_once("squelletteListe.php");
            $this->content = ob_get_clean();
        }

        /**fonction de debug , vu panoramique sur une erreur */
        public function makeDebugPage($variable)
        {
            $this->title = 'Debug';
            $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
        }

        /** fonction d'affichage du formulaire de creation
         * @param ReliqueBuilder donneesInit, les donnees d'initialisation du formulaire
         */
        public function makeReliqueCreation(ReliqueBuilder $donneesInit)
        {
            //on inclue le fichier d'affichage dans contente en attendant le rendu
            $this->title = "Formulaire";
            ob_start();
            $fromAction=  $this->routeur->getReliqueSaveURL();
            require_once("formulaire.php");
            $this->content = ob_get_clean();
        }

        /** fonction de redirection succes delation
         * cette fonction redirige vers la galerie
         */
        public function makeReliqueDelationSuccess()
        {
            return $this->routeur->POSTredirect($this->routeur->getGaleryURL(), "Supression succes");
        }

        /**  */
        public function makeUnknownActionPage()
        {
            $this->title = "Erreur";
            $this->content = "La page demandée n'existe pas.";
        }

        /**  fonction d'affichage du menu*/
        public function getMenu()
        {
            $tabMenu = [];
            $tabMenu[$this->routeur->getAccueilURL()]='Acceuil';
            $tabMenu[$this->routeur->getGaleryURL()]='Gelery';
            $tabMenu[$this->routeur->getReliqueCrationURL()]='Creation';
            $tabMenu[$this->routeur->getAproposURL()]='Apropos';
            return $tabMenu;
        }

        /** fonction d'affichage du formulaire d'edition d'une relique
         * @param ReliqueBuilder $donneesInit données d'initialisation du formulaire
         * @param mixed $id identifiant de la relique
        */
        public function makeReliqueModify($donneesInit, $id)
        {
            $this->title = "Formulaire de modification";
            ob_start();
            $fromAction= $this->routeur->updateModifiedRelique($id);
            require("formulaire.php");
            $this->content = ob_get_clean();
        }

        /** fonction de redirection modification failed
         * cette fonction redirige vers la la meme page (formulaire d'edition)
         * @param mixed $id identifiant de la relique
         */
        public function displayReliqueModifyFailure($reliqueId)
        {
            $url = $this->routeur->getreliqueModifURL($reliqueId);
            return $this->routeur->POSTredirect($url, "modification failure");
        }


        /** fonction de redirection succes creation
         * cette fonction redirige vers la l'affichage des detailles de la relique crée
         * @param mixed $id identifiant de la relique
         */
        public function displayReliqueCreationSuccess($id)
        {
            $reliqueURL = $this->routeur->getReliqueURL($id);
            return $this->routeur->POSTredirect($reliqueURL, "Creation succes");
        }


        /** fonction de redirection succes modification
         * cette fonction redirige vers l'affichage de la relique
         * @param mixed $id identifiant de la relique
         */
        public function displayReliqueModifySuccess($id)
        {
            $reliqueURL = $this->routeur->getReliqueURL($id);
            return $this->routeur->POSTredirect($reliqueURL, "modification succes");
        }

        /** fonction de redirection echec creation
         * cette fonction redirige vers la la page meme page (creation)
         * @param mixed $id identifiant de la relique
         */
        public function displayReliqueCreationFailure()
        {
            return $this->routeur->POSTredirect($this->routeur->getReliqueCrationURL(), "Creation failure");
        }

        /** fonction de notification d'erreur
         * @param mixed $error l'erreur a notifier
         */
        public function makeUnexpectedErrorPage($error)
        {
            echo $error;
        }

        public function showPropos()
        {
            $this->title = "Apropos";
            ob_start();
            require_once("aproposView.php");
            $this->content = ob_get_clean();
        }

        /* Une fonction pour échapper les caractères spéciaux de HTML,
        * car celle de PHP nécessite trop d'options. */
        public static function htmlesc($str)
        {
            return htmlspecialchars(
                $str,
                /* on échappe guillemets _et_ apostrophes : */
                ENT_QUOTES
                /* les séquences UTF-8 invalides sont
                * remplacées par le caractère �
                * au lieu de renvoyer la chaîne vide…) */
                | ENT_SUBSTITUTE
                /* on utilise les entités HTML5 (en particulier &apos;) */
                | ENT_HTML5,
                'UTF-8'
            );
        }
    }
