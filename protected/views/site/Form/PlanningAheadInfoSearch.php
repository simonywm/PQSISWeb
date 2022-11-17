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
                <div class="input-group col-12">
                    <div class="input-group-prepend"><span class="input-group-text">Scheme No.: </span></div>
                    <input id="searchSchemeNo" name="searchSchemeNo" type="text" class="form-control"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group row pt-3">
                <div class="input-group col-12">
                    <div class="input-group-prepend"><span class="input-group-text">Project Title: </span></div>
                    <input id="searchProjectTitle" name="searchProjectTitle" type="text" class="form-control"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group row pt-3">
                <div class="input-group col-12">
                    <div class="input-group-prepend"><span class="input-group-text">Type of Project: </span></div>
                    <select id="searchTypeOfProject" name="searchTypeOfProject" class="form-control">
                        <option value="0" selected>--- Any ---</option>
                        <?php foreach($this->viewbag['projectTypeList'] as $projectTypeList){
                            if ($projectTypeList['projectTypeId'] == $this->viewbag['searchProjectTypeId']) {?>
                                <option value="<?php echo $projectTypeList['projectTypeId']?>" selected>
                                    <?php echo $projectTypeList['projectTypeName']?>
                                </option>
                            <?php } else { ?>
                                <option value="<?php echo $projectTypeList['projectTypeId']?>">
                                    <?php echo $projectTypeList['projectTypeName']?>
                                </option>
                                <?php
                            }
                        } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-12">
            <table id="Table" class="display">
                <thead>
                    <tr>
                        <td>Scheme No</td>
                        <td>Project Title</td>
                        <td>Type of Project</td>
                        <td>Region</td>
                        <td>Infra Project</td>
                        <td>Temp Project</td>
                        <td>Commission Date</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        table = $("#Table").DataTable({
            "serverSide": true,
            "autoWidth": true,
            "processing": true,
            "scrollX": true,
            "fixedHeader": true,
            "stateSave": false,
            "dom": 'Blipfrtip',
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxGetPlanningAheadTable",
                "type": "POST",
                "contentType": 'application/json; charset=utf-8',
                "data": function(data) {
                    console.log(data);
                    return JSON.stringify(constructPostParam(data));
                }
            },
            buttons: [],
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
            table.ajax.reload(null, false);
        });

        function constructPostParam(d) {
            let searchParamStr = "{";
            if (($("#searchSchemeNo").val() != null) && ($("#searchSchemeNo").val().trim() != "")) {
                searchParamStr += "\"schemeNo\":" + "\"" + $("#searchSchemeNo").val() + "\"" + ",";
            }
            if (($("#searchProjectTitle").val() != null) && ($("#searchProjectTitle").val().trim() != "")) {
                searchParamStr += "\"projectTitle\":" + "\"" + $("#searchProjectTitle").val() + "\"" + ",";
            }
            if (($("#searchTypeOfProject").val() != null) && ($("#searchTypeOfProject").val().trim() != "0")) {
                searchParamStr += "\"typeOfProject\":" + "\"" + $("#searchTypeOfProject").val() + "\"" + ",";
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

</script>

