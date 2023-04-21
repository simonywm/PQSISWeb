﻿<script>
$(function() {
    $("#aMenuMaintenanceLinkUser").addClass("active");
    $("#aMenuMaintenanceLink").addClass("active");
    $("#aMenuMaintenanceLinkCommon").addClass("active");
});
</script>
<?php

$this->pageTitle = Yii::app()->name;
?>
<!doctype html>
<html lang="en">

<head>
    <style>
    body {
        overflow-x: hidden;
    }

    .overflow-x-hidden {
        /*   overflow-x: hidden; */
        border: 1px solid blue;
    }

    .is-hidden {
        opacity: 0;
        transition: transform 0.4s, opacity 0.2s;
    }

    .navbar-hide {
        pointer-events: none;
        opacity: 0;
    }

    .ui-autocomplete {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 3000;
        float: left;
        display: none;
        min-width: 160px;
        padding: 4px 0;
        margin: 0 0 10px 25px;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }

    .ui-menu-item>a.ui-corner-all {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
        text-decoration: none;
    }

    .ui-state-hover,
    .ui-state-active {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
    }

    .invalid {
        background-color: #2774ad69;
    }


    .required {
        border-color: #800000;
        border-width: 3px;
    }

    label {
        white-space: nowrap;
    }
    </style>
</head>

<div class="container">
    <div class="card border border-secondary">
        <form id="Form" onsubmit=>
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8">
                        <h3 id="title"> User </h3>
                    </div>
                    <div class="col-lg-4" style="text-align:right">


                        <button id="btnApply" name="btnApply" type="button"
                            class="btn btn-primary btnFormApply">Apply</button>
                        <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row" id="idDiv">
                    <div class="col-md-5">
                        <label>UserId <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-7">
                        <input id="txUserId" name="txUserId" type="text" class="form-control" placeholder="" value=""
                            readonly />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-5">
                        <label> User Name <span class="text-danger">*</span></label>

                    </div>
                    <div class="col-md-7">
                        <input id="txLoginId" name="txLoginId" type="text" class="form-control" placeholder="" value="">
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-5">
                        <label>Password <span class="text-danger">*</span></label>

                    </div>
                    <div class="col-md-7">
                        <input id="txPassword" name="txPassword" type="text" class="form-control" placeholder=""
                            value="">
                    </div>
                </div>
                <br />



                <div class="row">
                    <div class="col-lg-5" style="padding-right:0px"><label>Active? </label></div>
                    <div class="col-lg-7" style="padding-left:5px">
                        <select id="txActive" name="txActive" style="height:30px;width:100%">
                            <option value="Y"> Yes </option>
                            <option value="N"> No </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5" style="padding-right:0px"><label> Role </label></div>
                    <div class="col-lg-7" style="padding-left:5px">
                        <select id="txRoleId" name="txRoleId" style="height:30px;width:100%">
                            <option value="0"> User </option>
                            <option value="1"> Admin </option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>


</html>
<script>
$(document).ready(function() {

    <?php if( $this->viewbag['mode']=='update'){ ?>

    $("#btnApply").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxUpdateUser",
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info",
                        "New Data updated.", "",
                        function() {
                            location.reload();

                        });

                } else {
                    // error message
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson
                        .retMessage);
                }
            }
        }).fail(function(event, jqXHR, settings, thrownError) {
            if (event.status != 440) {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
            }
        }).always(function(data) {
            $("#loading-modal").modal("hide");
            $(".btnFormApply").attr("disabled", false);
        });
    });

    $("#idDiv").attr('hidden', false);
    $("#txUserId").val("<?php echo $this->viewbag['user']['userId']?>");
    $("#txLoginId").val("<?php echo $this->viewbag['user']['loginId']?>");
    $("#txPassword").val("<?php echo $this->viewbag['user']['password']?>");
    $("#txActive").val("<?php echo $this->viewbag['user']['active']?>");
    $("#txRoleId").val("<?php echo $this->viewbag['user']['roleId']?>");
    $("#txLoginId").attr("readonly", true);
    $("#txLoginId").attr("disabled", true);

    <?php }else{ ?> //else

    $("#btnApply").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxInsertUser",
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info",
                        "New Data inserted.", "",
                        function() {
                            location.reload();
                        });

                } else {
                    // error message
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson
                        .retMessage);
                }
            }
        }).fail(function(event, jqXHR, settings, thrownError) {
            if (event.status != 440) {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
            }
        }).always(function(data) {
            $("#loading-modal").modal("hide");
            $(".btnFormApply").attr("disabled", false);
        });
    });

    $("#idDiv").attr('hidden', true);
    <?php } ?>

    function validateInput() {
        //  if ($("#txCaseNo").val() == "") {
        //  showError("<i class=\"fas fa-times-circle\"></i> ", "Error", "Case No can not be blank");
        //      return false;
        //  }
        $("#Form input ").each(function(index, value) {
            $(this).removeClass("invalid");
        });
        $("#Form select ").each(function(index, value) {
            $(this).removeClass("invalid");
        });
        var errorMessage = "";
        var i = 1;


        if ($("#txLoginId").val() == "") {
            if (errorMessage == "")
                $("#txLoginId").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "User Name can not be blank <br/>";
            i = i + 1;
            $("#txUserDept").addClass("invalid");
        }
        if ($("#txPassword").val() == "") {
            if (errorMessage == "")
                $("#txPassword").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "User Password can not be blank <br/>";
            i = i + 1;
            $("#txUserDept").addClass("invalid");
        }
        if ($("#txActive").val() == "") {
            if (errorMessage == "")
                $("#txActive").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Active can not be blank <br/>";
            i = i + 1;
            $("#txActive").addClass("invalid");
        }
        if (errorMessage == "") {
            return true;
        } else {
            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
            return false;
        }
    }
    $("button[name='btnCancel']").unbind().bind("click", function() {

        $("#modifyModal").modal("hide");
        $("#modalBody").html("");
    });

    /* $("#btnUserCal").unbind().bind("click", function () {
         $("#loading-modal").modal("show");
         $(this).attr("disabled", true);


         $.ajax(
             {
                 url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxGetCalWorkingDate",
                 type: "POST",
                 cache: false,
                 data: $("#Form").serializeArray(),
                 success: function (data) {
                     console.log(data);
                     var retJson = JSON.parse(data);

                     if (retJson.status == "OK") {
                         // display message
                         alert(retJson.Date);

                     }
                     else {
                         // error message
                         showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson.retMessage);
                     }
                 }
             }).fail(function (event, jqXHR, settings, thrownError) {
                 if (event.status != 440) {
                     showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
                 }
             }).always(function (data) {
                 $("#loading-modal").modal("hide");
                 $(".btnFormApply").attr("disabled", false);
             });
     }); */

});
</script>