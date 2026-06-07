<?php
include_once __DIR__ . '/database.php';
$input = trim(($_POST['input'] ?? null));

class SearchResults extends Database{
    private string $tbl_name = "tbl_rentinfo";
    public function __construct() {
    parent::__construct();
    }
    public function search_query($input){
        $query = "SELECT * FROM `tbl_rentinfo` WHERE id = '$input' OR blocknumber = '$input' OR lotnumber = '$input'";;
        $show_query = $this->pdo->query($query);
        $results = $show_query->fetchAll(PDO::FETCH_OBJ);
        $row_num = count($results);
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
        echo "<h6 class = 'text-danger text-center mt-3'> No Data Found</h6>";
    }
    }
}



$search = new SearchResults;
$search->search_query($input)

?>
