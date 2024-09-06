<?php

class DiaryModel {

    private $conn;

    public function __construct() {
        // Database connection setup
        $this->conn = new mysqli('localhost', 'root', '', 'aft_site');

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getFilter($tableName, $filterArray, $extraCondition = '') {
        $condition = "";
        $flag = false;

        // Constructing the condition string from the filter array
        foreach ($filterArray as $key => $value) {
            if(strlen($value) > 0){
                if($flag){
                    $condition .= " AND "; 
                } else {
                    $flag = true;
                }
                // Safely escape the value to prevent SQL injection
                $condition .= $key . "='" . $this->conn->real_escape_string($value) . "'";
            }
        }

        // Adding extra condition (like LIMIT or ORDER BY)
        if(!empty($extraCondition)){
            if(!empty($condition) && strpos(trim($extraCondition), 'LIMIT') !== 0 && strpos(trim($extraCondition), 'ORDER BY') !== 0) {
                $condition .= ' AND ';
            }
            $condition .= $extraCondition;
        }

        // Determine whether to include the WHERE clause
        $where = '';
        if(!empty($condition) && !(strpos(trim($condition), 'LIMIT') === 0 || strpos(trim($condition), 'ORDER BY') === 0)) {
            $where = ' WHERE ';
        }

        // Construct the final SQL query
        $sql = "SELECT * FROM {$tableName}{$where}{$condition}";

        // Execute the query and fetch the results
        $query = $this->conn->query($sql);
        $result = null;
        if($query !== false){
            while ($row = $query->fetch_assoc()) {
                $result[] = $row;
            }
        }

        return $result;            
    }

    public function search($tableName, $searchArray, $extraCondition = '') {
        $condition = "";
        $flag = false;

        // Constructing the search condition string
        foreach ($searchArray as $key => $value) {
            if(strlen($value) > 0){
                if($flag){
                    $condition .= " OR "; 
                } else {
                    $flag = true;
                }
                // Safely escape the value to prevent SQL injection
                $condition .= $key . " LIKE '%" . $this->conn->real_escape_string($value) . "%'";
            }
        }

        if(!empty($extraCondition)){
            $condition .= " " . $extraCondition;
        }

        $sql = "SELECT * FROM {$tableName} WHERE {$condition}";

        $query = $this->conn->query($sql);
        $result = null;
        if($query !== false){
            while ($row = $query->fetch_assoc()) {
                $result[] = $row;
            }
        }

        return $result;   
    }

    public function page($pageRecord)
    {
        $page = 1;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            // $_SESSION['filter']['page'] = $page;
        }
        $startPage = ($page - 1) * $pageRecord;
        return $startPage;
    }

    public function pagination($url, $totalRecords, $record_per_page)
    {
        $totalPage = ceil($totalRecords / $record_per_page);
        $queryString = $_SERVER['QUERY_STRING'];
        if(isset($_GET['page'])){
            $pagePosition = strpos($queryString,'&page');
            $queryString = substr($queryString, 0,$pagePosition);
        }

        $url = $url.'?'.$queryString;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 0;
        }
        
        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination pagination-sm my-2 float-right">';
        if($page > 1){
            echo '<li class="page-item"><a href="'.$url.'&page='.($page - 1).'" class="page-link">Previous</a></li>';
        }
        else{
            echo '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
        }

        if($totalPage <= 10){
            for($i = 1; $i <= $totalPage; $i++){
                $active = $page == $i ? 'active' : '';
                echo '<li class="page-item '.$active.'"><a href="'.$url.'&page='.$i.'" class="page-link">'.$i.'</a></li>';
            }
        }
        else{
            if($page < 5){
                for($i = 1; $i <= 5; $i++){
                    $active = $page == $i ? 'active' : '';
                    echo '<li class="page-item '.$active.'"><a href="'.$url.'&page='.$i.'" class="page-link">'.$i.'</a></li>';
                }
                echo '<li class="page-item"><a href="#" class="page-link">...</a></li>';
                echo '<li class="page-item"><a href="'.$url.'&page='.$totalPage.'" class="page-link">'.$totalPage.'</a></li>';
            }
            elseif($page > $totalPage - 4){
                echo '<li class="page-item"><a href="'.$url.'&page=1" class="page-link">1</a></li>';
                echo '<li class="page-item"><a href="#" class="page-link">...</a></li>';
                for($i = $totalPage - 4; $i <= $totalPage; $i++){
                    $active = $page == $i ? 'active' : '';
                    echo '<li class="page-item '.$active.'"><a href="'.$url.'&page='.$i.'" class="page-link">'.$i.'</a></li>';
                }
            }
            elseif($page >= 5){
                $previous = $page - 1;
                $next = $page + 1;
                    echo '<li class="page-item"><a href="'.$url.'&page=1" class="page-link">1</a></li>';
                    echo '<li class="page-item"><a href="#" class="page-link">...</a></li>';
                    echo '<li class="page-item"><a href="'.$url.'&page='.$previous.'" class="page-link">'.$previous.'</a></li>';
                    echo '<li class="page-item active"><a href="'.$url.'&page='.$page.'" class="page-link">'.$page.'</a></li>';
                    echo '<li class="page-item"><a href="'.$url.'&page='.$next.'" class="page-link">'.$next.'</a></li>';
                    echo '<li class="page-item"><a href="#" class="page-link">...</a></li>';
                    echo '<li class="page-item"><a href="'.$url.'&page='.$totalPage.'" class="page-link">'.$totalPage.'</a></li>';
                }
            }
            if($page < $totalPage){
                echo '<li class="page-item"><a href="'.$url.'&page='.($page + 1).'" class="page-link">Next</a></li>';
            }
            else{
                echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
            }
            echo '</ul></nav>';
    }

    public function __destruct() {
        $this->conn->close();
    }
}

?>
