<link rel="stylesheet" href="css/menu.css" />
	
<script type="text/javascript" src="js/chili-1.7.pack.js"></script>
<script type="text/javascript" src="js/jquery.easing.js"></script>
<script type="text/javascript" src="js/jquery.dimensions.js"></script>
<script type="text/javascript" src="js/jquery.accordion.js"></script>
<script type="text/javascript">
	jQuery().ready(function(){
  		jQuery('#navigation').accordion({ 
		    active: false, 
			header: '.head', 
			navigation: true, 
			event: 'click', 
			fillSpace: true, 
			animated: 'bounceslide' 
		});
	});
	
</script>

<ul id="navigation">
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Setup</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('leaguetype.php', 'League Types Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- League Types Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('seasonstable.php', 'Seasons Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Seasons Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('clubstable.php', 'Clubs Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Clubs Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('playerstable.php', 'Players Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Players Setup</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Data Entries</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('fixturestable.php', 'Fixtures Update');">&nbsp;&nbsp;&nbsp;&nbsp;- Fixtures Update</a>
			</li>
			<li>
				<a href="javascript: checkAccess('matchestable.php', 'Matches Update');">&nbsp;&nbsp;&nbsp;&nbsp;- Matches Update</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Users Management</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('manageusers.php', 'Manage Users');">&nbsp;&nbsp;&nbsp;&nbsp;- Manage Users</a>
			</li>
			<li>
				<a href="javascript: checkAccess('accesscontrol.php', 'Users Access Control');">&nbsp;&nbsp;&nbsp;&nbsp;- Users Access Control</a>
			</li>
			<li>
				<a href="javascript: checkAccess('changepassword.php', 'Change Users Password');">&nbsp;&nbsp;&nbsp;&nbsp;- Change Users Password</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Reports</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('leaguetable.php', 'League Tables');">&nbsp;&nbsp;&nbsp;&nbsp;- League Tables</a>
			</li>
			<li>
				<a href="javascript: checkAccess('fixtureslists.php', 'Fixtures Lists');">&nbsp;&nbsp;&nbsp;&nbsp;- Fixtures List</a>
			</li>
			<li>
				<a href="javascript: checkAccess('matchesresults.php', 'Matches Results');">&nbsp;&nbsp;&nbsp;&nbsp;- Matches Results</a>
			</li>
			<li>
				<a href="javascript: checkAccess('goalslists.php', 'Goals Lists');">&nbsp;&nbsp;&nbsp;&nbsp;- Goals, Caution & Expulsions List</a>
			</li>
			<li>
				<a href="javascript: checkAccess('clubslists.php', 'Clubs Lists');">&nbsp;&nbsp;&nbsp;&nbsp;- Clubs List</a>
			</li>
			<li>
				<a href="javascript: checkAccess('playerslists.php', 'Players Lists');">&nbsp;&nbsp;&nbsp;&nbsp;- Players List</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul>
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Logout</a>
		<ul>
			<li>
				<a href="javascript:logoutUser()" title="Logout">&nbsp;&nbsp;&nbsp;&nbsp;- Logout</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
</ul>
