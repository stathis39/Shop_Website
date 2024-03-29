<?php
ini_set('display_errors','on' );

require_once "lib/dbconnect.php";
require_once "lib/board.php";
require_once "lib/pieces.php";
require_once "lib/game.php";
require_once "lib/users.php";

$method =$_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/') );
$input = json_decode(file_get_contents('php://input'),true);
if(isset($_SERVER['HTTP_X_TOKEN'])) {
	$input['token']=$_SERVER['HTTP_X_TOKEN'];
}

switch ($r=array_shift($request)){
    case 'board' :
            switch ($b=array_shift($request)){
                    case '':
                    case null : handle_board($method,$input);
                        break;
                        case 'piece': handle_piece($method, $request[0],$input);//pernw to pioni pou thelw
                        break;
                    default:header("HTTP/1.1 404 not Found");
                        break;
            }
            break;
    case 'status':
            if(sizeof($request)==0){show_status();}
            else{header("HTTP/1.1 404 Not Found");}
                break;
    case 'players':handle_player($method,$request,$input);
                break;
            default: header("HTTP/1.1 404 Not Found");
                exit;
    case 'pieces': //pernw ton pinaka me ola ta kommatia
            switch ($b=array_shift($request)){    
                case '':
                case null : handle_pieces($method);
                break;
                default:header("HTTP/1.1 404 not Found");
                break;  
            }
            exit;
}
function handle_board($method){

        if($method=='GET'){
                show_board();
        }else if ($method=='POST'){
            reset_board();
        }
}
//με την handle_pieces παίρνω τα πιόνια σε ξεχωριστό αρχείο json για να μπορεσω να κάνω την αντιστοιχία με τις εικόνες
function handle_pieces($method){
    if($method=='GET'){
        show_pieces();
}

}
function handle_piece($method, $x,$input) {
	if($method=='GET') {
        show_piece($x);
    } else if ($method=='PUT') {
		move_piece($x,$input['token']);
    }    
}
function handle_player($method, $request,$input) {
	switch ($b=array_shift($request)) {
		case '':
		case null: if($method=='GET') {show_users($method);}
				   else {header("HTTP/1.1 400 Bad Request"); 
						 print json_encode(['errormesg'=>"Method $method not allowed here."]);}
                    break;
        case 'p1': 
		case 'p2': handle_user($method, $b,$input);
					break;
		default: header("HTTP/1.1 404 Not Found");
				 print json_encode(['errormesg'=>"Player $b not found."]);
                 break;
	}
}