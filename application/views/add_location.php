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
        <div id="page-wrapper">
            <div class="container-fluid" >
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                       
                    </div>
                   
                </div>
                
                <div class="col-md-4 col-lg-3" >
                    <div >
                        <!-- <div id="morris-area-chart2" style="height:200px;visibility: hidden;"></div> -->
                    </div>
                </div>
                <div class="col-md-6" style="background: white">
                    <div class="white-box">
                       
                        <?php $this->load->view('message');?>    
                        <form class="form-horizontal" method="post" action="<?php echo base_url();?>location/add_location">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Location Zone Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Location Zone Name" required> </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Location Zone Name AR</label>
                                <div class="col-sm-9">
                                    <input type="text" name="arabic_name" class="form-control" id="inputEmail3" placeholder="Location Zone Name AR" required> </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Sorting</label>
                                <div class="col-sm-9">
                                    <input type="text" name="sorting" class="form-control" id="inputEmail3" placeholder="sorting" required> </div>
                            </div>
                            <div class="form-group m-b-0">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-info waves-effect waves-light m-t-10" id="submit">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <?php $this->load->view('common/common_footer');?>
            </div>
        </div>
         <?php $this->load->view('common/common_script');?>
        
        

    </body>

</html>
