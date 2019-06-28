<?php
	class Model{
		protected $db ;
		public function __construct($dsn,$usr,$pwd){
			try{
				$this->db = new PDO($dsn,$usr,$pwd);
			}catch(PDOException $e){
				echo "Not connect to database!".$e->getMessage();
				die;
			}
		}
		public function execSQL($sql){
			$dbh = $this->db->prepare($sql);
			$dbh->execute();
			return $dbh;
		}
		public function fetchOne($sql){
			$dbh = $this->execSQL($sql);
			$rs = $dbh->fetch(PDO::FETCH_ASSOC);
			//var_dump($dbh);
			return $rs;
		}
		public function insert($tblName,$ar){
			$aListKeys 		= array_keys($ar);
			$aListValues 	= array_values($ar);
			$listField 		= implode(',',$aListKeys);
			$listValue		= implode(',',$aListValues);
			$sql = "INSERT INTO {$tblName}({$listField})
			VALUES({$listValue})";
			if($this->execSQL($sql)){
				return true;
			}else return false;
		}
		public function checkExist($tbl,$where){
			$sql = "SELECT COUNT(1) as TOTAL
					FROM {$tbl} WHERE {$where}";
			$rs = $this->fetchOne($sql);
			if(intval($rs['TOTAL'])>0){
				return true;
			}else return false;
		}
		public function delete($tbl,$where){
			$sql = "DELETE FROM {$tbl} WHERE {$where}";
			if($this->execSQL($sql)){
				return true;
			}else return false;
		}
		public function update_one_value($tbl,$key,$value,$where){
			$sql = "UPDATE {$tbl} SET {$key} = {$value} WHERE {$where}";
			if($this->execSQL($sql)){
				return true;
			}else return false;
		}
		public function update($tbl,$update_queue,$where){
			$sql = "UPDATE {$tbl} SET {$update_queue} WHERE {$where}";
			if($this->execSQL($sql)){
				return true;
			}else return false;
		}
		public function fetch($sql){
			$dbh = $this->execSQL($sql);
			$rs = $dbh->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
	}