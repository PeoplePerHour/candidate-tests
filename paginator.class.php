<?php
 /*
 * Paginator Class
 * This class is used for setting paginated queries
 * with PHP Data Objects (PDO)
 */
class Paginator {
 
    private $query;

    
    public function __construct($query) {
    	$this->query = $query;
	}

	/*
     * Function for binding values with the prepared statment 
     * @param string the limit number of items per page
     * @param string the current page
     */
	public function paginatedQuery($listLimit = 10, $page = 1){
		$this->query->bindValue(':min',(( $page - 1 ) * $listLimit));
		$this->query->bindValue(':max',$listLimit);
		// Returns binded prepared statment for further manipulation
		return $this->query;
	}
 
}

?>