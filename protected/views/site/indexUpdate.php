<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'].":" .$_SERVER['SERVER_PORT'];
$url .= '/PQSIS_Deployment';
?>
<html>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />




<div class="row" id="loginDiv">
    <div class="col-md-4"></div>
    <div class="col-md-4" style="text-align: center;padding-bottom:0px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>System update required</b></h3>
                    </div>
                    <div class="panel-body">
                        <div align="left">
                            <font id="msgFont" color="red"></font>
                        </div>
                        <h4>You can go to localhost\PQSIS_Deployment for the update or click UPDATE button below</h4>
                        <div id="loginButtonDiv" class="col-md-12">
                            <button id="updateBtn" type="button" class="btn btn-primary"
                                style="margin-top:10px;width:100%;align:right;"
                                onclick='window.location="<?php echo $url?>"'>Update</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</html>

<script>
$(function() {

    $("#loginBtn").unbind().bind("click", function() {
        if ($("#txLoginId").val() == "") {
            $("#msgFont").html("Please input Password");
            return;
        }
        if ($("#txPassword").val() == "") {
            $("#msgFont").html("Please input Password");
            return;
        }
        if ($("#txEditable:checked").val() == "on") {
            check = "on";
        } else {
            check = "off"
        }
        $.ajax({

            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Site/AjaxLogin",
            type: "POST",
            cache: false,
            data: {
                loginId: $("#txLoginId").val(),
                password: $("#txPassword").val(),
                editable: check
            }
        }).done(function(data) {

            console.log(data);
            var retJson = JSON.parse(data);

            console.log(retJson);

            if (retJson.status == "OK") {
                window.location.href =
                    "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch";
            } else
                $("#msgFont").html(retJson.retMessage);
        }).fail(function(xhr, textStatus, errorThrown) {
            console.log(xhr);
            $("body").html(xhr.responseText);
        });
    });

    $("#txLoginId").focus();
});
</script>