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
		public function paging($url, $t, $l, $s){
			$current = (isset($_GET['page']))?$_GET['page']:1;
			$previous = $current - 1;
			$next = $current + 1;
			if ($current == 1){
				$pi = "<div class='float-right'>
							<nav aria-label='Page navigation example' pull-right>
								<ul class='pagination'>
									<li class='page-item'>
										<a class='page-link' href='#' aria-label='Previous'>
											<span aria-hidden='true'>&laquo;</span>
										</a>
									</li>";
			}else{
				$pi = "<div class='float-right'>
							<nav aria-label='Page navigation example' pull-right>
								<ul class='pagination'>
									<li class='page-item'>
										<a class='page-link' href='?{$url}&s={$s}&view={$l}&page={$previous}' aria-label='Previous'>
											<span aria-hidden='true'>&laquo;</span>
										</a>
									</li>";
			}
			for($i=1; $i <= ceil($t/$l) ; $i++){
				if($i != $current){
					if ($s != '') $pi .= "<li class='page-item'><a href='?{$url}&s={$s}&view={$l}&page={$i}' class='page-link'>{$i}</a></li>";
					else $pi .= "<li class='page-item'><a href='?{$url}&page={$i}' class='page-link'>{$i}</a></li>";
				}else $pi .= "<li class='page-item'><span class='page-link'>{$i}</span></li>";
			}
			if ($current == ceil($t/$l)){
				$pi .= "<li class='page-item'>
							<a class='page-link' href='#' aria-label='Next'>
								<span aria-hidden='true'>&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
				</div>";
			}else{
				$pi .= "<li class='page-item'>
							<a class='page-link' href='?{$url}&s={$s}&view={$l}&page={$next}' aria-label='Next'>
								<span aria-hidden='true'>&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
				</div>";
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