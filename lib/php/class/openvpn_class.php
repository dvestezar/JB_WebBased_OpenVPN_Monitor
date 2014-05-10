<?php 

/**
 * Class to query stats from a OpenVPN's Management Interface
 * 
 * rewrited by dvestezar
 * 
 */

class OpenVPN {
	private $hide=false; //if true then script rewrite IP and name of certificates

	private $maxlogrows=150; // count of log lines
	private $oneLineCommands = array('kill','load-stats','quit','exit');
	private $vpnSubNet = '10.8.0.';
	private $columnOrder = array(
		0=>array('IP-Adresa','ip'),
		5=>array('Online od','online'),
		2=>array('VPN-IP','vpn-ip'),
		3=>array('Up','upload'),
		4=>array('Down','download'),
		1=>array('Certifikát','KEY')
	);
	private $fp,$port,$ip,$errno,$errstr;
	
	public function __construct($ip,$port,$demo=false){
		$this->ip = $ip;
		$this->port = $port;
		$this->connect();
		$this->hide=$demo;
	}
	public function __destruct(){
		$this->sendCommand('quit');
		fclose($this->fp);
		$this->fp = NULL;
	}
	public function __toString(){
		$str = '<pre>';
		$str .= var_dump($self);
		$str .= '</pre>';
		return $str;
	}
	private function connect(){
		$this->fp = fsockopen($this->ip, $this->port, $this->errno, $this->errstr, 5);
		if (!$this->fp){
			return "$this->errstr ($this->errno)<br />\n";
			exit;
		}	
		fgets($this->fp);
	}
	public function sendCommand($cmd='status',$param=''){
		if($this->hide==true){
			if($cmd=='kill'){
				echo 'Denied - Demo';
				die;
			}
		}
		fwrite($this->fp,"{$cmd} {$param}\n\n\n");
		sleep(1);
		if(in_array($cmd,$this->oneLineCommands)) return fgets($this->fp);
			$string = '';
			while(($line=fgets($this->fp)) !== false) {
			if(trim($line)=='END'){
				break;
			}
			$string .= $line;
		}
		return $string;
	}
	public function getStatusData($array){
		if(!is_array($array) || empty($array)) return 'Kein Client verbunden</div></div>';
		$o=array();
		$cnt=0;
		foreach($array as $clist){
			if ( preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/',$clist) == 1){
				if (preg_match('/^\d{1,3}\./',$clist) == 0){
					$temp = explode(',',$clist);
					$ip = explode(':',$temp[1]);
					$d=new datetime(trim($temp[4]));
					$cert=($this->hide==true?'certificate_'.$cnt:$temp[0]);

					$array2[$cert]['ip'] = $this->hide==true?"$cnt.$cnt.$cnt.$cnt":$ip[0];
					$array2[$cert]['onl'] = $d->format('Y-m-d H:i:s');
					$array2[$cert]['up'] += ($temp[3]);
					$array2[$cert]['dwn'] += ($temp[2]);
				}else{
					$temp = explode(',',$clist);
					$cert=($this->hide==true?'certificate_'.$cnt:$temp[0]);

					$ip_ext = explode(':',$temp[2]);
					if(strpos($cert,$this->vpnSubNet) !== false){
						$array2[$temp[1]]['vpnip'] = $temp[0];
					}
				}
			}
			$cnt++;
		}
		return $array2;
	}
	public function getRAWstatus($cmd,$param){
		if($this->hide){
			return 'DEMO';
		}
		return $this->sendCommand($cmd,$param);
	}
	
	public function getJSONlog(){
		if($this->hide){
			$a=explode("\n",file_get_contents(dirname(__FILE__).'/demodata/log50.txt'));
		}else{
			$a=explode("\n",$this->sendCommand('log '.$this->maxlogrows));
		}	
		$d=array();
		$d[]=array('dt','tp','tx');
		foreach($a as $i){
			$i=preg_replace("/\r/",'',$i);
			if(preg_match('/^(\d+),(\w)?,(.+)/i',$i,$m)){
				$d[]=array($m[1],$m[2],$m[3]);
			}
		}
		$o=array();
		$o['ArrData']=$d;
		$o['msg']='OK';
		$o['cnt']=1;
		$o['pg']=0;
		$o['sel']=0;
		$o['maxrow']=99999;
		return json_encode($o);
	}
	public function getJSONnfo(){
		$a=explode("\n",$this->sendCommand('version'));
		$o=array();
		foreach($a as $i){
			if(preg_match('/^(.+):(.+)$/',$i,$m)){
				$o[]=array('nfo'=>$m[1],'tx'=>$m[2]);
			}
		}
		return json_encode($o);
	}
	
	public function getStatusJSON(){
		$a=$this->getStatusData(explode("\n", $this->sendCommand()));
		//překlad na assoc pole
		$o=array();
		foreach($a as $k=>$i){
			$itm=array();
			$itm[cert]=$k;
			foreach($i as $k2=>$i2)
				$itm[$k2]=$i2;
			$o[]=$itm;
		}
		//překlad na array pole s fieldhead
		$f=array();
		foreach($o[0] as $k=>$i)
			$f[]=$k;
		$a=array();
		$a[]=$f;
		foreach($o as $itm){
			$f=array();
			foreach($itm as $i)
				$f[]=$i;
			$a[]=$f;
		}
		$o=array();
		$o['ArrData']=$a;
		$o['msg']='OK';
		$o['cnt']=1;
		$o['pg']=0;
		$o['sel']=0;
		$o['maxrow']=99999;
		return json_encode($o);
	}
}
?>