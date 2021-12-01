<?php
function show_board(){

        global $mysqli;

        $sql='select * from board';
        $st = $mysqli->prepare($sql);

        $st->execute();
        $res = $st->get_result();

        header('Content-type:application/json');
        //παίρνει τον board στο  get_result και το τυπώνει σαν json
        print json_encode($res->fetch_all(MYSQLI_ASSOC),JSON_PRETTY_PRINT);

}
//καλεί την συνάρτηση clean_board();
function reset_board(){
    global $mysqli;

    $sql='call clean_board()';
    $mysqli->query($sql);
    show_board();
}
function move_piece($x) {
	//dokimazw tin do_move panw apo tous elegxous 
	do_move($x,$token);
			exit;
	if($token==null || $token=='') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"token is not set."]);
		exit;
	}
	
	$player = current_player($token);
	if($player==null ) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"You are not a player of this game."]);
		exit;
	}
	$status = read_status();
	if($status['status']!='started') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Game is not in action."]);
		exit;
	}
	if($status['p_turn']!=$player) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"It is not your turn."]);
		exit;
	}
	$orig_board=read_board();
	$board=convert_board($orig_board);
	$n = add_valid_moves_to_piece($board,$player,$x,$y);
	if($n==0) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"This piece cannot move."]);
		exit;
	}
	foreach($board[$x][$y]['moves'] as $i=>$move) {
		if($x2==$move['x'] && $y2==$move['y']) {
			do_move($x,$y,$x2,$y2);
			exit;
		}
	}
	header("HTTP/1.1 400 Bad Request");
	print json_encode(['errormesg'=>"This move is illegal."]);
	exit;
}
//topothetw to pioni pou exei kanei onclick o xristis ston pinaka empty_pieces
function do_move($x,$token) {
	global $mysqli;
	$sql = 'INSERT empty_pieces SELECT * FROM pieces WHERE id = ? ';
	$st = $mysqli->prepare($sql);
	$st->bind_param('i',$x);
	$st->execute();

	header('Content-type: application/json');
	print json_encode(read_board(), JSON_PRETTY_PRINT);
}
//enfanizw to pioni sto empty_pieces
function read_board() {
	global $mysqli;
	$sql = 'select * from empty_pieces';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	return($res->fetch_all(MYSQLI_ASSOC));
}
?>