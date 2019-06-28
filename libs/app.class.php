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
					else $pi .= "<a href='?{$url}&view={$l}&page={$i}' class='{$css}'>{$i}</a>";
				}else $pi .= "<span class='{$css}'>{$i}</span>";
			}
			return $pi;
		}
	}