<?php

if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}

        connect();
	/**
	 * Connect to MySQL database, as defined in Settings.php
	 */
	function connect(){
		global $connection;
		require_once('./Settings.php');
		$connection = mysqli_connect('p:'.host, dbUser, dbPass, dbName);		
	}

	/**
	 * Disconnects from MySQL database.
	 */
	function disconnect(){
		global $connection;
		mysqli_close($connection);
	}

	/**
	 * Creates a new user in the database.
	 *
	 * @param $userName Name of new user to create.
	 * @param $password Password of new user.
	 *
	 * @return True if successful, otherwise false.
	 */
	function createUser($userName, $password){
		$procedure_name = 'insert_user';
		$args = array($userName, $password);
		$result = executeFunction($procedure_name, $args);
		return $result;
	}

	//TODO: add createUser to admin index page
	//TODO: permission level setting for user in db

	/**
	 * Checks if username and password are valid.
	 *
	 * @param $userName Name of user to login.
	 * @param $password Password of user to login.
	 *
	 * @return True if successful, otherwise false. //TODO: return level after implementation
	 */
	function login($userName, $password){
		$procedure_name = 'user_get_password_valid_by_name';
		$args = array($userName, $password);
		$result = executeFunction($procedure_name, $args);
		return $result;
	}

	/**
	 * Executes a stored function defined in the MySQL database.
	 *
	 * @param $procedure_name Name of the procedure to run.
	 * @param $arr Array of arguments, or single argument, to pass in. Null if no args required.
	 *
	 * @return Result of executed function.
	 */
	function executeFunction($procedure_name, $arr){
		
		$init = "select $procedure_name(";
		$result = buildAndRunQuery($init, $arr);

		if ($result === FALSE) {
			echo "Func Failed<br />";
			return array(false);
		}

		$row = mysqli_fetch_array($result);
		mysqli_free_result($result);
		return $row[0];
		
	}

	/**
	 * Method for building a stored function/procedure statement 
	 * given the name, initializing string, and array of arguments.
	 * May be phased out if no stored procedures are introduced.
	 *
	 * @param $init Start of SQL statement to execute. 
	 * eg. "select $procedure_name(" for a function, "call $procedure_name" for a procedure.
	 * @param $arr Array of arguments, or single argument, to pass in. Null if no args required.
	 *
	 * @return Result of query. False if connection was refused.
	 */
	function buildAndRunQuery($init, $arr){

		global $connection;
		if ($connection === FALSE || $connection === NULL){
			echo 'Connection refused<br />';
			return FALSE;
		}

		if (is_array($arr)){
			$arrSize = count($arr);
			if ($arrSize > 0){
				foreach ($arr as $value) {
					if ($value != null){
						$init .= getEscapedSQLParam($value) . ', ';
					}
				}
				$init = substr($init, 0, -2);
			}
		}else if ($arr != null){
			$init .= getEscapedSQLParam($arr);
		}

		$init .= ");";
		//echo $init;
		$result = mysqli_query($connection, $init);
		return $result;
	}

	/**
	 * Escape a parameter to be entered into a MySQL function.
	 *
	 * @param $param Parameter to escape.
	 *
	 * @return Escaped parameter.
	 */
	function getEscapedSQLParam($param){
		global $connection;
		if (gettype($param) === "string"){
			$escaped = mysqli_real_escape_string($connection, $param);
			return "'" . $escaped . "'";
		}else{
			return $param;
		}
	}

?>