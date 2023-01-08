<?php
// Copyright 2022 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


// TODO:
// Maybe too many responsibilities for one single class:
//   - Maybe reduce protected functions to a 'core'-class?
//   - Store authenthification data separately
//   - Separate the singleton functions

class Database {
    const DEFAULT_SERVER = "localhost";
    const DEFAULT_DATABASE = "programming_survey_db";
    const DEFAULT_USERNAME = "root";
    const DEFAULT_PASSWORD = "";

    const TESTING_SERVER = "localhost";
    const TESTING_DATABASE = "testing_db";
    const TESTING_USERNAME = "root";
    const TESTING_PASSWORD = "";

    protected static $instance;
    protected static $testing_instance;
    public $connection;
    public static $running = false;

    static function get_instance() {
        
        // If there is already an instance of this class, return it
        if (isset(self::$instance) && self::instance != null)
            return self::$instance;

        // Else call the constructor with the default login information..
        $db =  new Database(
            Database::DEFAULT_SERVER, Database::DEFAULT_DATABASE,
            Database::DEFAULT_USERNAME, Database::DEFAULT_PASSWORD);

        // .. and return that
        return $db;
    }

    static function get_testing_instance() {
        
        // If there is already a testing instance of this class, return it
        if (isset(self::$testing_instance) && self::testing_instance != null)
            return self::$testing_instance;

        // Else call the constructor with the testing login information..
        $db =  new Database(
            Database::TESTING_SERVER, Database::TESTING_DATABASE,
            Database::TESTING_USERNAME, Database::TESTING_PASSWORD, true);

        // .. and return that
        return $db;
    }

    function __construct($servername, $db_name, $username, $password, $testing = false) {
        // Renew the 'instance' attribute for the singleton usage of this class
        if ($testing) {
            $this::$testing_instance = $this;
        } else {
            $this::$instance = $this;
        }

        // Connect to the database
        $this->connection = Database::get_new_connection(
            $servername, $db_name, $username, $password);
            
        // If this executed so far, it must be running I guess
        $this::$running = true;
    }

    private function get_new_connection($servername, $db_name, $username, $password) {
        // Connect to a database, should only be called in the constructor

        try {
            // Try to connect to the database
            $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
            
            // Show errors
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOExeption $e) {

            // Print error on failure
            echo "[DBError] Could not connect to database: ".$e->getMessage()."<br>";
        }

        // Return the connection
        return $conn;
    }

    protected function execute_or_print_message($cmd, $msg) {

        // Try to execute the command $cmd
        try {

            // First prepare to make sql injection a little harder
            $stmt = $this->connection->prepare($cmd);

            // Then execute
            $stmt->execute();

        } catch (PDOException $e) {

            // Print a nice error message on failure and return false
            echo "[DBError] ".$msg.": ".$e->getMessage()."<br>";

            // echo $e."<br>";

            return false;

        }

        // return true if the execution was successful
        return true;
    }

    function disconnect() {
        $this->connection = null;
        $this->instance = null;
        $this->testing_instance = null;
        $this->running = false;
    }

    function execute($cmd) {
        // Provides a standardized way to execute any query
        
        // Default error message
        $msg = "Could not execute query: ";

        // Execute with execute_or_print_message
        $result = $this->execute_or_print_message($cmd, $msg);
        
        // Return the result
        return $result;
    }

    function delete_table($table) {
        
        // Command to execute
        $cmd = "DROP TABLE IF EXISTS ".$table;

        // Message if command fails (followed by the more specific error message)
        $msg = "Could not delete table";

        // Execute
        $result = $this->execute_or_print_message($cmd, $msg);

        // Return the result
        return $result;
    }

    function insert($table, $elements, $values) {

        // Fill parameters into command string
        $cmd = 'INSERT INTO '.$table.'('.$elements.') VALUES('.$values.');';

        // Execute it
        $result = $this->execute_or_print_message($cmd, "Insertion failed");
        
        // Return the result
        return $result;
    }

    function is_in_table($table, $attr_name, $value) {

        // Prepare SELECT statement
        $cmd = "SELECT * FROM ".$table." WHERE ".$attr_name." = '".$value."';";
        $stmt = $this->connection->prepare($cmd);
        
        // Execute it
        $stmt->execute();

        // When it returns one or more rows, it was found
        $found = $stmt->rowCount() == 1;

        // Return the result
        return $found;
    }

    function get_elements($table, $col) {
        // Prepare SELECT statement
        $cmd = "SELECT ".$col." FROM ".$table.";";
        $stmt = $this->connection->prepare($cmd);
        
        // Execute it
        $stmt->execute();

        // Fetch the rows
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Return the rows
        return $rows;
    }

    function get_elements_where($table, $col, $condition) {
        // Prepare SELECT statement
        $cmd = "SELECT ".$col." FROM ".$table."WHERE ".$condition.";";
        $stmt = $this->connection->prepare($cmd);
        
        // Execute it
        $stmt->execute();

        // Fetch the rows
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Return the rows
        return $rows;
    }
}

?>