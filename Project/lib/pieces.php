<?php
function show_pieces(){
    global $mysqli;

    $sql='select * from pieces';
    $st = $mysqli->prepare($sql);

    $st->execute();
    $res = $st->get_result();

    header('Content-type:application/json');
    //παίρνει τον pieces στο  get_result και το τυπώνει σαν json
    print json_encode($res->fetch_all(MYSQLI_ASSOC),JSON_PRETTY_PRINT);

}
function show_piece($x) {
    global $mysqli;
	$sql = 'select * from pieces where id=?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('i',$x);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}
   

?>