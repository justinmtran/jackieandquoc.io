<?php 
	class Paginator{
		private $_conn; 
		private $_page; 
		private $_total; 
		
		public function __construct($conn){
			$this->conn = $conn; 
		}
		
		private function getData($limit = 10, $page = 1, $query){	
		    $this->_limit   = $limit;
			$this->_page    = $page;
		 
			if ( $this->_limit != 'all' ) {
				$query = $query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . "," . ($this->_limit*$this_page);
			}
			
			$rs = $this->_conn->query( $query );
		 
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
		
		public function createLinks($links, $list_class){
			if ( $this->_limit == 'all' ) {
				return '';
			}
 
			$last       = ceil( $this->_total / $this->_limit );

			$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
			$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

			$html       = '<ul class="' . $list_class . '">';

			$class      = ( $this->_page == 1 ) ? "disabled" : "";
			$html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

			if ( $start > 1 ) {
				$html   .= '<li><a href="?limit=' . $this->_limit . '&page=1">1</a></li>';
				$html   .= '<li class="disabled"><span>...</span></li>';
			}

			for ( $i = $start ; $i <= $end; $i++ ) {
				$class  = ( $this->_page == $i ) ? "active" : "";
				$html   .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
			}

			if ( $end < $last ) {
				$html   .= '<li class="disabled"><span>...</span></li>';
				$html   .= '<li><a href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
			}

			$class      = ( $this->_page == $last ) ? "disabled" : "";
			$html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';

			$html       .= '</ul>';

			return $html;
		}

	}
?>