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
                    <h3>Export Raw Data from Planning Ahead Table</h3>
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
                    <td>planning_ahead_id</td>
                    <td>project_title</td>
                    <td>scheme_no</td>
                    <td>region_id</td>
                    <td>condition_letter_filename</td>
                    <td>project_type_id</td>
                    <td>commission_date</td>
                    <td>key_infra</td>
                    <td>temp_project</td>
                    <td>first_region_staff_name</td>
                    <td>first_region_staff_phone</td>
                    <td>first_region_staff_email</td>
                    <td>second_region_staff_name</td>
                    <td>second_region_staff_phone</td>
                    <td>second_region_staff_email</td>
                    <td>third_region_staff_name</td>
                    <td>third_region_staff_phone</td>
                    <td>third_region_staff_email</td>
                    <td>first_consultant_title</td>
                    <td>first_consultant_surname</td>
                    <td>first_consultant_other_name</td>
                    <td>first_consultant_company</td>
                    <td>first_consultant_phone</td>
                    <td>first_consultant_email</td>
                    <td>second_consultant_title</td>
                    <td>second_consultant_surname</td>
                    <td>second_consultant_other_name</td>
                    <td>second_consultant_company</td>
                    <td>second_consultant_phone</td>
                    <td>third_consultant_title</td>
                    <td>third_consultant_surname</td>
                    <td>third_consultant_other_name</td>
                    <td>third_consultant_company</td>
                    <td>third_consultant_phone</td>
                    <td>third_consultant_email</td>
                    <td>first_project_owner_title</td>
                    <td>first_project_owner_surname</td>
                    <td>first_project_owner_other_name</td>
                    <td>first_project_owner_company</td>
                    <td>first_project_owner_phone</td>
                    <td>first_project_owner_email</td>
                    <td>second_project_owner_title</td>
                    <td>second_project_owner_surname</td>
                    <td>second_project_owner_other_name</td>
                    <td>second_project_owner_company</td>
                    <td>second_project_owner_phone</td>
                    <td>second_project_owner_email</td>
                    <td>third_project_owner_title</td>
                    <td>third_project_owner_surname</td>
                    <td>third_project_owner_other_name</td>
                    <td>third_project_owner_company</td>
                    <td>third_project_owner_phone</td>
                    <td>third_project_owner_email</td>
                    <td>stand_letter_issue_date</td>
                    <td>stand_letter_fax_ref_no</td>
                    <td>stand_letter_edms_link</td>
                    <td>stand_letter_letter_loc</td>
                    <td>meeting_first_prefer_meeting_date</td>
                    <td>meeting_second_prefer_meeting_date</td>
                    <td>meeting_actual_meeting_date</td>
                    <td>meeting_rej_reason</td>
                    <td>meeting_consent_consultant</td>
                    <td>meeting_remark</td>
                    <td>meeting_reply_slip_id</td>
                    <td>first_invitation_letter_issue_date</td>
                    <td>first_invitation_letter_fax_ref_no</td>
                    <td>first_invitation_letter_edms_link</td>
                    <td>first_invitation_letter_accept</td>
                    <td>first_invitation_letter_walk_date</td>
                    <td>second_invitation_letter_issue_date</td>
                    <td>second_invitation_letter_fax_ref_no</td>
                    <td>second_invitation_letter_edms_link</td>
                    <td>second_invitation_letter_accept</td>
                    <td>second_invitation_letter_walk_date</td>
                    <td>third_invitation_letter_issue_date</td>
                    <td>third_invitation_letter_fax_ref_no</td>
                    <td>third_invitation_letter_edms_link</td>
                    <td>third_invitation_letter_accept</td>
                    <td>third_invitation_letter_walk_date</td>
                    <td>forth_invitation_letter_issue_date</td>
                    <td>forth_invitation_letter_fax_ref_no</td>
                    <td>forth_invitation_letter_edms_link</td>
                    <td>forth_invitation_letter_accept</td>
                    <td>forth_invitation_letter_walk_date</td>
                    <td>eva_report_id</td>
                    <td>re_eva_report_id</td>
                    <td>state</td>
                    <td>active</td>
                    <td>last_email_notification_time</td>
                    <td>created_by</td>
                    <td>created_time</td>
                    <td>last_updated_by</td>
                    <td>last_updated_time</td>
                    <td>meeting_consent_date_consultant</td>
                    <td>meeting_consent_date_project_owner</td>
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
                    21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41,
                    42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 51, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62,
                    63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83,
                    84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94],
                    format: {
                        body: function(data, row, column, node) {
                            return data;
                        }
                    }
                }
            }, ],
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxGetExportRawDataFromPlanningAheadTable",
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
                    "data": "planning_ahead_id",
                    "width": "25%"
                },
                {
                    "data": "project_title",
                    "width": "25%"
                },
                {
                    "data": "scheme_no",
                    "width": "25%"
                },
                {
                    "data": "region_id",
                    "width": "25%"
                },
                {
                    "data": "condition_letter_filename",
                    "width": "25%"
                },
                {
                    "data": "project_type_id",
                    "width": "25%"
                },
                {
                    "data": "commission_date",
                    "width": "25%"
                },
                {
                    "data": "key_infra",
                    "width": "25%"
                },
                {
                    "data": "temp_project",
                    "width": "25%"
                },
                {
                    "data": "first_region_staff_name",
                    "width": "25%"
                },
                {
                    "data": "first_region_staff_phone",
                    "width": "25%"
                },
                {
                    "data": "first_region_staff_email",
                    "width": "25%"
                },
                {
                    "data": "second_region_staff_name",
                    "width": "25%"
                },
                {
                    "data": "second_region_staff_phone",
                    "width": "25%"
                },
                {
                    "data": "second_region_staff_email",
                    "width": "25%"
                },
                {
                    "data": "third_region_staff_name",
                    "width": "25%"
                },
                {
                    "data": "third_region_staff_phone",
                    "width": "25%"
                },
                {
                    "data": "third_region_staff_email",
                    "width": "25%"
                },
                {
                    "data": "first_consultant_title",
                    "width": "25%"
                },
                {
                    "data": "first_consultant_surname",
                    "width": "25%"
                },
                {
                    "data": "first_consultant_other_name",
                    "width": "25%"
                },
                {
                    "data": "first_consultant_company",
                    "width": "25%"
                },
                {
                    "data": "first_consultant_phone",
                    "width": "25%"
                },
                {
                    "data": "first_consultant_email",
                    "width": "25%"
                },
                {
                    "data": "second_consultant_title",
                    "width": "25%"
                },
                {
                    "data": "second_consultant_surname",
                    "width": "25%"
                },
                {
                    "data": "second_consultant_other_name",
                    "width": "25%"
                },
                {
                    "data": "second_consultant_company",
                    "width": "25%"
                },
                {
                    "data": "second_consultant_phone",
                    "width": "25%"
                },
                {
                    "data": "third_consultant_title",
                    "width": "25%"
                },
                {
                    "data": "third_consultant_surname",
                    "width": "25%"
                },
                {
                    "data": "third_consultant_other_name",
                    "width": "25%"
                },
                {
                    "data": "third_consultant_company",
                    "width": "25%"
                },
                {
                    "data": "third_consultant_phone",
                    "width": "25%"
                },
                {
                    "data": "third_consultant_email",
                    "width": "25%"
                },
                {
                    "data": "first_project_owner_title",
                    "width": "25%"
                },
                {
                    "data": "first_project_owner_surname",
                    "width": "25%"
                },
                {
                    "data": "first_project_owner_other_name",
                    "width": "25%"
                },
                {
                    "data": "first_project_owner_company",
                    "width": "25%"
                },
                {
                    "data": "first_project_owner_phone",
                    "width": "25%"
                },
                {
                    "data": "first_project_owner_email",
                    "width": "25%"
                },
                {
                    "data": "second_project_owner_title",
                    "width": "25%"
                },
                {
                    "data": "second_project_owner_surname",
                    "width": "25%"
                },
                {
                    "data": "second_project_owner_other_name",
                    "width": "25%"
                },
                {
                    "data": "second_project_owner_company",
                    "width": "25%"
                },
                {
                    "data": "second_project_owner_phone",
                    "width": "25%"
                },
                {
                    "data": "second_project_owner_email",
                    "width": "25%"
                },
                {
                    "data": "third_project_owner_title",
                    "width": "25%"
                },
                {
                    "data": "third_project_owner_surname",
                    "width": "25%"
                },
                {
                    "data": "third_project_owner_other_name",
                    "width": "25%"
                },
                {
                    "data": "third_project_owner_company",
                    "width": "25%"
                },
                {
                    "data": "third_project_owner_phone",
                    "width": "25%"
                },
                {
                    "data": "third_project_owner_email",
                    "width": "25%"
                },
                {
                    "data": "stand_letter_issue_date",
                    "width": "25%"
                },
                {
                    "data": "stand_letter_fax_ref_no",
                    "width": "25%"
                },
                {
                    "data": "stand_letter_edms_link",
                    "width": "25%"
                },
                {
                    "data": "stand_letter_letter_loc",
                    "width": "25%"
                },
                {
                    "data": "meeting_first_prefer_meeting_date",
                    "width": "25%"
                },
                {
                    "data": "meeting_second_prefer_meeting_date",
                    "width": "25%"
                },
                {
                    "data": "meeting_actual_meeting_date",
                    "width": "25%"
                },
                {
                    "data": "meeting_rej_reason",
                    "width": "25%"
                },
                {
                    "data": "meeting_consent_consultant",
                    "width": "25%"
                },
                {
                    "data": "meeting_remark",
                    "width": "25%"
                },
                {
                    "data": "meeting_reply_slip_id",
                    "width": "25%"
                },
                {
                    "data": "first_invitation_letter_issue_date",
                    "width": "25%"
                },
                {
                    "data": "first_invitation_letter_fax_ref_no",
                    "width": "25%"
                },
                {
                    "data": "first_invitation_letter_edms_link",
                    "width": "25%"
                },
                {
                    "data": "first_invitation_letter_accept",
                    "width": "25%"
                },
                {
                    "data": "first_invitation_letter_walk_date",
                    "width": "25%"
                },
                {
                    "data": "second_invitation_letter_issue_date",
                    "width": "25%"
                },
                {
                    "data": "second_invitation_letter_fax_ref_no",
                    "width": "25%"
                },
                {
                    "data": "second_invitation_letter_edms_link",
                    "width": "25%"
                },
                {
                    "data": "second_invitation_letter_accept",
                    "width": "25%"
                },
                {
                    "data": "second_invitation_letter_walk_date",
                    "width": "25%"
                },
                {
                    "data": "third_invitation_letter_issue_date",
                    "width": "25%"
                },
                {
                    "data": "third_invitation_letter_fax_ref_no",
                    "width": "25%"
                },
                {
                    "data": "third_invitation_letter_edms_link",
                    "width": "25%"
                },
                {
                    "data": "third_invitation_letter_accept",
                    "width": "25%"
                },
                {
                    "data": "third_invitation_letter_walk_date",
                    "width": "25%"
                },
                {
                    "data": "forth_invitation_letter_issue_date",
                    "width": "25%"
                },
                {
                    "data": "forth_invitation_letter_fax_ref_no",
                    "width": "25%"
                },
                {
                    "data": "forth_invitation_letter_edms_link",
                    "width": "25%"
                },
                {
                    "data": "forth_invitation_letter_accept",
                    "width": "25%"
                },
                {
                    "data": "forth_invitation_letter_walk_date",
                    "width": "25%"
                },
                {
                    "data": "eva_report_id",
                    "width": "25%"
                },
                {
                    "data": "re_eva_report_id",
                    "width": "25%"
                },
                {
                    "data": "state",
                    "width": "25%"
                },
                {
                    "data": "active",
                    "width": "25%"
                },
                {
                    "data": "last_email_notification_time",
                    "width": "25%"
                },
                {
                    "data": "created_by",
                    "width": "25%"
                },
                {
                    "data": "created_time",
                    "width": "25%"
                },
                {
                    "data": "last_updated_by",
                    "width": "25%"
                },
                {
                    "data": "last_updated_time",
                    "width": "25%"
                },
                {
                    "data": "meeting_consent_date_consultant",
                    "width": "25%"
                },
                {
                    "data": "meeting_consent_date_project_owner",
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
