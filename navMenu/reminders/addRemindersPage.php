<title>Billing application</title>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<script>
	document.getElementById("reminder").classList.add("active");
</script>
<main>
	<div class="content">
		<?php
				if($_GET)
				{
					if(isset($_GET['error'])){
						echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
					}
				}
		?>
		<div class="container" style="margin:auto">
			<div class="container row" style="margin:auto">
				  <div class="row shadowedBox col-sm-6" style="margin:auto">
					<div class="col-sm-12">
					<form action="/BillingApplication/navMenu/reminders/addReminders.php" method="post">
						<div>
							<div class="form-group">
								<label>Reminder message:</label>
								<textarea class="form-control" name="msg" id="msg" rows="2"></textarea>
							</div>
						</div><br>
						<div>
						  <label for="name">Date:</label>
						  <input type="date" class="form-control" required name="date" id="date">
						</div><br>
						<input type="submit" class="btn btn-info" name="submit">
					</form>
					</div>
				  </div>
			</div>
		</div>
	</div>
</main>
