<?php
//ikiganteng
include 'class_ig.php';
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

clear();
copycat();
$u = getUsername();
$p = getPassword();
echo PHP_EOL;
//$sleep = getComment('Sleep in seconds: ');
echo '############################################################' . PHP_EOL . PHP_EOL;
$login = login($u, $p);
if ($login['status'] == 'success') {
	echo color()["LG"].'[ * ] Login as '.$login['username'].' Success Login Sob xixi!' . PHP_EOL;
	$data_login = array(
		'username' => $login['username'],
		'csrftoken'	=> $login['csrftoken'],
		'sessionid'	=> $login['sessionid']
	);
	$data_target = findProfile($u, $data_login);
	echo color()["LG"].'[ # ] Name: '.$data_target['fullname'].' | Followers: '.$data_target['followers'] .' | Following: '.$data_target['following'] . PHP_EOL;
	if ($data_target['status'] == 'success') {
			$profile = getFollowing($u , $data_login, $data_target['following'], 1);
			foreach ($profile as $rs) {
				$username = $rs->username;
				$id_user = $rs->id;
				$post = findProfile($username, $data_login);
				if ($post['is_polbek'] == 'true') {
					echo color()["CY"].'[+] '.date('H:i:s').' @'.$username.' | Udh Follback kok' .PHP_EOL;
					sleep(1);
				}else{
				echo color()["LR"].'[-] '.date('H:i:s').' @'.$username.' | Belom Follback dia' ;
				$unfollow = unfollows($id_user, $data_login);
				if ($unfollow['status'] == 'success') {
					echo color()["LG"].' (Unfollow @'.$username.' Success Unfollow Bro xixixi)';
					sleep(rand(70,100));
					echo PHP_EOL;
				}else{
					echo color()["LR"].'(Unfollow @'.$username.' Failed) Throttled! Resting during 10 minutes before try again.';
					sleep(10*60);		
					echo PHP_EOL;
				}
			}
			}

	}else{
		echo 'Error!';
		echo PHP_EOL;
	}
}else{
		echo color()['LR'].'Error: '.ucfirst($login['details'])."" . PHP_EOL;
}
