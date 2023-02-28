<?php
/* @var $this PlanningAheadController */
$this->pageTitle = Yii::app()->name;
?>
<style>
    body {
        overflow-x: hidden;
    }

    .invalid {
        background-color: #2774ad69;
    }
</style>

<div class="container">
    <div class="pt-2" style="text-align:center;">
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#searchDiv"
                aria-expanded="false" aria-controls="searchDiv">
            Open Search box
        </button>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-9">
                    <h3>Export Planning Ahead Project Summary by Main Project Type</h3>
                </div>
                <div class="col-lg-3" style="text-align:right">
                    <button id="searchBtn" type="button" class="btn btn-success">Search</button>
                </div>
            </div>
            <div class="card-body collapse" id="searchDiv">
                <div class="form-group row">
                    <div class="input-group col-6">
                        <div class="input-group-prepend"><span class="input-group-text">Creation Date (From): </span></div>
                        <input id="searchCreationDateFrom" name="searchCreationDateFrom" type="text" placeholder="YYYY-mm-dd"
                               class="form-control" autocomplete="off">
                    </div>
                    <div class="input-group col-6">
                        <div class="input-group-prepend"><span class="input-group-text">Creation Date (To): </span></div>
                        <input id="searchCreationDateTo" name="searchCreationDateTo" type="text" placeholder="YYYY-mm-dd"
                               class="form-control" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-12">
            <table id="Table" width="100%" style="white-space:nowrap;" class="display">
                <thead>
                <tr>
                    <td>Date Range</td>
                    <td>Type of Project</td>
                    <td>Key Infrastructure Project</td>
                    <td>No. of New Supply Application</td>
                    <td>No. of PQ Planning Ahead Meeting Attended</td>
                    <td>No. of PQ Walk Invitation Sent</td>
                    <td>No. of PQ Site Walk Conducted</td>
                    <td>No. of Project Commissioned without Submitting PQ Reply Slip/PQ Meeting</td>
                    <td>No. of Project Commissioned with Submitting PQ Reply Slip/PQ Meeting</td>
                    <td>No. of PQ Site Walk with Passed Result (score >= 50%)</td>
                    <td>No. of PQ Site Walk with Passed Result (score < 50%)</td>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#searchCreationDateFrom").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#searchCreationDateTo").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        table = $("#Table").DataTable({
            "serverSide": true,
            "autoWidth": true,
            "processing": true,
            "scrollX": true,
            "fixedHeader": true,
            "stateSave": false,
            "dom": 'Blipfrtip',
            "ordering": false,
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    format: {
                        body: function(data, row, column, node) {
                            return data;
                        }
                    }
                }

            }, ],
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxGetExportProjectSummaryByMainProjectType",
                "type": "POST",
                "contentType": 'application/json; charset=utf-8',
                "data": function(data) {
                    console.log(data);
                    return JSON.stringify(constructPostParam(data));
                }
            },
            "order": [
                [1, "desc"]
            ],
            "bLengthChange" : false,
            "bInfo":false,
            "bPaginate": false,
            "filter": false,
            "columns": [
                {
                    "data": "created_time",
                    "width": "20%"
                },
                {
                    "data": "project_type_name",
                    "width": "20%"
                },
                {
                    "data": "key_infra",
                    "width": "10%"
                },
                {
                    "data": "new_application_count",
                    "width": "25%"
                },
                {
                    "data": "meeting_attended_count",
                    "width": "25%"
                },
                {
                    "data": "pq_walk_invitation_sent_count",
                    "width": "25%"
                },
                {
                    "data": "pq_site_walk_conducted_count",
                    "width": "25%"
                },
                {
                    "data": "pq_commission_without_reply_slip_count",
                    "width": "25%"
                },
                {
                    "data": "pq_commission_with_reply_slip_count",
                    "width": "25%"
                },
                {
                    "data": "pq_site_walk_pass_count",
                    "width": "25%"
                },
                {
                    "data": "pq_site_walk_fail_count",
                    "width": "25%"
                },
            ],
            "drawCallback": function(settings) {
                // bind all button
                rebindAllBtn();
            },
            "columnDefs": [{
                "targets": 0,
                "orderable": true
            }],
        });

        $("#searchBtn").unbind().bind("click", function() {
            let searchCreationDateFromStr = document.getElementById('searchCreationDateFrom').value;
            let searchCreationDateToStr = document.getElementById('searchCreationDateTo').value;

            if ((searchCreationDateFromStr != null) && (searchCreationDateToStr != null)) {
                let searchCreationDateFromDt = Date.parse(searchCreationDateFromStr);
                let searchCreationDateToDt = Date.parse(searchCreationDateToStr);

                if (searchCreationDateToDt < searchCreationDateFromDt) {
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", "Creation Date (From) must be earlier that Creation From (To)!");
                    return;
                }
            }
            table.ajax.reload(null, false);
        });

        function constructPostParam(d) {
            let searchParamStr = "{";
            if (($("#searchCreationDateFrom").val() != null) && ($("#searchCreationDateFrom").val().trim() != "")) {
                searchParamStr += "\"creationDateFrom\":" + "\"" + $("#searchCreationDateFrom").val() + "\"" + ",";
            } else {
                searchParamStr += "\"creationDateFrom\":" + "\"" + "1970-01-01" + "\"" + ",";
            }
            if (($("#searchCreationDateTo").val() != null) && ($("#searchCreationDateTo").val().trim() != "")) {
                searchParamStr += "\"creationDateTo\":" + "\"" + $("#searchCreationDateTo").val() + "\"" + ",";
            } else {
                searchParamStr += "\"creationDateTo\":" + "\"" + "2099-12-31" + "\"" + ",";
            }
            if (searchParamStr != "{") {
                searchParamStr = searchParamStr.substring(0, searchParamStr.length - 1);
            }
            searchParamStr += "}";
            d.searchParam = searchParamStr;
            return d;
        }

        function rebindAllBtn() {}

    });
</script>
