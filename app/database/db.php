<?php

session_start();
require("connect.php");


function db($value)
{
	echo "<pre>",print_r($value,true),"</pre>";
	die();
}

//Function used to execute the sql and return stmt
function executeQuery($sql,$data)
{
    global $conn;
	$stmt= $conn->prepare($sql);
	$values = array_values($data);
	$types = str_repeat("s",count($values));
	$stmt->bind_param($types, ...$values);
    $stmt ->execute();
	return $stmt;

}

function selectAll($table,$conditions = [])
{
	global $conn;
	$sql = "SELECT * FROM $table ";

	if(empty($conditions))
	{
		$stmt= $conn->prepare($sql);
		$stmt ->execute();
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
	}

	else
	{
		$i=0;
		
		foreach($conditions as $key => $value)
		{	
			
			
			if($i===0)
			{
				$sql =$sql . "WHERE $key=?";
			

			}
			else 
			{
				$sql = $sql. " AND $key = ?";
	
            }
			$i++;
        }

		$sql = $sql;
		$stmt = executeQuery($sql,$conditions);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;

	}
		
}









function selectOne($table,$conditions)
{
	global $conn;
	$sql = "SELECT * FROM $table ";

	$i=0;
	foreach($conditions as $key => $value)
	{	
			
			
		if($i===0)
		{
			$sql =$sql . "WHERE $key=?";
			

		}
		else 
		{
			$sql = $sql. " AND $key = ?";
	
        }
		$i++; 
    }

	$sql = $sql." LIMIT 1";
	$stmt = executeQuery($sql,$conditions);
	$records = $stmt->get_result()->fetch_assoc();
	return $records;

		
}


//iserting data into the database
function create($table,$data)
{
	global $conn;
	$sql= "INSERT INTO $table SET ";

	$i=0;
	foreach($data as $key => $value)
	{
			if($i===0)
			{
				$sql= $sql." $key = ?";

			}

			else
			{
				$sql = $sql. ", $key = ?";
	
            }

			$i++;
	}

	$sql=$sql;
	$stmt=executeQuery($sql,$data);
	$id = $stmt->insert_id;
	return $id;


}


//update values in the database

function update($table,$id,$data)
{
	global $conn;

	//UPDATE users SET admin=? usename=? password=? WHERE id=?
	$sql = "UPDATE $table SET ";
	$i=0;

	foreach($data as $key=>$value)
	{
		if($i===0)
		{
			$sql = $sql. " $key=?";
		}
		else
		{
			$sql= $sql. ", $key=?";
	
        }
		$i++;
	}
	$sql = $sql. " WHERE id=?";
	$data['id']=$id;
	$stmt=executeQuery($sql,$data);
	return $stmt->affected_rows;


}




function updateInventory($table,$id,$data)
{
	global $conn;

	//UPDATE users SET admin=? usename=? password=? WHERE id=?
	$sql = "UPDATE $table SET ";
	$i=0;

	foreach($data as $key=>$value)
	{
		if($i===0)
		{
			$sql = $sql. " $key=?";
		}
		else
		{
			$sql= $sql. ", $key=?";
	
        }
		$i++;
	}
	$sql = $sql. " WHERE id=? ";
	$data['id']=$id;
	$stmt=executeQuery($sql,$data);
	return $stmt->affected_rows;


}


	

function delete($table,$id)
{
	global $conn;

	//DELETE FROM users WHERE id=?
	$sql = "DELETE FROM $table WHERE id=? ";

	$stmt=executeQuery($sql,['id'=>$id]);
	return $stmt->affected_rows;

}







function getTotalQuantityOrder($sterm)
{
	
	$match='%' . $sterm .'%';
	global $conn;

	$sql= "SELECT sum(quantity) FROM requisition WHERE item LIKE ? AND approve=?";

	$stmt = executeQuery($sql,['item'=> $match,'approve'=>1]);
	
	$records = $stmt->get_result()->fetch_assoc();
	$total = $records['sum(quantity)'];
    return $total;
	

}

function getTotalQuantityOrdered($sterm)
{
	
	$match='%' . $sterm .'%';
	global $conn;

	$sql= "SELECT sum(quantity) FROM requisition WHERE item LIKE ?";

	$stmt = executeQuery($sql,['item'=> $match]);
	
	$records = $stmt->get_result()->fetch_assoc();
	$total = $records['sum(quantity)'];
    return $total;
	

}


function getTotalInventory($sterm)
{
    $match = '%' . $sterm . '%';
    global $conn;

  
    $sql = "SELECT total FROM store WHERE item LIKE ? ";
    $stmt = executeQuery($sql, ['item' => $match]);

	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if ($records)
	{
        $total = $records[0]['total'];
    } 
		else 
	{
        $total = 0;
    }

    return $total;
}



function getUniqueOrders($sterm)
{
    $match = $sterm;
    global $conn;

  
    $sql = "SELECT * FROM requisition WHERE user_id =? ";
    $stmt = executeQuery($sql, ['user_id' => $match]);

	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

   
    return $records;
}





function getNumberOfInventoryInProgress()
{
	global $conn;

	$sql= "SELECT count(item) FROM requisition WHERE approve=? AND issue=? OR approve=0 AND issue=0";

	$stmt = executeQuery($sql,['approve'=>1,'issue'=>0]);
	$records = $stmt->get_result()->fetch_assoc();

	foreach($records as $record)
	{
		$record;
	}
	return $record;


}






function getNumberOfInventoryOrdered()
{
	global $conn;

	$sql= "SELECT count(item) FROM requisition WHERE approve=? OR approve=0";

	$stmt = executeQuery($sql,['approve'=>1]);
	$records = $stmt->get_result()->fetch_assoc();
	

	foreach($records as $record)
	{
		$record;
	}

	return $record;


}




function findRemaining($sterm)
{
	$match = '%' . $sterm . '%';
	global $conn;

	$sql= "SELECT remaining FROM store WHERE item LIKE ?";

	$stmt = executeQuery($sql,['item'=>$match]);
	$records = $stmt->get_result()->fetch_assoc();
	
	
	foreach($records as $record)
	{
		$record;
	}

	return $record;
}




function findRemainingAfterOrder($sterm)
{
	$match = '%' . $sterm . '%';
	global $conn;

	$sql= "SELECT MIN(remainingAfterOrder) FROM requisition WHERE item LIKE ? AND remainingAfterOrder > 0";

	$stmt = executeQuery($sql,['item'=>$match]);
	$records = $stmt->get_result()->fetch_assoc();
	
	foreach($records as $record)
	{
		$record;
	}
	return $record;
}




function searchPosts($sterm)
{
	$match='%' . $sterm .'%';
	global $conn;

	$sql= "SELECT 
		p.*, u.username 
		FROM posts AS p 
		JOIN users AS u
		ON p.user_id = u.id 
		WHERE p.published=?

		AND p.title LIKE ? OR p.body LIKE ? ";

	$stmt = executeQuery($sql,['published'=>1,'title'=> $match, 'body'=>$match]);
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;

}











?>