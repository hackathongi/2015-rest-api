<?php

	class egapiConn {

		private $conn;


		function __construct() {
	       // Create connection
	       $servername = "localhost";
			$username = "u_hackajobs";
			$password = "root";
			$dbname = "Hackajobs";

			$this->conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($this->conn->connect_error) {
			    die("Connection failed: " . $this->conn->connect_error);
			}
	   	}

	   	public function iniApp(){
			$sql = "SELECT * FROM FAMILIES";
			$result = $this->conn->query($sql);
			$sortida = array();
			$sortida['families'] = array();

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			    	$row['nom'] = utf8_encode($row['nom']);
			       	$sortida['families'][] = $row;
			    }
			}

			$sql = "SELECT * FROM ESPECIALITATS";
			$result = $this->conn->query($sql);
			$sortida['especialitats'] = array();

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			    	$row['nom'] = utf8_encode($row['nom']);
			    	$row['descripcio'] = utf8_encode($row['descripcio']);
			       	$sortida['especialitats'][] = $row;
			    }
			}

			$sql = "SELECT * FROM PRODUCTORS";
			$result = $this->conn->query($sql);
			$sortida['productors'] = array();

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			    	$row['nom'] = utf8_encode($row['nom']);
			       	$sortida['productors'][] = $row;
			    }
			}

			$sql = "SELECT * FROM PUNTSDEVENDA";
			$result = $this->conn->query($sql);
			$sortida['puntsdevenda'] = array();

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			    	$row['nom'] = utf8_encode($row['nom']);
			    	$row['direccio'] = utf8_encode($row['direccio']);
			       	$sortida['puntsdevenda'][] = $row;
			    }
			    
			}
			echo json_encode($sortida);
			
		}

		public function getFamilies(){
			$sql = "SELECT * FROM FAMILIES";
			$result = $this->conn->query($sql);
			$sortida = array();

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			    	$row['nom'] = utf8_encode($row['nom']);
			       	$sortida[] = $row;
			    }
			    echo json_encode($sortida);
			} else {
			    return false;
			}
		}

		public function getEspecialitats($id_familia){
			$sql = "SELECT * FROM ESPECIALITATS WHERE id_familia='".$id_familia."'";
			$result = $this->conn->query($sql);
			$sortida = array();

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			    	$row['nom'] = utf8_encode($row['nom']);
			    	$row['descripcio'] = utf8_encode($row['descripcio']);
			       	$sortida[] = $row;
			    }
			    echo json_encode($sortida);
			} else {
			    return false;
			}
		}

		public function getProductors($id_especialitat){
			$sql = "SELECT * FROM PRODUCTORS WHERE id_especialitat='".$id_especialitat."'";
			$result = $this->conn->query($sql);
			$sortida = array();

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			    	$row['nom'] = utf8_encode($row['nom']);
			       	$sortida[] = $row;
			    }
			    echo json_encode($sortida);
			} else {
			    return false;
			}
		}

		public function getPuntsdevendaProductor($id_productor){
			$sql = "SELECT * FROM PUNTSDEVENDA WHERE id_productor='".$id_productor."'";
			$result = $this->conn->query($sql);
			$sortida = array();

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$row['nom'] = utf8_encode($row['nom']);
					$row['direccio'] = utf8_encode($row['direccio']);
					$sortida[] = $row;
				}
				echo json_encode($sortida);
			} else {
				return false;
			}
		}

		public function getPuntsdevendaEspecialitat($id_especialitat){
			$sql = "SELECT pv.* FROM PUNTSDEVENDA pv, PRODUCTORS p, ESPECIALITATS e WHERE e.id = '".$id_especialitat."' AND p.id = pv.id_productor AND p.id_especialitat = e.id";
			$result = $this->conn->query($sql);
			$sortida = array();

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$row['nom'] = utf8_encode($row['nom']);
					$row['direccio'] = utf8_encode($row['direccio']);
					$sortida[] = $row;
				}
				echo json_encode($sortida);
			} else {
				return false;
			}
		}

		public function __destruct() {
			$this->conn->close();
	    }
		

	}

?>