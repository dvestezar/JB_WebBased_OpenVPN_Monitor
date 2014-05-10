			<div id="header">
				<div id="logo" style="color:white;font-size:20px;font-family:monospace;font-variant:small-caps;">
					<img src="lib/images/logo.png" alt="openvpn logo">
				</div>
			</div>
			<div id="mainmenu">
				<ul>
					<li><a href="#" onclick="JBopenVPN.show_home();return false;" class="current"><script>wrln("mn_home")</script></a></li>
					<li><a href="#" onclick="JBopenVPN.show_log();return false;" class="current"><script>wrln("mn_log")</script></a></li>
					<li><a href="#" onclick="JBopenVPN.show_nfo();return false;" class="current"><script>wrln("mn_nfo")</script></a></li>
				</ul>
			</div>
			<div id="page">
				<div id="content">
					<div id="page_home" class="mon_pages">
						<div class="wra">
							<h2 class="title"><script>wrln("tx_comp")</script></h2>
							<div class="forum">
								<div id="for_status_table"></div>
							</div>
						</div>
					</div>
					<div id="page_logfile" class="mon_pages">
						<div class="wra">
							<h2 class="title"><script>wrln("tx_log")</script></h2>
							<div class="forum">
								<div id="for_log_table"></div>
							</div>
						</div>
					</div>
					<div>
						<h3><script>wrln("det_tx")</script></h3>
						<span style="display:block;float:left;color:grey;font-size:0.8em">
							<script>wrln("det_ipaddr")</script> : <?php echo $_SERVER['REMOTE_ADDR'] .':'.$_SERVER['REMOTE_PORT'] ?><br />
							<script>wrln("det_brow")</script> : <?php echo $_SERVER['HTTP_USER_AGENT'] ?>
						</span>
						<p style="float:right;margin-top:-5px;margin-right:10px;">
							<a href="http://validator.w3.org/check?uri=referer" target="fenster"><img
								border="0" src="http://www.w3.org/Icons/valid-xhtml10"
								alt="Valid XHTML 1.0 Transitional" height="31" width="88" />
							</a>
						</p>
					</div>
				</div>
			</div>
