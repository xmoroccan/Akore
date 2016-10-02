<?php 

/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Dinital Production 
 * @version   1.1
 * @link http://www.dinital.com
 * @license http://opensource.org/licenses/MIT  MIT License
 */

namespace Akore\Data;

class Pagination
{

	private $db, $pageId, $count, $limit, $get;

	/**
	 *
	 * @param Mysqli $db Database Connection Object
	 */
	public function __construct(Database\Mysqli $db)
	{
		$this->db = $db;
	}


	/**
	 * @param str  $select   [select col from table]
	 * @param str  $table    [table name]
	 * @param str  $where    [WHERE]
	 * @param integer $limit   
	 * @param str  $by    ORDER BY
	 * @param string  $get   GET['page']
	 * @return bool 
	 */
	public function query($select, $table, $where = '', $limit = 10, $by = 'id DESC', $get = 'page')
	{

		$countAll = $this->db->select('COUNT(*) as cnt', $table, $where . " ORDER BY {$by}");
		$count = $countAll->fetch_assoc();
		$this->limit = $limit;
		$this->get = $get;
		$this->count = $count['cnt'];
		$countAll->close();
		$this->pageId = $start = 0;

		if(isset($_GET[$get])) {
			$this->pageId = (int) $_GET[$get];
			if ($this->pageId === 0) $this->pageId = 1;
			$start = ($this->pageId - 1) * $limit;
		} 

		if ($this->pageId === 0) $this->pageId = 1;

		unset($count, $get, $countall);

		return $this->db->select($select, $table, "{$where} ORDER BY {$by} LIMIT $start, $limit");
	}

	/**
	 * 
	 * @param  string $page_url 
	 * @param  string $cssclass 
	 * @param  string $n        
	 * @param  string $p        
	 * @return string   
	 */
	public function getPagination($page_url, $cssclass = 'pagination', $n = 'Next', $p = 'Previous')
	{
		$adjacents = 3;
		$prev = $this->pageId - 1;							
		$next = $this->pageId + 1;
		$lastPage = ceil($this->count/$this->limit);
		$lpm1 = $lastPage - 1;
		$pagination = '';
		if($lastPage > 1) {	
			$pagination .= '<!--Start Pagination--><ul class="'.$cssclass.'">';
			if ($this->pageId > 1) { 
				$pagination.= '<li><a href="' . $page_url . '?'.$this->get.'='.$prev.'"> '.$p.'</a></li>';
			} else {
				$pagination.= '<li><span class="disabled"> '.$p.'</span></li>';	
			}	
		   		if ($lastPage < 7 + ($adjacents * 2)) {  
		   		  	for ($counter = 1; $counter <= $lastPage; $counter++) {
			   		  	 if ($counter == $this->pageId) {
							$pagination.= '<li><span class="current">'.$counter.'</span></li>';
						} else {
					        $pagination.= '<li><a href="' . $page_url . '?'.$this->get.'='.$counter.'">'.$counter.'</a></li>';
				    	}
				   	}
				} elseif($lastPage > 5 + ($adjacents * 2)) { 
				 if($this->pageId < 1 + ($adjacents * 2)) { 
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) { 
						if ($counter == $this->pageId) {
							$pagination.= '<li><span class="current">'.$counter.'</span></li>';
						} else {
					       $pagination.= '<li><a href="' . $page_url . '?'.$this->get.'='.$counter.'">'.$counter.'</a></li>'; 
						}
			        }
					$pagination.= '<li><a href="javascript:void(0)">...</a></li>';
					$pagination.= '<li><a href="' . $page_url . '?'.$this->get.'='.$lpm1.'">'.$lpm1.'</a></li>';
					$pagination.= '<li><a href="'. $page_url .'?'.$this->get.'='.$lastPage.'">'.$lastPage.'</a></li>';
				} elseif($lastPage - ($adjacents * 2) > $this->pageId && $this->pageId > ($adjacents * 2)) {
				    $pagination.= '<li><a href="'. $page_url . '?'.$this->get.'=1">1</a></li>';
					$pagination.= '<li><a href="'. $page_url .'?'.$this->get.'=2">2</a></li>';
					$pagination.= '<li><a href="javascript:void(0)">...</a></li>';
					for ($counter = $this->pageId - $adjacents; $counter <= $this->pageId + $adjacents; $counter++) { 
						if ($counter == $this->pageId) {
					        $pagination.= '<li><span class="current">'.$counter.'</span></li>';
						} else {
					        $pagination.= '<li><a href="'. $page_url . '?'.$this->get.'='.$counter.'">'.$counter.'</a></li>';
						}
				    }
					$pagination.= '<li><a href="javascript:void(0)">...</a></li>';
					$pagination.= '<li><a href="'. $page_url . '?'.$this->get.'='.$lpm1.'">'.$lpm1.'</a></li>';
					$pagination.= '<li><a href="'. $page_url .'?'.$this->get.'='.$lastPage.'">'.$lastPage.'</a></li>'; 
				} else { 
					$pagination.= '<li><a href="'. $page_url .'?'.$this->get.'=1">1</a></li>';
					$pagination.='<li><a href="'. $page_url .'?'.$this->get.'=2">2</a></li>'; // hna 
					$pagination.= '<li><a href="javascript:void(0)">...</a></li>';
					for ($counter = $lastPage - (2 + ($adjacents * 2)); $counter <= $lastPage; $counter++) { 
						if ($counter == $this->pageId) {
							$pagination.= '<li><span class="current">'.$counter.'</span></li>';
						} else {
							$pagination.= '<li><a href="'. $page_url . '?'.$this->get.'='.$counter.'">'.$counter.'</a></li>';
						}
				    } 
				} 
			}
			if ($this->pageId < $counter - 1) { 
				$pagination.= '<li><a href="'. $page_url . '?'.$this->get.'='.$next.'"> '.$n.'</a></li>';
			} else {
				$pagination.= '<li><span class="disabled"> '.$n.'</span></li>';
			}
			$pagination.= "</ul><!--End Pagination-->";
		}

		unset($counter, $adjacents, $prev, $next, $p, $n, $page_url, $lastPage, $lpm1, $cssclass);
		return $pagination;	
	}

}