<?php
include_once __DIR__ . '/database.php';
$input = trim(($_POST['input'] ?? null));

class SearchResults extends Database{
    private string $tbl_name = "tbl_rentinfo";
    public function __construct() {
    parent::__construct();
    }
    public function search_query($input){
        $query = "SELECT * FROM `tbl_rentinfo` WHERE id = :input OR blocknumber = :input OR lotnumber = :input";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'input' => $input
            ]);
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $row_num = count($results);
        try{
        if ($row_num > 0){?>
        <table>
            <thead>
            <tr>
                <th>House ID</th>
                <th>Block Number</th>
                <th>Lot Number</th> 
                <th>Status</th>
                <th>Rent</th>
                <th>Down Payment</th>
            </thead>

            </tr>
            <tbody>
            <?php foreach ($results as $search_row): ?>
                
                        
                                <tr>
                                <td><?= $search_row->id ?></td>
                                <td><?= $search_row->blocknumber ?></td>
                                <td><?= $search_row->lotnumber ?></td>
                                <td><?= $search_row->house_status ?></td>
                                <td><?= $search_row->rentprice ?></td>
                                <td><?= $search_row->downpayment ?></td>
                                <td><button> Inquire </button>
                                <button> Contact Seller </button>
                                <button> Bookmark </button>
                                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>


<?php 
        }else{
            echo "<div class='no-results-card'>";
            echo "<div class='no-results-icon' aria-hidden='true'>🔎</div>";
            echo "<h3>No results found</h3>";
            echo "<p>Try searching by another block number, lot number, or house ID.</p>";
            echo "</div>";
    }
    }catch(Exception $e){
        if ($e->errorInfo[1] == 1064) {
            echo "<div class='no-results-card'>";
            echo "<div class='no-results-icon' aria-hidden='true'>🔎</div>";
            echo "<h3>No results found</h3>";
            echo "<p>Try searching by another block number, lot number, or house ID.</p>";
            echo "</div>";
        }
        else{
            die("Insert Error: " . $e->getMessage());
        }
        

    }
    }
}



$search = new SearchResults;
$search->search_query($input)

?>
