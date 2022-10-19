<script>
$(function() {
    $("#aMenuMaintenanceLinkRQ").addClass("active");
    $("#aMenuMaintenanceLink").addClass("active");
    $("#aMenuMaintenanceLinkCaseForm").addClass("active");
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
                        <h3>Requested By New</h3>
                    </div>
                    <div class="col-lg-4" style="text-align:right">

                        <button id="btnApply" name="btnApply" type="button"
                            class="btn btn-primary btnFormApply">Apply</button>
                        <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row" hidden>
                    <div class="col-md-5">
                        <label>Requested By Id <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-7">
                        <input id="txRequestedById" name="txRequestedById" type="text" class="form-control"
                            placeholder="" value="" readonly />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-5">
                        <label> Requested By <span class="text-danger">*</span></label>

                    </div>
                    <div class="col-md-7">
                        <input id="txRequestedByName" name="txRequestedByName" type="text" class="form-control"
                            placeholder="" value="">
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-5">
                        <label>CLP Person Department </label>

                    </div>
                    <div class="col-md-7">
                        <input id="txRequestedByDept" name="txRequestedByDept" type="text" class="form-control"
                            placeholder="" value="">
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
            </div>
        </form>

    </div>
</div>

</div>
</div>

</html>
<script>
$(document).ready(function() {

    var availableTags = [
        <?php foreach ($this->viewbag['requestedByAutoCompleteList'] as $requestedBy) {?> "<?php echo $requestedBy ?>",
        <?php }?>
    ];
    var availableTags2 = [
        <?php foreach ($this->viewbag['requestedByDept'] as $requestedBy) {?> "<?php echo $requestedBy ?>",
        <?php }?>
    ];
    $("#txRequestedByName").autocomplete({

        source: function(request, response) {
            var results = $.ui.autocomplete.filter(availableTags, request.term);
            response(results.slice(0, 10));
        }
    });
    $("#txRequestedByDept").autocomplete({

        source: function(request, response) {
            var results = $.ui.autocomplete.filter(availableTags2, request.term);
            response(results.slice(0, 10));
        }
    });



    $("#btnApply").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxInsertRequestedBy",
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info",
                        "New Data created.", "",
                        function() {
                            table.ajax.reload(null, false);
                            $("#modifyModal").modal("hide");
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

        if ($("#txRequestedByName").val() == "") {
            if (errorMessage == "")
                $("#txRequestedByName").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Requested By can not be blank <br/>";
            i = i + 1;
            $("#txRequestedByName").addClass("invalid");
        }
        if ($("#txRequestedByDept").val() == "") {
            if (errorMessage == "")
                $("#txRequestedByDept").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "CLP Person Department can not be blank <br/>";
            i = i + 1;
            $("#txRequestedByDept").addClass("invalid");
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



});
</script>