<?php
//ikiganteng
date_default_timezone_set('Asia/Jakarta');
include 'class_ig.php';
error_reporting(0);
clear();
copycat();
$u = getUsername();
$p = getPassword();
$sleep = getComment('Enter your sleep here (Min 600): ');
// $u = 'indiramayasari7'; $p = 'Anonymous1704!'; $text = 'Hi!';
echo '############################################################' . PHP_EOL . PHP_EOL;
$login = login($u, $p);
if ($login['status'] == 'success') {
echo '[ * ] Login as '.$login['username'].' Success!' . PHP_EOL;
$data_login = array('username' => $login['username'],'csrftoken'	=> $login['csrftoken'],'sessionid'	=> $login['sessionid']);
				while(true){
		    $profile = getHome($data_login);
				$data_array = json_decode($profile);
			  $result = $data_array->user->edge_web_feed_timeline;
			  foreach ($result->edges as $items) {
				$id = $items->node->id;
				$username = $items->node->owner->username;
				$like = like($id, $data_login);
				if ($like['status'] == 'error') {
				echo '[+] Username: '.$username.' | Media_id: '.$id.' | Error Like' . PHP_EOL;
				}else{
				echo '[+] Username: '.$username.' | Media_id: '.$id.' | Like Success'. PHP_EOL;
				}
				}
				echo '[+] ['.date("H:i:s").'] Tidur selama '.$sleep.' detik [+]'. PHP_EOL;
				sleep($sleep);
				echo '############################################################' . PHP_EOL . PHP_EOL;
                }
				} else echo json_encode($login);
