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
                                    <h4 class="page-title">Manage Service Type</h4>
                                </div>
                                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                                    <a style="background: #2CABE3" href="<?php echo base_url('service/add_services') ?>" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Add Service Type</a>
                                    <a style="background: #2CABE3" href="<?php echo base_url('service/import_services') ?>"  class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Import Service</a>
                                    <a style="background: #2CABE3" href="<?php echo base_url(); ?>service/export"  class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Export Service</a>


                                </div>
                            </div>

                            <div class="col-md-4 col-lg-3" >
                                <div>


                                </div>
                            </div>
                            <?php $this->load->view('message');?>

                            <table id="myTable" class="table table-striped">

                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Image</th>
                                        <th>Name En</th>
                                        <th>Name Ar</th>
                                        <th>S.No</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
foreach ($rec as $us) {
	?>
                                    <tr>
                                        <td><?php echo $us['id']; ?></td>
                                        <td><image class="img_size" src="<?php echo base_url('upload/') . $us['image'] ?>"></td>
                                        <td><?php echo $us['name']; ?></td>
                                        <td><?php echo $us['arabic_name']; ?></td>
                                        <td><?php echo $us['sorting']; ?></td>
                                         <td>
                                            <a class="text-inverse pr-2" data-toggle="tooltip" data-original-title="Edit" href="<?php echo base_url('service/edit_service') ?>/<?php echo $us['id']; ?>"><i class="ti-marker-alt"></i></a>
                                            <a class="text-inverse pr-2" data-toggle="tooltip" data-original-title="Delete" href="<?php echo base_url('service/service_del/') ?><?php echo $us['id']; ?>" onclick="return confirm('Are You Sure To Delete This?')"><i class="ti-trash"></i></a>
                                         </td>
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
