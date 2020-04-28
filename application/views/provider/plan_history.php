
<?php $this->load->view('common/common_header'); ?>
<body class="fix-header">

<div class="preloader">
	<svg class="circular" viewBox="25 25 50 50">
		<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
	</svg>
</div>
<div id="wrapper">
	<?php $this->load->view('provider/common/top_nav');?>
	<?php $this->load->view('provider/common/left_nav');?>
	<div id="page-wrapper" style="background: white">
		<div class="container-fluid">
			<div class="row bg-title">
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
					<h4 class="page-title">Plans</h4>
				</div>

			</div>
			<?php $this->load->view('message');?>
			<div style="overflow: auto">
				<?php
				if($current_plan) {
					?>
					<div class="bg-title" style="padding: 10px 20px; margin-left: 0px; margin-right: 0px;">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
							<h5>Current Plan Title: <strong><?php echo $current_plan->plan->title; ?></strong></h5>
							<h5>Current Plan Duration: <strong><?php echo $current_plan->plan->frequency; ?>
									Months</strong></h5>
							<h5>Start Date: <strong><?php echo $current_plan->created_at; ?></strong></h5>
							<h5>End Date: <strong><?php echo $current_plan->end_date ?></strong></h5>
							<h5>Status: <strong><?php echo $current_plan->status; ?></strong></h5>
						</div>

					</div>
					<?php
				}
				?>
				<table id="myTable" class="table table-striped" >
					<thead>
					<tr>
						<th>Image</th>
						<th>Title</th>
						<th>Number of Parts</th>
						<th>Price</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($plans as $plan) {
						if($plan->plan->id == $current_plan->plan_id) {
							?>
							<tr style="background-color: #2F323E!important; color: white !important;">
							<?php
						}else{
							?>
							<tr>
							<?php
						}
						?>
						<td>
							<?php if (!empty($plan->plan->photo)) {?>
								<img class="img_size" src="<?php echo base_url() . "/upload/".$plan->plan->photo; ?>">
							<?php } else {echo "No image";}?>
						</td>
						<td><?php echo $plan->plan->title; ?></td>
						<td><?php echo $plan->plan->num_parts; ?> Parts</td>
						<td><?php echo $plan->plan->price; ?></td>
						<td><?php echo $plan->created_at; ?></td>
						<td><?php echo $plan->end_date; ?></td>
						<td><?php echo $plan->status; ?></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>

			</div>
			<?php $this->load->view("common/common_footer")?>
		</div>

	</div>
</div>
</div>
<?php $this->load->view("common/common_script")?>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable({"bSort": false});
    });
</script>

</body>
</html>
