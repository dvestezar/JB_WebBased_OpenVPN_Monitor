//Fields of status table
var tablefields={
	cert:'Certificate',
	ip:'IP address',
	onl:'Online',
	up:'Upload',
	dwn:'Download',
	vpnip:'VPN IP',
	ak:'Make',
	onlc:'Total online',
	akttr:'up/down per sec',
	tr_up:'',
	tr_dwn:'',
	flag:'IP Flag'
};
//Fields of log table
var logtablefields={
	dt:'Date',
	tp:'Type',
	tx:'Message'
};

//Global texts
var ovpnmon_lng={
	tabletitleinfo:'OpenVPN active connections',
	logtabletitleinfo:'OpenVPN log list',
	print:'Print',
	mn_home:'Home',
	mn_log:'Log list',
	mn_nfo:'About VPN server',
	tx_comp:'Computer',
	tx_log:'Log',
	tt_dwn:'Total downloaded',
	tt_up:'Total uploaded',
	det_tx:'Details',
	det_ipaddr:'IP Address',
	det_brow:'Browser',
	dt_diff_days:'and days',
	unloaded:'Not loaded',
	bt_kill:'Kill connection',
	conf_kill:'Kill connection',
	win_tit:'Killing connection',
	win_tx:'Killing connection by certificate : ',
	winnfo_tit:'Information about OpenVPN serveru',
	winnfo_ld:'Loading informations ...',
	winnfo_err:'Loading error :',
	flag_loading:'Loading...',
	ajxtbl_loading:'Loading ...'
}

var log_msgs={
	'I':'information',
	'F':'fatal error',
	'N':'non-fatal error',
	'W':'warning',
	'D':'debug'
};


//language for ajax table
with (JBajaxtable_var.lang){
	raz = 'Order by';
	str = 'Page';
	zob = 'viewed';
	z = 'of';
	max = 'Max';
	loading = 'Loading ....';
	loading_alert = 'Already loading !';
	err_serv = 'Error - server status';
	err_script = 'Error of server script';
	err_js = 'JS Error';
	tblrefr = 'Refresh table';
	tblrefr_alt = 'Refresh table content.';
	empty = 'Nothing found';
	rs_zobr = 'View reset';
	rs_zobr_qe = 'Opravtu provést reset zobrazení? Budou zobrazeny všechny sloupce.';
	fltrdiv = 'Zobrazené sloupce';
	print = 'Print';
	print_alt = 'Print table content.';
	generuji = 'Generating, wait please : ';
	ordby = 'Order by :';
	predch_pg = 'Previous page';
	nasled_pg = 'Next page';
	save_colsinfo = 'Chyba při ukládání infa sloupců tabulky';
	err_ret_no_obj = 'vrácená data nejsou JSON objekt';
	err_ret_no_obj_format = 'Vrácený objekt nemá formát požadovaných dat.';
	menubtn_alt = 'Table menu';
	menubtn_tx = 'Menu';
	sellall = 'Select all';
	sellall_alt = 'Select all rows';
	desellall = 'Deselect';
	desellall_alt = 'Deselect all rows';
	selinv = 'Invert selection';
	selinv_alt = 'Invert selected rows';
	err_acc_dn = 'Access denied / Not logged';
	err_conect = 'Chyba připojení do databáze.';
	err_parse_user = 'Chyba parsování uživatele - nebyl přidělen přístup, nejsi přilášen, nebo jsi nebyl inicializován jako uživatel';
	err_underrgetsql = 'Chyba při získání SQL';
	err_undsqlclasscmd = 'Neexistující příkaz v registrované třídě SQL';
	err_undsqlclass = 'Neexistující třída příkazů SQL';
	err_sqlcmdfilemiss = 'Neexistující soubor s příkazy SQL';
	err_login = 'Musíš být přihlášen.';
	err_no_asign = 'Uživatel nebyl nastaven';
	mysql_err_chk_qr = 'Chyba pordpůrného dotazu SQL';
	mysql_err_main_qr = 'Chyba hlavního dotazu SQL';
	mysql_err_add_qr = 'Chyba dotazů z dotazu dodatečných dat';
	end = 'End';
	reachedminpage = 'You reached first page.';
	reachedmaxpage = 'You reached last page.'
}