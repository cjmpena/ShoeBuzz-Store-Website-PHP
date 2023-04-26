<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 14 2023
    Description: The shoeshop file for my final Project.
****************/
$query = "SELECT * FROM shoecategory";
$statement = $db->prepare($query);
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="css/stylesheet/style.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="header-nav">
        <form action="search.php" method="get" class="search-container">
            <select name="shoecategory">
                <option value="">All Categories</option>
                <?php while($category = $statement->fetch()): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endwhile ?>
            </select>
            <input type="text" name="keyword" placeholder="Search for shoes...">
            <input type="submit" id="search-button" value="Search">
        </form>
        </div>
    </nav>
</body>
</html>
