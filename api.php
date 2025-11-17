<?php
header("Content-Type: application/json");
require "config.php";

$a = $_GET['action'] ?? "";

if($a=="take"){
  $mysqli->query("INSERT INTO tokens() VALUES()");
  echo json_encode(["token"=>$mysqli->insert_id]);
  exit;
}

if($a=="current"){
  $c = $mysqli->query("SELECT current_token FROM settings WHERE id=1")->fetch_assoc()['current_token'];
  echo json_encode(["current"=>$c]);
  exit;
}

if($a=="next"){
  $c = $mysqli->query("SELECT current_token FROM settings WHERE id=1")->fetch_assoc()['current_token'];
  $n = $mysqli->query("SELECT id FROM tokens WHERE id>$c ORDER BY id ASC LIMIT 1");
  if(!$n->num_rows){ echo json_encode(["msg"=>"No tokens"]); exit; }
  $next = $n->fetch_assoc()['id'];
  $mysqli->query("UPDATE settings SET current_token=$next WHERE id=1");
  echo json_encode(["current"=>$next]);
  exit;
}
