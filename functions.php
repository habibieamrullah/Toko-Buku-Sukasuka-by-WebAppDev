<?php

//Make table if not exists
function maketable($table){
	global $connection;
    mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $table (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY
    )");
}


//Esc sql
function escsql($data){
	global $connection;
	return mysqli_real_escape_string($connection, $data);
}


//Check column and make it if not exist
function makecolumn($columnname, $tablename, $ctype){
	global $connection;
    if(!mysqli_query($connection, "SELECT $columnname FROM $tablename")){
        mysqli_query($connection, "ALTER TABLE $tablename ADD $columnname $ctype");
    }
}

//Get current millisecond
function getCurrentMillisecond(){
    return round(microtime(true) * 1000);
}

//Make option data
function getoption($optionname){
	global $connection;
	global $tableoptions;
	$sql = "SELECT optionvalue FROM $tableoptions WHERE optionname = '$optionname'";
	$result = mysqli_query($connection, $sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			return mysqli_fetch_assoc($result)["optionvalue"];
		}else{
			return false;
		}
	}else{
		return false;
	}
}

//Set option data
function setoption($optionname, $optionvalue){
	global $connection;
	global $tableoptions;
	
	//check if row exists
	$sql = "SELECT * FROM $tableoptions WHERE optionname = '$optionname'";
	$result = mysqli_query($connection, $sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			//update
			mysqli_query($connection, "UPDATE $tableoptions SET optionvalue = '$optionvalue' WHERE optionname = '$optionname'");
		}else{
			//add
			mysqli_query($connection, "INSERT INTO $tableoptions (optionname, optionvalue) VALUES ('$optionname', '$optionvalue')");
		}
	}
}

//URL Friendly String
function urlfriendly($string){
	$r = preg_replace('/\W+/', '-', strtolower(trim($string)));
	return $r;
}







//// Website Specific

//generate horizontal cards
function showcards($sql){
    global $connection;
    $result = mysqli_query($connection, $sql);
    $content = "";
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$thumbnail = "";
			if($row["thumbnail"] != ""){
				$thumbnail = '<img class="productthumb" src="images/' . $row["thumbnail"] .'">';
			}
			$content .= '<a href="?product=' .$row["id"]. '"><div class="productcard">' . $thumbnail . '<div>' .  $row["title"] . '</div>
				<div>
					<span style="font-size: 12px; text-decoration: line-through;">Rp. ' . number_format($row["regularprice"]) . '</span><span style="background-color: ' . getoption("primarycolor") . '; color: white; padding: 2px; margin: 2px; border-radius: 3px;">' . $row["discount"] . '%</span>
				</div>
				<div style="color: ' . getoption("primarycolor") . '; font-weight: bold;">
					Rp. ' . number_format($row["currentprice"]) .
				'</div>
			</div></a>';
		}
	}
    return $content;
}