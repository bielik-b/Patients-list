<?php

namespace Model;

    class Doctor{
        private $id;
        private $name;
        private $specialization;
        private $expirience;

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            return $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @return mixed
         */
        public function getSpecialization()
        {
            return $this->specialization;
        }


        /**
         * @return mixed
         */
        public function getExpirience()
        {
            return $this->expirience;
        }

        /**
         * @param mixed $name
         */
        public function setName($name)
        {
            return $this->name = $name;
        }

        /**
         * @param mixed $specialization
         */
        public function setSpecialization($specialization)
        {
            return $this->specialization = $specialization;
        }

        /**
         * @param mixed $expirience
         */
        public function setExpirience($expirience)
        {
            return $this->expirience = $expirience;
        }
}