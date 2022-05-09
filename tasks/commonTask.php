<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Общее задание</title>
</head>
  
<body>

<?php

    function showTableRows($tableName, $mysqli){
        
        $tableHeader = $mysqli->query("SHOW COLUMNS FROM ".$tableName);
          
        echo "<table border=\"1\">";
        echo "<tr>";

        $orderSort = ""; 
        while ($row = $tableHeader->fetch_array(MYSQLI_NUM)){             
            echo "<th>".$row[0]."</th>";
            $orderSort = $row[0];
        }

        echo "</tr>";


        $result = $mysqli->query("SELECT * FROM ".$tableName." ORDER BY ".$orderSort);
        
        if ($result){
            
            $isHeader = true;
            

            while ($row = $result->fetch_array(MYSQLI_NUM)){
                
                echo "<tr>";
                
                foreach ($row as &$item){
                    echo "<td>".$item."</td>";
                }

                echo "</tr>";
                $isHeader = false;
            }

        }

        echo "</table>";

    }


    $mysqli = new mysqli('localhost', 'root', '57ivan22');
    
    if ($mysqli->connect_errno){
        echo "<p>Error! Incorrect connection";
        return;

    }

    $mysqli->set_charset('UTF8');
    
    if ($mysqli->query("USE yacht_federation")){
        
        $tables = $mysqli->query("SHOW TABLES");
        if (!$tables) return;
        
        
        while ($tablesItems = $tables->fetch_array()){
            echo "<p class='tablename'>".$tablesItems[0]."</p>";
            showTableRows($tablesItems[0], $mysqli);
        }

    }

    $mysqli->close();
?>

</body>

</html>
