<?php
//Version 1 from 2017-01-03

/**
 * @param string $User
 * @param string $Repo
 * @param string $File
 * @param string $Trunk Optional
 */
function GithubImport($User, $Repo, $File, $Trunk = "master"){
	$file = $User."/".$Repo."/".$Trunk."/".$File;
	$server = @file_get_contents("https://raw.githubusercontent.com/".$file);
	if(file_exists($file) == false){
		if($server === false){
			if(ini_get("display_errors") == true){
				die("Error: Could not possible to import dependents files from Github!");
			}else{
				return false;
			}
		}else{
			$path = substr($file, 0, strrpos($file, "/") - 1);
			@mkdir($path, 0777, true);
			file_put_contents($file, $server);
			require_once($file);
		}
	}else{
		if($server !== false){
			if(hash_file("sha256", $file) != hash("sha256", $server)){
				file_put_contents($file, $server);
			}
		}
		require_once($file);
	}
}