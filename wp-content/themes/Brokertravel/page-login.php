<?php
	$_SESSION['catID']=7;	
	$_SESSION['loggedIn']=true;		
	wp_redirect(home_url());
	exit;
/*
if(strtolower($_POST['membercode']) == strtolower("POST2302")){ 
	$_SESSION['catID']=7;	
	$_SESSION['loggedIn']=true;		
	wp_redirect(home_url());
	exit;
}else{
	wp_redirect(get_page_link(342));
	$_SESSION['logInSuccess']=false;	
}
*/
?>