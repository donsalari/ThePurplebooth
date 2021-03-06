<?php 
require_once "connections.php";
open_connection();

if(isset($_GET['get_unread_notifications'])){
	get_unread_notifications($_GET["userid"]);
}

if(isset($_POST['set_notifications_read'])){
	set_notifications_read($_POST["user_id"]);
}

if(isset($_GET['get_comments'])){
	get_comment_notifications($_GET["user_id"]);
}

if(isset($_GET['get_requests'])){
	get_request_notifications($_GET['user_id']);
}

function get_request_notifications($userid){
	try {
		$query = "SELECT * FROM  `notifications`WHERE  `notification_type` LIKE  '%REQUEST%' and `to_user_id`=$userid ORDER BY  `notification_timestamp` DESC";
		$res = mysql_query($query);
		$result = array();
		while ($data = mysql_fetch_array($res)) {
			$result[] = $data;
		}
		$response = json_encode($result);
		echo $response;
	} catch (Exception $e) {
		error_log($e);
		return FALSE;
	}
}

function get_comment_notifications($userid){
	try {
		$query = "SELECT * FROM  `notifications` WHERE (`notification_type` =  'COMMENT' OR `notification_type` =  'REPLY') AND  `to_user_id` =$userid ORDER BY  `notification_timestamp` DESC";
		$res = mysql_query($query);
		$result = array();
		while ($data = mysql_fetch_array($res)) {
			$result[] = $data;
		}
		$response = json_encode($result);
		echo $response;
	} catch (Exception $e) {
		error_log($e);
		return FALSE;
	}
} 

function insert_notification($to_user_id,$from_user_id,$image_id,$type){
	try {
		$query = "INSERT INTO `thepurplebooth`.`notifications` VALUES (DEFAULT,$from_user_id,$to_user_id,$image_id,$type,false,NOW())";
		mysql_query($query) or die('Error, query failed');
		return TRUE;
	} catch(Exception $ex) {
		error_log($ex);
		return FALSE;
	}
}

function get_unread_notifications($userid){
	try {
		$query = "SELECT count(notification_id) as unread_notifications FROM `thepurplebooth`.`notifications` WHERE to_user_id=".$userid." AND notification_read=false";
		$res = mysql_query($query);
		$result = array();
		while ($data = mysql_fetch_array($res)) {
			 $result[] = $data;
		}
		$response = json_encode($result);
		echo $response;
	} catch(Exception $ex) {
		error_log($ex);
		return FALSE;
	}
}

function set_notifications_read($to_user_id){
	try {
		$query = "Update `thepurplebooth`.`notifications` set `notification_read`=true where `to_user_id`=$to_user_id";
		mysql_query($query) or die('Error, query failed');
		return TRUE;
	} catch (Exception $e) {
		error_log($e);
		return FALSE;
	}
}

?>