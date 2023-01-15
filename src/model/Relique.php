<?php

require_once("donnees.php");

    class Relique
    {
        protected $nom;
        protected $pouvoir;
        protected $creation;
        protected $proprietaire;
        protected $liens;
        protected $id;

        /** Construit une relique avec les parametre,*/
        public function __construct($nom, $pouvoir, $creation, $proprietaire, $liens, $id =null)
        {
            $this->nom = $nom;
            $this->pouvoir = $pouvoir;
            $this->creation = $creation;
            $this->proprietaire = $proprietaire;
            $this->liens = $liens;
            $this->id = $id;
        }

        /** fonction d'acces au nom de la relique 
         * @return String le nom de la relique
        */
        public function getNom()
        {
            return $this->nom;
        }

        /** fonction d'acces au pouvoir de la relique 
         * @return String le pouvoir de la relique
        */
        public function getPouvoir()
        {
            return $this->pouvoir;
        }

        /** fonction d'acces au proprietaire de la relique 
         * @return String le nom du proprietaire de la relique
        */
        public function getProprietaire()
        {
            return $this->proprietaire;
        }

        /** fonction d'acces a la datte de creation de la relique 
         * @return int la date de creation de la relique
        */
        public function getCreation()
        {
            return $this->creation;
        }

        /** fonction d'acces au chemin (nom)de la relique 
         * @return String le cemin de la relique
        */
        public function getLiens()
        {
            return $this->liens;
        }

        /**fonction de modification du nom de la relique */
        public function setNom($nom)
        {
            $this->nom = $nom;
        }

        /**fonction de modification du pouvoir de la relique */
        public function setPouvoir($pouvoir)
        {
            $this->pouvoir = $pouvoir;
        }

        /**fonction de modification du proprietaire de la relique */
        public function setProprietaire($proprietaire)
        {
            $this->proprietaire = $proprietaire;
        }

        /**fonction de modification date de creation/ou decouvert de la relique */
        public function setCreation($creation)
        {
            $this->creation = $creation;
        }

        /**fonction de modification du liens de la relique */
        public function setLiens($liens)
        {
            $this->liens = $liens;
        }
    }
