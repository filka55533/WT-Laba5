<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>2 вариант</title>
    <style>
       
        p.header{
            font-size: 200%;
            font-weight: 700;
            margin-top: 10px;
        }
        th { white-space:pre }

    </style>
</head>

<body>
    <p class="header">Datebases</p>
    
    <form method="post">
    <select name="databaseName">
    
    <?php
        
        function showTableRows($tableName, $mysqli){
    
            $tableHeader = $mysqli->query("SHOW COLUMNS FROM ".$tableName);
                
            echo "<table border=\"1\">";
            echo "<tr>";
    
            $orderSort = ""; 
            
            while ($row = $tableHeader->fetch_array(MYSQLI_NUM)){             
                
                $res = "<th>".$row[0]."\n".$row[1];
                
              
                echo $res."</th>";
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
        $mysqli->set_charset('UTF8');

        $dateBasesNames = $mysqli->query("SHOW DATABASES");

        
        if ($mysqli->connect_errno)
            return ;

      
        while ($baseName = $dateBasesNames->fetch_array(MYSQLI_NUM))
            echo "<option value=".$baseName[0].">".$baseName[0]."</option>";

        
    ?>

    </select>
    <input type="submit" value="Process">
    </form>

    <?php
        if (reset($_POST) !== false){
                    
            if ($mysqli->query("USE ".$_POST["databaseName"])){

                $tables = $mysqli->query("SHOW TABLES");
                
                if (!$tables) return;

                
                while ($tablesItems = $tables->fetch_array()){
                    echo "<p class='tablename'>".$tablesItems[0]."</p>";
                    showTableRows($tablesItems[0], $mysqli);
                }
            }

        }

        $mysqli->close();
    ?>
</body>


</html>