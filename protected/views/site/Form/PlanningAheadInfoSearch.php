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

<div class="container" style="">
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
                    <h3>Planning Ahead Information Search</h3>
                </div>
                <div class="col-lg-3" style="text-align:right">
                    <button id="searchBtn" type="button" class="btn btn-success">Search</button>
                </div>
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
            <div class="form-group row">
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Commission Date (From): </span></div>
                    <input id="searchCommissionDateFrom" name="searchCommissionDateFrom" type="text" placeholder="YYYY-mm-dd"
                           class="form-control" autocomplete="off">
                </div>
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Commission Date (To): </span></div>
                    <input id="searchCommissionDateTo" name="searchCommissionDateTo" type="text" placeholder="YYYY-mm-dd"
                           class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Scheme No.: </span></div>
                    <input id="searchSchemeNo" name="searchSchemeNo" type="text" class="form-control"
                           autocomplete="off">
                </div>
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Project Title: </span></div>
                    <input id="searchProjectTitle" name="searchProjectTitle" type="text" class="form-control"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Main Type of Project: </span></div>
                    <select id="searchMainTypeOfProject" name="searchMainTypeOfProject" class="form-control" onchange="reloadTypeOfList()">
                        <option value="" selected>--- Any ---</option>
                        <?php foreach($this->viewbag['projectMainTypeList'] as $projectMainTypeList) { ?>
                            <option value="<?php echo $projectMainTypeList['projectTypeClass']?>">
                                <?php echo $projectMainTypeList['projectTypeClass']?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Type of Project: </span></div>
                    <select id="searchTypeOfProject" name="searchTypeOfProject" class="form-control">
                        <option value="0" selected>--- Any ---</option>
                        <?php foreach($this->viewbag['projectTypeList'] as $projectTypeList) { ?>
                            <option value="<?php echo $projectTypeList['projectTypeId']?>">
                                <?php echo $projectTypeList['projectTypeName']?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Consultant Name: </span></div>
                    <input id="searchConsultantName" name="searchConsultantName" type="text" class="form-control"
                           autocomplete="off">
                </div>
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Consultant Tel No.: </span></div>
                    <input id="searchConsultantPhone" name="searchConsultantPhone" type="text" class="form-control"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Owner Name: </span></div>
                    <input id="searchOwnerName" name="searchOwnerName" type="text" class="form-control"
                           autocomplete="off">
                </div>
                <div class="input-group col-6">
                    <div class="input-group-prepend"><span class="input-group-text">Owner Tel No.: </span></div>
                    <input id="searchOwnerPhone" name="searchOwnerPhone" type="text" class="form-control"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <div class="input-group col-12">
                    <div class="input-group-prepend"><span class="input-group-text">State: </span></div>
                    <select id="searchState" name="searchState" class="form-control">
                        <option value="" selected>--- Any ---</option>
                        <option value="INITIAL">INITIAL</option>
                        <option value="CLOSED_AS_TEMP_PROJ">CLOSED_AS_TEMP_PROJ</option>
                        <option value="WAITING_INITIAL_INFO">WAITING_INITIAL_INFO</option>
                        <option value="COMPLETED_INITIAL_INFO_BY_PQ">COMPLETED_INITIAL_INFO_BY_PQ</option>
                        <option value="WAITING_INITIAL_INFO_BY_REGION_STAFF">WAITING_INITIAL_INFO_BY_REGION_STAFF</option>
                        <option value="COMPLETED_INITIAL_INFO">COMPLETED_INITIAL_INFO</option>
                        <option value="WAITING_STANDARD_LETTER">WAITING_STANDARD_LETTER</option>
                        <option value="COMPLETED_STANDARD_LETTER">COMPLETED_STANDARD_LETTER</option>
                        <option value="WAITING_CONSULTANT_MEETING_INFO">WAITING_CONSULTANT_MEETING_INFO</option>
                        <option value="COMPLETED_CONSULTANT_MEETING_INFO">COMPLETED_CONSULTANT_MEETING_INFO</option>
                        <option value="COMPLETED_ACTUAL_MEETING_DATE">COMPLETED_ACTUAL_MEETING_DATE</option>
                        <option value="SENT_MEETING_ACK">SENT_MEETING_ACK</option>
                        <option value="SENT_FIRST_INVITATION_LETTER">SENT_FIRST_INVITATION_LETTER</option>
                        <option value="SENT_SECOND_INVITATION_LETTER">SENT_SECOND_INVITATION_LETTER</option>
                        <option value="SENT_THIRD_INVITATION_LETTER">SENT_THIRD_INVITATION_LETTER</option>
                        <option value="WAITING_PQ_SITE_WALK">WAITING_PQ_SITE_WALK</option>
                        <option value="NOTIFIED_PQ_SITE_WALK">NOTIFIED_PQ_SITE_WALK</option>
                        <option value="COMPLETED_PQ_SITE_WALK_PASS">COMPLETED_PQ_SITE_WALK_PASS</option>
                        <option value="COMPLETED_PQ_SITE_WALK_FAIL">COMPLETED_PQ_SITE_WALK_FAIL</option>
                        <option value="SENT_FORTH_INVITATION_LETTER">SENT_FORTH_INVITATION_LETTER</option>
                        <option value="WAITING_RE_PQ_SITE_WALK">WAITING_RE_PQ_SITE_WALK</option>
                        <option value="NOTIFIED_RE_PQ_SITE_WALK">NOTIFIED_RE_PQ_SITE_WALK</option>
                        <option value="COMPLETED_RE_PQ_SITE_WALK_PASS">COMPLETED_RE_PQ_SITE_WALK_PASS</option>
                        <option value="COMPLETED_RE_PQ_SITE_WALK_FAIL">COMPLETED_RE_PQ_SITE_WALK_FAIL</option>
                    </select>
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
                        <td>Scheme No</td>
                        <td>Project Title</td>
                        <td>Type of Project</td>
                        <td>Region</td>
                        <td>Infra Project</td>
                        <td>Temp Project</td>
                        <td>Commission Date</td>
                        <td>State</td>
                        <td>1<span style="vertical-align: super; font-size: 10px">st</span> Consultant</td>
                        <td>1<span style="vertical-align: super; font-size: 10px">st</span> Consultant Company</td>
                        <td>1<span style="vertical-align: super; font-size: 10px">st</span> Consultant Phone</td>
                        <td>1<span style="vertical-align: super; font-size: 10px">st</span> Consultant Email</td>
                        <td>2<span style="vertical-align: super; font-size: 10px">nd</span> Consultant</td>
                        <td>2<span style="vertical-align: super; font-size: 10px">nd</span> Consultant Company</td>
                        <td>2<span style="vertical-align: super; font-size: 10px">nd</span> Consultant Phone</td>
                        <td>2<span style="vertical-align: super; font-size: 10px">nd</span> Consultant Email</td>
                        <td>3<span style="vertical-align: super; font-size: 10px">rd</span> Consultant</td>
                        <td>3<span style="vertical-align: super; font-size: 10px">rd</span> Consultant Company</td>
                        <td>3<span style="vertical-align: super; font-size: 10px">rd</span> Consultant Phone</td>
                        <td>3<span style="vertical-align: super; font-size: 10px">rd</span> Consultant Email</td>
                        <td>1<span style="vertical-align: super; font-size: 10px">st</span> Project Owner</td>
                        <td>1<span style="vertical-align: super; font-size: 10px">st</span> Project Owner Company</td>
                        <td>1<span style="vertical-align: super; font-size: 10px">st</span> Project Owner Phone</td>
                        <td>1<span style="vertical-align: super; font-size: 10px">st</span> Project Owner Email</td>
                        <td>2<span style="vertical-align: super; font-size: 10px">nd</span> Project Owner</td>
                        <td>2<span style="vertical-align: super; font-size: 10px">nd</span> Project Owner Company</td>
                        <td>2<span style="vertical-align: super; font-size: 10px">nd</span> Project Owner Phone</td>
                        <td>2<span style="vertical-align: super; font-size: 10px">nd</span> Project Owner Email</td>
                        <td>3<span style="vertical-align: super; font-size: 10px">rd</span> Project Owner</td>
                        <td>3<span style="vertical-align: super; font-size: 10px">rd</span> Project Owner Company</td>
                        <td>3<span style="vertical-align: super; font-size: 10px">rd</span> Project Owner Phone</td>
                        <td>3<span style="vertical-align: super; font-size: 10px">rd</span> Project Owner Email</td>
                        <td>Plan-ahead meeting Invitation Link</td>
                        <td>First Invitation Letter Link</td>
                        <td>Second Invitation Letter Link</td>
                        <td>Third Invitation Letter Link</td>
                        <td>Actual Meeting Date</td>
                        <td>Reply Slip Submitted</td>
                        <td>Reply Slip Submission Date</td>
                        <td>PQ Site Walk Date</td>
                        <td>PQ Site Walk Report Link</td>
                        <td>PQ Site Walk Report Score</td>
                        <td>Last Email Notified Time</td>
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

        $("#searchCommissionDateFrom").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#searchCommissionDateTo").datetimepicker({
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42],
                    format: {
                        body: function(data, row, column, node) {
                            if (column != 0)
                                return data;
                            return node.innerText;
                        }
                    }
                }

            }, ],
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxGetPlanningAheadTable",
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
            "lengthMenu": [
                [50, 100, 200, 500, 9000000],
                [50, 100, 200, 500, "All"]
            ],
            "filter": false,
            "sPaginationType": "full_numbers",
            "columns": [
                {
                    "data": "scheme_no",
                    render: function(data, type, row) {
                        let btnHtml =
                            "<a href='<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailForm&SchemeNo=" +
                            row.scheme_no + "'>" + data + "</a>";
                        return btnHtml;
                    },
                    "width": "10%"
                },
                {
                    "data": "project_title",
                    "width": "35%"
                },
                {
                    "data": "project_type_name",
                    "width": "15%"
                },
                {
                    "data": "region_short_name",
                    "width": "10%"
                },
                {
                    "data": "key_infra",
                    "width": "10%"
                },
                {
                    "data": "temp_project",
                    "width": "10%"
                },
                {
                    "data": "commission_date",
                    "width": "10%"
                },
                {
                    "data": "state",
                    "width": "20%"
                },
                {
                    "data": "first_consultant",
                    "width": "20%"
                },
                {
                    "data": "first_consultant_company",
                    "width": "20%"
                },
                {
                    "data": "first_consultant_phone",
                    "width": "20%"
                },
                {
                    "data": "first_consultant_email",
                    "width": "20%"
                },
                {
                    "data": "second_consultant",
                    "width": "20%"
                },
                {
                    "data": "second_consultant_company",
                    "width": "20%"
                },
                {
                    "data": "second_consultant_phone",
                    "width": "20%"
                },
                {
                    "data": "second_consultant_email",
                    "width": "20%"
                },
                {
                    "data": "third_consultant",
                    "width": "20%"
                },
                {
                    "data": "third_consultant_company",
                    "width": "20%"
                },
                {
                    "data": "third_consultant_phone",
                    "width": "20%"
                },
                {
                    "data": "third_consultant_email",
                    "width": "20%"
                },
                {
                    "data": "first_project_owner",
                    "width": "20%"
                },
                {
                    "data": "first_project_owner_company",
                    "width": "20%"
                },
                {
                    "data": "first_project_owner_phone",
                    "width": "20%"
                },
                {
                    "data": "first_project_owner_email",
                    "width": "20%"
                },
                {
                    "data": "second_project_owner",
                    "width": "20%"
                },
                {
                    "data": "second_project_owner_company",
                    "width": "20%"
                },
                {
                    "data": "second_project_owner_phone",
                    "width": "20%"
                },
                {
                    "data": "second_project_owner_email",
                    "width": "20%"
                },
                {
                    "data": "third_project_owner",
                    "width": "20%"
                },
                {
                    "data": "third_project_owner_company",
                    "width": "20%"
                },
                {
                    "data": "third_project_owner_phone",
                    "width": "20%"
                },
                {
                    "data": "third_project_owner_email",
                    "width": "20%"
                },
                {
                    "data": "stand_letter_edms_link",
                    "width": "30%"
                },
                {
                    "data": "first_invitation_letter_edms_link",
                    "width": "30%"
                },
                {
                    "data": "second_invitation_letter_edms_link",
                    "width": "30%"
                },
                {
                    "data": "third_invitation_letter_edms_link",
                    "width": "30%"
                },
                {
                    "data": "meeting_actual_meeting_date",
                    "width": "20%"
                },
                {
                    "data": "is_reply_slip_submitted",
                    "width": "15%"
                },
                {
                    "data": "meeting_consent_date_consultant",
                    "width": "20%"
                },
                {
                    "data": "pq_site_walk_date",
                    "width": "20%"
                },
                {
                    "data": "evaluation_report_edms_link",
                    "width": "30%"
                },
                {
                    "data": "evaluation_report_score",
                    "width": "20%"
                },
                {
                    "data": "last_email_notification_time",
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
            let searchCommissionDateFromStr = document.getElementById('searchCommissionDateFrom').value;
            let searchCommissionDateToStr = document.getElementById('searchCommissionDateTo').value;

            if ((searchCreationDateFromStr != null) && (searchCreationDateToStr != null)) {
                let searchCreationDateFromDt = Date.parse(searchCreationDateFromStr);
                let searchCreationDateToDt = Date.parse(searchCreationDateToStr);

                if (searchCreationDateToDt < searchCreationDateFromDt) {
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", "Creation Date (From) must be earlier that Creation From (To)!");
                    return;
                }
            }

            if ((searchCommissionDateFromStr != null) && (searchCommissionDateToStr != null)) {
                let searchCommissionDateFromDt = Date.parse(searchCommissionDateFromStr);
                let searchCommissionDateToDt = Date.parse(searchCommissionDateToStr);

                if (searchCommissionDateToDt < searchCommissionDateFromDt) {
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", "Commission Date (From) must be earlier that Commission From (To)!");
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

            if (!((($("#searchCommissionDateFrom").val() == null) || ($("#searchCommissionDateFrom").val().trim() == "")) &&
                (($("#searchCommissionDateTo").val() == null) || ($("#searchCommissionDateTo").val().trim() == "")))) {
                if (($("#searchCommissionDateFrom").val() != null) && ($("#searchCommissionDateFrom").val().trim() != "")) {
                    searchParamStr += "\"commissionDateFrom\":" + "\"" + $("#searchCommissionDateFrom").val() + "\"" + ",";
                } else {
                    searchParamStr += "\"commissionDateFrom\":" + "\"" + "1970-01-01" + "\"" + ",";
                }
                if (($("#searchCommissionDateTo").val() != null) && ($("#searchCommissionDateTo").val().trim() != "")) {
                    searchParamStr += "\"commissionDateTo\":" + "\"" + $("#searchCommissionDateTo").val() + "\"" + ",";
                } else {
                    searchParamStr += "\"commissionDateTo\":" + "\"" + "2099-12-31" + "\"" + ",";
                }
            }

            if (($("#searchSchemeNo").val() != null) && ($("#searchSchemeNo").val().trim() != "")) {
                searchParamStr += "\"schemeNo\":" + "\"" + $("#searchSchemeNo").val() + "\"" + ",";
            }
            if (($("#searchProjectTitle").val() != null) && ($("#searchProjectTitle").val().trim() != "")) {
                searchParamStr += "\"projectTitle\":" + "\"" + $("#searchProjectTitle").val() + "\"" + ",";
            }
            if (($("#searchTypeOfProject").val() != null) && ($("#searchTypeOfProject").val().trim() != "0")) {
                searchParamStr += "\"typeOfProject\":" + "\"" + $("#searchTypeOfProject").val() + "\"" + ",";
            }
            if (($("#searchMainTypeOfProject").val() != null) && ($("#searchMainTypeOfProject").val().trim() != "")) {
                searchParamStr += "\"mainTypeOfProject\":" + "\"" + $("#searchMainTypeOfProject").val() + "\"" + ",";
            }
            if (($("#searchState").val() != null) && ($("#searchState").val().trim() != "")) {
                searchParamStr += "\"state\":" + "\"" + $("#searchState").val() + "\"" + ",";
            }
            if (($("#searchConsultantName").val() != null) && ($("#searchConsultantName").val().trim() != "")) {
                searchParamStr += "\"consultantName\":" + "\"" + $("#searchConsultantName").val() + "\"" + ",";
            }
            if (($("#searchConsultantPhone").val() != null) && ($("#searchConsultantPhone").val().trim() != "")) {
                searchParamStr += "\"consultantPhone\":" + "\"" + $("#searchConsultantPhone").val() + "\"" + ",";
            }
            if (($("#searchOwnerName").val() != null) && ($("#searchOwnerName").val().trim() != "")) {
                searchParamStr += "\"ownerName\":" + "\"" + $("#searchOwnerName").val() + "\"" + ",";
            }
            if (($("#searchOwnerPhone").val() != null) && ($("#searchOwnerPhone").val().trim() != "")) {
                searchParamStr += "\"ownerPhone\":" + "\"" + $("#searchOwnerPhone").val() + "\"" + ",";
            }
            if (searchParamStr != "{") {
                searchParamStr = searchParamStr.substring(0, searchParamStr.length - 1);
            }
            searchParamStr += "}";
            d.searchParam = searchParamStr;
            return d;
        }

        function rebindAllBtn() {
        }
    });

    function reloadTypeOfList() {

        let searchTypeOfProject = document.getElementById('searchTypeOfProject');
        searchTypeOfProject.innerHTML = '<option value="0" selected>--- Any ---</option>';

        if ($("#searchMainTypeOfProject").val() == '') {
            <?php foreach($this->viewbag['projectTypeList'] as $projectTypeList) { ?>
            searchTypeOfProject.innerHTML = searchTypeOfProject.innerHTML +
                '<option value="<?php echo $projectTypeList['projectTypeId'] ?>"><?php echo $projectTypeList['projectTypeName'] ?></option>';
            <?php } ?>
        }

        <?php foreach($this->viewbag['projectMainTypeList'] as $projectMainTypeList) { ?>
                if ($("#searchMainTypeOfProject").val() == '<?php echo $projectMainTypeList['projectTypeClass'] ?>') {
                    <?php foreach($this->viewbag['projectTypeList'] as $projectTypeList) {
                        if ($projectTypeList['projectTypeClass'] == $projectMainTypeList['projectTypeClass']) {?>
                        searchTypeOfProject.innerHTML = searchTypeOfProject.innerHTML +
                            '<option value="<?php echo $projectTypeList['projectTypeId'] ?>"><?php echo $projectTypeList['projectTypeName'] ?></option>';
                    <?php }
                    } ?>
                }
        <?php } ?>
    }
</script>

