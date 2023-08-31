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
	$sql = "SELECT * FROM $table";

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

	$sql= 'SELECT sum(quantity) FROM requisition WHERE item LIKE ? AND approve=?';

	$stmt = executeQuery($sql,['item'=> $match,'approve'=>1]);
	
	$records = $stmt->get_result()->fetch_assoc();
	$total = $records['sum(quantity)'];
    return $total;
	

}

function getTotalQuantityOrdered($sterm)
{
	
	$match='%' . $sterm .'%';
	global $conn;

	$sql= 'SELECT sum(quantity) FROM requisition WHERE item LIKE ?';

	$stmt = executeQuery($sql,['item'=> $match]);
	
	$records = $stmt->get_result()->fetch_assoc();
	$total = $records['sum(quantity)'];
    return $total;
	

}


function getTotalInventory($sterm)
{
    $match = '%' . $sterm . '%';
    global $conn;

  
    $sql = 'SELECT total FROM store WHERE item LIKE ? ';
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

  
    $sql = 'SELECT * FROM requisition WHERE user_id =? ';
    $stmt = executeQuery($sql, ['user_id' => $match]);

	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

   
    return $records;
}



function getUser_id($sterm)
{
	$match = $sterm;
    global $conn;

  
    $sql = 'SELECT user_id FROM requisition WHERE id =?';
    $stmt = executeQuery($sql, ['id' => $match]);

	$records = $stmt->get_result()->fetch_assoc();

	foreach($records as $record)
	{
		$record;
	}
	return $record;
	
}




function selectAllInDepartment($sterm)
{
	$match = $sterm;
    global $conn;

  
    $sql = 'SELECT * FROM requisition WHERE department =?';
    $stmt = executeQuery($sql, ['department' => $match]);

	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    return $records;
}


function getDepartment($sterm)
{
	$match = $sterm;
    global $conn;

  
    $sql = 'SELECT department FROM users WHERE id=?';
    $stmt = executeQuery($sql, ['id' => $match]);

	$records = $stmt->get_result()->fetch_assoc();

	foreach($records as $record)
	{
		$record;
	}
	return $record;
	
}





function getMessages($sterm)
{
	$match = $sterm;
    global $conn;
  
    $sql = 'SELECT * FROM messages WHERE user_id =?';
    $stmt = executeQuery($sql, ['user_id' => $match]);

	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    return $records;

}




function getCountMessages($sterm)
{
	$match = $sterm;
    global $conn;

  
    $sql = 'SELECT count(message) FROM messages WHERE user_id =? AND status= ? ';
    $stmt = executeQuery($sql, ['user_id' => $match, 'status'=>0]);

	$records = $stmt->get_result()->fetch_assoc();

	foreach($records as $record)
	{
		$record;
	}
	return $record;

}




function getNumberOfInventoryInProgress()
{
	global $conn;

	$sql= 'SELECT count(item) FROM requisition WHERE approve=? AND issue=?';

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

	$sql= 'SELECT count(item) FROM requisition WHERE approve=?';

	$stmt = executeQuery($sql,['approve'=>1]);
	$records = $stmt->get_result()->fetch_assoc();
	

	foreach($records as $record)
	{
		$record;
	}
	return $record;

}




function getNumberOfInventoryOrderedInDept($sterm)
{
	$match = '%' . $sterm . '%';
	global $conn;

	$sql= 'SELECT count(item) FROM requisition WHERE department LIKE ?';

	$stmt = executeQuery($sql,['department'=>$match]);
	$records = $stmt->get_result()->fetch_assoc();
	
	foreach($records as $record)
	{
		$record;
	}

	return $record;

}



function getNumberOfInventoryInProgressDept($sterm)
{
	$match = '%' . $sterm . '%';
	global $conn;

	$sql= 'SELECT count(item) FROM requisition WHERE department Like ? AND ( approve=1 OR approve=0) AND (issue=0)';

	$stmt = executeQuery($sql,['department'=>$match]);
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

	$sql= 'SELECT remaining FROM store WHERE item LIKE ?';

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

	$sql= 'SELECT MIN(remainingAfterOrder) FROM requisition WHERE item LIKE ? AND remainingAfterOrder > 0';

	$stmt = executeQuery($sql,['item'=>$match]);
	$records = $stmt->get_result()->fetch_assoc();
	
	foreach($records as $record)
	{
		$record;
	}
	return $record;
}



function findmaxId()
{
	global $conn;
	$sql= 'SELECT MAX(id) FROM requisition WHERE approve=? OR approve=0';

	$stmt = executeQuery($sql,['approve'=>1]);
	$records = $stmt->get_result()->fetch_assoc();
	
	foreach($records as $record)
	{
		$record;
	}
	return $record;
}




function getItem_id($sterm)
{
	$match = $sterm;
    global $conn;

  
    $sql = 'SELECT id FROM store  WHERE item LIKE ?';
    $stmt = executeQuery($sql, ['item' => $match]);

	$records = $stmt->get_result()->fetch_assoc();

	foreach($records as $record)
	{
		$record;
	}
	return $record;
	
}



function selectAllInDepartmentDesc($sterm)
{
	$match = $sterm;
    global $conn;

  
    $sql = 'SELECT * FROM requisition WHERE department =? ORDER BY id DESC';
    $stmt = executeQuery($sql, ['department' => $match]);

	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    return $records;
}



function selectRemaining($sterm)
{
	$match='%' . $sterm .'%';
    global $conn;

    $sql = 'SELECT * FROM store WHERE item LIKE ? OR remaining LIKE ?';
    $stmt = executeQuery($sql, ['item' => $match,'remaining' => $match]);

	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    return $records;
}





function selectAllInDepartmentPending($sterm)
{
	$match = $sterm;
    global $conn;

  
    $sql = 'SELECT * FROM requisition WHERE department =? AND approve=? ORDER BY id DESC ';
    $stmt = executeQuery($sql, ['department' => $match, 'approve'=>0]);

	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    return $records;
}


function selectAllDesc($table,$conditions = [])
{
	global $conn;
	$sql = "SELECT * FROM $table ORDER BY id DESC ";

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



function selectAllPending($table,$conditions = [])
{
	global $conn;
	$sql = "SELECT * FROM $table WHERE issue=0 ORDER BY id DESC ";

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
				$sql =$sql . 'WHERE $key=?';
			

			}
			else 
			{
				$sql = $sql. ' AND $key = ?';
	
            }
			$i++;
        }

		$sql = $sql;
		$stmt = executeQuery($sql,$conditions);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;

	}
		
}



function searchTerm($sterm)
{
	$match='%' . $sterm .'%';
	global $conn;

	$sql= 'SELECT 
		r.*
		FROM requisition AS r
		WHERE r.item LIKE ? OR  r.quantity LIKE ? OR r.department LIKE ? OR r.reason LIKE ? OR r.orderdBy LIKE ? OR r.approvedBy LIKE ? OR r.issuedBy LIKE ? OR r.finalId LIKE ? OR  r.created_at LIKE ? ORDER BY id DESC';

	$stmt = executeQuery($sql,['item'=> $match, 'quantity'=>$match, 'department'=>$match, 'reason'=>$match, 'orderdBy'=>$match, 'approvedBy'=>$match, 'issuedBy'=>$match, 'finalId'=>$match, 'created_at'=>$match]);
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;

}


function searchName($sterm)
{
	$match='%' . $sterm .'%';
	global $conn;

	$sql= 'SELECT 
		u.*
		FROM users AS u
		WHERE u.username LIKE ? OR  u.secondname LIKE ? OR u.email LIKE ? OR u.department LIKE ? ';
	$stmt = executeQuery($sql,['username'=> $match, 'secondname'=>$match, 'email'=>$match, 'department'=>$match]);
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;
}


function getRemaining()
{
	global $conn;
	$sql= 'SELECT remaining FROM store WHERE issue=? OR issue=1';
	$stmt = executeQuery($sql,['issue'=>0]);
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;

}


function getAlert()
{
	global $conn;
	$sql= 'SELECT alert FROM store WHERE  issue=? OR issue=1';

	$stmt = executeQuery($sql,['issue'=>0]);
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;

}


function getItem()
{
	global $conn;
	$sql= 'SELECT item FROM store WHERE  issue=? OR issue=1';

	$stmt = executeQuery($sql,['issue'=>0]);
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	
	return $records;

}


function searchAdmin()
{
	global $conn;
	$sql= 'SELECT * FROM users WHERE admin=? OR admin=2';

	$stmt = executeQuery($sql,['admin'=>1]);
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	
	return $records;
}





function searchTermDept($dept,$sterm)
{
	$deptValue='%' . $dept .'%';
	$match='%' . $sterm .'%';
	global $conn;

	$sql= 'SELECT 
		r.*
		FROM requisition AS r
		WHERE r.department LIKE ? AND (r.item LIKE ? OR  r.quantity LIKE ? OR r.department LIKE ? OR r.reason LIKE ? OR r.orderdBy LIKE ? OR r.approvedBy LIKE ? OR r.issuedBy LIKE ? OR r.finalId LIKE ? OR r.created_at LIKE ? ) ORDER BY id DESC ';

	$stmt = executeQuery($sql,['deparment'=>$deptValue,'item'=> $match, 'quantity'=>$match, 'department'=>$match, 'reason'=>$match, 'orderdBy'=>$match, 'approvedBy'=>$match, 'issuedBy'=>$match, 'finalId'=>$match, 'created_at'=>$match]);
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;

}













?>