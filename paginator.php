<?php 
	class Paginator{
		private $_conn; 
		private $_page; 
		private $_total; 
		
		public function __construct($conn){
			$this->_conn = $conn; 
		}
		
		private function getData($limit = 10, $page = 1, $query){	
		    $this->_limit   = $limit;
			$this->_page    = $page;
		 
			if ( $this->_limit != 'all' ) {
				$query = $query . " LIMIT " . $this->_limit . " OFFSET " . ( ( $this->_page - 1 ) * $this->_limit );
			}
		
			$rs = $this->_conn->query($query);
		 
			while ( $row = $rs->fetch_assoc() ) {
				$results[]  = $row;
			}
		 
			$result         = new stdClass();
			$result->page   = $this->_page;
			$result->limit  = $this->_limit;
			$result->total  = $this->_total;
			$result->data   = $results;
		 
			return $result;
		}
		
		public function getPendingData($limit, $page){
			$query = "SELECT * FROM PendingForms";	
			return $this->getData($limit, $page, $query); 
		}
		
		public function getApprovedData($limit, $page){
			$query = "SELECT * FROM ApprovedForms"; 
			return $this->getData($limit, $page, $query); 
		}
		
		public function getDeniedData($limit, $page){
			$query = "SELECT * FROM DeniedForms"; 
			return $this->getData($limit, $page, $query); 
		}
	}
?>