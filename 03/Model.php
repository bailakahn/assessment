<?php

	require 'Database.php';

	/**
	* 
	*/
	class Model
	{

		protected $table;
		protected $db;
		
		function __construct(Database $db)
		{

			$this->db = $db;

	        if(is_null($this->table)){

	        	//get the class name
	            $parts = explode('\\', get_class($this));

	            $class = end($parts);

	            //get the table name by erasing the 'Model' string from the class name
	            $this->table = strtolower(str_replace('Model', '', $class) . 's');

	        }


		}

		/**
	     * @param $statement string the query to execute
	     * @param null $attributes the value in case of a prepared query
	     * @param bool $one
	     * @return mixed
	     */
	    public  function query($statement, $attributes = null, $one = false){

	    	//if there are attributes, call a prepared method
	        if ($attributes){

	           return $this->db->prepare(

	               $statement,
	               $attributes,
	               $one

	           );

	        }else{
	            return $this->db->query(
	                $statement,
	                $one
	            );
	        }
	    }


		/**
	     * get all the records from a table
	     * @return mixed
	     */
		public function all(){

			return  $this->query(
            
            	"SELECT * FROM " . $this->table
        	
        	);

		}

		/**
	     * create a record in a table
	     * @param $fields
	     * @return mixed
	     */
	    public function create($fields){

	        $sql_parts = [];

	        $attributes = [];

	        /*
				this allows to insert data like as shown in the 'test.php' file

				$user->create(
					[
						'first_name' => $_POST['firstname'],
						'last_name' => $_POST['lastname'],
						.
						.
						...
					]
				);

	        */
	        foreach ($fields as $k => $v){

	            $sql_parts[] = "$k = ?";

	            $attributes[] = $v;

	        }

	        //implode the table to get a string like 'first_name = ?, last_name = ?, ...'
	        $sql_part = implode(', ', $sql_parts);

	        return $this->query("INSERT INTO {$this->table} SET  $sql_part
	        ", $attributes, true);
	    }

	    /**
	     * @param $id string the id of the entry to update
	     * @param $fields array the fields to update
	     * @return mixed
	     */
	    public function update($id, $fields){

	        $sql_parts = [];

	        $attributes = [];

	        /*
				this allows to insert data like as shown in the 'test.php' file

				$user->update(1,
					[
						'first_name' => $_POST['firstname'],
						'last_name' => $_POST['lastname'],
						.
						.
						...
					]
				);

	        */
	        foreach ($fields as $k => $v){
	            $sql_parts[] = "$k = ?";
	            $attributes[] = $v;
	        }

	        //add the id to the attributes array
	        $attributes[] = $id;

	        //implode the table to get a string like 'first_name = ?, last_name = ?, ...'
	        $sql_part = implode(', ', $sql_parts);

	        //this query assume that the table id column follows the pattern '{tablename_id}'
	        //without the 's' at the end of the tablename
	        return $this->query(
	        	"UPDATE  {$this->table} SET  $sql_part
		         WHERE " . rtrim($this->table, 's') . "_id = ?
		        ", $attributes, true);
	    }

	    /**
	     * @param $id string the id of the entry to delete
	     * @return mixed
	     */
	    public function delete($id){

	        //this query assume that the table id column follows the pattern '{tablename_id}'
	        //without the 's' at the end of the tablename
	        return $this->query("DELETE FROM  {$this->table}
	        WHERE " . rtrim($this->table, 's') . "_id = ?
	        ", [$id], true);
	    }
	}

?>