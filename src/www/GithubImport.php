<?php
//Version 1 from 2017-01-02

function GithubImport($User, $Repo, $Path, $File, $Trunk = "master"){
	$path = $User."/".$Repo."/".$Trunk."/".$Path;
	$file = $path."/".$File;
	$server = @file_get_contents("https://raw.githubusercontent.com/".$file);
	if(file_exists($file) == false){
		if($server === false){
			if(ini_get("display_errors") == true){
				die("Error: Could not possible to import dependents files from Github!");
			}else{
				return false;
			}
		}else{
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