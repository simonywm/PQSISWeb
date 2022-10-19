<script>
$(function() {
    $("#aMenuMaintenanceLinkBG").addClass("active");
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
<br />

<div class="container">
    <div class="card border border-secondary">
        <form id="Form" onsubmit=>
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8">
                        <h3 id="title"> Budget </h3>
                        <label>Year&nbsp;:&nbsp; </label>
                        <select id="countYear" name="countYear">
                            <option value=""> ----- </option>
                            <?php foreach ($this->viewbag['countYearAvaliableForNew'] as $countYear) {?>
                            <option value="<?php echo $countYear["countYear"] ?>"><?php echo $countYear["countYear"] ?>
                            </option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-lg-4" style="text-align:right">


                        <button id="btnApply" name="btnApply" type="button"
                            class="btn btn-primary btnFormApply">Apply</button>
                        <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="card-body" id="card-body" style="max-height:70vh; overflow:scroll" hidden>
                <div class="table">
                    <table class="table table-bordered table-condensed" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td class="w-auto"><input class="w-auto form-control" type="text" readonly disabled>
                                </td>
                                <td class="w-auto"><input class="w-auto form-control" type="text" value="Unit Rate"
                                        readonly disabled></td>
                                <?php foreach ($this->viewbag['partyToBeChargedList'] as $partyToBeCharged) {?>
                                <td><input type="text" class="w-auto form-control"
                                        value="<?php echo $partyToBeCharged['partyToBeChargedName'] ?>" readonly
                                        disabled /></td>


                                <?php }?>
                            </tr>

                            <?php foreach ($this->viewbag['serviceTypeList'] as $serviceType) {?>
                            <tr>
                                <td>
                                    <input type="text" class=" form-control w-auto"
                                        value="<?php echo $serviceType['serviceTypeName'] ?>" readonly disabled />
                                </td>
                                <td>
                                    <div class="input-group mb-3 w-auto ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>

                                        <input type="text" min="0" class="form-control"
                                            name="unitRate[<?php echo $serviceType['serviceTypeId'] ?>]" value="0"
                                            readonly disabled>
                                    </div>
                                </td>
                                <?php foreach ($this->viewbag['partyToBeChargedList'] as $partyToBeCharged) {?>
                                <td>
                                    <div class="input-group mb-3 w-auto ">
                                        <div class="input-group-prepend">
                                        </div>

                                        <input type="number" min="0" step="1" class="form-control"
                                            name="budget[<?php echo $serviceType['serviceTypeId'] ?>][<?php echo $partyToBeCharged['partyToBeChargedId'] ?>]"
                                            value="0" />
                                    </div>
                                </td>
                                <?php }?>

                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>


</html>
<script>
$(document).ready(function() {


    <?php if ($this->viewbag['mode'] == 'update') {?>

    $("#btnApply").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxUpdateBudget",
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

    $('#countYear').find('option').remove().end().append(
        '<option value="<?php echo $this->viewbag['countYearEdit'] ?>"> <?php echo $this->viewbag['countYearEdit'] ?> </option>'
        );
    $("#countYear").val("<?php echo $this->viewbag['countYearEdit'] ?>");

    <?php foreach ($this->viewbag['costTypeList'] as $costType) {?>
    $("input[name='unitRate[<?php echo $costType['serviceTypeId'] ?>]'").val(
        "<?php echo $costType['unitCost'] ?>")
    <?php }?>

    <?php foreach ($this->viewbag['budgetList'] as $budget) {?>
    $("input[name='budget[<?php echo $budget['serviceTypeId'] ?>][<?php echo $budget['partyToBeChargedId'] ?>]'")
        .val("<?php echo $budget['budgetNumber'] ?>")
    <?php }?>

    $("#card-body").attr("hidden", false);

    <?php } else {?> //else

    $("#btnApply").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxInsertBudget",
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

    <?php }?>

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

        if ($("#countYear").val() == "") {
            if (errorMessage == "")
                $("#countYear").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Year can not be blank <br/>";
            i = i + 1;
            $("#countYear").addClass("invalid");
        }
        $("input[name^='unitRate'").each(function() {
            if ($(this).val() == "N/A" || $(this).val() == "") {
                errorMessage = errorMessage + "Error " + i + ": " +
                    "Unit Rate can not be blank or N/A <br/>";
                i = i + 1;
                $(this).addClass("invalid");
            };
        });
        $("input[name^='budget'").each(function() {
            if ($(this).val() == "N/A" || $(this).val() == "") {
                errorMessage = errorMessage + "Error " + i + ": " +
                    "Budget Number can not be blank or N/A <br/>";
                i = i + 1;
                $(this).addClass("invalid");
            };
        });
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


    $("#countYear").change(function() {
        $("input[name^='unitRate'").each(function() {
            $(this).val('N/A');
        });
        $countYear = $("#countYear").val();
        if ($countYear != "") {
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxGetCostTypeByYear&countYear=" +
                    $countYear,
                type: "POST",
                cache: false,
                data: $("#Form").serializeArray(),
                success: function(data) {
                    console.log(data);
                    var retJson = JSON.parse(data);
                    $.each(retJson, function(index, val) {
                        $("input[name='unitRate[" + val['serviceTypeId'] + "]'")
                            .val(val['unitCost'])
                        console.log('val=' + val['costTypeId']);
                    });
                    $("#btnApply").attr("disabled", false);
                    $("#card-body").attr("hidden", false);
                }
            }).fail(function(event, jqXHR, settings, thrownError) {
                if (event.status != 440) {
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", 'error');
                }
            }).always(function(data) {});
        } else {

            $("input[name^='unitRate'").each(function() {
                $(this).val('N/A');

            });
            $("#btnApply").attr("disabled", true);
            $("#card-body").attr("hidden", true);

        }
    });

});
</script>