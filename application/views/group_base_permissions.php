<?php $this->load->view('common/common_header');?>
    <body class="fix-header">
        <!-- <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div> -->
        <div id="wrapper" style="background: white">
        <?php $this->load->view('common/top_nav');?>
        <?php $this->load->view('common/left_nav');?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">Permissions</h4>
                        </div>
                        <!--<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                            <a style="background: #2CABE3" data-toggle="modal" data-target="#add_group" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Add Group</a>
                        </div> -->
                    </div>
                    <form name="frm_group" id="frm_group">
                        <input type="hidden" name="group_id" />
                    </form>
                    <?php $this->load->view('message');?>
                    <form name="role_base_permission" method="post" action="<?php echo base_url() ?>permissions/set_group_permissions">
                    <div class="row">
                        <div class="col-md-1">
                            <label for="">Groups :</label>
                        </div>
                        <div class="col-md-4">
                            <select id="group_id" class="form-control" name="groups" onchange="selectRole(this.value)">
                                <option value="">Select Group</option>
                                <?php foreach ($groups as $g) {?>
                                    <option <?php if ($this->input->get('group_id') == $g['id']) {?> selected="selected" <?php }?>  value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-info m-btn m-btn--icon m-btn--pill"  onclick="return checkGroup();">Update</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="checkAll" class="btn btn-info m-btn m-btn--icon m-btn--pill"> <input type="checkbox" value="" id="checkAll"/> Select All</label>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-4">
                            <a onclick="expandCollapse()" class="btn btn-info m-btn m-btn--icon m-btn--pill" id="expand-collapse">Collapse All</a>
                        </div>
                    </div> -->
                    <div class="row" id="nestable">
                        <?php foreach ($permissions as $c) {?>
                        <div class="col-md-6">
                            <ol class="dd-list">
                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle"> &nbsp; <?php echo $c['controllers']; ?></div>
                                    <?php $functions = $this->acl_model->get_all_functions($c['controllers']);?>
	                                <?php foreach ($functions as $f) {?>
                                        <ol class="dd-list">
                                            <li class="dd-item" data-id="6">
                                                <div class="dd-handle"><input type="checkbox" name="permissions[]"  value="<?php echo $f['id']; ?>" <?php if (!empty($group_permissions)) {if (in_array($f['id'], $group_permissions)) {?> checked <?php }}?>/> &nbsp; <?php echo $f['name']; ?></div>
                                            </li>
                                        </ol>
                                    <?php }?>
                                </li>
                            </ol>
                        </div>
                        <?php }?>
                    </div>
                </form>
                <?php $this->load->view('common/common_footer');?>
            </div>
        </div>
    </div>
<div id="functions" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Add Function</h4>
            </div>
            <form method="post" name="frm" action="<?php echo base_url() ?>permissions/add_permission_function" >
                <input type="hidden" name="module" class="module_value" />
                <input type="hidden" name="controller" class="controller_value" />
                <input type="hidden" name="user_id" id="user_id" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label for="">Name</label>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" placeholder="Name" name="function" id="function_name1" />
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label for="">Function Name</label>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" placeholder="Function Name" name="name" />
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label for="">Description</label>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>Availability</label>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <ul style="list-style-type:none; margin-top:10px;">
                                <li>
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio5" data-pattern="" value="public" name="permission_status" checked>
                                        <label for="inlineRadio5" style="padding-right:25px;"> Public </label>
                                        <input type="radio" id="inlineRadio6" data-pattern="" value="permission_needed" name="permission_status">
                                        <label for="inlineRadio6"> Permission Needed </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-border"> <span id="loading_img" style="display:none"><img src="<?php echo base_url() ?>assets/images/loader-new.gif" /></span>
                    <button type="submit"  class="btn btn-info m-btn--pill waves-effect waves-light" onclick="return check_function();">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="child_functions" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Add Child Function</h4>
            </div>
            <form method="post" name="frm" action="<?php echo base_url() ?>permissions/add_permission_function" >
                <input type="hidden" name="module" class="module_value" />
                <input type="hidden" name="controller" class="controller_value" />
                <input type="hidden" name="parent_id" id="parent_id" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label for="">Name</label>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" placeholder="Name" name="function" id="function_name2"/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label for="">Function Name</label>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" placeholder="Function Name" name="name" />
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label for="">Description</label>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>Availability</label>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <ul style="list-style-type:none; text-align:center; margin-top:10px;">
                                <li>
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio5" data-pattern="" value="public" name="permission_status" checked>
                                        <label for="inlineRadio5" style="padding-right:25px;"> Public </label>
                                        <input type="radio" id="inlineRadio6" data-pattern="" value="permission_needed" name="permission_status">
                                        <label for="inlineRadio6"> Permission Needed </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-border"> <span id="loading_img" style="display:none"><img src="<?php echo base_url() ?>assets/images/loader-new.gif" /></span>
                    <button type="submit"  class="btn btn-info m-btn--pill waves-effect waves-light" onclick="return check_child_function();">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('common/common_script');?>
<link href="<?php echo base_url(); ?>/assets/css/jquery.nestable.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>/assets/js/jquery.nestable.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/nestable.js"></script>

<script type="text/javascript">
    function selectRole(id) {
        document.frm_group.group_id.value = id;
        document.frm_group.submit();
    }
    function checkGroup() {
        var group = $('#group_id').val();
        if (group == '') {
            alert("Please Select Group!");
            return false;
        }
    }

    function check_function() {
        var val1 = $('#function_name1').val();
        if (val1 == '') {
            alert("Please Enter Function Name!");
            return false;
        }
    }

    function check_child_function() {
        var val2 = $('#function_name2').val();
        if (val2 == '') {
            alert("Please Enter Function Name!");
            return false;
        }
    }

    function setName(module_name, controller, id) {
        name = module_name;
        controller = controller;
        $(".module_value").val(name);
        $(".controller_value").val(controller);
        if (id) {
            $("#parent_id").val(id);
        }
    }
    $(document).ready(function() {
        $("input[type=checkbox]").on("change", function() {
            var checked = "";
            if ($(this).prop("checked") == true) {
                checked = "checked";
            }
            var checkboxes = $(this).parent().parent().find("li");
            checkboxes.each(function() {
                $(this).find("input[type=checkbox]").prop("checked", checked);
            });
        });
    });
    $(document).ready(function(){
        var updateOutput = function(e){
            var list = e.length ? e : $(e.target),
                    output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1
        })
            .on('change', updateOutput);
        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    });


    $(document).ready(function() {
        $('#checkAll').click(function () {
            $('input:checkbox').prop('checked', this.checked);
        });
    });

    function expandCollapse() {
        if($(".submenu").css('display') == 'none') {
            $("#expand-collapse").html("Collapse All");
            $(".submenu").show("fast");
        } else {
            $("#expand-collapse").html("Expand All");
            $(".submenu").hide("fast");
        }
    }
</script>