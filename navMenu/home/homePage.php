<title>Billing application</title>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
$sql = "select * from reminders where date=CURRENT_DATE";
$count=0;
$result = mysqli_query($conn, $sql);
?>
<script>
	document.getElementById("home").classList.add("active");
</script>
<div class="container content">
	<main>
		<div>
			<div>
				<?php 
						if (mysqli_num_rows($result) > 0) 
						{
							while($row = mysqli_fetch_assoc($result)) 
									{
										echo "<div class='alert alert-primary alert-dismissible'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>"
										.$row["reminder_msg"]."</div>";
									}
								}
				?>
			</div>
			<h3 style="text-align:center">Sales statistics</h3><hr>
	</main>
<?php mysqli_close($conn);?>
<script src="https://d3js.org/d3.v4.min.js"></script>
<div style="text-align:center">
<svg width="300" height="200"> </svg>
</div>
<script>
    var data = [2, 4, 8, 10];

    var svg = d3.select("svg"),
        width = svg.attr("width"),
        height = svg.attr("height"),
        radius = Math.min(width, height) / 2,
        g = svg.append("g").attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");
		

    var color = d3.scaleOrdinal(['#4daf4a','#377eb8','#ff7f00','#984ea3','#e41a1c']);

    // Generate the pie
    var pie = d3.pie();

    // Generate the arcs
    var arc = d3.arc()
                .innerRadius(0)
                .outerRadius(radius);

    //Generate groups
    var arcs = g.selectAll("arc")
                .data(pie(data))
                .enter()
                .append("g")
                .attr("class", "arc")
	

    //Draw arc paths
    arcs.append("path")
        .attr("fill", function(d, i) {
            return color(i);
        })
        .attr("d", arc);
</script>
</div>
</body>
</html>
