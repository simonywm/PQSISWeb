<script>
$(function() {
    $("#aMenuFunctionLinkIR").addClass("active");
    $("#aMenuFunctionLink").addClass("active");
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
    </style>
</head>

<body class="" style="">
    <div class="container" style="margin-top:56px;">

        <div class="row border border-secondary p-4">
            <div class="col-md-12" style="text-align:center">
                Voltage DOCX Upload
            </div>
            <div class="col-md-2">
                <br />
                <b> Report Path: <?php echo dirname(dirname(__dir__)) . '/upload/voltage/waiting/' ?> </b>
                <button id="uploadBtn" name="uploadBtn" type="button" class="btn btn-primary">Upload</button>
            </div>
        </div>
        <div class="row border border-secondary p-4" id="resultDiv">
        </div>
    </div>

    <div id="modifyModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content" style="width:100%;height:auto;">
                <div id="modalBody" class="modal-body">
                </div>

            </div>
        </div>
    </div>

    <script>
    $(function() {



        $("#uploadBtn").unbind().bind("click", function() {
            $("#loading-modal").modal("show");
            $(this).attr("disabled", true);
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Function/VoltageReportUpload",
                type: "POST",
                cache: false,
                data: '',
                success: function(data) {
                    console.log(data);
                    var retJson = JSON.parse(data);

                    if (retJson.status == "OK") {
                        // display message
                        $("#resultDiv").html(retJson.resultMessage);

                    } else {
                        // error message
                        $("#resultDiv").html(retJson.resultMessage);
                    }
                }
            }).fail(function(event, jqXHR, settings, thrownError) {
                if (event.status != 440) {
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event
                        .resultMessage);
                }
            }).always(function(data) {
                $("#loading-modal").modal("hide");
                $("#uploadBtn").attr("disabled", false);
            });
        });


    });
    </script>