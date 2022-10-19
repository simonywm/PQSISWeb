<script>
$(function() {
    $("#aMenuMaintenanceLinkRQ").addClass("active");
    $("#aMenuMaintenanceLink").addClass("active");
    $("#aMenuMaintenanceLinkCaseForm").addClass("active");
});
</script>
<?php
/* @var $this SiteController */

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

        <div class="row">
            <div class="col-md-3">
                ID
            </div>
            <div class="col-md-9">
                <input id="requestedByIdSearchTxt" name="requestedByIdSearchTxt" type="number" class="form-control"
                    placeholder="Requested By ID" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-3">
                Requested By
            </div>
            <div class="col-md-9">
                <input id="requestedByNameSearchTxt" name="requestedByNameSearchTxt" type="text" class="form-control"
                    placeholder="Requested By" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-3">
                CLP Person Department
            </div>
            <div class="col-md-9">
                <select class="form-control" id="clpPersonDepartmentSearchSel" name="clpPersonDepartmentSearchSel"
                    style="">
                    <option value="">---</option>
                    <?php $requestedByDepartment = $this->viewbag['requestedByDept']?>
                    <?php foreach ($requestedByDepartment as $requestedBy) {?>
                    <option value="<?php echo $requestedBy ?>"><?php echo $requestedBy ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-3">
                Active
            </div>
            <div class="col-md-9">
                <select id="activeSearchSel" name="activeSearchSel" class="form-control">
                    <option value=""> </option>
                    <option value="Y"> Yes </option>
                    <option value="N"> No </option>
                </select>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-12">
                <button id="searchBtn" type="button" class="btn btn-primary">Search</button>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-12">
                <button id="newBtn" name="newBtn" <?php echo $this->viewbag['disabled'] ?> type="button"
                    class="btn btn-primary">New</button>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-12">
            <table id="requestedByTable" width="100%" class="display no-wrap">
                <thead>
                    <tr>

                        <td width="10%">ID </td>
                        <td width="10%">Requested By </td>
                        <td width="10%">CLP Person Department </td>
                        <td width="10%">Active</td>
                        <td width="10%"> </td>
                        <td width="20%">Created By</td>
                        <td width="20%">Created Date</td>
                        <td width="20%">Last Updated By</td>
                        <td width="20%">Last Updated Time</td>

                    </tr>
                </thead>
                <tbody></tbody>
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


        var availableTags = [
            <?php foreach ($this->viewbag['requestedByAutoCompleteList'] as $requestedBy) {?> "<?php echo $requestedBy ?>",
            <?php }?>
        ];

        $("#requestedByNameSearchTxt").autocomplete({

            source: function(request, response) {
                var results = $.ui.autocomplete.filter(availableTags, request.term);
                response(results.slice(0, 10));
            }

        });

        table = $("#requestedByTable").DataTable({
            "serverSide": true,
            "processing": true,
            "scrollX": true,
            "fixedHeader": true,
            "stateSave": false,
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxGetRequestedByTable",
                "type": "POST",
                "contentType": 'application/json; charset=utf-8',
                "data": function(data) {
                    return JSON.stringify(constructPostParam(data));
                }
            },

            "order": [
                [0, "desc"]
            ],
            "aLengthMenu": [
                [100, 200, 500, 1000, 9000000],
                [100, 200, 500, 1000, 'All'],
            ],
            "filter": false,
            "sPaginationType": "full_numbers",
            "columns": [

                {
                    "data": "requestedById",
                    "width": "10%"
                },
                {
                    "data": "requestedByName",
                    "width": "20%"
                },
                {
                    "data": "requestedByDept",
                    "width": "20%"
                },

                {
                    "data": "active",
                    "width": "10%"
                },
                {
                    "data": "requestedById",
                    render: function(data, type, row) {
                        var btnHtml = "<button id='modifyBtn-" + row.requestedById +
                            "' name='modifyBtn' <?php echo $this->viewbag['disabled'] ?> class='btn btn-primary'  requestedById='" +
                            row.requestedById + "' > Modify</button> ";
                        return btnHtml;
                    },
                    "width": "20%"
                },
                {
                    "data": "createdBy"
                },
                {
                    "data": "createdTime"
                },
                {
                    "data": "lastUpdatedBy"
                },
                {
                    "data": "lastUpdatedTime"
                }


            ],
            "drawCallback": function(settings) {
                // bind all button
                rebindAllBtn();
            },
            "columnDefs": [{
                "targets": 4,
                "orderable": false
            }]
        });

        $("#searchBtn").unbind().bind("click", function() {
            table.ajax.reload(null, false);
        });
    });

    function constructPostParam(d) {
        var searchParamStr = "{";
        if ($("#requestedByIdSearchTxt").val() != null && $("#requestedByIdSearchTxt").val() != "") {
            searchParamStr += "\"requestedById\":" + "\"" + $("#requestedByIdSearchTxt").val() + "\"" + ",";
        }

        if ($("#requestedByNameSearchTxt").val() != null && $("#requestedByNameSearchTxt").val() != "") {
            searchParamStr += "\"requestedByName\":" + "\"" + $("#requestedByNameSearchTxt").val() + "\"" + ",";
        }
        if ($("#clpPersonDepartmentSearchSel").val() != null && $("#clpPersonDepartmentSearchSel").val() != "") {
            searchParamStr += "\"requestedByDept\":" + "\"" + $("#clpPersonDepartmentSearchSel").val() + "\"" + ",";
        }
        if ($("#activeSearchSel").val() != null && $("#activeSearchSel").val() != "") {
            searchParamStr += "\"active\":" + "\"" + $("#activeSearchSel").val() + "\"" + ",";
        }

        if (searchParamStr != "{") {
            searchParamStr = searchParamStr.substr(0, searchParamStr.length - 1);
        }

        searchParamStr += "}";

        d.searchParam = searchParamStr;

        return d;
    }

    function rebindAllBtn() {


        /* $("button[name='newBtn']").unbind().bind("click", function () {
             $("#divLoadingModal").modal("show");
             $("#caseFormBody").html("");
             $.ajax({

                 url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetCaseFormForNew",
                 type: "POST",
                 cache: false,
                 data: { loginId: $("#txLoginId").val(), password: $("#txPassword").val()}
             }).done(function( data ) {

                 console.log(data);
                 var retJson = JSON.parse(data);

                 console.log(retJson);

                 if (retJson.status == "OK")
                 {
                     window.location.href = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/Landing";
                 }
                 else
                     $("#msgFont").html(retJson.retMessage);
             }).fail(function (xhr, textStatus, errorThrown) {
                 console.log(xhr);
                 $("body").html(xhr.responseText);
             });
             */
        $("button[name='newBtn']").unbind().bind("click", function() {
            $("#divLoadingModal").modal("show");
            $("#modalBody").html("");

            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/GetRequestedByForNew",
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
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/GetRequestedByForUpdate&requestedById=" +
                    $(this).attr("requestedById"),
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