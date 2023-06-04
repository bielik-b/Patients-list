<?php

namespace Model;

    class Doctor {
        private $id;
        private $name;
        private $specialization;
        private $expirience;


        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            return $this->id = $id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getSpecialization()
        {
            return $this->specialization;
        }

        public function getExpirience()
        {
            return $this->expirience;
        }

        public function setName($name)
        {
          return $this->name = $name;
        }

        public function setSpecialization($specialization)
        {
          return $this->specialization = $specialization;
        }

        public function setExpirience($expirience)
        {
          return $this->expirience = $expirience;
        }

}