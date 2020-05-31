<?php $this->load->view('common/common_header');?>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>

        <div id="wrapper" style="background: white">
            <?php $this->load->view('common/top_nav');?>
            <?php $this->load->view('common/left_nav');?>
                 <div id="page-wrapper"style="background: white">
                        <div class="container-fluid">
                            <div class="row bg-title">
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <h4 class="page-title">Manage Membership Features</h4>
                                </div>
                            </div>

                            <?php $this->load->view('message');?>

                            <table id="myTable" class="table table-striped">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gold Price</th>
                                        <th>Platinum Price</th>
                                        <th>Gold image</th>
                                        <th>Platinum image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
foreach ($rec as $us) {
	?>
                                    <tr>
                                        <td><?php echo $us->id ?></td>
                                        <td><?php echo $us->price ?></td>
                                        <td><?php echo $us->platinum_price ?></td>
                                        <td>
                                            <img class="img_size" src="<?php echo base_url() . "/upload/$us->gold_image" ?>">
                                        </td>
                                        <td>
                                            <img class="img_size" src="<?php echo base_url() . "/upload/$us->platinum_image" ?>">
                                        </td>
                                         <td>
                                            <a class="text-inverse pr-2" data-toggle="tooltip" data-original-title="Edit" href="<?php echo base_url('membership/edit_membership_features') ?>/<?php echo $us->id ?>"><i class="ti-marker-alt"></i></a>

                                         </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                    <?php $this->load->view('common/common_footer');?>
                </div>
            </div>
        </div>
         <?php $this->load->view('common/common_script');?>
         <script>
            $(document).ready( function () {
                $('#myTable').DataTable({"bSort": false});
            } );
        </script>
    </body>

</html>