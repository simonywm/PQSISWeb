<script>
$(function() {
    $("#aMenuMaintenanceLinkCF").addClass("active");
    $("#aMenuMaintenanceLink").addClass("active");
    $("#aMenuMaintenanceLinkCommon").addClass("active");
});
</script>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
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

        <div class="row">
            <div class="col-12">
                <!--<button id="newBtn" name="newBtn" <?php echo $this->viewbag['disabled'] ?> type="button"  class="btn btn-primary" >New</button>-->
            </div>
        </div>
        <br />
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <table id="Table" class="display nowrap" width="100%">
                <thead>
                    <tr>

                        <th width="5%">ID </th>
                        <th width="10%">Config Name </th>
                        <th width="5%">Config Value </th>
                        <th width="50%">Description </th>
                        <th width="10%"> </th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->viewbag['configList'] as $config) { ?>
                    <tr>
                        <td> <?php echo $config['configId'] ?> </td>
                        <td> <?php echo $config['configName'] ?> </td>
                        <td> <?php echo $config['configValue'] ?> </td>
                        <td> <?php echo $config['configDescription'] ?> </td>
                        <td> <button id="modifyBtn" name="modifyBtn" configId="<?php echo $config['configId'] ?>"
                                <?php echo $this->viewbag['disabled'] ?> type="button"
                                class="btn btn-primary">Modify</button> </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
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



        table = $("#Table").DataTable({
            "scrollX": true,
            deferRender: true,
            "scroller": true,
            "stateSave": true,
            "columnDefs": [{
                "targets": 4,
                "orderable": false
            }]
        });
        rebindAllBtn();
    });


    function rebindAllBtn() {

        $("button[name='newBtn']").unbind().bind("click", function() {
            $("#divLoadingModal").modal("show");
            $("#modalBody").html("");

            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/GetConfigForNew",
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                cache: false,
                success: function(data) {
                    $("#modalBody").html(data);
                    $("#modifyModal").modal("show");
                }
            }).fail(function(event, jqXHR, settings, thrownError) {
                if (event.status != 440) {
                    alert("error in opening Modal")
                }

            }).always(function(data) {
                $("#divLoadingModal").modal("hide");
            });
        });
        $("button[name='modifyBtn']").unbind().bind("click", function() {

            $("#divLoadingModal").modal("show");
            $("#modalBody").html("");

            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/GetConfigForUpdate&configId=" +
                    $(this).attr("configId"),
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                cache: false,
                success: function(data) {
                    $("#modalBody").html(data);
                    $("#modifyModal").modal("show");
                }
            }).fail(function(event, jqXHR, settings, thrownError) {
                if (event.status != 440) {
                    alert("error in opening Modal")
                    alert(event.responseText);
                }

            }).always(function(data) {
                $("#divLoadingModal").modal("hide");
            });
        });

    }
    </script>