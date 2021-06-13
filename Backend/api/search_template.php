<?php

// search form
echo "<form role='search' action='backEnd/api/search.php' class='search-wrapper'>";
    echo "<div class='search-box'>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='search-text' placeholder='Search product ...' name='s' id='srch-term' required {$search_value} />";
            echo "<button class='search-btn' type='submit'><i class='fas fa-search'></i></button>";       
    echo "</div>";
echo "</form>";
?>