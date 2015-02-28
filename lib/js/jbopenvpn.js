if(typeof Q=='undefined')
	Q=jQuery;

var JBopenVPN;
function JBopenVPNclass(){
	var ajaxtable;
	var logtable;
	var clk_dwn;
	var clk_up;
	var last_data;
	var last_time;
	var akt_time;
	var timer=-1;
	var fwin;
	var logwin;
	var log_adddata;
	var ajx_nfo;
	var ip_nfo={};
	
	function init(){
		ajaxtable = new JBajaxtable(
			'status', //dotaz
			'for_status_table',
			{
				selectable:'cert',
				firstread:false,
				scriptfilename:'?',
				ordering:false,
				showfilters:false,
				printname:getln('print')+' '+getln('tabletitleinfo'),
				title:getln('tabletitleinfo'),
				fields:tablefields,
				ontdcreate:tbl_tdcreate.bind(this),
				ondataloaded:tbl_dataloaded.bind(this),
				ontablefinish:tbl_tablefinish.bind(this),
				sqlparamfn:fnsqlparamfn.bind(this)
			}
		);	
		logtable =  new JBajaxtable(
			'log', //dotaz
			'for_log_table',
			{
				firstread:false,
				scriptfilename:'?',
				ordering:false,
				showfilters:false,
				printname:getln('print')+' '+getln('logtabletitleinfo'),
				title:getln('logtabletitleinfo'),
				fields:logtablefields,
				ondataloaded:logtbl_dataloaded.bind(this),
				ontdcreate:logtbl_tdcreate.bind(this)
			}
		);
		fwin=new JB_win();
		init_logwin.bind(this)();
		this.show_home();
	}
	function init_logwin(){
		logwin=new JB_win();
	}
	
	// **********************
	// BOF pages
	this.show_home=function(){
		hide_log.bind(this)();
		$('#page_home').show();
		ajaxtable.refresh();
	}
	hide_home=function(){
		if(timer!=-1){
			clearTimeout(timer);
			timer=-1;
		}
		$('#page_home').hide();
	}
	this.show_log=function(){
		hide_home.bind(this)();
		$('#page_logfile').show();
		logtable.refresh();
	}
	hide_log=function(){
		$('#page_logfile').hide();
	}
	
	this.show_nfo=function(){
		logwin.open(getln('winnfo_tit'),getln('winnfo_ld'),{w:400,h:200,
			onclose:nfo_onclose.bind(this)
		});
		ajx_nfo=$.getJSON(
			'',
			{s:'nfo'},
			show_nfo_getok.bind(this)
		).fail((function(jhxr,status){
			logwin.set_tx(getln('winnfo_err')+'\n'+status);
		}).bind(this));
	}
	function show_nfo_getok(d){
		var o='';
		for(var a=0;a<d.length;a++){
			o+='<p><b><u>'+d[a].nfo+' :</u></b><br />'+d[a].tx+'</p>';
		}
	
		logwin.set_tx(o);
		ajx_nfo=null;
	}
	function nfo_onclose(){
		if(ajx_nfo!=null)
			try{ajx_nfo.abort();}catch(e){};
	}
	
	// BOF pages
	// **********************
	// BOF staus table
	function fnsqlparamfn(p){
		if(timer!=-1){
			clearTimeout(timer);
		}
		return p;
	}
	function tbl_dataloaded(el,empty,data,obj){
		akt_time=Math.floor(JB.date.toNum(JB.date.now())*86400);
		clk_dwn=0;
		clk_up=0;
		var o,x;
		if(!empty){
			for(var a=0;a<data.length;a++){
				o={};
				for(x in data[a]){
					o[x]=data[a][x];
					if(x=='onl'){
						o['onlc']='';
					}else if(x=='dwn'){
						o['akttr']='';
					}else if(x=='ip'){
						o['flag']='';
					}
				}
				o['ak']='';
				data[a]=o;
				if(JB.is.und(ip_nfo[data[a].ip])){
					ip_nfo[data[a].ip]=null;
				}
			}
		}
	}
	function tbl_tablefinish(tb){
		var o=getln('tt_dwn')+' : '+JB.x.byte_to_text(clk_dwn);
		o+='<br />'+getln('tt_up')+' : '+JB.x.byte_to_text(clk_up);
		
		tb.ajxtbl.setSouhrn(o);
		last_data=ajaxtable.getLastData().data;
		last_time=Math.floor(JB.date.toNum(JB.date.now())*86400);
		
		timer=setTimeout(fn_timer.bind(this), tablerefresh*1000);
		get_empty_flags.bind(this)();
	}
	function tbl_tdcreate(el){
		if(el.field=='up'){
			clk_up+=el.val*1;
			el.innerHTML=JB.x.byte_to_text(el.val);
		}else if(el.field=='dwn'){
			clk_dwn+=el.val*1;
			el.innerHTML=JB.x.byte_to_text(el.val);
		}else if(el.field=='onl'){
			el.innerHTML=JB.date.printable(el.val);
		}else if(el.field=='onlc'){
			var a=JB.date.toNum(JB.date.now());
			a-=JB.date.toNum(el.tr['onl']);
			var b=Math.floor(a);
			el.innerHTML=JB.date.fromNum(a,2)+(b==0?'':' '+getln('dt_diff_days')+' : '+b);
		}else if(el.field=='akttr'){
			var a=getDataByCert.bind(this)(el.tr['cert']);
			if(a==false){				
				el.innerHTML=getln('unloaded');
			}else{
				var b=el.tr['up']-a['up'];
				var c=el.tr['dwn']-a['dwn'];
				el.tr['tr_up']=b;
				el.tr['tr_dwn']=c;
				var t=akt_time-last_time;
				
				el.innerHTML=
					JB.x.byte_to_text(Math.floor(b/t)) + '<span class="act_traffic_' + (el.tr['tr_up']>a['tr_up']?'up">↑':'dwn">↓') + '</span>'
					+' / '+
					JB.x.byte_to_text(Math.floor(c/t)) + '<span class="act_traffic_' + (el.tr['tr_up']>a['tr_up']?'up">↑':'dwn">↓') + '</span>';
			}
		}else if(el.field=='ak'){
			var a=JB.x.cel('input',{ob:el,tp:'image',val:getln('bt_kill'),pop:getln('bt_kill')});
			a.src='lib/images/cancel_20.png';
			a.onclick=killconnection.bind(this,el);
		}else if(el.field=='flag'){
			if(ip_nfo[el.tr['ip']]!=null){
				var a=ip_nfo[el.tr['ip']];
				JB.x.cel('img',{ob:el,ad:{src:'lib/flags/png/'+a.country_code.toLowerCase()+'.png'}});
			}else{
				el.innerHTML=getln('flag_loading')
			}
		}
	}
	// EOF staus table
	// **********************
	// BOF  LOG table
	function logtbl_tdcreate(td){
		var a;
		if(td.field=='tp'){
			b=log_msgs[td.tr['tp']];
			if(JB.is.und(b))
				b='';
			var s='';
			if(td.tr['tp']!=''){
				s='logcolor_typemsg_'+td.tr['tp'];
			}
			$(td).addClass(s);
			td.innerHTML=b;
		}else if(td.field=='dt'){
			td.innerHTML=JB.date.printable(new Date(td.val*1000));
		}
	}
	function logtbl_dataloaded(el,empty,data,obj,add){
		var a,b;
		if(!empty){
			data.sort(function(a,b){
				return parseInt(b.dt)-parseInt(a.dt);
			});
		}
	}
	//EOF LOG table
	// **********************
	function fn_timer(){
		timer=-1;
		ajaxtable.refresh();
	}

	function getDataByCert(certname){
		if(JB.is.und(last_data)) return false;
		if(last_data.length<1) return false;
		for(var a=0;a<last_data.length;a++){
			if(last_data[a].cert==certname){
				return last_data[a];
			}
		}
		return false;
	}
	
	function killconnection(td){
		if(timer!=-1){
			clearTimeout(timer);
			timer=-1;
		}
		var a=td.tr['cert'];
		fwin.open(getln('win_tit'),getln('win_tx')+td.tr['cert']);
		if(confirm(getln('conf_kill')+' '+a+' ?')){
			Q.ajax({
				url:'?',
				dataType:'text',
				type:'POST',
				data:{
					s:'kill',
					c:a
				},
				success:function(d){
					d=String(d).trim();
					if(d!='OK'){
						alert('Chyba : '+d);
					}
				},
				complete:(function(){
					ajaxtable.refresh();
					fwin.close();
				}).bind(this)
			});
		}else
			ajaxtable.refresh();
	}
	function get_empty_flags(){	
			var a,o;
			o='';
			for(a in ip_nfo){
				if(ip_nfo[a]==null){
					if(o!='')o+=',';
					o+=a;
				}
			}
			if(o!=''){
				Q.getJSON(
					'',
					{'s':'geo',ip:o},
					(function(data){
						var a;
						for(a in data){
							if(!JB.is.und(ip_nfo[a])){
								ip_nfo[a]=JSON.parse(JSON.stringify(data[a]));
							}
						}
					}).bind(this)
				);
			}
		
	}
	
	init.bind(this)();
}

Q(document).ready(function(){
	JBopenVPN= new JBopenVPNclass();
});

function wrln(name){
	document.write(ovpnmon_lng[name]);
}
function getln(name){
	return ovpnmon_lng[name];
}
