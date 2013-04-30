<?php

# for accessing the database the pdo object has been used. for further reference about pdo object please refer to followings
# http://php.net/manual/en/class.pdostatement.php
# http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/

# include database connection class
require_once("database.php");

#database loader object to load database if connection is not established
$loader = null;

#base model that every models has to inherit
class baseModel{
	// private $tableName = null;
	
	public function __construct(){		
		global $loader;								#global key word identifies the variable is global else it is taken as local
		if (!database::isDBHLoaded()){				#if connection has not been established then establish it
			$loader = new database();
		}
		// $this->tableName = get_class($this);
	}

	public function __destruct(){

	}


	public function selectAll($limit=-1, $orderBy=-1, $orderType="ASC"){ # returns the array of all the item in the table
		$tableName = $this->getTableName();
		$ls = $this->getLimitString($limit);
		$os = $this->getOrderString($orderBy, $orderType);

		$sql = "SELECT * FROM $tableName $os $ls";
		
		return $this->executeSQL($sql);
	}

	public function selectUnique($filter){						# returns single object(object not array!!!) out of the filter string
		$tempArray = $this->filter($filter, 1);
		return ($tempArray)?$tempArray[0]:$tempArray;
	}

	public function filter($filter, $limit=-1, $orderBy=-1, $orderType="ASC"){	# returns the array out of the filter
		$tableName = $this->getTableName();
		$fs = $this->getFilterString($filter);
		$ls = $this->getLimitString($limit);
		$os = $this->getOrderString($orderBy, $orderType);

		$sql = "SELECT * FROM $tableName WHERE $fs $os $ls";
		
		return $this->executeSQL($sql);
	}

	public function search($searchArray, $limit=-1, $orderBy=-1, $orderType="ASC"){		#returns the array of object out of the search array
		$tableName = $this->getTableName();
		$ss = $this->getSearchString($searchArray);
		$ls = $this->getLimitString($limit);
		$os = $this->getOrderString($orderBy, $orderType);

		$sql = "SELECT * FROM $tableName WHERE $ss $os $ls";
		
		return $this->executeSQL($sql);
	}

	public function addToDB(){				# adds this object to db no arguments required arguments are assumed to be the variables of the class
		$tableName = $this->getTableName();
		$fields = $this->getFields();
		$fieldArray = preg_split(" ?, ?", $fields);
		$placeHolder = "";
		
		foreach ($fieldArray as $key => $value){
			$placeHolder .= ($placeHolder == "")?"":", ";
			$placeHolder .= ":".trim($value);
		}

		$sql = "INSERT INTO $tableName ($fields) VALUE ($placeHolder)";

		return $this->SQLCRUD($sql, $this);
	}
	public function removeFromDB($filterlist){					# removes the entity that is selected from the filterlist
		$tableName = $this->getTableName();
		$ds = $this->getFilterString($filterlist);

		$query = "DELETE FROM $tableName WHERE $ds";

		return $this->executeSQL($query);

	}
	public function updateDB(){								# updates the entity as according to the id field of this object
		$tableName = $this->getTableName();
		$us = $this->getUpdateString();

		$query = "UPDATE $tableName SET $us WHERE `id` = $this->id ";

		return $this->executeSQL($query);

	}


	private function getFilterString($filter){				# filter string out of the filter array
		global $dbh;
		if (!$filter) return "1";

		$qs = "";
		foreach ($filter as $key => $value) {
			$qs .= ($qs == "")?"":" AND ";
			$value = $dbh->quote($value);
			$qs .= "`$key` = $value";
		}

		return $qs;
	}

	private function getSearchString($search){			# returns the search string out of the search array
		global $dbh;
		if (!$search) return "1";

		$qs = "";
		foreach ($search as $key => $value){
			$qs .= ($qs == "")?"":" OR ";
			$value = $dbh->quote($value);
			$qs .= "`$key` LIKE '%$value%'";
		}

		return $qs;
	}
	private function getUpdateString(){			# for updateDB function
		$ad = (array)$this;

		$qs = "";
		foreach ($ad as $key => $value) {
			$qs .= ($qs=="")?"":", ";
			$qs .= "`$key` = '$value'";
		}

		return $qs;
	}
	private function getLimitString($limit){
		return ($limit == -1)?"":"LIMIT 0, $limit";
	}

	private function getOrderString($orderBy, $orderType){
		return ($orderBy == -1)?"":"ORDER BY `$orderBy` $orderType";
	}

	public function executeSQL($query){				# executes the sql query
		global $dbh;
		$tableName = $this->getTableName();

		$th = $dbh->prepare($query);
		$th->execute();

		$th->setFetchMode(PDO::FETCH_CLASS, "$tableName");
		$output = $th->fetchAll();

		return $output;			
	}

	private function SQLCRUD($query, $data){		# executes the sql query with the placeholder for further reference google 'pdo placeholder'
		global $dbh;
		$tableName = $this->getTableName();

		$th = $dbh->prepare($query);
		$th->execute((array)$this);

		$th->setFetchMode(PDO::FETCH_CLASS, "$tableName");
		$output = $th->fetchAll();

		return $output;
	}

	public function getTableName(){
		return get_class($this)."s";
	}

}

?>