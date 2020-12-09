
<?php

use MongoDB\Operation\CreateCollection;

require 'vendor/autoload.php'; // include Composer's autoloader
class mongo
{
    public $connection;
    function __construct($url)
    {
        $connection = new MongoDB\Client($url);
        $this->connection = $connection;
    }



    function db_exist($db)
    {
        $ret_val = 0;
        foreach ($this->connection->listDatabaseNames() as $dbname)
        {
            if ($dbname == $db)
            {
                $ret_val = 1;
                break;
            }
        }
        return $ret_val;
    }


    
    function select_db($db)
    {
        if ($this->db_exist($db) == 1)
        {
            $db_ret = $this->connection->selectDatabase($db);
            echo("Database $db is selected"."\n");
            return $db_ret;
        }
        else
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to select"."\n");
        }
    }



    function drop_db($db)
    {
        if ($this->db_exist($db) == 1)
        {
            $this->connection->dropDatabase($db);
            echo("Database \033[01;31m $db is dropped"."\n");
        }
        else
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to drop"."\n");
        }
    }



    function create_db($db)
    {
        if ($this->db_exist($db) == 1)
        {
            throw new Exception("Database \033[01;31m $db \033[0m already exist"."\n");
        }
        else
        {
            $database = $this->connection->{$db};
            return $database;
        }
    }



    function list_dbnames()
    {
        foreach ($this->connection->listDatabaseNames() as $dbname)
        {
            echo($dbname."\n");
        }
    }


    function clone_db($db)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to clone"."\n");
            return;  
        }
        else
        {
            $database = $this->connection->{$db};
            $newdb = $database->withOptions();
            return $newdb;
        }
    }


    function list_collectionnames($db)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to list collections"."\n");
            return;
        }
        $database = $this->connection->{$db};
        foreach ($database->listCollectionNames() as $collectionInfo)
        {
            echo "$collectionInfo"."\n";
        }
    }



    function collection_exist($db,$collection)
    {
        if ($this->db_exist($db) == 0)
        {
            return 0;
        }
        $database = $this->connection->{$db};
        $ret_val = 0;
        foreach ($database->listCollectionNames() as $collectionInfo)
        {
            if ($collectionInfo == $collection)
            {
                $ret_val = 1;
                break;
            }
        }
        return $ret_val;
    }



    function create_collection($db,$collection)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to create collection"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 1)
        {
            throw new Exception("Collection $collection \033[01;31m already exist \033[0m in database $db"."\n");
            return;
        }
        else
        {
            $collc = $this->connection->{$db}->{$collection};
            return $collc;
        }

    }




    function select_collection($db,$collection)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to select the collection $collection"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m is not found in Database $db to select"."\n");
            return;
        }
        else
        {
            $database = $this->connection->{$db};
            $collc = $database->selectCollection($collection);
            return $collc;
        }
    }




    function drop_collection($db,$collection)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to drop the collection $collection"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m is not found in Database $db to drop"."\n");
            return;
        }
        else
        {
            $collc = $this->connection->{$db}->{$collection};
            $collc->drop();
        }
    }




    function insert_doc($db,$collection,$array)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to insert in collection $collection"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m is not found in Database $db to insert"."\n");
            return;
        }
        else if (is_array($array))
        {
            $this->connection->$db->$collection->insertOne($array);
        }
        else
        {
            throw new Exception("\033[01;31m Data must be a valid array \033[0m");
        }
    }




    function insert_docs($db,$collection,...$arrays)
    {
        if ($this->db_exist($db) == 0)
        {
            
            throw new Exception("Database \033[01;31m $db \033[0m not found to insert in collection $collection"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m is not found in Database $db to insert"."\n");
            return;
        }
        $i = 0;
        foreach ($arrays as $arr)
        {
            if (is_array($arr))
            {
                $this->connection->$db->$collection->insertOne($arr);
            }
            else
            {
                $j = $i+3;
                throw new Exception("\033[01;31m Argument $j should be a valid array \033[0m");
            }
            $i++;
        }
    }




    function fetch_doc($db,$collection,$match,$projection)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to fetch the document"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m not found in database $db to insert the document"."\n");
            return;
        }
        $collc = $this->connection->{$db}->{$collection};
        $cursor = $collc->findOne($match,$projection);
        return $cursor;
    }




    function fetch_docs($db,$collection,$match,$projection)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to fetch the document"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m not found in database $db to insert the document"."\n");
            return;
        }
        $collc = $this->connection->{$db}->{$collection};
        $cursor = $collc->find($match,$projection);
        return $cursor;
    }




    function delete_doc($db,$collection,$match)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to delete the document"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m not found in database $db to delete the document"."\n");
            return;
        }
        $collc = $this->connection->{$db}->{$collection};
        $cursor = $collc->deleteOne($match);
        return $cursor;
    }



    function delete_docs($db,$collection,$match)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to delete the document"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m not found in database $db to delete the document"."\n");
            return;
        }
        $collc = $this->connection->{$db}->{$collection};
        $cursor = $collc->deleteOne($match);
        return $cursor;
    }



    function update_doc($db,$collection,$match,$update)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to update the document"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m not found in database $db to update the document"."\n");
            return;
        }
        $collc = $this->connection->{$db}->{$collection};
        $cursor = $collc->updateOne($match,$update);
        return $cursor;
    }



    function update_docs($db,$collection,$match,$update)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to update the document"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m not found in database $db to update the document"."\n");
            return;
        }
        $collc = $this->connection->{$db}->{$collection};
        $cursor = $collc->updateMany($match,$update);
        return $cursor;
    }



    function clone_collection($db,$collection)
    {
        if ($this->db_exist($db) == 0)
        {
            throw new Exception("Database \033[01;31m $db \033[0m not found to clone the collection"."\n");
            return;
        }
        else if ($this->collection_exist($db,$collection) == 0)
        {
            throw new Exception("Collection \033[01;31m $collection \033[0m not found in database $db to clone"."\n");
            return;
        }
        $collc = $this->connection->{$db}->{$collection};
        return $collc;
    }
    
}

$conn = new mysqli("34.71.67.81","sruteeshP","32175690Pq","logindata");

$sql = "CREATE TABLE logindat (`FirstName` VARCHAR(500), `LastName` VARCHAR(500), `EmailId` VARCHAR(500), `Password` VARCHAR(500), `Crypt` VARCHAR(500), `Userkey` VARCHAR(500), `foldername` VARCHAR(500))";

if ($conn->query($sql) === TRUE)
  {
    echo "Table logindata created successfully";
  } else 
  {
    echo "Error creating table: " . $conn->error;
  }
  
  $conn->close();

?>
