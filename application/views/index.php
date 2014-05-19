<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Main</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>
<div id="container">
	<h1>Welcome!</h1>

	<div id="body">
		<p>You're see all users in the wifi system of north-west branch of Megafon Retail. You can to add <a href="<?= base_url('index.php/welcome/add'); ?>">one more user</a>. You can also view the <a href="<?= base_url('index.php/welcome'); ?>?view=Expired">expired</a> users and the <a href="<?= base_url('index.php/welcome'); ?>?view=Activated">activated</a> users in the system</p>
		<? if ($result) { ?>
		<? foreach ($result as $k => $r) { ?>
		<div style="display: table; width: 50%; border: 1px solid grey">
			<div style="display: table-row">
				<div style="display: table-cell">
					UserID
				</div>
				<div style="display: table-cell">
					<?= $k ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					Login
				</div>
				<div style="display: table-cell">
					<?= $r['name'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					Duration
				</div>
				<div style="display: table-cell">
					<?= $r['type'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					Password for session
				</div>
				<div style="display: table-cell">
					<?= $r['password'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					Auth method
				</div>
				<div style="display: table-cell">
					<?= $r['mac-auth-method'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					User's email
				</div>
				<div style="display: table-cell">
					<?= $r['email-address'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					User's phone
				</div>
				<div style="display: table-cell">
					<?= $r['phone-number'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					start-date
				</div>
				<div style="display: table-cell">
					<?= $r['start-date'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					end-date
				</div>
				<div style="display: table-cell">
					<?= $r['end-date'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					last-login-time
				</div>
				<div style="display: table-cell">
					<?= $r['last-login-time'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					state
				</div>
				<div style="display: table-cell">
					<?= $r['state'] ?>
				</div>
			</div>
			<div style="display: table-row">
				<div style="display: table-cell">
					Delete user and drop the session
				</div>
				<div style="display: table-cell">
					<a href="<?= base_url('index.php/welcome/delete/' . $r['name']) ?>">delete</a>
				</div>
			</div>
		</div>
		<? } ?>
		<? } else { ?>
			<p><b>There are currently no users</b></p>
		<? } ?>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>