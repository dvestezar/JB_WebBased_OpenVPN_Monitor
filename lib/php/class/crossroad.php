<?php
class class_crossroad extends class_init {
	public function where(){
		$cmd=$this->cmd;
		if($cmd=='status'){
			$this->ht->set_json_output();
			echo $this->openVPN->getStatusJSON();
		}elseif($cmd=='rawstatus'){
			header("Content-type: text/plain");
			echo $this->openVPN->getRAWstatus($this->ht->ghp('cmd'),$this->ht->ghp('param'));
		}elseif($cmd=='geo'){
			$this->ht->set_json_output();
			echo json_encode($this->ht->get_geo($this->ht->ghp('ip')));
		}elseif($cmd=='log'){
			$this->ht->set_json_output();
			echo $this->openVPN->getJSONlog();
		}elseif($cmd=='nfo'){
			$this->ht->set_json_output();
			echo $this->openVPN->getJSONnfo();
		}elseif($cmd=='kill'){
			$c=$this->ht->ghp('c');
			$this->openVPN->sendCommand("kill",$c);
			echo('OK');
		}else{
			//default action
			echo $this->ht->head();
			require_once 'tmpl/'.$this->cnf->template.'/index.php';
			echo $this->ht->foot();
		}	
	}
}
 ?>