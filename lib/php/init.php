<?php
//include("../../config.php");
include("geo/geoip.inc");
include("geo/geoipcity.inc");
include("geo/geoipregionvars.php");
include('class/html_class.php');
include('class/openvpn_class.php');
include('class/crossroad.php');

class class_init {
	public $cnf,$openVPN,$ht,$cmd,$cs;
	
	public function __construct(){
		$this->cnf=new jbovpnmonclass();
		$this->openVPN = new OpenVPN($this->cnf->mon_ip,$this->cnf->mon_port,$this->cnf->demo);
		$this->ht=new jbhtml($this->cnf->title,$this->cnf->proto);
		$this->cmd=$this->ht->ghp('s');;
	}
}
?>