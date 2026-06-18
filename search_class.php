<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/database.php';
$input = trim(($_POST['input'] ?? null));

class SearchResults extends Database{
    private $query_config;  
    public function __construct() {
    
    parent::__construct();
    $this->query_config = require __DIR__ . '/query_config.php';
    }
    public function search_query($input, $user_id) { // <-- Parameter changed to $user_id
    
    // 1. The new LEFT JOIN query that does all the heavy lifting
    $query = "
        SELECT 
            central.*, 
            IF(bookmark.registry_id IS NOT NULL, true, false) AS is_saved
        FROM {$this->query_config['tables']['central']} AS central
        LEFT JOIN tbl_bookmark AS bookmark 
            ON central.id = bookmark.registry_id 
            AND bookmark.user_id = :user
        WHERE central.id = :input 
           OR central.blocknumber = :input 
           OR central.lotnumber = :input
    ";

    $stmt = $this->pdo->prepare($query);
    
    // 2. Execute with the search text AND the user ID
    $stmt->execute([
        'input' => $input,
        'user'  => $user_id
    ]);
    
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
    $row_num = count($results);
    
    try {
        if ($row_num > 0) { ?>
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
                                        <input type="checkbox" class="bookmark-checkbox" data-id="<?php echo $search_row->id; ?>" <?= $search_row->is_saved ? 'checked' : '' ?>>
                                        <span class="btn-icon" aria-hidden="true">♥</span>
                                        <span class="btn-text"><?= $search_row->is_saved ? 'Saved' : 'Bookmark' ?></span>
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
if (isset($_SESSION["user_id"])) {
    include_once 'bookmark.php';
    $book = new Bookmark();
    $saved_ids = $book->save_bookmark($_SESSION["user_id"]);
    $search = new SearchResults;
    $search->search_query($input, $_SESSION["user_id"]);
}





?>
