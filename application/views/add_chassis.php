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
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">ADD Chassis Number</h4>
                </div>

            </div>
            <?php $this->load->view('message');?>
            <form  name="frm" method="post" action="<?php echo base_url('chassisNumber/add_chassis') ?>" enctype="multipart/form-data" >
                <div class="form-body"style="background: white;padding-bottom:30px">

                    <div class="form-body"style="background: white;padding-bottom:30px">
                        <div class="row margin-top">

                            <div class="row margin-top">
                                <div class="">
                                    <div align="center">
                                        <label class="control-label ">Enter Chassis number </label>
                                        <input type="text" style="width: 400px ; margin-top: 20px" name="chassis_number" class=" form-control"  placeholder=" Chassis" value="<?php echo $this->input->post("chassis_number") ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row margin-top">
                                <div class="">
                                    <div align="center">
                                        <label class="control-label ">Select Car Class </label>
                                         <select name="model_id" class="form-control" style="width: 400px ; margin-top: 20px">
                                                <option>Select Model</option>
                                                <?php foreach ($model_name as $name) {?>
                                                    <?php echo '<option value="' . $name->id . '">' . $name->name . '</option>'; ?>
                                                <?php }?>
                                            </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row margin-top">

                                <div align="center" class="margin-top" style="">
                                    <input style="width: 200px; height: 50px;font-size: 20px     ; background-color: forestgreen " type="submit" name="submit" class="btn btn-primary" value="ADD">
                                </div>
                            </div>
            </form>


        </div>
        </form>

    </div>
    <?php $this->load->view('common/common_footer')?>
</div>
</div>
<?php $this->load->view('common/common_script')?>
</body>

</html>

