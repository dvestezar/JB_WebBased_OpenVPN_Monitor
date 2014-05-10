<?php
define('GeoLibPath',$_SERVER["DOCUMENT_ROOT"].'/vpnmon/lib/php/geo/GeoLiteCity.dat');

class jbovpnmonclass {
	public $title='JB OpenVPN Monitor';
	public $proto='';
	public $template='default';
	public $language='cz';
	public $mon_ip='127.0.0.1';
	public $mon_port='7505';
	public $tablerefresh=10;
	public $demo=false;
}
?>