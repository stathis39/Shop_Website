<?php
//show_users = diavazei olo ton pinaka apo tou players sto db kai to typwnw san json
function show_users() {
	global $mysqli;
	$sql = 'select username,player_id from players';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}
//show_user = pairnei orisma p1 or p2 kai epistrefei se json morfi mono ton sigkekrimeno xristi
function show_user($p) {
	global $mysqli;
	$sql = 'select username,player_id from players where player_id=?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('s',$p);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}
//set_user= proshetei enan xristi ston pinaka mou alla epipleo elegxei to na mhn exei parei kapoios to p1 h to p2 
function set_user($p,$input) {
	//print_r($input);
	if(!isset($input['username'])) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"No username given."]);
		exit;
	}
	$username=$input['username'];
	global $mysqli;
	$sql = 'select count(*) as c from players where player_id=? and username is not null';
	$st = $mysqli->prepare($sql);
	$st->bind_param('s',$p);
	$st->execute();
	$res = $st->get_result();
	$r = $res->fetch_all(MYSQLI_ASSOC);
	if($r[0]['c']>0) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Player $p is already set. Please select another number ."]); // tupwnei to minima lathous se json morfi 
		exit;
	}
	$sql = 'update players set username=?, token=md5(CONCAT( ?, NOW()))  where player_id=?';
	$st2 = $mysqli->prepare($sql);
	$st2->bind_param('sss',$username,$username,$p);
	$st2->execute();


	
	update_game_status();
	$sql = 'select * from players where player_id=?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('s',$p);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
	
	
}

function handle_user($method, $b,$input) {
	if($method=='GET') {
		show_user($b);
	} else if($method=='PUT') {
        set_user($b,$input);
    }
}




?>