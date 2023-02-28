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
                    <h3>Export Planning Ahead Project Response Rate from Consultant</h3>
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
                    <td>Consultant’s Company Name</td>
                    <td>Consultant’s Response Rate on Reply Slip</td>
                    <td>Consultant’s Response Rate on Meeting</td>
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
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3],
                    format: {
                        body: function(data, row, column, node) {
                            return data;
                        }
                    }
                }
            }, ],
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxGetExportResponseRateFromConsultant",
                "type": "POST",
                "contentType": 'application/json; charset=utf-8',
                "data": function(data) {
                    console.log(data);
                    return JSON.stringify(constructPostParam(data));
                }
            },
            "order": [
                [0, "desc"]
            ],
            "bLengthChange" : false,
            "bInfo":false,
            "bPaginate": false,
            "filter": false,
            "columns": [
                {
                    "data": "created_time",
                    "width": "25%"
                },
                {
                    "data": "consultant_company",
                    "width": "25%"
                },
                {
                    "data": "response_rate_on_reply_slip",
                    "width": "25%"
                },
                {
                    "data": "response_rate_on_meeting",
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
