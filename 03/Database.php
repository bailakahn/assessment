<?php

	/**
	* A simple class to connect to the database and define MySQL queries
	*/

	class Database
	{
		private $pdo;

		/**
         * connect to the database
         * @return PDO
         */
        public function getPDO(){

            if ($this->pdo === null){

                $pdo = new PDO('mysql:dbname=klf;host=localhost', 'root', '');

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $this->pdo = $pdo;
            
            }

            return $this->pdo;
            
        }

        /**
         * @param $statement string the SQL statement
         * @param $one bool allow to return one or many elements
         * @return array|mixed|\PDOStatement
         */
        public function query($statement, $one = false){

            $req = $this->getPDO()->query($statement);

            //if its an INSERT, UPDATE or DELETE there no data to fetch so we just execute the query
            if (strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0){

                return $req;

            }else{

	            $req->setFetchMode(PDO::FETCH_OBJ);
	            
	            if ($one){

	                $data = $req->fetch();

	            }else{

	                $data = $req->fetchAll();
	                
	            }
	            return $data;
	        }

        }


        /**
         * @param $statement string prepared SQL query
         * @param $attributes array values to fill in the prepared query
         * @param bool $one allow to return one or many elements
         * @return array|bool|mixed
         */
        public function prepare($statement, $attributes, $one = false){

            $req = $this->getPDO()->prepare($statement);
            
            $res = $req->execute($attributes);

            //if its an INSERT, UPDATE or DELETE there no data to fetch so we just execute the query
            if (strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0){

                return $res;

            }else {

                $req->setFetchMode(PDO::FETCH_OBJ);
           
                if ($one) {

                    $data = $req->fetch();

                } else {

                    $data = $req->fetchAll();

                }

                return $data;

            }
        }
	}

?>