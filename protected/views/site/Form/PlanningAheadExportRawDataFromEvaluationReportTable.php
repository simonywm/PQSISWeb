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
                    <h3>Export Raw Data from Evaluation Report Table</h3>
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
                    <td>evaluation_report_id</td>
                    <td>scheme_no</td>
                    <td>evaluation_report_remark</td>
                    <td>evaluation_report_edms_link</td>
                    <td>evaluation_report_issue_date</td>
                    <td>evaluation_report_fax_ref_no</td>
                    <td>evaluation_report_score</td>
                    <td>bms_yes_no</td>
                    <td>bms_server_central_computer_yes_no</td>
                    <td>bms_server_central_computer_finding</td>
                    <td>bms_server_central_computer_recommend</td>
                    <td>bms_server_central_computer_pass</td>
                    <td>bms_ddc_yes_no</td>
                    <td>bms_ddc_finding</td>
                    <td>bms_ddc_recommend</td>
                    <td>bms_ddc_pass</td>
                    <td>bms_supplement_yes_no</td>
                    <td>bms_supplement</td>
                    <td>bms_supplement_pass</td>
                    <td>changeover_scheme_yes_no</td>
                    <td>changeover_scheme_control_yes_no</td>
                    <td>changeover_scheme_control_finding</td>
                    <td>changeover_scheme_control_recommend</td>
                    <td>changeover_scheme_control_pass</td>
                    <td>changeover_scheme_uv_yes_no</td>
                    <td>changeover_scheme_uv_finding</td>
                    <td>changeover_scheme_uv_recommend</td>
                    <td>changeover_scheme_uv_pass</td>
                    <td>changeover_scheme_supplement_yes_no</td>
                    <td>changeover_scheme_supplement</td>
                    <td>changeover_scheme_supplement_pass</td>
                    <td>chiller_plant_yes_no</td>
                    <td>chiller_plant_ahu_chilled_water_yes_no</td>
                    <td>chiller_plant_ahu_chilled_water_finding</td>
                    <td>chiller_plant_ahu_chilled_water_recommend</td>
                    <td>chiller_plant_ahu_chilled_water_pass</td>
                    <td>chiller_plant_chiller_yes_no</td>
                    <td>chiller_plant_chiller_finding</td>
                    <td>chiller_plant_chiller_recommend</td>
                    <td>chiller_plant_chiller_pass</td>
                    <td>chiller_plant_supplement_yes_no</td>
                    <td>chiller_plant_supplement</td>
                    <td>chiller_plant_supplement_pass</td>
                    <td>escalator_yes_no</td>
                    <td>escalator_braking_system_yes_no</td>
                    <td>escalator_braking_system_finding</td>
                    <td>escalator_braking_system_recommend</td>
                    <td>escalator_braking_system_pass</td>
                    <td>escalator_control_yes_no</td>
                    <td>escalator_control_finding</td>
                    <td>escalator_control_recommend</td>
                    <td>escalator_control_pass</td>
                    <td>escalator_supplement_yes_no</td>
                    <td>escalator_supplement</td>
                    <td>escalator_supplement_pass</td>
                    <td>hid_lamp_yes_no</td>
                    <td>hid_lamp_ballast_yes_no</td>
                    <td>hid_lamp_ballast_finding</td>
                    <td>hid_lamp_ballast_recommend</td>
                    <td>hid_lamp_ballast_pass</td>
                    <td>hid_lamp_addon_protect_yes_no</td>
                    <td>hid_lamp_addon_protect_finding</td>
                    <td>hid_lamp_addon_protect_recommend</td>
                    <td>hid_lamp_addon_protect_pass</td>
                    <td>hid_lamp_supplement_yes_no</td>
                    <td>hid_lamp_supplement</td>
                    <td>hid_lamp_supplement_pass</td>
                    <td>lift_yes_no</td>
                    <td>lift_operation_yes_no</td>
                    <td>lift_operation_finding</td>
                    <td>lift_operation_recommend</td>
                    <td>lift_operation_pass</td>
                    <td>lift_main_supply_yes_no</td>
                    <td>lift_main_supply_finding</td>
                    <td>lift_main_supply_recommend</td>
                    <td>lift_main_supply_pass</td>
                    <td>lift_supplement_yes_no</td>
                    <td>lift_supplement</td>
                    <td>lift_supplement_pass</td>
                    <td>sensitive_machine_yes_no</td>
                    <td>sensitive_machine_medical_yes_no</td>
                    <td>sensitive_machine_medical_finding</td>
                    <td>sensitive_machine_medical_recommend</td>
                    <td>sensitive_machine_medical_pass</td>
                    <td>sensitive_machine_supplement_yes_no</td>
                    <td>sensitive_machine_supplement</td>
                    <td>sensitive_machine_supplement_pass</td>
                    <td>telecom_machine_yes_no</td>
                    <td>telecom_machine_server_or_computer_yes_no</td>
                    <td>telecom_machine_server_or_computer_finding</td>
                    <td>telecom_machine_server_or_computer_recommend</td>
                    <td>telecom_machine_server_or_computer_pass</td>
                    <td>telecom_machine_peripherals_yes_no</td>
                    <td>telecom_machine_peripherals_finding</td>
                    <td>telecom_machine_peripherals_recommend</td>
                    <td>telecom_machine_peripherals_pass</td>
                    <td>telecom_machine_harmonic_emission_yes_no</td>
                    <td>telecom_machine_harmonic_emission_finding</td>
                    <td>telecom_machine_harmonic_emission_recommend</td>
                    <td>telecom_machine_harmonic_emission_pass</td>
                    <td>telecom_machine_supplement_yes_no</td>
                    <td>telecom_machine_supplement</td>
                    <td>telecom_machine_supplement_pass</td>
                    <td>air_conditioners_yes_no</td>
                    <td>air_conditioners_micb_yes_no</td>
                    <td>air_conditioners_micb_finding</td>
                    <td>air_conditioners_micb_recommend</td>
                    <td>air_conditioners_micb_pass</td>
                    <td>air_conditioners_load_forecasting_yes_no</td>
                    <td>air_conditioners_load_forecasting_finding</td>
                    <td>air_conditioners_load_forecasting_recommend</td>
                    <td>air_conditioners_load_forecasting_pass</td>
                    <td>air_conditioners_type_yes_no</td>
                    <td>air_conditioners_type_finding</td>
                    <td>air_conditioners_type_recommend</td>
                    <td>air_conditioners_type_pass</td>
                    <td>air_conditioners_supplement_yes_no</td>
                    <td>air_conditioners_supplement</td>
                    <td>air_conditioners_supplement_pass</td>
                    <td>non_linear_load_yes_no</td>
                    <td>non_linear_load_harmonic_emission_yes_no</td>
                    <td>non_linear_load_harmonic_emission_finding</td>
                    <td>non_linear_load_harmonic_emission_recommend</td>
                    <td>non_linear_load_harmonic_emission_pass</td>
                    <td>non_linear_load_supplement_yes_no</td>
                    <td>non_linear_load_supplement</td>
                    <td>non_linear_load_supplement_pass</td>
                    <td>renewable_energy_yes_no</td>
                    <td>renewable_energy_inverter_and_controls_yes_no</td>
                    <td>renewable_energy_inverter_and_controls_finding</td>
                    <td>renewable_energy_inverter_and_controls_recommend</td>
                    <td>renewable_energy_inverter_and_controls_pass</td>
                    <td>renewable_energy_harmonic_emission_yes_no</td>
                    <td>renewable_energy_harmonic_emission_finding</td>
                    <td>renewable_energy_harmonic_emission_recommend</td>
                    <td>renewable_energy_harmonic_emission_pass</td>
                    <td>renewable_energy_supplement_yes_no</td>
                    <td>renewable_energy_supplement_pass</td>
                    <td>ev_charger_system_yes_no</td>
                    <td>ev_charger_system_ev_charger_yes_no</td>
                    <td>ev_charger_system_ev_charger_finding</td>
                    <td>ev_charger_system_ev_charger_recommend</td>
                    <td>ev_charger_system_ev_charger_pass</td>
                    <td>ev_charger_system_harmonic_emission_yes_no</td>
                    <td>ev_charger_system_harmonic_emission_finding</td>
                    <td>ev_charger_system_harmonic_emission_recommend</td>
                    <td>ev_charger_system_harmonic_emission_pass</td>
                    <td>ev_charger_system_supplement_yes_no</td>
                    <td>ev_charger_system_supplement</td>
                    <td>ev_charger_system_supplement_pass</td>
                    <td>active</td>
                    <td>created_by</td>
                    <td>created_time</td>
                    <td>last_updated_by</td>
                    <td>last_updated_time</td>
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
                        84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103,
                        104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119,
                        120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135,
                        136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151,
                        152, 153, 154],
                    format: {
                        body: function(data, row, column, node) {
                            return data;
                        }
                    }
                }
            }, ],
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxGetExportRawDataFromEvaluationReportTable",
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
                    "data": "evaluation_report_id",
                    "width": "25%"
                },
                {
                    "data": "scheme_no",
                    "width": "25%"
                },
                {
                    "data": "evaluation_report_remark",
                    "width": "25%"
                },
                {
                    "data": "evaluation_report_edms_link",
                    "width": "25%"
                },
                {
                    "data": "evaluation_report_issue_date",
                    "width": "25%"
                },
                {
                    "data": "evaluation_report_fax_ref_no",
                    "width": "25%"
                },
                {
                    "data": "evaluation_report_score",
                    "width": "25%"
                },
                {
                    "data": "bms_yes_no",
                    "width": "25%"
                },
                {
                    "data": "bms_server_central_computer_yes_no",
                    "width": "25%"
                },
                {
                    "data": "bms_server_central_computer_finding",
                    "width": "25%"
                },
                {
                    "data": "bms_server_central_computer_recommend",
                    "width": "25%"
                },
                {
                    "data": "bms_server_central_computer_pass",
                    "width": "25%"
                },
                {
                    "data": "bms_ddc_yes_no",
                    "width": "25%"
                },
                {
                    "data": "bms_ddc_finding",
                    "width": "25%"
                },
                {
                    "data": "bms_ddc_recommend",
                    "width": "25%"
                },
                {
                    "data": "bms_ddc_pass",
                    "width": "25%"
                },
                {
                    "data": "bms_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "bms_supplement",
                    "width": "25%"
                },
                {
                    "data": "bms_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_yes_no",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_control_yes_no",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_control_finding",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_control_recommend",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_control_pass",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_uv_yes_no",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_uv_finding",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_uv_recommend",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_uv_pass",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_supplement",
                    "width": "25%"
                },
                {
                    "data": "changeover_scheme_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_yes_no",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_ahu_chilled_water_yes_no",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_ahu_chilled_water_finding",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_ahu_chilled_water_recommend",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_ahu_chilled_water_pass",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_chiller_yes_no",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_chiller_finding",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_chiller_recommend",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_chiller_pass",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_supplement",
                    "width": "25%"
                },
                {
                    "data": "chiller_plant_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "escalator_yes_no",
                    "width": "25%"
                },
                {
                    "data": "escalator_braking_system_yes_no",
                    "width": "25%"
                },
                {
                    "data": "escalator_braking_system_finding",
                    "width": "25%"
                },
                {
                    "data": "escalator_braking_system_recommend",
                    "width": "25%"
                },
                {
                    "data": "escalator_braking_system_pass",
                    "width": "25%"
                },
                {
                    "data": "escalator_control_yes_no",
                    "width": "25%"
                },
                {
                    "data": "escalator_control_finding",
                    "width": "25%"
                },
                {
                    "data": "escalator_control_recommend",
                    "width": "25%"
                },
                {
                    "data": "escalator_control_pass",
                    "width": "25%"
                },
                {
                    "data": "escalator_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "escalator_supplement",
                    "width": "25%"
                },
                {
                    "data": "escalator_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_yes_no",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_ballast_yes_no",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_ballast_finding",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_ballast_recommend",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_ballast_pass",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_addon_protect_yes_no",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_addon_protect_finding",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_addon_protect_recommend",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_addon_protect_pass",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_supplement",
                    "width": "25%"
                },
                {
                    "data": "hid_lamp_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "lift_yes_no",
                    "width": "25%"
                },
                {
                    "data": "lift_operation_yes_no",
                    "width": "25%"
                },
                {
                    "data": "lift_operation_finding",
                    "width": "25%"
                },
                {
                    "data": "lift_operation_recommend",
                    "width": "25%"
                },
                {
                    "data": "lift_operation_pass",
                    "width": "25%"
                },
                {
                    "data": "lift_main_supply_yes_no",
                    "width": "25%"
                },
                {
                    "data": "lift_main_supply_finding",
                    "width": "25%"
                },
                {
                    "data": "lift_main_supply_recommend",
                    "width": "25%"
                },
                {
                    "data": "lift_main_supply_pass",
                    "width": "25%"
                },
                {
                    "data": "lift_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "lift_supplement",
                    "width": "25%"
                },
                {
                    "data": "lift_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "sensitive_machine_yes_no",
                    "width": "25%"
                },
                {
                    "data": "sensitive_machine_medical_yes_no",
                    "width": "25%"
                },
                {
                    "data": "sensitive_machine_medical_finding",
                    "width": "25%"
                },
                {
                    "data": "sensitive_machine_medical_recommend",
                    "width": "25%"
                },
                {
                    "data": "sensitive_machine_medical_pass",
                    "width": "25%"
                },
                {
                    "data": "sensitive_machine_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "sensitive_machine_supplement",
                    "width": "25%"
                },
                {
                    "data": "sensitive_machine_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_yes_no",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_server_or_computer_yes_no",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_server_or_computer_finding",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_server_or_computer_recommend",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_server_or_computer_pass",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_peripherals_yes_no",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_peripherals_finding",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_peripherals_recommend",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_peripherals_pass",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_harmonic_emission_yes_no",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_harmonic_emission_finding",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_harmonic_emission_recommend",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_harmonic_emission_pass",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_supplement",
                    "width": "25%"
                },
                {
                    "data": "telecom_machine_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_yes_no",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_micb_yes_no",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_micb_finding",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_micb_recommend",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_micb_pass",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_load_forecasting_yes_no",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_load_forecasting_finding",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_load_forecasting_recommend",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_load_forecasting_pass",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_type_yes_no",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_type_finding",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_type_recommend",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_type_pass",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_supplement",
                    "width": "25%"
                },
                {
                    "data": "air_conditioners_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "non_linear_load_yes_no",
                    "width": "25%"
                },
                {
                    "data": "non_linear_load_harmonic_emission_yes_no",
                    "width": "25%"
                },
                {
                    "data": "non_linear_load_harmonic_emission_finding",
                    "width": "25%"
                },
                {
                    "data": "non_linear_load_harmonic_emission_recommend",
                    "width": "25%"
                },
                {
                    "data": "non_linear_load_harmonic_emission_pass",
                    "width": "25%"
                },
                {
                    "data": "non_linear_load_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "non_linear_load_supplement",
                    "width": "25%"
                },
                {
                    "data": "non_linear_load_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_yes_no",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_inverter_and_controls_yes_no",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_inverter_and_controls_finding",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_inverter_and_controls_recommend",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_inverter_and_controls_pass",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_harmonic_emission_yes_no",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_harmonic_emission_finding",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_harmonic_emission_recommend",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_harmonic_emission_pass",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "renewable_energy_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_yes_no",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_ev_charger_yes_no",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_ev_charger_finding",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_ev_charger_recommend",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_ev_charger_pass",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_harmonic_emission_yes_no",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_harmonic_emission_finding",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_harmonic_emission_recommend",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_harmonic_emission_pass",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_supplement_yes_no",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_supplement",
                    "width": "25%"
                },
                {
                    "data": "ev_charger_system_supplement_pass",
                    "width": "25%"
                },
                {
                    "data": "active",
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
