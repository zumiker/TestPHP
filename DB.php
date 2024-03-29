<?
	class DB { 
	    private $userlogin;
	    private $server;
		private $dbname; 
	    private $userpas;
	    private $tablename; 

		function getLogin(){
	        return $this -> userlogin;
	    }

	    function getServer(){
	        return $this -> server;
	    }

	    function getTbname(){
	        return $this -> tablename;
	    }

	    function getDbname(){
	        return $this -> dbname;
	    }

	    function getPas(){
	        return $this -> userpas;
	    }

	     function setLogin($log){
	        $this -> userlogin = $log;
	    }

	    function setServer($ser){
	        $this -> server = $ser;
	    }

	    function setDbname($db){
	        $this -> dbname = $db;
	    }

	    function setPas($pas){
	        $this -> userpas = $pas;
	    }

	    function setTbname($table){
	        $this -> tablename = $table;
	    }

	    function connect(){
	    	$mysqli = new mysqli($this -> getServer(),$this -> getLogin(),$this -> getPas(),$this -> getDbname());
			if ($mysqli -> connect_errno){
				printf("Connectfailed: %s\n", $con->connect_error);
				die();
			}
			return $mysqli;
	    }

	    function close($con){
	    	$con -> close();
	    }

	    function __construct(){
	    	$this -> setDbname("php_test");
	    	$this -> setServer("localhost");
	    	$this -> setLogin("root");
	    	$this -> setPas("");
	    	$this -> setTbname("TEST");
	    	$con = $this -> connect();
	    	$sql = "CREATE TABLE  IF NOT EXISTS `".$this -> getTbname()."` (
	  						`id` int(11) NOT NULL AUTO_INCREMENT,
	  						`name` varchar(256) NOT NULL,
	  						PRIMARY KEY (`id`)) 
	    					ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	    	if ($con -> query($sql) === FALSE) {
			    echo "Error creating table: " . $con -> error;
	            die();
			}
	    	$this -> close($con);
	    }

	    function Create($name){
	    	$con = $this -> connect();
	    	$sql = "Insert into ".$this -> getTbname()." (name) values('".$name."') ";
	    	if ($con -> query($sql) === TRUE) 
			    echo "New user has been created\n";
			else 
			    echo "Error creating new user: " . $con -> error;
	    	$this -> close($con);
	    }

	    function Get($id){
	    	$con = $this -> connect();
	        $sql = "select name from ".$this -> getTbname()." where id = '$id'";
	        $result = $con -> query($sql);
	    	if ($result == 1) {
	                $name = $result->fetch_row();
	                if($name[0] != null)
	                    echo "User name = ".$name[0];
	                else
	                    echo "Error getting user";
			} else 
			    echo "Error getting user: " . $con -> error;
	    	$this -> close($con);
	    }
	} 

    header('Content-Type: text/html; charset=utf-8');
    $obj = new DB();
    $obj -> Create("Вадим");
    echo "<br>";
    echo $obj -> Get("1");
    echo "<br>";
    $obj -> Create("Vadim");
    echo "<br>";
    echo $obj -> Get("2");
?>