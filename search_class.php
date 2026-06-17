<?php
include_once __DIR__ . '/database.php';
$input = trim(($_POST['input'] ?? null));

class SearchResults extends Database{
    private $query_config;
    public function __construct() {
    
    parent::__construct();
    $this->query_config = require __DIR__ . '/query_config.php';
    }
    public function search_query($input){
    $query = "SELECT * FROM `{$this->query_config['tables']['central']}` WHERE id = :input OR blocknumber = :input OR lotnumber = :input";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([
        'input' => $input
    ]);
    
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
    $row_num = count($results);
    
    try {
        if ($row_num > 0) { ?>
            <head>
                <link rel="stylesheet" href="css/index.css">
            </head> 
            <div class="sale-dashboard" id="sale-dashboard">
                <div class="dashboard-container">
                    <table>
                        <thead>
                            <tr>
                                <th>House ID</th>
                                <th>Block Number</th>
                                <th>Lot Number</th> 
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $search_row): ?>
                            <tr>
                                <td><?= htmlspecialchars($search_row->id) ?></td>
                                <td><?= htmlspecialchars($search_row->blocknumber) ?></td>
                                <td><?= htmlspecialchars($search_row->lotnumber) ?></td>
                                <td><?= htmlspecialchars($search_row->house_status) ?></td>
                                <td class="action-cell">
                                    <button type="button" class="action-btn inquire-btn">Inquire</button>
                                    <button type="button" class="action-btn contact-btn">Contact Seller</button>
                                    
                                    <label class="action-btn bookmark-btn">
                                        <input type="checkbox" class="bookmark-checkbox" data-id="<?php echo $search_row->id; ?>">
                                        <span class="btn-icon" aria-hidden="true">♥</span>
                                        <span class="btn-text">Bookmark</span>
                                    </label>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php 
        } else {
            // Displays your custom card when a search yields zero matches
            echo "<div class='no-results-card'>";
            echo "<div class='no-results-icon' aria-hidden='true'>🔎</div>";
            echo "<h3>No results found</h3>";
            echo "<p>Try searching by another block number, lot number, or house ID.</p>";
            echo "</div>";
        }
    } catch(PDOException $e) { 
        // Handles SQL Error 1064 safely, or kills the script for other major DB failures
        if (isset($e->errorInfo) && $e->errorInfo[1] == 1064) {
            echo "<div class='no-results-card'>";
            echo "<div class='no-results-icon' aria-hidden='true'>🔎</div>";
            echo "<h3>No results found</h3>";
            echo "<p>Try searching by another block number, lot number, or house ID.</p>";
            echo "</div>";
        } else {
            die("Insert Error: " . $e->getMessage());
        }
    }
}
}



$search = new SearchResults;
$search->search_query($input)

?>
