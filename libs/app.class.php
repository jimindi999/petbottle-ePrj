<?php
	class app{
		public function __construct(){
			
		}
		public function getInfo($str){
			;
		}
		public function redir($url){
			header("Location:{$url}");
		}
		public function paging($url, $t, $l, $css, $s){
			$pi = '';
			$current = (isset($_GET['page']))?$_GET['page']:1;
			for($i=ceil($t/$l); $i >= 1 ; $i--){
				if($i != $current){
					if ($s != '') $pi .= "<a href='?{$url}&s={$s}&view={$l}&page={$i}' class='{$css}'>{$i}</a>";
					else $pi .= "<a href='?{$url}&page={$i}' class='{$css}'>{$i}</a>";
				}else $pi .= "<span class='{$css}'>{$i}</span>";
			}
			return $pi;
		}
		public function file_upload($name, $type_array, $size_limit, $type, $baseUrl){
			$file_name = $_FILES[$name]['name'];
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$file_new_name = substr($file_name, 0, - strlen($file_ext) - 1)."_".time().".".$file_ext;
			$file_tmp = $_FILES[$name]['tmp_name'];
			$file_size = $_FILES[$name]['size'];
			if(in_array($file_ext, $type_array) && $file_size <= $size_limit){
				if(move_uploaded_file($file_tmp, "../resources/".$type."/".$file_new_name)){
					$result = "success|".$baseUrl."resources/".$type."/".$file_new_name;
				}else{
					$result = "failed|Upload failed";
				}
			}else if(!in_array($file_ext, $type_array)){
				$result = "failed|Wrong file type";
			}else{
				$result = "failed|File exceeds size limit";
			}
			return $result;
		}
	}