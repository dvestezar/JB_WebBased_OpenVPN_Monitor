<?php
class jbhtml {
	private $baseURL,$proto;
	public function __construct($title,$proto){
		$this->title = $title;
		$this->proto = $proto;
	}

	public function head(){
		$cnf=new jbovpnmonclass();
		return '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" type="text/css" href="http://www.dvestezar.cz/!moje_js/table.css?v='.VersioN.'" />
		<link rel="stylesheet" type="text/css" href="http://www.dvestezar.cz/!moje_js/JB.modal.win.css?v='.VersioN.'" />
		<link rel="stylesheet" type="text/css" href="lib/css/global.css?v='.VersioN.'" />
		<title>'.$this->title.' v'.VersioN.'</title>
		<script src="lib/js/jquery.min.js?v='.VersioN.'" language="javascript" type="text/javascript"></script>
		<script src="http://www.dvestezar.cz/!moje_js/JB.js?v='.VersioN.'" language="javascript" type="text/javascript"></script>
		<script src="http://www.dvestezar.cz/!moje_js/JB.modalwin.js?v='.VersioN.'" language="javascript" type="text/javascript"></script>
		<script src="http://www.dvestezar.cz/!moje_js/table.js?v='.VersioN.'" language="javascript" type="text/javascript"></script>
		<script src="lang/'.$cnf->language.'.js?v='.VersioN.'" language="javascript" type="text/javascript"></script>

		<script src="config.js?v='.VersioN.'" language="javascript" type="text/javascript"></script>
		<script src="lib/js/jbopenvpn.js?v='.VersioN.'" language="javascript" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="tmpl/'.$cnf->template.'/css/template.css?v='.VersioN.'" />
		<script language="javascript">
			var tablerefresh='.$cnf->tablerefresh.';
			JBajaxtable_var.lang.loading=\'<div class="loading_div"><img src="lib/images/14.gif" height="10"><span>\'+getln("ajxtbl_loading")+\'</span></div>\';
		</script>
		</head>
		<body>
		';
						
	}
	public function foot(){
   	return '
			<div style="text-align:center;font-size:10px">Rewrited by <a href="http://www.dvestezar.cz" target="_blank">Dvestezar &copy;2014</a>  v'.VersioN.'</div>
		</body>
		</html>';
	}
	public function set_json_output(){
		ob_end_clean();

		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Wed, 01 Jan 2020 05:00:00 GMT");

		header("Content-type: application/json;charset=utf-8;");
		header('Content-Disposition: ; filename="out.json"');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	
	}
	
	public function get_geo($comma_ips){
		$privateIP='/^(10(\.\d+){3})|(((192.168)|(172.16))(\.\d+){2})$/';
		$def=array(
			"country_code"=>"err",
			"country_code3"=> "",
			"country_name"=> "Error",
			"region"=> "",
			"city"=> "Error",
			"postal_code"=> "",
			"latitude"=> 0,
			"longitude"=> 0,
			"area_code"=> null,
			"dma_code"=> null,
			"metro_code"=> null,
			"continent_code"=> "err"
		);
		
		$this->set_json_output();
		$gi=geoip_open(GeoLibPath,GEOIP_STANDARD);
		
		$a=explode(',',$comma_ips);
		$o=array();
		foreach($a as $i){
			$x=geoip_record_by_addr($gi,$i);
			if($x==null){
				if(preg_match($privateIP,$i)){
					$x=$def;
					$x['country_code']='lan';
					$x['continent_code']='lan';
					$x['city']='LAN';
					$x['country_name']='LAN';
				}else{
					$x=$def;
				}
			}
			$o[$i]=$x;
		}
		return $o;
	}
	
	public function ghp($x){
		//get http params
		if (preg_match('/^post$/i',$_SERVER['REQUEST_METHOD'])) {
			$x=$_POST[$x];
		}else{
			$x=$_GET[$x];
		}
		if($x==null)$x='';
		return $x;
	}
}
?>