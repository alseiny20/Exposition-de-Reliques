<?php

    class Router
    {
        /** construction d'un Routeur */
        public function __construct()
        {
        }
        /** fonction principale du routeur
         * cette fonction analyse les url et choisie les action a effectue
         *
         * @param ReliqueStorage $reliqueStorage est une base de données
        */
        public function main(ReliqueStorage $reliqueStorage)
        {
            session_start();
            if (array_key_exists("feedback", $_SESSION)) {
                $feed =$_SESSION["feedback"];
                $view =new View($this, $feed);
                $_SESSION['feedback']="";
            } else {
                $view =new View($this, '');
            }
            /* Analyse de l'URL */

            $controller = new Controller($view, $reliqueStorage);
            $reliqueId = key_exists('relique', $_GET) ? $_GET['relique'] : null;
            $action = key_exists('action', $_GET) ? $_GET['action'] : null;

            if ($action === null) {
                /* Pas d'action demandée : par défaut on affiche
                   * la page d'accueil, sauf si une relique est demandée,
                   * auquel cas on affiche sa page. */
                $action = ($reliqueId === null) ? "accueil" : "voir";
            }
            try {
                switch ($action) {
                case "voir":
                    if ($reliqueId === null) {
                        $view->makeUnknownActionPage();
                    } else {
                        $controller->showRelique($reliqueId);
                    }
                    break;
                case "accueil":
                    $view->makeHomePage();
                    break;
                case "liste":
                    $controller->showList();
                    break;
                case "apropos":
                    $view->showPropos();
                    break;
                case "nouveau":
                    $controller->newRelique();
                    break;
                case "saveNouveau":
                    $controller->saveNewRelique($_POST, $_FILES);
                    break;
                case "confirmesupprimer":
                    if ($reliqueId === null) {
                        $view->makeUnknownActionPage();
                    } else {
                        $controller->askReliqueDeletion($reliqueId);
                    }
                    break;
                case "supprimer":
                    $controller->deleteRelique($reliqueId);
                    break;
                case "modifier":
                    if ($reliqueId === null) {
                        $view->makeUnknownActionPage();
                    } else {
                        $controller->modifyrelique($reliqueId);
                    }
                    break;
                case "sauverModifs":
                    if ($reliqueId === null) {
                        $view->makeUnknownActionPage();
                    } else {
                        $controller->saveReliqueModifications($reliqueId, $_POST, $_FILES);
                    }
                    break;
                default:
                    /* L'internaute a demandé une action non prévue. */
                    $view->makeUnknownActionPage();
                    break;
                }
            } catch (Exception $e) {
                /* Si on arrive ici, il s'est passé quelque chose d'imprévu
                * (par exemple un problème de base de données) */
                $view->makeUnexpectedErrorPage($e);
            }
            //affichage de la page
            $view->render();
        }

        // URL de la page de creation d'une relique
        public function getReliqueCrationURL()
        {
            return ".?action=nouveau";
        }
        // URL de sauvegarde d'une nouvelle relique
        public function getReliqueSaveURL()
        {
            return "?action=saveNouveau";
        }
        /**
         * URL de la page de la relique d'dentifiant $id
         * @param mixed $id identifiant du relique
         *  */
        public function getReliqueURL($id)
        {
            return "?relique=$id";
        }

        /** URL de la page demandant la confirmation
        * de la suppression d'une remoqie
        *
        * @param mixed $id identifiant de la relique
        */
        public function getReliqueAskDeletionURL($id)
        {
            return ".?relique=$id&amp;action=confirmesupprimer";
        }

        /** URL de suppression effective d'une relique
        * (champ 'action' du formulaire)
        * @param mixed $id identifiant de la relique
        */
        public function getReliqueDeletionURL($id)
        {
            return ".?relique=$id&amp;action=supprimer";
        }

        /** URL de la page d'édition d'une relique existante
         * @param mixed $id identifiant de la relique
        */
        public function getreliqueModifURL($id)
        {
            return ".?relique=$id&amp;action=modifier";
        }

        /**
         * URL d'enregistrement des modifications sur une
         * couleur (champ 'action' du formulaire)
         * @param mixed $id identifiant de la relique
         */
        public function updateModifiedRelique($id)
        {
            return ".?relique=$id&amp;action=sauverModifs";
        }

        /* URL de la page d'accueil */
        public function getAccueilURL()
        {
            return "?action=accueil";
        }
        /* URL de la page avec toutes les reliques */
        public function getGaleryURL()
        {
            return "?action=liste";
        }

        /** Fonction pour le POST-redirect-GET,
        * destinée à prendre des URL du routeur
        * (dont il faut décoder les entités HTML)
        *
        *@param String $feedback le message de notification
        *@param mixed $url liens de redirection
        */
        public function POSTredirect($url, $feedback)
        {
            $_SESSION['feedback']=$feedback;
            header("Location: " . htmlspecialchars_decode($url), true, 303);
            exit();
        }

        /* URL de la page apropos */
        public function getAproposURL()
        {
            return "?action=apropos";
        }
    }
