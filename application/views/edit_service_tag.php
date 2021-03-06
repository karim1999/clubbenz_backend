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
                       <h4 class="page-title">Edit Services</h4>
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
                        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>service_tag/update_service_tag">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"> Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" id="inputEmail3" maxlength="20" value="<?php echo $service->name ?>" > </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"> Name AR</label>
                                <div class="col-sm-9">
                                    <input type="text" name="arabic_name" class="form-control" id="inputEmail3" maxlength="20" value="<?php echo $service->arabic_name ?>">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Select Shop Type</label>
                                <div class="col-sm-9">
                                    <select name="shop_type"  class="form-control" onchange='CheckColors(this.value);'>

                                         <?php if (!empty($service->shop_type)) {?>
                                            <option value="workshop" <?php echo $service->shop_type == 'workshop' ? 'selected' : ''; ?>>workshop</option>
                                            <option value="serviceshop" <?php echo $service->shop_type == 'serviceshop' ? 'selected' : ''; ?>>serviceshop</option>
                                            <option value="partshop" <?php echo $service->shop_type == 'partshop' ? 'selected' : ''; ?>>partshop</option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style='<?php if ($service->shop_type == 'workshop' || $service->shop_type == 'partshop') {echo "display:none";}?>/* display:none; */' id="service_id">
                                <label for="inputEmail3" class="col-sm-3 control-label">service group Name</label>
                                <div class="col-sm-9">
                                    <select name="service_type_id" class="form-control">
                                        <option value="">Select Option</option>
                                        <?php foreach ($service_type as $sr) {?>
                                        <option value="<?php echo $sr->id ?>"<?php if ($sr->id == $service->service_type_id) {echo 'selected="selected"';}?>><?php echo $sr->name ?></option>

                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Keywords</label>
                                <div class="col-sm-9">
                                    <input type="text" name="keywords" class="form-control js-example-tokenizer" id="inputEmail3" value="<?php echo $service->keywords ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Sorting</label>
                                <div class="col-sm-9">
                                    <input type="text" name="sorting" class="form-control" id="inputEmail3" value="<?php echo $service->sorting ?>"> </div>
                                <input type="hidden" name="id" value="<?php echo $service->id ?>">
                            </div>
                            <div class="form-group m-b-0">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-info waves-effect waves-light m-t-10" id="submit">Update</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <?php $this->load->view('common/common_footer');?>
            </div>
        </div>
        <?php $this->load->view('common/common_script');?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    </body>
    <script >
       $('.js-example-tokenizer').tokenfield({
          autocomplete: {
            source: [],
            delay: 100
          },
          showAutocompleteOnFocus: true
        })
    </script>

    <script type="text/javascript">
        function CheckColors(val){
         var element=document.getElementById('service_id');
         if(val=='serviceshop')
           element.style.display='block';
         else
           element.style.display='none';
        }
    </script>



</html>
