<?PHP

if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');

class Page {
	
	var $number;
	
	public function __construct($number) {
		$this->number  = (int) $number;
	}
	
}

class Paginator extends DB {
    
    var $_id;
	var $_maxRows = 2;	
	var $_jumps = 5;    
    var $_currentPage = 1;
    var $_sql;
    var $_rows;
    var $_pages;
    var $_page;
	var $_hiddens;
	var $_acceptDuplicateKeys = false;
   
    public function __construct() {        
        $this->_id = Paginator::getNewId();
        $this->_page = (int) $_REQUEST["page"] + empty($_REQUEST["page"]);
		$this->_hiddens = array();
    }

	function addHidden($name, $value) {
		if ($this->_acceptDuplicateKeys) {
			$this->_hiddens[] = array("name" => $name, "value" => $value);
		} else {
			$this->_hiddens[$name] = array("name" => $name, "value" => $value);
		}
	}

	function setAcceptDuplicateKeys($acceptDuplicateKeys = true) {
		$this->_acceptDuplicateKeys = $acceptDuplicateKeys == true;
	}
    
    function getNewId() {
		static $count;
		return ++$count;
	}
    
	function setMaxRows($maxRows) {
	    $this->_maxRows = (int) $maxRows;
	}
	
    function process($sql) {
    	$this->_sql = $sql;		
		$this->_process();
		$this->_refreshSQL();
	}
	
	function _process() {
		$DB 	= new DB();
		$this->_rows = $DB->num_rows($this->_sql);	
		$this->_pages = Paginator::rows2Pages($this->_rows, $this->_maxRows);
	    if ($this->_page > $this->_pages) {
			$this->_page = $this->_pages;
		}				
	}
	
	function rows2Pages ($rows, $maxRows) {
       return ((int) ($rows / $maxRows)) + (1 && $rows % $maxRows);
    }
	
    function pageRange() {        
        $pages = array();
        
        if ($this->_pages >= 1) {
            if ($this->_page > (int)($this->_jumps/2)) {
                $init = $this->_page - (int)($this->_jumps/2);
            } else {
                $init = 1;
            }
        }
			
        for ($i = $init; $i <= $init + $this->_jumps - 1 && $i <= $this->_pages; $i++) {					
               $pages[] = new Page($i);
        }
        		
        return $pages;
    }
	
	function isDisplay() {
		return $this->isPrevPage()||$this->isNextPage();
	}

	function isPrevPage() {
		if ($this->_page > 1) {
			return true;
		} else {
			return false;
		}
	}

	function isNextPage() {
		if ($this->_page < $this->_pages) {
			return true;
		} else {
			return false;
		}
	}

	function getPage($required) {
		if ($required == 'PREV') {
			$numberPage = $this->_page - 1;
		} elseif ($required == 'NEXT') {
			$numberPage = $this->_page + 1;
		} elseif ($required == 'FIRST') {
			$numberPage = 1;		
		} else {
			$numberPage = $this->_pages;
		}
		return $numberPage;
	}

    
    function _refreshSQL() {
    	if ( !preg_match("/LIMIT/i", $this->_sql) ) {
			$init = ($this->_page - 1) * $this->_maxRows;			
			$this->_sql = "$this->_sql LIMIT $this->_maxRows OFFSET ". abs($init);			
		}
        
		$end = $init++ + $this->_maxRows;
		if ($end > $this->_rows) {
			$end = $this->_rows;
		}				
	}

	function getLength() {
		$lenght = count($this->pageRange());
		return $lenght;
	}
	
	/* 
	<nav>
        <ul class="pagination justify-content-center">
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item active">
            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
          </li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#">Next</a>
          </li>
        </ul>
      </nav>
	*/
	public function displayPages(){
		foreach ($this->_hiddens as $hidden){
			$input_hidden.= "<input type=\"hidden\" name=\"$hidden[name]\" value=\"$hidden[value]\">";
		}
		$elements = $this->pageRange();




		$pages = "<nav><ul class=\"pagination justify-content-center\">";

		if ($this->_pages > 1) {
			if($this->isPrevPage()){
				$prev 	= $this->getPage('PREV');
				$pages .= "<li class=\"page-item\"><a href=\"javascript:goPage($prev);\" class=\"prev page-link\"><<</a></li>";
			}
        	foreach($elements as $page) { 
        		if($this->_page == $page->number){
        			$class = "active";
        		}else{
        			$class = "";
        		}
        		$pages.= "<li class=\"page-item ".$class."\"><a  class=\" page-link \" href=\"javascript:goPage($page->number);\"> ".$page->number;
        		
        		$pages.= " </a></li>";
			}
			if($this->isNextPage()){
				$next 	= $this->getPage('NEXT');
				$pages .= "<li class=\"page-item\"><a href=\"javascript:goPage($next);\" class=\"next page-link\">>></a></li>";
			}
		}
		$pages.= "</ul></nav>";
		$html.=  "<form name=\"paginator\" id=\"paginator\" method=\"POST\"><input type=\"hidden\" name=\"page\" id=\"page\">".$input_hidden."</form>".$pages."";
	return $html;					
	}
}
?>