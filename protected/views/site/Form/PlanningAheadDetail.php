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

<div id="planningAheadDetailForm" class="pt-2">

    <div class="p-2" style="background-color: #2b669a; color: white; font-size: x-large"><b>Project Details</b></div>

    <form action="#" method="post" id="detailForm">
        <div class="form-group row pt-3">
            <div class="input-group col-12">
                <div class="input-group-prepend"><span class="input-group-text">Project Title: </span></div>
                <input id="projectTitle" name="projectTitle" type="text" class="form-control"
                       autocomplete="off" <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"readonly":""; ?>>
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-6">
                <div class="input-group-prepend"><span class="input-group-text">Scheme No.: </span></div>
                <input id="schemeNo" name="schemeNo" type="text" class="form-control"
                       autocomplete="off" <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"readonly":""; ?>>
            </div>
            <div class="input-group col-6">
                <div class="input-group-prepend"><span class="input-group-text">Project Region: </span></div>
                <select id="region" name="region" class="form-control">
                    <?php foreach($this->viewbag['regionList'] as $regionList){
                        if ($regionList['regionId'] == $this->viewbag['regionId']) {?>
                            <option value="<?php echo $regionList['regionId']?>" selected>
                                <?php echo $regionList['regionShortName']?>
                            </option>
                        <?php } else { ?>
                                <?php if (isset(Yii::app()->session['tblUserDo']['roleId'])) { ?>
                                    <option value="<?php echo $regionList['regionId']?>">
                                        <?php echo $regionList['regionShortName']?>
                                    </option>
                                <?php } ?>
                    <?php
                        }
                    } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-6">
                <div class="input-group-prepend"><span class="input-group-text">Type of Project: </span></div>
                <select id="typeOfProject" name="typeOfProject" class="form-control">
                    <option value="0" selected disabled>------</option>
                    <?php foreach($this->viewbag['projectTypeList'] as $projectTypeList){
                        if ($projectTypeList['projectTypeId'] == $this->viewbag['projectTypeId']) {?>
                            <option value="<?php echo $projectTypeList['projectTypeId']?>" selected>
                                <?php echo $projectTypeList['projectTypeName']?>
                            </option>
                        <?php } else { ?>
                            <?php if (isset(Yii::app()->session['tblUserDo']['roleId'])) { ?>
                                <option value="<?php echo $projectTypeList['projectTypeId']?>">
                                    <?php echo $projectTypeList['projectTypeName']?>
                                </option>
                            <?php } ?>
                    <?php
                            }
                        } ?>
                </select>
            </div>
            <div class="input-group col-6">
                <div class="input-group-prepend"><span class="input-group-text">Planned Commission Date: </span></div>
                <input id="commissionDate" name="commissionDate" type="text" placeholder="YYYY-mm-dd"
                       class="form-control" autocomplete="off">
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-12">
                <div class="input-group-prepend"><span class="input-group-text">Key Infrastructure: </span></div>
                <?php if ($this->viewbag['keyInfra'] == 'Y') { ?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="Y" checked>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="N"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>No
                        </label>
                    </div>
                <?php } else if ($this->viewbag['keyInfra'] == 'N') {?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="Y"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="N" checked>No
                        </label>
                    </div>
                <?php } else { ?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="Y"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="N"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>No
                        </label>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-12">
                <div class="input-group-prepend"><span class="input-group-text">Temp Project: </span></div>
                <?php if ($this->viewbag['tempProject'] == 'Y') { ?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="Y" checked>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="N"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>No
                        </label>
                    </div>
                <?php } else if ($this->viewbag['tempProject'] == 'N') {?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="Y"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="N" checked>No
                        </label>
                    </div>
                <?php } else { ?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="Y"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="N"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>No
                        </label>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-12">
                <div class="input-group-prepend"><span class="input-group-text">State: </span></div>
                <input id="projectState" name="projectState" type="text" class="form-control"
                       autocomplete="off" disabled>
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-12">
                <div class="input-group-prepend"><span class="input-group-text">Active: </span></div>
                <?php if ($this->viewbag['active'] == 'Y') { ?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="activeOpt" class="form-check-input" value="Y" checked>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="activeOpt" class="form-check-input" value="N"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>No
                        </label>
                    </div>
                <?php } else {?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="activeOpt" class="form-check-input" value="Y"
                                <?php echo (!isset(Yii::app()->session['tblUserDo']['roleId']))?"disabled":""; ?>>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="activeOpt" class="form-check-input" value="N" checked>No
                        </label>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div id="accordionFirstRegionStaff">
            <div class="card">
                <div class="card-header" style="background-color: #6f42c1">
                    <a class="card-link" data-toggle="collapse" href="#firstRegionStaff" onclick="cardSelected('firstRegionStaffIcon')">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">1<span style="vertical-align: super; font-size: 10px">st</span> Contact of Region Staff</h5></div>
                            <div class="col-1">
                                <img id="firstRegionStaffIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="firstRegionStaff" class="collapse" data-parent="#accordionFirstRegionStaff">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <input id="firstRegionStaffName" name="firstRegionStaffName" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="firstRegionStaffPhone" name="firstRegionStaffPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="firstRegionStaffEmail" name="firstRegionStaffEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionSecondRegionStaff">
            <div class="card">
                <div class="card-header" style="background-color: #6f42c1">
                    <a class="card-link" data-toggle="collapse" href="#secondRegionStaff" onclick="cardSelected('secondRegionStaffIcon')">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">2<span style="vertical-align: super; font-size: 10px">nd</span> Contact of Region Staff</h5></div>
                            <div class="col-1">
                                <img id="secondRegionStaffIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="secondRegionStaff" class="collapse" data-parent="#accordionSecondRegionStaff">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <input id="secondRegionStaffName" name="secondRegionStaffName" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="secondRegionStaffPhone" name="secondRegionStaffPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="secondRegionStaffEmail" name="secondRegionStaffEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionThirdRegionStaff">
            <div class="card">
                <div class="card-header" style="background-color: #6f42c1">
                    <a class="card-link" data-toggle="collapse" href="#thirdRegionStaff" onclick="cardSelected('thirdRegionStaffIcon')">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">3<span style="vertical-align: super; font-size: 10px">rd</span> Contact of Region Staff</h5></div>
                            <div class="col-1">
                                <img id="thirdRegionStaffIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="thirdRegionStaff" class="collapse" data-parent="#accordionThirdRegionStaff">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <input id="thirdRegionStaffName" name="thirdRegionStaffName" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="thirdRegionStaffPhone" name="thirdRegionStaffPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="thirdRegionStaffEmail" name="thirdRegionStaffEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionFirstContactOfConsultant">
            <div class="card">
                <div class="card-header" style="background-color: #6e5f1e">
                    <a class="card-link" data-toggle="collapse" href="#firstContactOfConsultant" onclick="cardSelected('firstContactOfConsultantIcon')">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">1<span style="vertical-align: super; font-size: 10px">st</span> Contact of Consultant</h5></div>
                            <div class="col-1">
                                <img id="firstContactOfConsultantIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="firstContactOfConsultant" class="collapse" data-parent="#accordionFirstContactOfConsultant">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <select id="firstConsultantTitle" name="firstConsultantTitle" class="form-control">
                                        <option value="" selected>--- Title ---</option>
                                        <?php if ($this->viewbag['firstConsultantTitle'] == "Mr.") { ?>
                                            <option value="Mr." selected>Mr.</option>
                                        <?php } else { ?>
                                            <option value="Mr.">Mr.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['firstConsultantTitle'] == "Mrs.") { ?>
                                            <option value="Mrs." selected>Mrs.</option>
                                        <?php } else { ?>
                                            <option value="Mrs.">Mrs.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['firstConsultantTitle'] == "Ms.") { ?>
                                            <option value="Ms." selected>Ms.</option>
                                        <?php } else { ?>
                                            <option value="Ms.">Ms.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['firstConsultantTitle'] == "Miss") { ?>
                                            <option value="Miss" selected>Miss</option>
                                        <?php } else { ?>
                                            <option value="Miss">Miss</option>
                                        <?php } ?>
                                    </select>
                                    <input id="firstConsultantOtherName" name="firstConsultantOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s) (e.g. T.M.)">
                                    <input id="firstConsultantSurname" name="firstConsultantSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname (e.g. Chan)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Company: </span>
                                    </div>
                                    <input id="firstConsultantCompany" name="firstConsultantCompany" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="firstConsultantPhone" name="firstConsultantPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="firstConsultantEmail" name="firstConsultantEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionSecondContactOfConsultant">
            <div class="card">
                <div class="card-header" style="background-color: #6e5f1e">
                    <a class="card-link" data-toggle="collapse" href="#secondContactOfConsultant" onclick="cardSelected('secondContactOfConsultantIcon')">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">2<span style="vertical-align: super; font-size: 10px">nd</span> Contact of Consultant</h5></div>
                            <div class="col-1">
                                <img id="secondContactOfConsultantIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="secondContactOfConsultant" class="collapse" data-parent="#accordionSecondContactOfConsultant">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <select id="secondConsultantTitle" name="secondConsultantTitle" class="form-control">
                                        <option value="" selected>--- Title ---</option>
                                        <?php if ($this->viewbag['secondConsultantTitle'] == "Mr.") { ?>
                                            <option value="Mr." selected>Mr.</option>
                                        <?php } else { ?>
                                            <option value="Mr.">Mr.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['secondConsultantTitle'] == "Mrs.") { ?>
                                            <option value="Mrs." selected>Mrs.</option>
                                        <?php } else { ?>
                                            <option value="Mrs.">Mrs.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['secondConsultantTitle'] == "Ms.") { ?>
                                            <option value="Ms." selected>Ms.</option>
                                        <?php } else { ?>
                                            <option value="Ms.">Ms.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['secondConsultantTitle'] == "Miss") { ?>
                                            <option value="Miss" selected>Miss</option>
                                        <?php } else { ?>
                                            <option value="Miss">Miss</option>
                                        <?php } ?>
                                    </select>
                                    <input id="secondConsultantOtherName" name="secondConsultantOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s) (e.g. T.M.)">
                                    <input id="secondConsultantSurname" name="secondConsultantSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname (e.g. Chan)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Company: </span>
                                    </div>
                                    <input id="secondConsultantCompany" name="secondConsultantCompany" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="secondConsultantPhone" name="secondConsultantPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="secondConsultantEmail" name="secondConsultantEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionThirdContactOfConsultant">
            <div class="card">
                <div class="card-header" style="background-color: #6e5f1e">
                    <a class="card-link" data-toggle="collapse" href="#thirdContactOfConsultant" onclick="cardSelected('thirdContactOfConsultantIcon')">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">3<span style="vertical-align: super; font-size: 10px">rd</span> Contact of Consultant</h5></div>
                            <div class="col-1">
                                <img id="thirdContactOfConsultantIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="thirdContactOfConsultant" class="collapse" data-parent="#accordionThirdContactOfConsultant">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <select id="thirdConsultantTitle" name="thirdConsultantTitle" class="form-control">
                                        <option value="" selected>--- Title ---</option>
                                        <?php if ($this->viewbag['thirdConsultantTitle'] == "Mr.") { ?>
                                            <option value="Mr." selected>Mr.</option>
                                        <?php } else { ?>
                                            <option value="Mr.">Mr.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['thirdConsultantTitle'] == "Mrs.") { ?>
                                            <option value="Mrs." selected>Mrs.</option>
                                        <?php } else { ?>
                                            <option value="Mrs.">Mrs.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['thirdConsultantTitle'] == "Ms.") { ?>
                                            <option value="Ms." selected>Ms.</option>
                                        <?php } else { ?>
                                            <option value="Ms.">Ms.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['thirdConsultantTitle'] == "Miss") { ?>
                                            <option value="Miss" selected>Miss</option>
                                        <?php } else { ?>
                                            <option value="Miss">Miss</option>
                                        <?php } ?>
                                    </select>
                                    <input id="thirdConsultantOtherName" name="thirdConsultantOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s) (e.g. T.M.)">
                                    <input id="thirdConsultantSurname" name="thirdConsultantSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname (e.g. Chan)">

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Company: </span>
                                    </div>
                                    <input id="thirdConsultantCompany" name="thirdConsultantCompany" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="thirdConsultantPhone" name="thirdConsultantPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="thirdConsultantEmail" name="thirdConsultantEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionFirstContactOfProjectOwner">
            <div class="card">
                <div class="card-header" style="background-color: #106222">
                    <a class="card-link" data-toggle="collapse" href="#firstContactOfProjectOwner" onclick="cardSelected('firstContactOfProjectOwnerIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">1<span style="vertical-align: super; font-size: 10px">st</span> Contact of Project Owner</h5></div>
                            <div class="col-1">
                                <img id="firstContactOfProjectOwnerIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="firstContactOfProjectOwner" class="collapse" data-parent="#accordionFirstContactOfProjectOwner">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <select id="firstProjectOwnerTitle" name="firstProjectOwnerTitle" class="form-control">
                                        <option value="" selected>--- Title ---</option>
                                        <?php if ($this->viewbag['firstProjectOwnerTitle'] == "Mr.") { ?>
                                            <option value="Mr." selected>Mr.</option>
                                        <?php } else { ?>
                                            <option value="Mr.">Mr.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['firstProjectOwnerTitle'] == "Mrs.") { ?>
                                            <option value="Mrs." selected>Mrs.</option>
                                        <?php } else { ?>
                                            <option value="Mrs.">Mrs.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['firstProjectOwnerTitle'] == "Ms.") { ?>
                                            <option value="Ms." selected>Ms.</option>
                                        <?php } else { ?>
                                            <option value="Ms.">Ms.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['firstProjectOwnerTitle'] == "Miss") { ?>
                                            <option value="Miss" selected>Miss</option>
                                        <?php } else { ?>
                                            <option value="Miss">Miss</option>
                                        <?php } ?>
                                    </select>
                                    <input id="firstProjectOwnerOtherName" name="firstProjectOwnerOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s) (e.g. T.M.)">
                                    <input id="firstProjectOwnerSurname" name="firstProjectOwnerSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname (e.g. Chan)">

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Company: </span>
                                    </div>
                                    <input id="firstProjectOwnerCompany" name="firstProjectOwnerCompany" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="firstProjectOwnerPhone" name="firstProjectOwnerPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="firstProjectOwnerEmail" name="firstProjectOwnerEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionSecondContactOfProjectOwner">
            <div class="card">
                <div class="card-header" style="background-color: #106222">
                    <a class="card-link" data-toggle="collapse" href="#secondContactOfProjectOwner" onclick="cardSelected('secondContactOfProjectOwnerIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">2<span style="vertical-align: super; font-size: 10px">nd</span> Contact of Project Owner</h5></div>
                            <div class="col-1">
                                <img id="secondContactOfProjectOwnerIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="secondContactOfProjectOwner" class="collapse" data-parent="#accordionSecondContactOfProjectOwner">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <select id="secondProjectOwnerTitle" name="secondProjectOwnerTitle" class="form-control">
                                        <option value="" selected>--- Title ---</option>
                                        <?php if ($this->viewbag['secondProjectOwnerTitle'] == "Mr.") { ?>
                                            <option value="Mr." selected>Mr.</option>
                                        <?php } else { ?>
                                            <option value="Mr.">Mr.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['secondProjectOwnerTitle'] == "Mrs.") { ?>
                                            <option value="Mrs." selected>Mrs.</option>
                                        <?php } else { ?>
                                            <option value="Mrs.">Mrs.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['secondProjectOwnerTitle'] == "Ms.") { ?>
                                            <option value="Ms." selected>Ms.</option>
                                        <?php } else { ?>
                                            <option value="Ms.">Ms.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['secondProjectOwnerTitle'] == "Miss") { ?>
                                            <option value="Miss" selected>Miss</option>
                                        <?php } else { ?>
                                            <option value="Miss">Miss</option>
                                        <?php } ?>
                                    </select>
                                    <input id="secondProjectOwnerOtherName" name="secondProjectOwnerOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s) (e.g. T.M.)">
                                    <input id="secondProjectOwnerSurname" name="secondProjectOwnerSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname (e.g. Chan)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Company: </span>
                                    </div>
                                    <input id="secondProjectOwnerCompany" name="secondProjectOwnerCompany" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="secondProjectOwnerPhone" name="secondProjectOwnerPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="secondProjectOwnerEmail" name="secondProjectOwnerEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionThirdContactOfProjectOwner">
            <div class="card">
                <div class="card-header" style="background-color: #106222">
                    <a class="card-link" data-toggle="collapse" href="#thirdContactOfProjectOwner" onclick="cardSelected('thirdContactOfProjectOwnerIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">3<span style="vertical-align: super; font-size: 10px">rd</span> Contact of Project Owner</h5></div>
                            <div class="col-1">
                                <img id="thirdContactOfProjectOwnerIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="thirdContactOfProjectOwner" class="collapse" data-parent="#accordionThirdContactOfProjectOwner">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <select id="thirdProjectOwnerTitle" name="thirdProjectOwnerTitle" class="form-control">
                                        <option value="" selected>--- Title ---</option>
                                        <?php if ($this->viewbag['thirdProjectOwnerTitle'] == "Mr.") { ?>
                                            <option value="Mr." selected>Mr.</option>
                                        <?php } else { ?>
                                            <option value="Mr.">Mr.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['thirdProjectOwnerTitle'] == "Mrs.") { ?>
                                            <option value="Mrs." selected>Mrs.</option>
                                        <?php } else { ?>
                                            <option value="Mrs.">Mrs.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['thirdProjectOwnerTitle'] == "Ms.") { ?>
                                            <option value="Ms." selected>Ms.</option>
                                        <?php } else { ?>
                                            <option value="Ms.">Ms.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['thirdProjectOwnerTitle'] == "Miss") { ?>
                                            <option value="Miss" selected>Miss</option>
                                        <?php } else { ?>
                                            <option value="Miss">Miss</option>
                                        <?php } ?>
                                    </select>
                                    <input id="thirdProjectOwnerOtherName" name="thirdProjectOwnerOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s) (e.g. T.M.)">
                                    <input id="thirdProjectOwnerSurname" name="thirdProjectOwnerSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname (e.g. Chan)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Company: </span>
                                    </div>
                                    <input id="thirdProjectOwnerCompany" name="thirdProjectOwnerCompany" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="thirdProjectOwnerPhone" name="thirdProjectOwnerPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="thirdProjectOwnerEmail" name="thirdProjectOwnerEmail" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (($this->viewbag['state']=="WAITING_STANDARD_LETTER") ||
            ($this->viewbag['state']=="COMPLETED_STANDARD_LETTER") ||
            ($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
            ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
            ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
            ($this->viewbag['state']=="SENT_MEETING_ACK") ||
            ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
            ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        <div id="accordionDetailofPQStandardLetter">
            <div class="card">
                <div class="card-header" style="background-color: #184a6c">
                    <a class="card-link" data-toggle="collapse" href="#detailofPQStandardLetter" onclick="cardSelected('standardLetterIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">Details of PQ Standard Letter</h5></div>
                            <div class="col-1">
                                <img id="standardLetterIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="detailofPQStandardLetter" class="collapse" data-parent="#accordionDetailofPQStandardLetter">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Issue Date: </span>
                                    </div>
                                    <input id="standLetterIssueDate" name="standLetterIssueDate" type="text"
                                           placeholder="YYYY-mm-dd"
                                           class="form-control"
                                           onchange="updateGenStandLetterButton()" autocomplete="off">
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Fax Reference No.: </span>
                                    </div>
                                    <input id="standLetterFaxRefNo" name="standLetterFaxRefNo" type="text"
                                           class="form-control"
                                           onchange="updateGenStandLetterButton()" autocomplete="off">
                                </div>
                                <div class="input-group col-4">
                                    <?php if (($this->viewbag['standLetterIssueDate'] == null) ||
                                                ($this->viewbag['standLetterFaxRefNo'] == null) ||
                                                ($this->viewbag['standLetterIssueDate'] == "") ||
                                                ($this->viewbag['standLetterFaxRefNo'] == "")) { ?>
                                    <input class="btn btn-primary form-control" type="button" name="genStandLetterBtn"
                                           id="genStandLetterBtn" value="Generate PQ Standard Letter" disabled>
                                    <?php } else { ?>
                                        <input class="btn btn-primary form-control" type="button" name="genStandLetterBtn"
                                               id="genStandLetterBtn" value="Generate PQ Standard Letter">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">EDMS Link: </span>
                                    </div>
                                    <input id="standLetterEdmsLink" name="standLetterEdmsLink" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Signed Letter: </span>
                                    </div>
                                    <input id="standSignedLetter" name="standSignedLetter" type="file"
                                           placeholder="Please upload the signed standard letter"
                                           class="form-control" autocomplete="false">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if (($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
            ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
            ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
            ($this->viewbag['state']=="SENT_MEETING_ACK") ||
            ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
            ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        <div id="accordionDetailofMeeting">
            <div class="card">
                <div class="card-header" style="background-color: #412911">
                    <a class="card-link" data-toggle="collapse" href="#detailofMeeting"
                       onclick="cardSelected('detailofMeetingIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">Details of Meeting</h5></div>
                            <div class="col-1">
                                <img id="detailofMeetingIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="detailofMeeting" class="collapse" data-parent="#accordionDetailofMeeting">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">1<span style="vertical-align: super; font-size: 10px" class="pr-1">st</span>Preferred Meeting Date & Time:</span>
                                    </div>
                                    <input id="meetingFirstPreferMeetingDate" name="meetingFirstPreferMeetingDate" type="text"
                                           placeholder="YYYY-mm-dd hh:mi" class="form-control" autocomplete="off">
                                </div>
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">2<span style="vertical-align: super; font-size: 10px" class="pr-1">nd</span> Preferred Meeting Date & Time:</span>
                                    </div>
                                    <input id="meetingSecondPreferMeetingDate" name="meetingSecondPreferMeetingDate" type="text"
                                           placeholder="YYYY-mm-dd hh:mi" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Actual Meeting Date & Time:</span>
                                    </div>
                                    <input id="meetingActualMeetingDate" name="meetingActualMeetingDate" type="text"
                                           placeholder="YYYY-mm-dd hh:mi" class="form-control" autocomplete="off">
                                </div>
                                <div class="input-group col-6">
                                    <input class="btn btn-primary form-control" type="button" name="resendMeetingRequestBtn"
                                           id="resendMeetingRequestBtn" value="Resend Meeting Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Reason of Rejection:</span>
                                    </div>
                                    <input id="meetingRejReason" name="meetingRejReason" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Consented by Consultant: </span>
                                    </div>
                                    <div class="form-check-inline pl-4">
                                        <?php if (($this->viewbag['meetingConsentConsultant']) == 'Y') { ?>
                                        <input id="meetingConsentConsultant" name="meetingConsentConsultant" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="meetingConsentConsultant" name="meetingConsentConsultant" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Consented by Project Owner: </span>
                                    </div>
                                    <div class="form-check-inline pl-4">
                                        <?php if (($this->viewbag['meetingConsentOwner']) == 'Y') { ?>
                                            <input id="meetingConsentOwner" name="meetingConsentOwner" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="meetingConsentOwner" name="meetingConsentOwner" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Remarks (Sensitive equipment of infrastructure):</span>
                                    </div>
                                    <input id="meetingRemark" name="meetingRemark" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <?php if (($this->viewbag['meetingReplySlipId']) != '0') { ?>
                            <div class="form-group row">
                                <div class="input-group col-3">
                                    <input class="btn btn-primary form-control" type="button" name="showReplySlipDetailBtn"
                                           id="showReplySlipDetailBtn" value="Show Reply Slip Detail">
                                </div>
                                <div class="input-group col-9">&nbsp;</div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionDetailofReplySlip" style="display: none">
            <div class="card">
                <div class="card-header" style="background-color: #412911">
                    <a class="card-link" data-toggle="collapse" href="#detailofReplySlip" onclick="cardSelected('detailofReplySlipIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light pt-2">Reply Slip Detail</h5></div>
                            <div class="col-1 pt-2">
                                <img id="detailofReplySlipIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png"
                                     width="20px" style="transform: rotate(180deg);"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="detailofReplySlip" class="collapse show" data-parent="#accordionDetailofReplySlip">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">&nbsp;</div>
                            <div class="col-3 pb-2">
                                <input class="btn btn-warning form-control" type="button" name="genReplySlipDetail"
                                       id="genReplySlipDetailBtn" value="Generate Reply Slip File">
                            </div>
                        </div>
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th style="width: 5%">&nbsp;</th>
                                    <th style="width: 30%">Equipment</th>
                                    <th style="width: 25%">Component</th>
                                    <th style="width: 40%">Actual Design Approach</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pt-3" rowspan="2">
                                        <?php if ($this->viewbag['replySlipBmsYesNo'] == 'Y') { ?>
                                        <input id="replySlipBmsYesNo" name="replySlipBmsYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="replySlipBmsYesNo" name="replySlipBmsYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="2">BMS</td>
                                    <td class="pt-3">Server or Central Computer</td>
                                    <td>
                                        <textarea id="replySlipBmsServerCentralComputer" name="replySlipBmsServerCentralComputer"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Distributed digitial control (DDC)</td>
                                    <td>
                                        <textarea id="replySlipBmsDdc" name="replySlipBmsDdc"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3" rowspan="2">
                                        <?php if ($this->viewbag['replySlipChangeoverSchemeYesNo'] == 'Y') { ?>
                                        <input id="replySlipChangeoverSchemeYesNo" name="replySlipChangeoverSchemeYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipChangeoverSchemeYesNo" name="replySlipChangeoverSchemeYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="2">Changeover Scheme</td>
                                    <td class="pt-3">Controls, relays, main contractor</td>
                                    <td>
                                        <textarea id="replySlipChangeoverSchemeControl" name="replySlipChangeoverSchemeControl"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Under-voltage (UV) relay</td>
                                    <td>
                                        <textarea id="replySlipChangeoverSchemeUv" name="replySlipChangeoverSchemeUv"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['replySlipChillerPlantYesNo'] == 'Y') { ?>
                                        <input id="replySlipChillerPlantYesNo" name="replySlipChillerPlantYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipChillerPlantYesNo" name="replySlipChillerPlantYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">
                                        <div>Chiller Plant</div>
                                        <div class="py-2">
                                            <textarea id="replySlipChillerPlantAhuControl" name="replySlipChillerPlantAhuControl"
                                                  type="text" class="form-control"></textarea>
                                        </div>
                                        <div>
                                            <textarea id="replySlipChillerPlantAhuStartup" name="replySlipChillerPlantAhuStartup"
                                                      type="text" class="form-control"></textarea>
                                        </div>
                                    </td>
                                    <td class="pt-3">VSD Mitigation</td>
                                    <td>
                                        <textarea id="replySlipChillerPlantVsd" name="replySlipChillerPlantVsd"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">AHU, chilled water pump</td>
                                    <td>
                                        <div class="py-2">
                                            <textarea id="replySlipChillerPlantAhuChilledWater" name="replySlipChillerPlantAhuChilledWater"
                                                       type="text" class="form-control"></textarea>
                                        </div>
                                        <div>
                                            <textarea id="replySlipChillerPlantStandbyAhu" name="replySlipChillerPlantStandbyAhu"
                                                      type="text" class="form-control"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Chiller</td>
                                    <td>
                                        <textarea id="replySlipChillerPlantChiller" name="replySlipChillerPlantChiller"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['replySlipEscalatorYesNo'] == 'Y') { ?>
                                        <input id="replySlipEscalatorYesNo" name="replySlipEscalatorYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipEscalatorYesNo" name="replySlipEscalatorYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">
                                        <div>Escalator</div>
                                        <div class="py-2">
                                            <textarea id="replySlipEscalatorMotorStartup" name="replySlipEscalatorMotorStartup"
                                                      type="text" class="form-control"></textarea>
                                        </div>
                                    </td>
                                    <td class="pt-3">VSD Mitigation</td>
                                    <td>
                                        <textarea id="replySlipEscalatorVsdMitigation" name="replySlipEscalatorVsdMitigation"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Braking system</td>
                                    <td>
                                        <textarea id="replySlipEscalatorBrakingSystem" name="replySlipEscalatorBrakingSystem"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Controls</td>
                                    <td>
                                        <textarea id="replySlipEscalatorControl" name="replySlipEscalatorControl"
                                               type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['replySlipHidLampYesNo'] == 'Y') { ?>
                                        <input id="replySlipHidLampYesNo" name="replyHidLampYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipHidLampYesNo" name="replyHidLampYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">High Intensity Discharge Lamp</td>
                                    <td class="pt-3">Ballast & Add-on protection</td>
                                    <td>
                                        <textarea id="replySlipHidLampMitigation" name="replySlipHidLampMitigation"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['replySlipLiftYesNo'] == 'Y') { ?>
                                        <input id="replySlipLiftYesNo" name="replyLiftYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipLiftYesNo" name="replyLiftYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Lift</td>
                                    <td class="pt-3">Controls</td>
                                    <td>
                                        <textarea id="replySlipLiftOperation" name="replySlipLiftOperation"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['replySlipSensitiveMachineYesNo'] == 'Y') { ?>
                                        <input id="replySlipSensitiveMachineYesNo" name="replySlipSensitiveMachineYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipSensitiveMachineYesNo" name="replySlipSensitiveMachineYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Sensitive Machine</td>
                                    <td class="pt-3">Medical equipment, Controls, PLC</td>
                                    <td>
                                        <textarea id="replySlipSensitiveMachineMitigation"
                                               name="replySlipSensitiveMachineMitigation"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['replySlipTelecomMachineYesNo'] == 'Y') { ?>
                                        <input id="replySlipTelecomMachineYesNo" name="replySlipTelecomMachineYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipTelecomMachineYesNo" name="replySlipTelecomMachineYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">Telecom, IT Equipment, Data Centre & Harmonic</td>
                                    <td class="pt-3">Server or computer</td>
                                    <td>
                                        <textarea id="replySlipTelecomMachineServerOrComputer"
                                               name="replySlipTelecomMachineServerOrComputer"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Peripherals such as modem, router</td>
                                    <td>
                                        <textarea id="replySlipTelecomMachinePeripherals"
                                               name="replySlipTelecomMachinePeripherals"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <textarea id="replySlipTelecomMachineHarmonicEmission"
                                               name="replySlipTelecomMachineHarmonicEmission"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['replySlipAirConditionersYesNo'] == 'Y') { ?>
                                        <input id="replySlipAirConditionersYesNo" name="replySlipAirConditionersYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipAirConditionersYesNo" name="replySlipAirConditionersYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">Air-conditioners & ACB at Residential Building</td>
                                    <td class="pt-3">Protection facilities of Main Incoming Circuit Breaker</td>
                                    <td>
                                        <textarea id="replySlipAirConditionersMicb"
                                               name="replySlipAirConditionersMicb"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Load forecasting for air-conditioning load</td>
                                    <td>
                                        <textarea id="replySlipAirConditionersLoadForecasting"
                                               name="replySlipAirConditionersLoadForecasting"
                                            type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Type of Air-conditioner</td>
                                    <td>
                                        <textarea id="replySlipAirConditionersType"
                                               name="replySlipAirConditionersType"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['replySlipNonLinearLoadYesNo'] == 'Y') { ?>
                                        <input id="replySlipNonLinearLoadYesNo" name="replySlipNonLinearLoadYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipNonLinearLoadYesNo" name="replySlipNonLinearLoadYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">
                                        Buildings with high penetration of energy efficient equipment, e.g. LED
                                        lighting, VSD Air Conditioner, and other non-linear loads etc.
                                    </td>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <textarea id="replySlipNonLinearLoadHarmonicEmission"
                                               name="replySlipNonLinearLoadHarmonicEmission"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3" rowspan="2">
                                        <?php if ($this->viewbag['replySlipRenewableEnergyYesNo'] == 'Y') { ?>
                                        <input id="replySlipRenewableEnergyYesNo" name="replySlipRenewableEnergyYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipRenewableEnergyYesNo" name="replySlipRenewableEnergyYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="2">Renewable Energy, e.g. photovoltaic or wind energy system etc.</td>
                                    <td class="pt-3">Inventer, controls</td>
                                    <td>
                                        <textarea id="replySlipRenewableEnergyInverterAndControls"
                                               name="replySlipRenewableEnergyInverterAndControls"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <textarea id="replySlipRenewableEnergyHarmonicEmission"
                                               name="replySlipRenewableEnergyHarmonicEmission"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['replySlipEvChargerSystemYesNo'] == 'Y') { ?>
                                        <input id="replySlipEvChargerSystemYesNo" name="replySlipEvChargerSystemYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipEvChargerSystemYesNo" name="replySlipEvChargerSystemYesNo"
                                               type="checkbox" class="form-control" value="Y"
                                               style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">EV charger system</td>
                                    <td class="pt-3">
                                        <table class="table-borderless">
                                            <tr>
                                                <td>
                                                    <?php if ($this->viewbag['replySlipEvControlYesNo'] == 'Y') { ?>
                                                        <input id="replySlipEvControlYesNo" name="replySlipEvControlYesNo"
                                                               type="checkbox" class="form-control" value="Y"
                                                               style="width:25px; height: 25px" checked>
                                                    <?php } else { ?>
                                                        <input id="replySlipEvControlYesNo" name="replySlipEvControlYesNo"
                                                               type="checkbox" class="form-control" value="Y"
                                                               style="width:25px; height: 25px">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    EV charger
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <textarea id="replySlipEvChargerSystemEvCharger"
                                               name="replySlipEvChargerSystemEvCharger"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <table class="table-borderless">
                                            <tr>
                                                <td>
                                                    <?php if ($this->viewbag['replySlipEvChargerSystemSmartYesNo'] == 'Y') { ?>
                                                        <input id="replySlipEvChargerSystemSmartYesNo" name="replySlipEvChargerSystemSmartYesNo"
                                                               type="checkbox" class="form-control" value="Y"
                                                               style="width:25px; height: 25px" checked>
                                                    <?php } else { ?>
                                                        <input id="replySlipEvChargerSystemSmartYesNo" name="replySlipEvChargerSystemSmartYesNo"
                                                               type="checkbox" class="form-control" value="Y"
                                                               style="width:25px; height: 25px">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    Load management system
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <textarea id="replySlipEvChargerSystemSmartChargingSystem"
                                               name="replySlipEvChargerSystemSmartChargingSystem"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <textarea id="replySlipEvChargerSystemHarmonicEmission"
                                               name="replySlipEvChargerSystemHarmonicEmission"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Submitted by</td>
                                    <td>
                                        <input id="replySlipConsultantNameConfirmation"
                                                  name="replySlipConsultantNameConfirmation"
                                                  type="text" class="form-control">
                                    </td>
                                    <td class="font-weight-bold">Company</td>
                                    <td>
                                        <input id="replySlipConsultantCompany"
                                               name="replySlipConsultantCompany"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Project Owner Name</td>
                                    <td>
                                        <input id="replySlipProjectOwnerNameConfirmation"
                                               name="replySlipProjectOwnerNameConfirmation"
                                               type="text" class="form-control">
                                    </td>
                                    <td class="font-weight-bold">Project Owner Company</td>
                                    <td>
                                        <input id="replySlipProjectOwnerCompany"
                                               name="replySlipProjectOwnerCompany"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
            ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
            <div id="accordionDetailofFirstInvitation">
                <div class="card">
                    <div class="card-header" style="background-color: #123b1a">
                        <a class="card-link" data-toggle="collapse" href="#detailofFirstInvitation"
                           onclick="cardSelected('detailofFirstInvitationIcon');">
                            <div class="row">
                                <div class="col-11"><h5 class="text-light">Details of 1<span style="vertical-align: super; font-size: 10px">st</span> Invitation Letter</h5></div>
                                <div class="col-1">
                                    <img id="detailofFirstInvitationIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div id="detailofFirstInvitation" class="collapse" data-parent="#accordionDetailofFirstInvitation">
                        <div class="card-body">
                            <div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Issue Date:</span>
                                        </div>
                                        <input id="firstInvitationLetterIssueDate" name="firstInvitationLetterIssueDate"
                                               type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fax Reference No.:</span>
                                        </div>
                                        <input id="firstInvitationLetterFaxRefNo" name="firstInvitationLetterFaxRefNo"
                                               type="text" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="input-group col-4">
                                        <input class="btn btn-primary form-control" type="button" name="genFirstInvitationLetterBtn"
                                               id="genFirstInvitationLetterBtn" value="Export Invitation Letter">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">EDMS Link:</span>
                                        </div>
                                        <input id="firstInvitationLetterEdmsLink" name="firstInvitationLetterEdmsLink" type="text"
                                               class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Accepted: </span>
                                        </div>
                                        <?php if ($this->viewbag['firstInvitationLetterAccept'] == 'Y') { ?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="firstInvitationLetterAccept"
                                                           class="form-check-input" value="Y" checked>Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="firstInvitationLetterAccept"
                                                           class="form-check-input" value="N">No
                                                </label>
                                            </div>
                                        <?php } else if ($this->viewbag['firstInvitationLetterAccept'] == 'N') {?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="firstInvitationLetterAccept"
                                                           class="form-check-input" value="Y">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="firstInvitationLetterAccept"
                                                           class="form-check-input" value="N" checked>No
                                                </label>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="firstInvitationLetterAccept"
                                                           class="form-check-input" value="Y">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="firstInvitationLetterAccept"
                                                           class="form-check-input" value="N">No
                                                </label>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Date of PQ Walk:</span>
                                        </div>
                                        <input id="firstInvitationLetterWalkDate" name="firstInvitationLetterWalkDate"
                                               type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
            ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
            <div id="accordionDetailofSecondInvitation">
                <div class="card">
                    <div class="card-header" style="background-color: #123b1a">
                        <a class="card-link" data-toggle="collapse" href="#detailofSecondInvitation"
                           onclick="cardSelected('detailofSecondInvitationIcon');">
                            <div class="row">
                                <div class="col-11"><h5 class="text-light">Details of 2<span style="vertical-align: super; font-size: 10px">nd</span> Invitation Letter</h5></div>
                                <div class="col-1">
                                    <img id="detailofSecondInvitationIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div id="detailofSecondInvitation" class="collapse" data-parent="#accordionDetailofSecondInvitation">
                        <div class="card-body">
                            <div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Issue Date:</span>
                                        </div>
                                        <input id="secondInvitationLetterIssueDate" name="secondInvitationLetterIssueDate"
                                               type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fax Reference No.:</span>
                                        </div>
                                        <input id="secondInvitationLetterFaxRefNo" name="secondInvitationLetterFaxRefNo"
                                               type="text" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="input-group col-4">
                                        <input class="btn btn-primary form-control" type="button" name="genSecondInvitationLetterBtn"
                                               id="genSecondInvitationLetterBtn" value="Export Invitation Letter">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">EDMS Link:</span>
                                        </div>
                                        <input id="secondInvitationLetterEdmsLink" name="secondInvitationLetterEdmsLink" type="text"
                                               class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Accepted: </span>
                                        </div>
                                        <?php if ($this->viewbag['secondInvitationLetterAccept'] == 'Y') { ?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="secondInvitationLetterAccept"
                                                           class="form-check-input" value="Y" checked>Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="secondInvitationLetterAccept"
                                                           class="form-check-input" value="N">No
                                                </label>
                                            </div>
                                        <?php } else if ($this->viewbag['secondInvitationLetterAccept'] == 'N') {?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="secondInvitationLetterAccept"
                                                           class="form-check-input" value="Y">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="secondInvitationLetterAccept"
                                                           class="form-check-input" value="N" checked>No
                                                </label>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="secondInvitationLetterAccept"
                                                           class="form-check-input" value="Y">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="secondInvitationLetterAccept"
                                                           class="form-check-input" value="N">No
                                                </label>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Date of PQ Walk:</span>
                                        </div>
                                        <input id="secondInvitationLetterWalkDate" name="secondInvitationLetterWalkDate"
                                               type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
            ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
            <div id="accordionDetailofThirdInvitation">
                <div class="card">
                    <div class="card-header" style="background-color: #123b1a">
                        <a class="card-link" data-toggle="collapse" href="#detailofThirdInvitation"
                           onclick="cardSelected('detailofThirdInvitationIcon');">
                            <div class="row">
                                <div class="col-11"><h5 class="text-light">Details of 3<span style="vertical-align: super; font-size: 10px">rd</span> Invitation Letter</h5></div>
                                <div class="col-1">
                                    <img id="detailofThirdInvitationIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div id="detailofThirdInvitation" class="collapse" data-parent="#accordionDetailofThirdInvitation">
                        <div class="card-body">
                            <div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Issue Date:</span>
                                        </div>
                                        <input id="thirdInvitationLetterIssueDate" name="thirdInvitationLetterIssueDate"
                                               type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fax Reference No.:</span>
                                        </div>
                                        <input id="thirdInvitationLetterFaxRefNo" name="thirdInvitationLetterFaxRefNo"
                                               type="text" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="input-group col-4">
                                        <input class="btn btn-primary form-control" type="button" name="genThirdInvitationLetterBtn"
                                               id="genThirdInvitationLetterBtn" value="Export Invitation Letter">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">EDMS Link:</span>
                                        </div>
                                        <input id="thirdInvitationLetterEdmsLink" name="thirdInvitationLetterEdmsLink" type="text"
                                               class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Accepted: </span>
                                        </div>
                                        <?php if ($this->viewbag['thirdInvitationLetterAccept'] == 'Y') { ?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="thirdInvitationLetterAccept"
                                                           class="form-check-input" value="Y" checked>Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="thirdInvitationLetterAccept"
                                                           class="form-check-input" value="N">No
                                                </label>
                                            </div>
                                        <?php } else if ($this->viewbag['thirdInvitationLetterAccept'] == 'N') {?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="thirdInvitationLetterAccept"
                                                           class="form-check-input" value="Y">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="thirdInvitationLetterAccept"
                                                           class="form-check-input" value="N" checked>No
                                                </label>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="thirdInvitationLetterAccept"
                                                           class="form-check-input" value="Y">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="thirdInvitationLetterAccept"
                                                           class="form-check-input" value="N">No
                                                </label>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Date of PQ Walk:</span>
                                        </div>
                                        <input id="thirdInvitationLetterWalkDate" name="thirdInvitationLetterWalkDate"
                                               type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <?php if (($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
            ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        <div id="accordionDetailOfEvaluationReport">
            <div class="card">
                <div class="card-header" style="background-color: #3a1b44">
                    <a class="card-link" data-toggle="collapse" href="#detailOfEvaluationReport"
                       onclick="cardSelected('detailOfEvaluationReportIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">Details of Evaluation Report</h5></div>
                            <div class="col-1">
                                <img id="detailOfEvaluationReportIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="detailOfEvaluationReport" class="collapse" data-parent="#accordionDetailOfEvaluationReport">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Evaluation Score:</span>
                                    </div>
                                    <input id="evaReportScore" name="evaReportScore"
                                           type="text" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Remark (Project Comment on Circuit Drawings / Technical Specifications):</span>
                                    </div>
                                    <input id="evaReportRemark" name="evaReportRemark"
                                           type="text" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">EDMS Link of Report:</span>
                                    </div>
                                    <input id="evaReportEdmsLink" name="evaReportEdmsLink"
                                           type="text" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-3">
                                    <input class="btn btn-primary form-control" type="button" name="showEvaReport"
                                           id="showEvaReportBtn" value="Show Evaluation Report Detail">
                                </div>
                                <div class="input-group col-9">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionDetailOfEvaluationReportDetail" style="display: none">
            <div class="card">
                <div class="card-header" style="background-color: #3a1b44">
                    <a class="card-link" data-toggle="collapse" href="#detailOfEvaluationReportDetail" onclick="cardSelected('detailOfEvaluationReportDetailIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light pt-2">Evaluation Report Detail</h5></div>
                            <div class="col-1 pt-2">
                                <img id="detailOfEvaluationReportDetail" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png"
                                     width="20px" style="transform: rotate(180deg);"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="detailOfEvaluationReportDetail" class="collapse show" data-parent="#accordionDetailOfEvaluationReportDetail">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">&nbsp;</div>
                            <div class="col-3 pb-2">
                                <input class="btn btn-warning form-control" type="submit" name="genEvaluationReportDetail"
                                       id="genEvaluationReportDetail" value="Generate Evaluation Report">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="input-group col-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Issue Date:</span>
                                </div>
                                <input id="evaReportIssueDate" name="evaReportIssueDate"
                                       type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="input-group col-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Fax Reference No.:</span>
                                </div>
                                <input id="evaReportFaxRefNo" name="evaReportFaxRefNo"
                                       type="text" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th style="width: 3%">&nbsp;</th>
                                    <th style="width: 15%">Equipment</th>
                                    <th style="width: 3%">&nbsp;</th>
                                    <th style="width: 15%">Component</th>
                                    <th style="width: 29%">Findings during PQ Site Walk</th>
                                    <th style="width: 30%">Any further PQ recommendations</th>
                                    <th style="width: 5%">Pass?</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="pt-3" rowspan="3">
                                    <?php if ($this->viewbag['evaReportBmsYesNo'] == 'Y') { ?>
                                        <input id="evaReportBmsYesNo" name="evaReportBmsYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportBmsYesNo" name="evaReportBmsYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="3">BMS</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportBmsServerCentralComputerYesNo'] == 'Y') { ?>
                                        <input id="evaReportBmsServerCentralComputerYesNo"
                                               name="evaReportBmsServerCentralComputerYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportBmsServerCentralComputerYesNo"
                                               name="evaReportBmsServerCentralComputerYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Server or Central Computer</td>
                                <td>
                                        <textarea id="evaReportBmsServerCentralComputerFinding"
                                                  name="evaReportBmsServerCentralComputerFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportBmsServerCentralComputerRecommend"
                                                  name="evaReportBmsServerCentralComputerRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportBmsServerCentralComputerPass'] == 'Y') { ?>
                                        <input id="evaReportBmsServerCentralComputerPass"
                                               name="evaReportBmsServerCentralComputerPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportBmsServerCentralComputerPass"
                                               name="evaReportBmsServerCentralComputerPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportBmsDdcYesNo'] == 'Y') { ?>
                                        <input id="evaReportBmsDdcYesNo"
                                               name="evaReportBmsDdcYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportBmsDdcYesNo"
                                               name="evaReportBmsDdcYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Distributed Digital Control (DDC)</td>
                                <td>
                                        <textarea id="evaReportBmsDdcFinding"
                                                  name="evaReportBmsDdcFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportBmsDdcRecommend"
                                                  name="evaReportBmsDdcRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportBmsDdcPass'] == 'Y') { ?>
                                        <input id="evaReportBmsDdcPass"
                                               name="evaReportBmsDdcPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportBmsDdcPass"
                                               name="evaReportBmsDdcPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportBmsSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportBmsSupplementYesNo"
                                               name="evaReportBmsSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportBmsSupplementYesNo"
                                               name="evaReportBmsSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportBmsSupplement"
                                                  name="evaReportBmsSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportBmsSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportBmsSupplementPass"
                                               name="evaReportBmsSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportBmsSupplementPass"
                                               name="evaReportBmsSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="3">
                                    <?php if ($this->viewbag['evaReportChangeoverSchemeYesNo'] == 'Y') { ?>
                                        <input id="evaReportChangeoverSchemeYesNo" name="evaReportChangeoverSchemeYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChangeoverSchemeYesNo" name="evaReportChangeoverSchemeYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="3">Changeover Scheme</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChangeoverSchemeControlYesNo'] == 'Y') { ?>
                                        <input id="evaReportChangeoverSchemeControlYesNo"
                                               name="evaReportChangeoverSchemeControlYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChangeoverSchemeControlYesNo"
                                               name="evaReportChangeoverSchemeControlYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Controls, relays, main contactor</td>
                                <td>
                                        <textarea id="evaReportChangeoverSchemeControlFinding"
                                                  name="evaReportChangeoverSchemeControlFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportChangeoverSchemeControlRecommend"
                                                  name="evaReportChangeoverSchemeControlRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChangeoverSchemeControlPass'] == 'Y') { ?>
                                        <input id="evaReportChangeoverSchemeControlPass"
                                               name="evaReportChangeoverSchemeControlPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChangeoverSchemeControlPass"
                                               name="evaReportChangeoverSchemeControlPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChangeoverSchemeUvYesNo'] == 'Y') { ?>
                                        <input id="evaReportChangeoverSchemeUvYesNo"
                                               name="evaReportChangeoverSchemeUvYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChangeoverSchemeUvYesNo"
                                               name="evaReportChangeoverSchemeUvYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Under-voltage (UV) relay</td>
                                <td>
                                        <textarea id="evaReportChangeoverSchemeUvFinding"
                                                  name="evaReportChangeoverSchemeUvFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportChangeoverSchemeUvRecommend"
                                                  name="evaReportChangeoverSchemeUvRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChangeoverSchemeUvPass'] == 'Y') { ?>
                                        <input id="evaReportChangeoverSchemeUvPass"
                                               name="evaReportChangeoverSchemeUvPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChangeoverSchemeUvPass"
                                               name="evaReportChangeoverSchemeUvPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChangeoverSchemeSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportChangeoverSchemeSupplementYesNo"
                                               name="evaReportChangeoverSchemeSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChangeoverSchemeSupplementYesNo"
                                               name="evaReportChangeoverSchemeSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportChangeoverSchemeSupplement"
                                                  name="evaReportChangeoverSchemeSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChangeoverSchemeSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportChangeoverSchemeSupplementPass"
                                               name="evaReportChangeoverSchemeSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChangeoverSchemeSupplementPass"
                                               name="evaReportChangeoverSchemeSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="3">
                                    <?php if ($this->viewbag['evaReportChillerPlantYesNo'] == 'Y') { ?>
                                        <input id="evaReportChillerPlantYesNo" name="evaReportChillerPlantYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChillerPlantYesNo" name="evaReportChillerPlantYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="3">Chiller Plant</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChillerPlantAhuChilledWaterYesNo'] == 'Y') { ?>
                                        <input id="evaReportChillerPlantAhuChilledWaterYesNo"
                                               name="evaReportChillerPlantAhuChilledWaterYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChillerPlantAhuChilledWaterYesNo"
                                               name="evaReportChillerPlantAhuChilledWaterYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">AHU, chilled/ condenser water pump</td>
                                <td>
                                        <textarea id="evaReportChillerPlantAhuChilledWaterFinding"
                                                  name="evaReportChillerPlantAhuChilledWaterFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportChillerPlantAhuChilledWaterRecommend"
                                                  name="evaReportChillerPlantAhuChilledWaterRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChillerPlantAhuChilledWaterPass'] == 'Y') { ?>
                                        <input id="evaReportChillerPlantAhuChilledWaterPass"
                                               name="evaReportChillerPlantAhuChilledWaterPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChillerPlantAhuChilledWaterPass"
                                               name="evaReportChillerPlantAhuChilledWaterPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChillerPlantChillerYesNo'] == 'Y') { ?>
                                        <input id="evaReportChillerPlantChillerYesNo"
                                               name="evaReportChillerPlantChillerYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChillerPlantChillerYesNo"
                                               name="evaReportChillerPlantChillerYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Chiller</td>
                                <td>
                                        <textarea id="evaReportChillerPlantChillerFinding"
                                                  name="evaReportChillerPlantChillerFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportChillerPlantChillerRecommend"
                                                  name="evaReportChillerPlantChillerRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChillerPlantChillerPass'] == 'Y') { ?>
                                        <input id="evaReportChillerPlantChillerPass"
                                               name="evaReportChillerPlantChillerPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChillerPlantChillerPass"
                                               name="evaReportChillerPlantChillerPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChillerPlantSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportChillerPlantSupplementYesNo"
                                               name="evaReportChillerPlantSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChillerPlantSupplementYesNo"
                                               name="evaReportChillerPlantSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportChillerPlantSupplement"
                                                  name="evaReportChillerPlantSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportChillerPlantSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportChillerPlantSupplementPass"
                                               name="evaReportChillerPlantSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportChillerPlantSupplementPass"
                                               name="evaReportChillerPlantSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="3">
                                    <?php if ($this->viewbag['evaReportEscalatorYesNo'] == 'Y') { ?>
                                        <input id="evaReportEscalatorYesNo" name="evaReportEscalatorYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEscalatorYesNo" name="evaReportEscalatorYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="3">Escalator</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEscalatorBrakingSystemYesNo'] == 'Y') { ?>
                                        <input id="evaReportEscalatorBrakingSystemYesNo"
                                               name="evaReportEscalatorBrakingSystemYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEscalatorBrakingSystemYesNo"
                                               name="evaReportEscalatorBrakingSystemYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Braking system</td>
                                <td>
                                        <textarea id="evaReportEscalatorBrakingSystemFinding"
                                                  name="evaReportEscalatorBrakingSystemFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportEscalatorBrakingSystemRecommend"
                                                  name="evaReportEscalatorBrakingSystemRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEscalatorBrakingSystemPass'] == 'Y') { ?>
                                        <input id="evaReportEscalatorBrakingSystemPass"
                                               name="evaReportEscalatorBrakingSystemPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEscalatorBrakingSystemPass"
                                               name="evaReportEscalatorBrakingSystemPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEscalatorControlYesNo'] == 'Y') { ?>
                                        <input id="evaReportEscalatorControlYesNo"
                                               name="evaReportEscalatorControlYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEscalatorControlYesNo"
                                               name="evaReportEscalatorControlYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Controls</td>
                                <td>
                                        <textarea id="evaReportEscalatorControlFinding"
                                                  name="evaReportEscalatorControlFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportEscalatorControlRecommend"
                                                  name="evaReportEscalatorControlRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEscalatorControlPass'] == 'Y') { ?>
                                        <input id="evaReportEscalatorControlPass"
                                               name="evaReportEscalatorControlPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEscalatorControlPass"
                                               name="evaReportEscalatorControlPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEscalatorSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportEscalatorSupplementYesNo"
                                               name="evaReportEscalatorSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEscalatorSupplementYesNo"
                                               name="evaReportEscalatorSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportEscalatorSupplement"
                                                  name="evaReportEscalatorSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEscalatorSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportEscalatorSupplementPass"
                                               name="evaReportEscalatorSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEscalatorSupplementPass"
                                               name="evaReportEscalatorSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="3">
                                    <?php if ($this->viewbag['evaReportHidLampYesNo'] == 'Y') { ?>
                                        <input id="evaReportHidLampYesNo" name="evaReportHidLampYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportHidLampYesNo" name="evaReportHidLampYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="3">LED Lighting</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportHidLampBallastYesNo'] == 'Y') { ?>
                                        <input id="evaReportHidLampBallastYesNo"
                                               name="evaReportHidLampBallastYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportHidLampBallastYesNo"
                                               name="evaReportHidLampBallastYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Ballast</td>
                                <td>
                                        <textarea id="evaReportHidLampBallastFinding"
                                                  name="evaReportHidLampBallastFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportHidLampBallastRecommend"
                                                  name="evaReportHidLampBallastRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportHidLampBallastPass'] == 'Y') { ?>
                                        <input id="evaReportHidLampBallastPass"
                                               name="evaReportHidLampBallastPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportHidLampBallastPass"
                                               name="evaReportHidLampBallastPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportHidLampAddonProtectYesNo'] == 'Y') { ?>
                                        <input id="evaReportHidLampAddonProtectYesNo"
                                               name="evaReportHidLampAddonProtectYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportHidLampAddonProtectYesNo"
                                               name="evaReportHidLampAddonProtectYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Add-on protection</td>
                                <td>
                                        <textarea id="evaReportHidLampAddonProtectFinding"
                                                  name="evaReportHidLampAddonProtectFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportHidLampAddonProtectRecommend"
                                                  name="evaReportHidLampAddonProtectRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportHidLampAddonProtectPass'] == 'Y') { ?>
                                        <input id="evaReportHidLampAddonProtectPass"
                                               name="evaReportHidLampAddonProtectPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportHidLampAddonProtectPass"
                                               name="evaReportHidLampAddonProtectPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportHidLampSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportHidLampSupplementYesNo"
                                               name="evaReportHidLampSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportHidLampSupplementYesNo"
                                               name="evaReportHidLampSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportHidLampSupplement"
                                                  name="evaReportHidLampSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportHidLampSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportHidLampSupplementPass"
                                               name="evaReportHidLampSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportHidLampSupplementPass"
                                               name="evaReportHidLampSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="3">
                                    <?php if ($this->viewbag['evaReportLiftYesNo'] == 'Y') { ?>
                                        <input id="evaReportLiftYesNo" name="evaReportLiftYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportLiftYesNo" name="evaReportLiftYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="3">Lift</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportLiftOperationYesNo'] == 'Y') { ?>
                                        <input id="evaReportLiftOperationYesNo"
                                               name="evaReportLiftOperationYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportLiftOperationYesNo"
                                               name="evaReportLiftOperationYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Controls</td>
                                <td>
                                        <textarea id="evaReportLiftOperationFinding"
                                                  name="evaReportLiftOperationFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportLiftOperationRecommend"
                                                  name="evaReportLiftOperationRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportLiftOperationPass'] == 'Y') { ?>
                                        <input id="evaReportLiftOperationPass"
                                               name="evaReportLiftOperationPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportLiftOperationPass"
                                               name="evaReportLiftOperationPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportLiftMainSupplyYesNo'] == 'Y') { ?>
                                        <input id="evaReportLiftMainSupplyYesNo"
                                               name="evaReportLiftMainSupplyYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportLiftMainSupplyYesNo"
                                               name="evaReportLiftMainSupplyYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Main Supply</td>
                                <td>
                                        <textarea id="evaReportLiftMainSupplyFinding"
                                                  name="evaReportLiftMainSupplyFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportLiftMainSupplyRecommend"
                                                  name="evaReportLiftMainSupplyRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportLiftMainSupplyPass'] == 'Y') { ?>
                                        <input id="evaReportLiftMainSupplyPass"
                                               name="evaReportLiftMainSupplyPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportLiftMainSupplyPass"
                                               name="evaReportLiftMainSupplyPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportLiftSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportLiftSupplementYesNo"
                                               name="evaReportLiftSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportLiftSupplementYesNo"
                                               name="evaReportLiftSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportLiftSupplement"
                                                  name="evaReportLiftSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportLiftSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportLiftSupplementPass"
                                               name="evaReportLiftSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportLiftSupplementPass"
                                               name="evaReportLiftSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="2">
                                    <?php if ($this->viewbag['evaReportSensitiveMachineYesNo'] == 'Y') { ?>
                                        <input id="evaReportSensitiveMachineYesNo" name="evaReportSensitiveMachineYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportSensitiveMachineYesNo" name="evaReportSensitiveMachineYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="2">Sensitive Machine</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportSensitiveMachineMedicalYesNo'] == 'Y') { ?>
                                        <input id="evaReportSensitiveMachineMedicalYesNo"
                                               name="evaReportSensitiveMachineMedicalYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportSensitiveMachineMedicalYesNo"
                                               name="evaReportSensitiveMachineMedicalYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Medical equipment, Controls, PLC</td>
                                <td>
                                        <textarea id="evaReportSensitiveMachineMedicalFinding"
                                                  name="evaReportSensitiveMachineMedicalFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportSensitiveMachineMedicalRecommend"
                                                  name="evaReportSensitiveMachineMedicalRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportSensitiveMachineMedicalPass'] == 'Y') { ?>
                                        <input id="evaReportSensitiveMachineMedicalPass"
                                               name="evaReportSensitiveMachineMedicalPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportSensitiveMachineMedicalPass"
                                               name="evaReportSensitiveMachineMedicalPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportSensitiveMachineSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportSensitiveMachineSupplementYesNo"
                                               name="evaReportSensitiveMachineSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportSensitiveMachineSupplementYesNo"
                                               name="evaReportSensitiveMachineSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportSensitiveMachineSupplement"
                                                  name="evaReportSensitiveMachineSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportSensitiveMachineSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportSensitiveMachineSupplementPass"
                                               name="evaReportSensitiveMachineSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportSensitiveMachineSupplementPass"
                                               name="evaReportSensitiveMachineSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="4">
                                    <?php if ($this->viewbag['evaReportTelecomMachineYesNo'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachineYesNo" name="evaReportTelecomMachineYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachineYesNo" name="evaReportTelecomMachineYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="4">Telecom, IT Equipment, Data Centre & Harmonic</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportTelecomMachineServerOrComputerYesNo'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachineServerOrComputerYesNo"
                                               name="evaReportTelecomMachineServerOrComputerYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachineServerOrComputerYesNo"
                                               name="evaReportTelecomMachineServerOrComputerYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Server or computer</td>
                                <td>
                                        <textarea id="evaReportTelecomMachineServerOrComputerFinding"
                                                  name="evaReportTelecomMachineServerOrComputerFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportTelecomMachineServerOrComputerRecommend"
                                                  name="evaReportTelecomMachineServerOrComputerRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportTelecomMachineServerOrComputerPass'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachineServerOrComputerPass"
                                               name="evaReportTelecomMachineServerOrComputerPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachineServerOrComputerPass"
                                               name="evaReportTelecomMachineServerOrComputerPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportTelecomMachinePeripheralsYesNo'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachinePeripheralsYesNo"
                                               name="evaReportTelecomMachinePeripheralsYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachinePeripheralsYesNo"
                                               name="evaReportTelecomMachinePeripheralsYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Peripherals such as modem, router</td>
                                <td>
                                        <textarea id="evaReportTelecomMachinePeripheralsFinding"
                                                  name="evaReportTelecomMachinePeripheralsFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportTelecomMachinePeripheralsRecommend"
                                                  name="evaReportTelecomMachinePeripheralsRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportTelecomMachinePeripheralsPass'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachinePeripheralsPass"
                                               name="evaReportTelecomMachinePeripheralsPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachinePeripheralsPass"
                                               name="evaReportTelecomMachinePeripheralsPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportTelecomMachineHarmonicEmissionYesNo'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachineHarmonicEmissionYesNo"
                                               name="evaReportTelecomMachineHarmonicEmissionYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachineHarmonicEmissionYesNo"
                                               name="evaReportTelecomMachineHarmonicEmissionYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Harmonic emission</td>
                                <td>
                                        <textarea id="evaReportTelecomMachineHarmonicEmissionFinding"
                                                  name="evaReportTelecomMachineHarmonicEmissionFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportTelecomMachineHarmonicEmissionRecommend"
                                                  name="evaReportTelecomMachineHarmonicEmissionRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportTelecomMachineHarmonicEmissionPass'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachineHarmonicEmissionPass"
                                               name="evaReportTelecomMachineHarmonicEmissionPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachineHarmonicEmissionPass"
                                               name="evaReportTelecomMachineHarmonicEmissionPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportTelecomMachineSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachineSupplementYesNo"
                                               name="evaReportTelecomMachineSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachineSupplementYesNo"
                                               name="evaReportTelecomMachineSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportTelecomMachineSupplement"
                                                  name="evaReportTelecomMachineSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportTelecomMachineSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportTelecomMachineSupplementPass"
                                               name="evaReportTelecomMachineSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportTelecomMachineSupplementPass"
                                               name="evaReportTelecomMachineSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="4">
                                    <?php if ($this->viewbag['evaReportAirConditionersYesNo'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersYesNo" name="evaReportAirConditionersYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersYesNo" name="evaReportAirConditionersYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="4">Air-conditioners</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportAirConditionersMicbYesNo'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersMicbYesNo"
                                               name="evaReportAirConditionersMicbYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersMicbYesNo"
                                               name="evaReportAirConditionersMicbYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Protection Facilities of Main Incoming Circuit Breaker</td>
                                <td>
                                        <textarea id="evaReportAirConditionersMicbFinding"
                                                  name="evaReportAirConditionersMicbFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportAirConditionersMicbRecommend"
                                                  name="evaReportAirConditionersMicbRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportAirConditionersMicbPass'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersMicbPass"
                                               name="evaReportAirConditionersMicbPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersMicbPass"
                                               name="evaReportAirConditionersMicbPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportAirConditionersLoadForecastingYesNo'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersLoadForecastingYesNo"
                                               name="evaReportAirConditionersLoadForecastingYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersLoadForecastingYesNo"
                                               name="evaReportAirConditionersLoadForecastingYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Load forecasting for air-conditioning load</td>
                                <td>
                                        <textarea id="evaReportAirConditionersLoadForecastingFinding"
                                                  name="evaReportAirConditionersLoadForecastingFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportAirConditionersLoadForecastingRecommend"
                                                  name="evaReportAirConditionersLoadForecastingRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportAirConditionersLoadForecastingPass'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersLoadForecastingPass"
                                               name="evaReportAirConditionersLoadForecastingPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersLoadForecastingPass"
                                               name="evaReportAirConditionersLoadForecastingPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportAirConditionersTypeYesNo'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersTypeYesNo"
                                               name="evaReportAirConditionersTypeYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersTypeYesNo"
                                               name="evaReportAirConditionersTypeYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Type of Air-conditioner</td>
                                <td>
                                        <textarea id="evaReportAirConditionersTypeFinding"
                                                  name="evaReportAirConditionersTypeFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportAirConditionersTypeRecommend"
                                                  name="evaReportAirConditionersTypeRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportAirConditionersTypePass'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersTypePass"
                                               name="evaReportAirConditionersTypePass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersTypePass"
                                               name="evaReportAirConditionersTypePass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportAirConditionersSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersSupplementYesNo"
                                               name="evaReportAirConditionersSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersSupplementYesNo"
                                               name="evaReportAirConditionersSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportAirConditionersSupplement"
                                                  name="evaReportAirConditionersSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportAirConditionersSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportAirConditionersSupplementPass"
                                               name="evaReportAirConditionersSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportAirConditionersSupplementPass"
                                               name="evaReportAirConditionersSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="2">
                                    <?php if ($this->viewbag['evaReportNonLinearLoadYesNo'] == 'Y') { ?>
                                        <input id="evaReportNonLinearLoadYesNo" name="evaReportNonLinearLoadYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportNonLinearLoadYesNo" name="evaReportNonLinearLoadYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="2">Buildings with high penetration of energy efficient equipment, e.g. LED lighting, VSD Air Conditioner, and other non-linear loads etc.</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportNonLinearLoadHarmonicEmissionYesNo'] == 'Y') { ?>
                                        <input id="evaReportNonLinearLoadHarmonicEmissionYesNo"
                                               name="evaReportNonLinearLoadHarmonicEmissionYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportNonLinearLoadHarmonicEmissionYesNo"
                                               name="evaReportNonLinearLoadHarmonicEmissionYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Harmonic emission</td>
                                <td>
                                        <textarea id="evaReportNonLinearLoadHarmonicEmissionFinding"
                                                  name="evaReportNonLinearLoadHarmonicEmissionFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportNonLinearLoadHarmonicEmissionRecommend"
                                                  name="evaReportNonLinearLoadHarmonicEmissionRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportNonLinearLoadHarmonicEmissionPass'] == 'Y') { ?>
                                        <input id="evaReportNonLinearLoadHarmonicEmissionPass"
                                               name="evaReportNonLinearLoadHarmonicEmissionPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportNonLinearLoadHarmonicEmissionPass"
                                               name="evaReportNonLinearLoadHarmonicEmissionPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportNonLinearLoadSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportNonLinearLoadSupplementYesNo"
                                               name="evaReportNonLinearLoadSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportNonLinearLoadSupplementYesNo"
                                               name="evaReportNonLinearLoadSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportNonLinearLoadSupplement"
                                                  name="evaReportNonLinearLoadSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportNonLinearLoadSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportNonLinearLoadSupplementPass"
                                               name="evaReportNonLinearLoadSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportNonLinearLoadSupplementPass"
                                               name="evaReportNonLinearLoadSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="3">
                                    <?php if ($this->viewbag['evaReportRenewableEnergyYesNo'] == 'Y') { ?>
                                        <input id="evaReportRenewableEnergyYesNo" name="evaReportRenewableEnergyYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportRenewableEnergyYesNo" name="evaReportRenewableEnergyYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="3">Renewable Energy, e.g. photovoltaic or wind energy system etc.</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportRenewableEnergyInverterAndControlsYesNo'] == 'Y') { ?>
                                        <input id="evaReportRenewableEnergyInverterAndControlsYesNo"
                                               name="evaReportRenewableEnergyInverterAndControlsYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportRenewableEnergyInverterAndControlsYesNo"
                                               name="evaReportRenewableEnergyInverterAndControlsYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Inverter, controls</td>
                                <td>
                                        <textarea id="evaReportRenewableEnergyInverterAndControlsFinding"
                                                  name="evaReportRenewableEnergyInverterAndControlsFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportRenewableEnergyInverterAndControlsRecommend"
                                                  name="evaReportRenewableEnergyInverterAndControlsRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportRenewableEnergyInverterAndControlsPass'] == 'Y') { ?>
                                        <input id="evaReportRenewableEnergyInverterAndControlsPass"
                                               name="evaReportRenewableEnergyInverterAndControlsPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportRenewableEnergyInverterAndControlsPass"
                                               name="evaReportRenewableEnergyInverterAndControlsPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportRenewableEnergyHarmonicEmissionYesNo'] == 'Y') { ?>
                                        <input id="evaReportRenewableEnergyHarmonicEmissionYesNo"
                                               name="evaReportRenewableEnergyHarmonicEmissionYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportRenewableEnergyHarmonicEmissionYesNo"
                                               name="evaReportRenewableEnergyHarmonicEmissionYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Harmonic emission</td>
                                <td>
                                        <textarea id="evaReportRenewableEnergyHarmonicEmissionFinding"
                                                  name="evaReportRenewableEnergyHarmonicEmissionFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportRenewableEnergyHarmonicEmissionRecommend"
                                                  name="evaReportRenewableEnergyHarmonicEmissionRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportRenewableEnergyHarmonicEmissionPass'] == 'Y') { ?>
                                        <input id="evaReportRenewableEnergyHarmonicEmissionPass"
                                               name="evaReportRenewableEnergyHarmonicEmissionPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportRenewableEnergyHarmonicEmissionPass"
                                               name="evaReportRenewableEnergyHarmonicEmissionPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportRenewableEnergySupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportRenewableEnergySupplementYesNo"
                                               name="evaReportRenewableEnergySupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportRenewableEnergySupplementYesNo"
                                               name="evaReportRenewableEnergySupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportRenewableEnergySupplement"
                                                  name="evaReportRenewableEnergySupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportRenewableEnergySupplementPass'] == 'Y') { ?>
                                        <input id="evaReportRenewableEnergySupplementPass"
                                               name="evaReportRenewableEnergySupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportRenewableEnergySupplementPass"
                                               name="evaReportRenewableEnergySupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-3" rowspan="3">
                                    <?php if ($this->viewbag['evaReportEvChargerSystemYesNo'] == 'Y') { ?>
                                        <input id="evaReportEvChargerSystemYesNo" name="evaReportEvChargerSystemYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEvChargerSystemYesNo" name="evaReportEvChargerSystemYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3" rowspan="3">EV charger system</td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEvChargerSystemEvChargerYesNo'] == 'Y') { ?>
                                        <input id="evaReportEvChargerSystemEvChargerYesNo"
                                               name="evaReportEvChargerSystemEvChargerYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEvChargerSystemEvChargerYesNo"
                                               name="evaReportEvChargerSystemEvChargerYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Controls</td>
                                <td>
                                        <textarea id="evaReportEvChargerSystemEvChargerFinding"
                                                  name="evaReportEvChargerSystemEvChargerFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportEvChargerSystemEvChargerRecommend"
                                                  name="evaReportEvChargerSystemEvChargerRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEvChargerSystemEvChargerPass'] == 'Y') { ?>
                                        <input id="evaReportEvChargerSystemEvChargerPass"
                                               name="evaReportEvChargerSystemEvChargerPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEvChargerSystemEvChargerPass"
                                               name="evaReportEvChargerSystemEvChargerPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEvChargerSystemHarmonicEmissionYesNo'] == 'Y') { ?>
                                        <input id="evaReportEvChargerSystemHarmonicEmissionYesNo"
                                               name="evaReportEvChargerSystemHarmonicEmissionYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEvChargerSystemHarmonicEmissionYesNo"
                                               name="evaReportEvChargerSystemHarmonicEmissionYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Harmonic emission</td>
                                <td>
                                        <textarea id="evaReportEvChargerSystemHarmonicEmissionFinding"
                                                  name="evaReportEvChargerSystemHarmonicEmissionFinding"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td>
                                        <textarea id="evaReportEvChargerSystemHarmonicEmissionRecommend"
                                                  name="evaReportEvChargerSystemHarmonicEmissionRecommend"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEvChargerSystemHarmonicEmissionPass'] == 'Y') { ?>
                                        <input id="evaReportEvChargerSystemHarmonicEmissionPass"
                                               name="evaReportEvChargerSystemHarmonicEmissionPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEvChargerSystemHarmonicEmissionPass"
                                               name="evaReportEvChargerSystemHarmonicEmissionPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEvChargerSystemSupplementYesNo'] == 'Y') { ?>
                                        <input id="evaReportEvChargerSystemSupplementYesNo"
                                               name="evaReportEvChargerSystemSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEvChargerSystemSupplementYesNo"
                                               name="evaReportEvChargerSystemSupplementYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                                <td class="pt-3">Supplement (if any)</td>
                                <td colspan="2">
                                        <textarea id="evaReportEvChargerSystemSupplement"
                                                  name="evaReportEvChargerSystemSupplement"
                                                  type="text" class="form-control"></textarea>
                                </td>
                                <td class="pt-3">
                                    <?php if ($this->viewbag['evaReportEvChargerSystemSupplementPass'] == 'Y') { ?>
                                        <input id="evaReportEvChargerSystemSupplementPass"
                                               name="evaReportEvChargerSystemSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                    <?php } else { ?>
                                        <input id="evaReportEvChargerSystemSupplementPass"
                                               name="evaReportEvChargerSystemSupplementPass" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                    <?php } ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
            <div id="accordionDetailofForthInvitation">
                <div class="card">
                    <div class="card-header" style="background-color: #5b3e25">
                        <a class="card-link" data-toggle="collapse" href="#detailofForthInvitation"
                           onclick="cardSelected('detailofForthInvitationIcon');">
                            <div class="row">
                                <div class="col-11"><h5 class="text-light">Details of 4<span style="vertical-align: super; font-size: 10px">th</span> Invitation Letter</h5></div>
                                <div class="col-1">
                                    <img id="detailofForthInvitationIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div id="detailofForthInvitation" class="collapse" data-parent="#accordionDetailofForthInvitation">
                        <div class="card-body">
                            <div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Issue Date:</span>
                                        </div>
                                        <input id="forthInvitationLetterIssueDate" name="forthInvitationLetterIssueDate"
                                               type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fax Reference No.:</span>
                                        </div>
                                        <input id="forthInvitationLetterFaxRefNo" name="forthInvitationLetterFaxRefNo"
                                               type="text" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="input-group col-4">
                                        <input class="btn btn-primary form-control" type="button" name="genForthInvitationLetterBtn"
                                               id="genForthInvitationLetterBtn" value="Export Invitation Letter">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">EDMS Link:</span>
                                        </div>
                                        <input id="forthInvitationLetterEdmsLink" name="forthInvitationLetterEdmsLink" type="text"
                                               class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Accepted: </span>
                                        </div>
                                        <?php if ($this->viewbag['forthInvitationLetterAccept'] == 'Y') { ?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="forthInvitationLetterAccept"
                                                           class="form-check-input" value="Y" checked>Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="forthInvitationLetterAccept"
                                                           class="form-check-input" value="N">No
                                                </label>
                                            </div>
                                        <?php } else if ($this->viewbag['forthInvitationLetterAccept'] == 'N') {?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="forthInvitationLetterAccept"
                                                           class="form-check-input" value="Y">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="forthInvitationLetterAccept"
                                                           class="form-check-input" value="N" checked>No
                                                </label>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-check-inline pl-4">
                                                <label class="form-check-label">
                                                    <input type="radio" name="forthInvitationLetterAccept"
                                                           class="form-check-input" value="Y">Yes
                                                </label>
                                            </div>
                                            <div class="form-check-inline pl-2">
                                                <label class="form-check-label">
                                                    <input type="radio" name="forthInvitationLetterAccept"
                                                           class="form-check-input" value="N">No
                                                </label>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Date of PQ Walk:</span>
                                        </div>
                                        <input id="forthInvitationLetterWalkDate" name="forthInvitationLetterWalkDate"
                                               type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <?php if (($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
            <div id="accordionDetailOfReEvaluationReport">
                <div class="card">
                    <div class="card-header" style="background-color: #1f4826">
                        <a class="card-link" data-toggle="collapse" href="#detailOfReEvaluationReport"
                           onclick="cardSelected('detailOfReEvaluationReportIcon');">
                            <div class="row">
                                <div class="col-11"><h5 class="text-light">Details of Re-Site Walk Evaluation Report</h5></div>
                                <div class="col-1">
                                    <img id="detailOfReEvaluationReportIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div id="detailOfReEvaluationReport" class="collapse" data-parent="#accordionDetailOfReEvaluationReport">
                        <div class="card-body">
                            <div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Evaluation Score:</span>
                                        </div>
                                        <input id="reEvaReportScore" name="reEvaReportScore"
                                               type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Remark (Project Comment on Circuit Drawings / Technical Specifications):</span>
                                        </div>
                                        <input id="reEvaReportRemark" name="reEvaReportRemark"
                                               type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">EDMS Link of Report:</span>
                                        </div>
                                        <input id="reEvaReportEdmsLink" name="reEvaReportEdmsLink"
                                               type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group col-3">
                                        <input class="btn btn-primary form-control" type="button" name="showReEvaReport"
                                               id="showReEvaReportBtn" value="Show Evaluation Report Detail">
                                    </div>
                                    <div class="input-group col-9">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="accordionDetailOfReEvaluationReportDetail" style="display: none">
                <div class="card">
                    <div class="card-header" style="background-color: #1f4826">
                        <a class="card-link" data-toggle="collapse" href="#detailOfReEvaluationReportDetail" onclick="cardSelected('detailOfReEvaluationReportDetailIcon');">
                            <div class="row">
                                <div class="col-11"><h5 class="text-light pt-2">Evaluation Report Detail</h5></div>
                                <div class="col-1 pt-2">
                                    <img id="detailOfReEvaluationReportDetail" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png"
                                         width="20px" style="transform: rotate(180deg);"/>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div id="detailOfReEvaluationReportDetail" class="collapse show" data-parent="#accordionDetailOfReEvaluationReportDetail">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">&nbsp;</div>
                                <div class="col-3 pb-2">
                                    <input class="btn btn-warning form-control" type="submit" name="genReEvaluationReportDetail"
                                           id="genReEvaluationReportDetail" value="Generate Re-Site Walk Evaluation Report">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Issue Date:</span>
                                    </div>
                                    <input id="reEvaReportIssueDate" name="reEvaReportIssueDate"
                                           type="text" placeholder="YYYY-mm-dd" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Fax Reference No.:</span>
                                    </div>
                                    <input id="reEvaReportFaxRefNo" name="reEvaReportFaxRefNo"
                                           type="text" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th style="width: 3%">&nbsp;</th>
                                    <th style="width: 15%">Equipment</th>
                                    <th style="width: 3%">&nbsp;</th>
                                    <th style="width: 15%">Component</th>
                                    <th style="width: 29%">Findings during PQ Site Walk</th>
                                    <th style="width: 30%">Any further PQ recommendations</th>
                                    <th style="width: 5%">Pass?</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['reEvaReportBmsYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportBmsYesNo" name="reEvaReportBmsYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportBmsYesNo" name="reEvaReportBmsYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">BMS</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportBmsServerCentralComputerYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportBmsServerCentralComputerYesNo"
                                                   name="reEvaReportBmsServerCentralComputerYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportBmsServerCentralComputerYesNo"
                                                   name="reEvaReportBmsServerCentralComputerYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Server or Central Computer</td>
                                    <td>
                                        <textarea id="reEvaReportBmsServerCentralComputerFinding"
                                                  name="reEvaReportBmsServerCentralComputerFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportBmsServerCentralComputerRecommend"
                                                  name="reEvaReportBmsServerCentralComputerRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportBmsServerCentralComputerPass'] == 'Y') { ?>
                                            <input id="reEvaReportBmsServerCentralComputerPass"
                                                   name="reEvaReportBmsServerCentralComputerPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportBmsServerCentralComputerPass"
                                                   name="reEvaReportBmsServerCentralComputerPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportBmsDdcYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportBmsDdcYesNo"
                                                   name="reEvaReportBmsDdcYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportBmsDdcYesNo"
                                                   name="reEvaReportBmsDdcYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Distributed Digital Control (DDC)</td>
                                    <td>
                                        <textarea id="reEvaReportBmsDdcFinding"
                                                  name="reEvaReportBmsDdcFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportBmsDdcRecommend"
                                                  name="reEvaReportBmsDdcRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportBmsDdcPass'] == 'Y') { ?>
                                            <input id="reEvaReportBmsDdcPass"
                                                   name="reEvaReportBmsDdcPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportBmsDdcPass"
                                                   name="reEvaReportBmsDdcPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportBmsSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportBmsSupplementYesNo"
                                                   name="reEvaReportBmsSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportBmsSupplementYesNo"
                                                   name="reEvaReportBmsSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportBmsSupplement"
                                                  name="reEvaReportBmsSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportBmsSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportBmsSupplementPass"
                                                   name="reEvaReportBmsSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportBmsSupplementPass"
                                                   name="reEvaReportBmsSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['reEvaReportChangeoverSchemeYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportChangeoverSchemeYesNo" name="reEvaReportChangeoverSchemeYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChangeoverSchemeYesNo" name="reEvaReportChangeoverSchemeYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">Changeover Scheme</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChangeoverSchemeControlYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportChangeoverSchemeControlYesNo"
                                                   name="reEvaReportChangeoverSchemeControlYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChangeoverSchemeControlYesNo"
                                                   name="reEvaReportChangeoverSchemeControlYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Controls, relays, main contactor</td>
                                    <td>
                                        <textarea id="reEvaReportChangeoverSchemeControlFinding"
                                                  name="reEvaReportChangeoverSchemeControlFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportChangeoverSchemeControlRecommend"
                                                  name="reEvaReportChangeoverSchemeControlRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChangeoverSchemeControlPass'] == 'Y') { ?>
                                            <input id="reEvaReportChangeoverSchemeControlPass"
                                                   name="reEvaReportChangeoverSchemeControlPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChangeoverSchemeControlPass"
                                                   name="reEvaReportChangeoverSchemeControlPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChangeoverSchemeUvYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportChangeoverSchemeUvYesNo"
                                                   name="reEvaReportChangeoverSchemeUvYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChangeoverSchemeUvYesNo"
                                                   name="reEvaReportChangeoverSchemeUvYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Under-voltage (UV) relay</td>
                                    <td>
                                        <textarea id="reEvaReportChangeoverSchemeUvFinding"
                                                  name="reEvaReportChangeoverSchemeUvFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportChangeoverSchemeUvRecommend"
                                                  name="reEvaReportChangeoverSchemeUvRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChangeoverSchemeUvPass'] == 'Y') { ?>
                                            <input id="reEvaReportChangeoverSchemeUvPass"
                                                   name="reEvaReportChangeoverSchemeUvPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChangeoverSchemeUvPass"
                                                   name="reEvaReportChangeoverSchemeUvPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChangeoverSchemeSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportChangeoverSchemeSupplementYesNo"
                                                   name="reEvaReportChangeoverSchemeSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChangeoverSchemeSupplementYesNo"
                                                   name="reEvaReportChangeoverSchemeSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportChangeoverSchemeSupplement"
                                                  name="reEvaReportChangeoverSchemeSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChangeoverSchemeSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportChangeoverSchemeSupplementPass"
                                                   name="reEvaReportChangeoverSchemeSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChangeoverSchemeSupplementPass"
                                                   name="reEvaReportChangeoverSchemeSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['reEvaReportChillerPlantYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportChillerPlantYesNo" name="evaReportChillerPlantYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChillerPlantYesNo" name="evaReportChillerPlantYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">Chiller Plant</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChillerPlantAhuChilledWaterYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportChillerPlantAhuChilledWaterYesNo"
                                                   name="reEvaReportChillerPlantAhuChilledWaterYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChillerPlantAhuChilledWaterYesNo"
                                                   name="reEvaReportChillerPlantAhuChilledWaterYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">AHU, chilled/ condenser water pump</td>
                                    <td>
                                        <textarea id="reEvaReportChillerPlantAhuChilledWaterFinding"
                                                  name="reEvaReportChillerPlantAhuChilledWaterFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportChillerPlantAhuChilledWaterRecommend"
                                                  name="reEvaReportChillerPlantAhuChilledWaterRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChillerPlantAhuChilledWaterPass'] == 'Y') { ?>
                                            <input id="reEvaReportChillerPlantAhuChilledWaterPass"
                                                   name="reEvaReportChillerPlantAhuChilledWaterPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChillerPlantAhuChilledWaterPass"
                                                   name="reEvaReportChillerPlantAhuChilledWaterPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChillerPlantChillerYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportChillerPlantChillerYesNo"
                                                   name="reEvaReportChillerPlantChillerYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChillerPlantChillerYesNo"
                                                   name="reEvaReportChillerPlantChillerYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Chiller</td>
                                    <td>
                                        <textarea id="reEvaReportChillerPlantChillerFinding"
                                                  name="reEvaReportChillerPlantChillerFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportChillerPlantChillerRecommend"
                                                  name="reEvaReportChillerPlantChillerRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChillerPlantChillerPass'] == 'Y') { ?>
                                            <input id="reEvaReportChillerPlantChillerPass"
                                                   name="reEvaReportChillerPlantChillerPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChillerPlantChillerPass"
                                                   name="reEvaReportChillerPlantChillerPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChillerPlantSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportChillerPlantSupplementYesNo"
                                                   name="reEvaReportChillerPlantSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChillerPlantSupplementYesNo"
                                                   name="reEvaReportChillerPlantSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportChillerPlantSupplement"
                                                  name="reEvaReportChillerPlantSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportChillerPlantSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportChillerPlantSupplementPass"
                                                   name="reEvaReportChillerPlantSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportChillerPlantSupplementPass"
                                                   name="reEvaReportChillerPlantSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['reEvaReportEscalatorYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportEscalatorYesNo" name="reEvaReportEscalatorYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEscalatorYesNo" name="reEvaReportEscalatorYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">Escalator</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEscalatorBrakingSystemYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportEscalatorBrakingSystemYesNo"
                                                   name="reEvaReportEscalatorBrakingSystemYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEscalatorBrakingSystemYesNo"
                                                   name="reEvaReportEscalatorBrakingSystemYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Braking system</td>
                                    <td>
                                        <textarea id="reEvaReportEscalatorBrakingSystemFinding"
                                                  name="reEvaReportEscalatorBrakingSystemFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportEscalatorBrakingSystemRecommend"
                                                  name="reEvaReportEscalatorBrakingSystemRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEscalatorBrakingSystemPass'] == 'Y') { ?>
                                            <input id="reEvaReportEscalatorBrakingSystemPass"
                                                   name="reEvaReportEscalatorBrakingSystemPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEscalatorBrakingSystemPass"
                                                   name="reEvaReportEscalatorBrakingSystemPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEscalatorControlYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportEscalatorControlYesNo"
                                                   name="reEvaReportEscalatorControlYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEscalatorControlYesNo"
                                                   name="reEvaReportEscalatorControlYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Controls</td>
                                    <td>
                                        <textarea id="reEvaReportEscalatorControlFinding"
                                                  name="reEvaReportEscalatorControlFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportEscalatorControlRecommend"
                                                  name="reEvaReportEscalatorControlRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEscalatorControlPass'] == 'Y') { ?>
                                            <input id="reEvaReportEscalatorControlPass"
                                                   name="reEvaReportEscalatorControlPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEscalatorControlPass"
                                                   name="reEvaReportEscalatorControlPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEscalatorSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportEscalatorSupplementYesNo"
                                                   name="reEvaReportEscalatorSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEscalatorSupplementYesNo"
                                                   name="reEvaReportEscalatorSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportEscalatorSupplement"
                                                  name="reEvaReportEscalatorSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEscalatorSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportEscalatorSupplementPass"
                                                   name="reEvaReportEscalatorSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEscalatorSupplementPass"
                                                   name="reEvaReportEscalatorSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['reEvaReportHidLampYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportHidLampYesNo" name="reEvaReportHidLampYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportHidLampYesNo" name="reEvaReportHidLampYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">LED Lighting</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportHidLampBallastYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportHidLampBallastYesNo"
                                                   name="reEvaReportHidLampBallastYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportHidLampBallastYesNo"
                                                   name="reEvaReportHidLampBallastYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Ballast</td>
                                    <td>
                                        <textarea id="reEvaReportHidLampBallastFinding"
                                                  name="reEvaReportHidLampBallastFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportHidLampBallastRecommend"
                                                  name="reEvaReportHidLampBallastRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportHidLampBallastPass'] == 'Y') { ?>
                                            <input id="reEvaReportHidLampBallastPass"
                                                   name="reEvaReportHidLampBallastPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportHidLampBallastPass"
                                                   name="reEvaReportHidLampBallastPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportHidLampAddonProtectYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportHidLampAddonProtectYesNo"
                                                   name="reEvaReportHidLampAddonProtectYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportHidLampAddonProtectYesNo"
                                                   name="reEvaReportHidLampAddonProtectYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Add-on protection</td>
                                    <td>
                                        <textarea id="reEvaReportHidLampAddonProtectFinding"
                                                  name="reEvaReportHidLampAddonProtectFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportHidLampAddonProtectRecommend"
                                                  name="reEvaReportHidLampAddonProtectRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportHidLampAddonProtectPass'] == 'Y') { ?>
                                            <input id="reEvaReportHidLampAddonProtectPass"
                                                   name="reEvaReportHidLampAddonProtectPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportHidLampAddonProtectPass"
                                                   name="reEvaReportHidLampAddonProtectPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportHidLampSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportHidLampSupplementYesNo"
                                                   name="reEvaReportHidLampSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportHidLampSupplementYesNo"
                                                   name="reEvaReportHidLampSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportHidLampSupplement"
                                                  name="reEvaReportHidLampSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportHidLampSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportHidLampSupplementPass"
                                                   name="reEvaReportHidLampSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportHidLampSupplementPass"
                                                   name="reEvaReportHidLampSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['reEvaReportLiftYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportLiftYesNo" name="reEvaReportLiftYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportLiftYesNo" name="reEvaReportLiftYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">Lift</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportLiftOperationYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportLiftOperationYesNo"
                                                   name="reEvaReportLiftOperationYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportLiftOperationYesNo"
                                                   name="reEvaReportLiftOperationYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Controls</td>
                                    <td>
                                        <textarea id="reEvaReportLiftOperationFinding"
                                                  name="reEvaReportLiftOperationFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportLiftOperationRecommend"
                                                  name="reEvaReportLiftOperationRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportLiftOperationPass'] == 'Y') { ?>
                                            <input id="reEvaReportLiftOperationPass"
                                                   name="reEvaReportLiftOperationPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportLiftOperationPass"
                                                   name="reEvaReportLiftOperationPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportLiftMainSupplyYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportLiftMainSupplyYesNo"
                                                   name="reEvaReportLiftMainSupplyYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportLiftMainSupplyYesNo"
                                                   name="reEvaReportLiftMainSupplyYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Main Supply</td>
                                    <td>
                                        <textarea id="reEvaReportLiftMainSupplyFinding"
                                                  name="reEvaReportLiftMainSupplyFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportLiftMainSupplyRecommend"
                                                  name="reEvaReportLiftMainSupplyRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportLiftMainSupplyPass'] == 'Y') { ?>
                                            <input id="reEvaReportLiftMainSupplyPass"
                                                   name="reEvaReportLiftMainSupplyPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportLiftMainSupplyPass"
                                                   name="reEvaReportLiftMainSupplyPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportLiftSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportLiftSupplementYesNo"
                                                   name="reEvaReportLiftSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportLiftSupplementYesNo"
                                                   name="reEvaReportLiftSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportLiftSupplement"
                                                  name="reEvaReportLiftSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportLiftSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportLiftSupplementPass"
                                                   name="reEvaReportLiftSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportLiftSupplementPass"
                                                   name="reEvaReportLiftSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="2">
                                        <?php if ($this->viewbag['reEvaReportSensitiveMachineYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportSensitiveMachineYesNo" name="reEvaReportSensitiveMachineYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportSensitiveMachineYesNo" name="reEvaReportSensitiveMachineYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="2">Sensitive Machine</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportSensitiveMachineMedicalYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportSensitiveMachineMedicalYesNo"
                                                   name="reEvaReportSensitiveMachineMedicalYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportSensitiveMachineMedicalYesNo"
                                                   name="reEvaReportSensitiveMachineMedicalYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Medical equipment, Controls, PLC</td>
                                    <td>
                                        <textarea id="reEvaReportSensitiveMachineMedicalFinding"
                                                  name="reEvaReportSensitiveMachineMedicalFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportSensitiveMachineMedicalRecommend"
                                                  name="reEvaReportSensitiveMachineMedicalRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportSensitiveMachineMedicalPass'] == 'Y') { ?>
                                            <input id="reEvaReportSensitiveMachineMedicalPass"
                                                   name="reEvaReportSensitiveMachineMedicalPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportSensitiveMachineMedicalPass"
                                                   name="reEvaReportSensitiveMachineMedicalPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportSensitiveMachineSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportSensitiveMachineSupplementYesNo"
                                                   name="reEvaReportSensitiveMachineSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportSensitiveMachineSupplementYesNo"
                                                   name="reEvaReportSensitiveMachineSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportSensitiveMachineSupplement"
                                                  name="reEvaReportSensitiveMachineSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportSensitiveMachineSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportSensitiveMachineSupplementPass"
                                                   name="reEvaReportSensitiveMachineSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportSensitiveMachineSupplementPass"
                                                   name="reEvaReportSensitiveMachineSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="4">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachineYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachineYesNo" name="reEvaReportTelecomMachineYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachineYesNo" name="reEvaReportTelecomMachineYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="4">Telecom, IT Equipment, Data Centre & Harmonic</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachineServerOrComputerYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachineServerOrComputerYesNo"
                                                   name="reEvaReportTelecomMachineServerOrComputerYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachineServerOrComputerYesNo"
                                                   name="reEvaReportTelecomMachineServerOrComputerYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Server or computer</td>
                                    <td>
                                        <textarea id="reEvaReportTelecomMachineServerOrComputerFinding"
                                                  name="reEvaReportTelecomMachineServerOrComputerFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportTelecomMachineServerOrComputerRecommend"
                                                  name="reEvaReportTelecomMachineServerOrComputerRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachineServerOrComputerPass'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachineServerOrComputerPass"
                                                   name="reEvaReportTelecomMachineServerOrComputerPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachineServerOrComputerPass"
                                                   name="reEvaReportTelecomMachineServerOrComputerPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachinePeripheralsYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachinePeripheralsYesNo"
                                                   name="reEvaReportTelecomMachinePeripheralsYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachinePeripheralsYesNo"
                                                   name="reEvaReportTelecomMachinePeripheralsYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Peripherals such as modem, router</td>
                                    <td>
                                        <textarea id="reEvaReportTelecomMachinePeripheralsFinding"
                                                  name="reEvaReportTelecomMachinePeripheralsFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportTelecomMachinePeripheralsRecommend"
                                                  name="reEvaReportTelecomMachinePeripheralsRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachinePeripheralsPass'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachinePeripheralsPass"
                                                   name="reEvaReportTelecomMachinePeripheralsPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachinePeripheralsPass"
                                                   name="reEvaReportTelecomMachinePeripheralsPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachineHarmonicEmissionYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachineHarmonicEmissionYesNo"
                                                   name="reEvaReportTelecomMachineHarmonicEmissionYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachineHarmonicEmissionYesNo"
                                                   name="reEvaReportTelecomMachineHarmonicEmissionYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <textarea id="reEvaReportTelecomMachineHarmonicEmissionFinding"
                                                  name="reEvaReportTelecomMachineHarmonicEmissionFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportTelecomMachineHarmonicEmissionRecommend"
                                                  name="reEvaReportTelecomMachineHarmonicEmissionRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachineHarmonicEmissionPass'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachineHarmonicEmissionPass"
                                                   name="reEvaReportTelecomMachineHarmonicEmissionPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachineHarmonicEmissionPass"
                                                   name="reEvaReportTelecomMachineHarmonicEmissionPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachineSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachineSupplementYesNo"
                                                   name="reEvaReportTelecomMachineSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachineSupplementYesNo"
                                                   name="reEvaReportTelecomMachineSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportTelecomMachineSupplement"
                                                  name="reEvaReportTelecomMachineSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportTelecomMachineSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportTelecomMachineSupplementPass"
                                                   name="reEvaReportTelecomMachineSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportTelecomMachineSupplementPass"
                                                   name="reEvaReportTelecomMachineSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="4">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersYesNo" name="reEvaReportAirConditionersYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersYesNo" name="reEvaReportAirConditionersYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="4">Air-conditioners</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersMicbYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersMicbYesNo"
                                                   name="reEvaReportAirConditionersMicbYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersMicbYesNo"
                                                   name="reEvaReportAirConditionersMicbYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Protection Facilities of Main Incoming Circuit Breaker</td>
                                    <td>
                                        <textarea id="reEvaReportAirConditionersMicbFinding"
                                                  name="reEvaReportAirConditionersMicbFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportAirConditionersMicbRecommend"
                                                  name="reEvaReportAirConditionersMicbRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersMicbPass'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersMicbPass"
                                                   name="reEvaReportAirConditionersMicbPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersMicbPass"
                                                   name="reEvaReportAirConditionersMicbPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersLoadForecastingYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersLoadForecastingYesNo"
                                                   name="reEvaReportAirConditionersLoadForecastingYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersLoadForecastingYesNo"
                                                   name="reEvaReportAirConditionersLoadForecastingYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Load forecasting for air-conditioning load</td>
                                    <td>
                                        <textarea id="reEvaReportAirConditionersLoadForecastingFinding"
                                                  name="reEvaReportAirConditionersLoadForecastingFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportAirConditionersLoadForecastingRecommend"
                                                  name="reEvaReportAirConditionersLoadForecastingRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersLoadForecastingPass'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersLoadForecastingPass"
                                                   name="reEvaReportAirConditionersLoadForecastingPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersLoadForecastingPass"
                                                   name="reEvaReportAirConditionersLoadForecastingPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersTypeYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersTypeYesNo"
                                                   name="reEvaReportAirConditionersTypeYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersTypeYesNo"
                                                   name="reEvaReportAirConditionersTypeYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Type of Air-conditioner</td>
                                    <td>
                                        <textarea id="reEvaReportAirConditionersTypeFinding"
                                                  name="reEvaReportAirConditionersTypeFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportAirConditionersTypeRecommend"
                                                  name="reEvaReportAirConditionersTypeRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersTypePass'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersTypePass"
                                                   name="reEvaReportAirConditionersTypePass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersTypePass"
                                                   name="reEvaReportAirConditionersTypePass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersSupplementYesNo"
                                                   name="reEvaReportAirConditionersSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersSupplementYesNo"
                                                   name="reEvaReportAirConditionersSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportAirConditionersSupplement"
                                                  name="reEvaReportAirConditionersSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportAirConditionersSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportAirConditionersSupplementPass"
                                                   name="reEvaReportAirConditionersSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportAirConditionersSupplementPass"
                                                   name="reEvaReportAirConditionersSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="2">
                                        <?php if ($this->viewbag['reEvaReportNonLinearLoadYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportNonLinearLoadYesNo" name="reEvaReportNonLinearLoadYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportNonLinearLoadYesNo" name="reEvaReportNonLinearLoadYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="2">Buildings with high penetration of energy efficient equipment, e.g. LED lighting, VSD Air Conditioner, and other non-linear loads etc.</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportNonLinearLoadHarmonicEmissionYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportNonLinearLoadHarmonicEmissionYesNo"
                                                   name="reEvaReportNonLinearLoadHarmonicEmissionYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportNonLinearLoadHarmonicEmissionYesNo"
                                                   name="reEvaReportNonLinearLoadHarmonicEmissionYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <textarea id="reEvaReportNonLinearLoadHarmonicEmissionFinding"
                                                  name="reEvaReportNonLinearLoadHarmonicEmissionFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportNonLinearLoadHarmonicEmissionRecommend"
                                                  name="reEvaReportNonLinearLoadHarmonicEmissionRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportNonLinearLoadHarmonicEmissionPass'] == 'Y') { ?>
                                            <input id="reEvaReportNonLinearLoadHarmonicEmissionPass"
                                                   name="reEvaReportNonLinearLoadHarmonicEmissionPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportNonLinearLoadHarmonicEmissionPass"
                                                   name="reEvaReportNonLinearLoadHarmonicEmissionPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportNonLinearLoadSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportNonLinearLoadSupplementYesNo"
                                                   name="reEvaReportNonLinearLoadSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportNonLinearLoadSupplementYesNo"
                                                   name="reEvaReportNonLinearLoadSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportNonLinearLoadSupplement"
                                                  name="reEvaReportNonLinearLoadSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportNonLinearLoadSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportNonLinearLoadSupplementPass"
                                                   name="reEvaReportNonLinearLoadSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="ereEvaReportNonLinearLoadSupplementPass"
                                                   name="reEvaReportNonLinearLoadSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['reEvaReportRenewableEnergyYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportRenewableEnergyYesNo" name="reEvaReportRenewableEnergyYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportRenewableEnergyYesNo" name="reEvaReportRenewableEnergyYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">Renewable Energy, e.g. photovoltaic or wind energy system etc.</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportRenewableEnergyInverterAndControlsYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportRenewableEnergyInverterAndControlsYesNo"
                                                   name="reEvaReportRenewableEnergyInverterAndControlsYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportRenewableEnergyInverterAndControlsYesNo"
                                                   name="reEvaReportRenewableEnergyInverterAndControlsYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Inverter, controls</td>
                                    <td>
                                        <textarea id="reEvaReportRenewableEnergyInverterAndControlsFinding"
                                                  name="reEvaReportRenewableEnergyInverterAndControlsFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportRenewableEnergyInverterAndControlsRecommend"
                                                  name="reEvaReportRenewableEnergyInverterAndControlsRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportRenewableEnergyInverterAndControlsPass'] == 'Y') { ?>
                                            <input id="reEvaReportRenewableEnergyInverterAndControlsPass"
                                                   name="reEvaReportRenewableEnergyInverterAndControlsPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportRenewableEnergyInverterAndControlsPass"
                                                   name="reEvaReportRenewableEnergyInverterAndControlsPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportRenewableEnergyHarmonicEmissionYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportRenewableEnergyHarmonicEmissionYesNo"
                                                   name="reEvaReportRenewableEnergyHarmonicEmissionYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportRenewableEnergyHarmonicEmissionYesNo"
                                                   name="reEvaReportRenewableEnergyHarmonicEmissionYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <textarea id="reEvaReportRenewableEnergyHarmonicEmissionFinding"
                                                  name="reEvaReportRenewableEnergyHarmonicEmissionFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportRenewableEnergyHarmonicEmissionRecommend"
                                                  name="reEvaReportRenewableEnergyHarmonicEmissionRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportRenewableEnergyHarmonicEmissionPass'] == 'Y') { ?>
                                            <input id="reEvaReportRenewableEnergyHarmonicEmissionPass"
                                                   name="reEvaReportRenewableEnergyHarmonicEmissionPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportRenewableEnergyHarmonicEmissionPass"
                                                   name="reEvaReportRenewableEnergyHarmonicEmissionPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportRenewableEnergySupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportRenewableEnergySupplementYesNo"
                                                   name="reEvaReportRenewableEnergySupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportRenewableEnergySupplementYesNo"
                                                   name="reEvaReportRenewableEnergySupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportRenewableEnergySupplement"
                                                  name="reEvaReportRenewableEnergySupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportRenewableEnergySupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportRenewableEnergySupplementPass"
                                                   name="reEvaReportRenewableEnergySupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportRenewableEnergySupplementPass"
                                                   name="reEvaReportRenewableEnergySupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="pt-3" rowspan="3">
                                        <?php if ($this->viewbag['reEvaReportEvChargerSystemYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportEvChargerSystemYesNo" name="reEvaReportEvChargerSystemYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEvChargerSystemYesNo" name="reEvaReportEvChargerSystemYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3" rowspan="3">EV charger system</td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEvChargerSystemEvChargerYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportEvChargerSystemEvChargerYesNo"
                                                   name="reEvaReportEvChargerSystemEvChargerYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEvChargerSystemEvChargerYesNo"
                                                   name="reEvaReportEvChargerSystemEvChargerYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Controls</td>
                                    <td>
                                        <textarea id="reEvaReportEvChargerSystemEvChargerFinding"
                                                  name="reEvaReportEvChargerSystemEvChargerFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportEvChargerSystemEvChargerRecommend"
                                                  name="reEvaReportEvChargerSystemEvChargerRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEvChargerSystemEvChargerPass'] == 'Y') { ?>
                                            <input id="reEvaReportEvChargerSystemEvChargerPass"
                                                   name="reEvaReportEvChargerSystemEvChargerPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEvChargerSystemEvChargerPass"
                                                   name="reEvaReportEvChargerSystemEvChargerPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEvChargerSystemHarmonicEmissionYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportEvChargerSystemHarmonicEmissionYesNo"
                                                   name="reEvaReportEvChargerSystemHarmonicEmissionYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEvChargerSystemHarmonicEmissionYesNo"
                                                   name="reEvaReportEvChargerSystemHarmonicEmissionYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <textarea id="reEvaReportEvChargerSystemHarmonicEmissionFinding"
                                                  name="reEvaReportEvChargerSystemHarmonicEmissionFinding"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <textarea id="reEvaReportEvChargerSystemHarmonicEmissionRecommend"
                                                  name="reEvaReportEvChargerSystemHarmonicEmissionRecommend"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEvChargerSystemHarmonicEmissionPass'] == 'Y') { ?>
                                            <input id="reEvaReportEvChargerSystemHarmonicEmissionPass"
                                                   name="reEvaReportEvChargerSystemHarmonicEmissionPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEvChargerSystemHarmonicEmissionPass"
                                                   name="reEvaReportEvChargerSystemHarmonicEmissionPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEvChargerSystemSupplementYesNo'] == 'Y') { ?>
                                            <input id="reEvaReportEvChargerSystemSupplementYesNo"
                                                   name="reEvaReportEvChargerSystemSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEvChargerSystemSupplementYesNo"
                                                   name="reEvaReportEvChargerSystemSupplementYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Supplement (if any)</td>
                                    <td colspan="2">
                                        <textarea id="reEvaReportEvChargerSystemSupplement"
                                                  name="reEvaReportEvChargerSystemSupplement"
                                                  type="text" class="form-control"></textarea>
                                    </td>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['reEvaReportEvChargerSystemSupplementPass'] == 'Y') { ?>
                                            <input id="reEvaReportEvChargerSystemSupplementPass"
                                                   name="reEvaReportEvChargerSystemSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="reEvaReportEvChargerSystemSupplementPass"
                                                   name="reEvaReportEvChargerSystemSupplementPass" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="form-group row px-3 pt-2">
            <div>
                <input class="btn btn-primary" type="submit" name="backBtn" id="backBtn" value="Back">
                <input class="btn btn-primary" type="submit" name="saveDraftBtn" id="saveDraftBtn" value="Save as Draft">
                <input class="btn btn-primary" type="submit" name="saveProcessBtn" id="saveProcessBtn" value="Save & Process">
            </div>
        </div>

        <input type="hidden" id="planningAheadId" name="planningAheadId" value="<?php echo $this->viewbag['planningAheadId']; ?>">
        <input type="hidden" id="standLetterLetterLoc" name="standLetterLetterLoc" value="<?php echo $this->viewbag['standLetterLetterLoc']; ?>">
        <input type="hidden" id="meetingReplySlipId" name="meetingReplySlipId" value="<?php echo $this->viewbag['meetingReplySlipId']; ?>">
        <input type="hidden" id="evaReportId" name="evaReportId" value="<?php echo $this->viewbag['evaReportId']; ?>">
        <input type="hidden" id="reEvaReportId" name="reEvaReportId" value="<?php echo $this->viewbag['reEvaReportId']; ?>">
        <input type="hidden" id="state" name="state" value="<?php echo $this->viewbag['state']; ?>">
        <?php
            if ((isset(Yii::app()->session['tblUserDo']['roleId']))) {
        ?>
        <input type="hidden" id="roleId" name="roleId" value="<?php echo Yii::app()->session['tblUserDo']['roleId']; ?>">
        <?php
            }
        ?>

    </form>

</div>

<!-- Script for processing the data -->
<script>
    $(document).ready(function(){

        // set timer for keep alive
        setInterval(function() {

            /*
            if (validateDraftInput()) {
                const form = document.getElementById('detailForm');
                $.ajax({
                    url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxPostPlanningAheadProjectDetailDraftUpdate",
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData(form),
                    success: function(data) {}
                });
            }
            */
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxGetKeepAlive",
                type: "GET",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {}
            });

        }, 300000);

        // Load information for the project detail
        let availableTagsForConsultantCompanyName = [
            <?php foreach ($this->viewbag['consultantCompanyList'] as $consultantCompany) {?> {
                value: "<?php echo $consultantCompany['consultantCompanyName']; ?>",
                name: "<?php echo $consultantCompany['consultantCompanyName']; ?>"
            },
            <?php }?>
        ];

        let availableTagsForProjectOwnerCompanyName = [
            <?php foreach ($this->viewbag['projectOwnerCompanyList'] as $consultantCompany) {?> {
                value: "<?php echo $consultantCompany['projectOwnerCompanyName']; ?>",
                name: "<?php echo $consultantCompany['projectOwnerCompanyName']; ?>"
            },
            <?php }?>
        ];

        $("#projectTitle").val("<?php echo $this->viewbag['projectTitle']; ?>");
        $("#schemeNo").val("<?php echo $this->viewbag['schemeNo']; ?>");
        $("#commissionDate").val("<?php echo $this->viewbag['commissionDate']; ?>");
        $("#firstRegionStaffName").val("<?php echo $this->viewbag['firstRegionStaffName']; ?>");
        $("#firstRegionStaffPhone").val("<?php echo $this->viewbag['firstRegionStaffPhone']; ?>");
        $("#firstRegionStaffEmail").val("<?php echo $this->viewbag['firstRegionStaffEmail']; ?>");
        $("#secondRegionStaffName").val("<?php echo $this->viewbag['secondRegionStaffName']; ?>");
        $("#secondRegionStaffPhone").val("<?php echo $this->viewbag['secondRegionStaffPhone']; ?>");
        $("#secondRegionStaffEmail").val("<?php echo $this->viewbag['secondRegionStaffEmail']; ?>");
        $("#thirdRegionStaffName").val("<?php echo $this->viewbag['thirdRegionStaffName']; ?>");
        $("#thirdRegionStaffPhone").val("<?php echo $this->viewbag['thirdRegionStaffPhone']; ?>");
        $("#thirdRegionStaffEmail").val("<?php echo $this->viewbag['thirdRegionStaffEmail']; ?>");
        $("#firstConsultantSurname").val("<?php echo $this->viewbag['firstConsultantSurname']; ?>");
        $("#firstConsultantOtherName").val("<?php echo $this->viewbag['firstConsultantOtherName']; ?>");
        $("#firstConsultantCompany").val("<?php echo $this->viewbag['firstConsultantCompany']; ?>");
        $("#firstConsultantPhone").val("<?php echo $this->viewbag['firstConsultantPhone']; ?>");
        $("#firstConsultantEmail").val("<?php echo $this->viewbag['firstConsultantEmail']; ?>");
        $("#secondConsultantSurname").val("<?php echo $this->viewbag['secondConsultantSurname']; ?>");
        $("#secondConsultantOtherName").val("<?php echo $this->viewbag['secondConsultantOtherName']; ?>");
        $("#secondConsultantCompany").val("<?php echo $this->viewbag['secondConsultantCompany']; ?>");
        $("#secondConsultantPhone").val("<?php echo $this->viewbag['secondConsultantPhone']; ?>");
        $("#secondConsultantEmail").val("<?php echo $this->viewbag['secondConsultantEmail']; ?>");
        $("#thirdConsultantSurname").val("<?php echo $this->viewbag['thirdConsultantSurname']; ?>");
        $("#thirdConsultantOtherName").val("<?php echo $this->viewbag['thirdConsultantOtherName']; ?>");
        $("#thirdConsultantCompany").val("<?php echo $this->viewbag['thirdConsultantCompany']; ?>");
        $("#thirdConsultantPhone").val("<?php echo $this->viewbag['thirdConsultantPhone']; ?>");
        $("#thirdConsultantEmail").val("<?php echo $this->viewbag['thirdConsultantEmail']; ?>");
        $("#firstProjectOwnerSurname").val("<?php echo $this->viewbag['firstProjectOwnerSurname']; ?>");
        $("#firstProjectOwnerOtherName").val("<?php echo $this->viewbag['firstProjectOwnerOtherName']; ?>");
        $("#firstProjectOwnerCompany").val("<?php echo $this->viewbag['firstProjectOwnerCompany']; ?>");
        $("#firstProjectOwnerPhone").val("<?php echo $this->viewbag['firstProjectOwnerPhone']; ?>");
        $("#firstProjectOwnerEmail").val("<?php echo $this->viewbag['firstProjectOwnerEmail']; ?>");
        $("#secondProjectOwnerSurname").val("<?php echo $this->viewbag['secondProjectOwnerSurname']; ?>");
        $("#secondProjectOwnerOtherName").val("<?php echo $this->viewbag['secondProjectOwnerOtherName']; ?>");
        $("#secondProjectOwnerCompany").val("<?php echo $this->viewbag['secondProjectOwnerCompany']; ?>");
        $("#secondProjectOwnerPhone").val("<?php echo $this->viewbag['secondProjectOwnerPhone']; ?>");
        $("#secondProjectOwnerEmail").val("<?php echo $this->viewbag['secondProjectOwnerEmail']; ?>");
        $("#thirdProjectOwnerSurname").val("<?php echo $this->viewbag['thirdProjectOwnerSurname']; ?>");
        $("#thirdProjectOwnerOtherName").val("<?php echo $this->viewbag['thirdProjectOwnerOtherName']; ?>");
        $("#thirdProjectOwnerCompany").val("<?php echo $this->viewbag['thirdProjectOwnerCompany']; ?>");
        $("#thirdProjectOwnerPhone").val("<?php echo $this->viewbag['thirdProjectOwnerPhone']; ?>");
        $("#thirdProjectOwnerEmail").val("<?php echo $this->viewbag['thirdProjectOwnerEmail']; ?>");
        $("#standLetterIssueDate").val("<?php echo $this->viewbag['standLetterIssueDate']; ?>");
        $("#standLetterFaxRefNo").val("<?php echo $this->viewbag['standLetterFaxRefNo']; ?>");
        $("#standLetterEdmsLink").val("<?php echo $this->viewbag['standLetterEdmsLink']; ?>");
        $("#meetingFirstPreferMeetingDate").val("<?php echo $this->viewbag['meetingFirstPreferMeetingDate']; ?>");
        $("#meetingSecondPreferMeetingDate").val("<?php echo $this->viewbag['meetingSecondPreferMeetingDate']; ?>");
        $("#meetingActualMeetingDate").val("<?php echo $this->viewbag['meetingActualMeetingDate']; ?>");
        $("#meetingRejReason").val("<?php echo $this->viewbag['meetingRejReason']; ?>");
        $("#meetingRemark").val("<?php echo $this->viewbag['meetingRemark']; ?>");
        $("#projectState").val("<?php echo $this->viewbag['state']; ?>");

        // Set the autocomplete for 1st consultant company name
        $('#firstConsultantCompany').autocomplete({
            source: function(request, response) {
                let results = $.ui.autocomplete.filter(availableTagsForConsultantCompanyName, request.term);
                response(results.slice(0, 10));
            },
            focus: function(event, ui) {
                $("#firstConsultantCompany").val(ui.item.name);
                return false;
            },
            select: function(event, ui) {
                $("#firstConsultantCompany").val(ui.item.name);
                return false;
            }
        });

        // Set the autocomplete for 2nd consultant company name
        $('#secondConsultantCompany').autocomplete({
            source: function(request, response) {
                let results = $.ui.autocomplete.filter(availableTagsForConsultantCompanyName, request.term);
                response(results.slice(0, 10));
            },
            focus: function(event, ui) {
                $("#secondConsultantCompany").val(ui.item.name);
                return false;
            },
            select: function(event, ui) {
                $("#secondConsultantCompany").val(ui.item.name);
                return false;
            }
        });

        // Set the autocomplete for 3rd consultant company name
        $('#thirdConsultantCompany').autocomplete({
            source: function(request, response) {
                let results = $.ui.autocomplete.filter(availableTagsForConsultantCompanyName, request.term);
                response(results.slice(0, 10));
            },
            focus: function(event, ui) {
                $("#thirdConsultantCompany").val(ui.item.name);
                return false;
            },
            select: function(event, ui) {
                $("#thirdConsultantCompany").val(ui.item.name);
                return false;
            }
        });

        // Set the autocomplete for 1st project owner company name
        $('#firstProjectOwnerCompany').autocomplete({
            source: function(request, response) {
                let results = $.ui.autocomplete.filter(availableTagsForProjectOwnerCompanyName, request.term);
                response(results.slice(0, 10));
            },
            focus: function(event, ui) {
                $("#firstProjectOwnerCompany").val(ui.item.name);
                return false;
            },
            select: function(event, ui) {
                $("#firstProjectOwnerCompany").val(ui.item.name);
                return false;
            }
        });

        // Set the autocomplete for 2nd project owner company name
        $('#secondProjectOwnerCompany').autocomplete({
            source: function(request, response) {
                let results = $.ui.autocomplete.filter(availableTagsForProjectOwnerCompanyName, request.term);
                response(results.slice(0, 10));
            },
            focus: function(event, ui) {
                $("#secondProjectOwnerCompany").val(ui.item.name);
                return false;
            },
            select: function(event, ui) {
                $("#secondProjectOwnerCompany").val(ui.item.name);
                return false;
            }
        });

        // Set the autocomplete for 3rd project owner company name
        $('#thirdProjectOwnerCompany').autocomplete({
            source: function(request, response) {
                let results = $.ui.autocomplete.filter(availableTagsForProjectOwnerCompanyName, request.term);
                response(results.slice(0, 10));
            },
            focus: function(event, ui) {
                $("#thirdProjectOwnerCompany").val(ui.item.name);
                return false;
            },
            select: function(event, ui) {
                $("#thirdProjectOwnerCompany").val(ui.item.name);
                return false;
            }
        });

        $("#commissionDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#detailForm").on("submit", function(e) {

            e.preventDefault();

            if ($(this).find("input[type=submit]:focus" ).val() == 'Save as Draft') {

                if (!validateDraftInput()) {
                    return;
                }

                $("#loading-modal").modal("show");
                $("#saveDraftBtn").attr("disabled", true);
                $("#saveProcessBtn").attr("disabled", true);
                $("#backBtn").attr("disabled", true);

                $.ajax({
                    url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxPostPlanningAheadProjectDetailDraftUpdate",
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData(this),
                    success: function(data) {
                        let retJson = JSON.parse(data);
                        if (retJson.status == "OK") {
                            // display message
                            showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info", "Project Detail updated successfully.");
                        } else {
                            // error message
                            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson.retMessage);
                        }
                    }
                }).fail(function(event, jqXHR, settings, thrownError) {
                    if (event.status != 440) {
                        showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
                    }
                }).always(function(data) {
                    $("#loading-modal").modal("hide");
                    $("#saveDraftBtn").attr("disabled", false);
                    $("#saveProcessBtn").attr("disabled", false);
                    $("#backBtn").attr("disabled", false);
                });
            } else if ($(this).find("input[type=submit]:focus" ).val() == 'Save & Process') {

                if (!validateProcessInput()) {
                    return;
                }

                if ($('input[name="tempProjOpt"]:checked','#detailForm').val() == 'Y') {
                    showConfirmation("<i class=\"fas fa-exclamation-circle\"></i> ", "Confirmation",
                        "Set as Temp Project will close this project in PQSIS, are you sure?",
                        function() {
                            $("#loading-modal").modal("show");
                            $("#saveDraftBtn").attr("disabled", true);
                            $("#saveProcessBtn").attr("disabled", true);
                            $("#backBtn").attr("disabled", true);

                            const form = document.getElementById('detailForm');

                            $.ajax({
                                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxPostPlanningAheadProjectDetailProcessUpdate",
                                type: "POST",
                                cache: false,
                                processData: false,
                                contentType: false,
                                data: new FormData(form),
                                success: function(data) {
                                    let retJson = JSON.parse(data);
                                    if (retJson.status == "OK") {
                                        // display message
                                        showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info", "Project Detail updated successfully.");
                                        window.location.reload();
                                    } else {
                                        // error message
                                        showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson.retMessage);
                                    }
                                }
                            }).fail(function(event, jqXHR, settings, thrownError) {
                                if (event.status != 440) {
                                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
                                }
                            }).always(function(data) {
                                $("#loading-modal").modal("hide");
                                $("#saveDraftBtn").attr("disabled", false);
                                $("#saveProcessBtn").attr("disabled", false);
                                $("#backBtn").attr("disabled", false);
                            });
                        },
                        function() {});
                } else {
                    $("#loading-modal").modal("show");
                    $("#saveDraftBtn").attr("disabled", true);
                    $("#saveProcessBtn").attr("disabled", true);
                    $("#backBtn").attr("disabled", true);

                    $.ajax({
                        url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxPostPlanningAheadProjectDetailProcessUpdate",
                        type: "POST",
                        cache: false,
                        processData: false,
                        contentType: false,
                        data: new FormData(this),
                        success: function(data) {
                            let retJson = JSON.parse(data);
                            if (retJson.status == "OK") {
                                // display message
                                showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info", "Project Detail updated successfully.");
                                window.location.reload();
                            } else {
                                // error message
                                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson.retMessage);
                            }
                        }
                    }).fail(function(event, jqXHR, settings, thrownError) {
                        if (event.status != 440) {
                            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
                        }
                    }).always(function(data) {
                        $("#loading-modal").modal("hide");
                        $("#saveDraftBtn").attr("disabled", false);
                        $("#saveProcessBtn").attr("disabled", false);
                        $("#backBtn").attr("disabled", false);
                    });
                }
            } else if ($(this).find("input[type=submit]:focus" ).val() == 'Generate Evaluation Report') {

                $(this).attr("disabled", true);

                let errorMessage = "";
                let i = 1;

                let result = validateEmpty("#evaReportIssueDate", "Evaluation Report Issue Date", errorMessage, i);
                errorMessage = result[0]; i = result[1];

                result = validateEmpty("#evaReportFaxRefNo", "Evaluation Report Fax Reference No.", errorMessage, i);
                errorMessage = result[0]; i = result[1];

                result = validateDateOnlyFormat("#evaReportIssueDate", "Evaluation Report Issue Date", errorMessage, i);
                errorMessage = result[0]; i = result[1];

                if (!(errorMessage == "")) {
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
                    return false;
                }

                if (!validateDraftInput()) {
                    return;
                }

                $("#loading-modal").modal("show");

                $.ajax({
                    url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxPostPlanningAheadProjectDetailDraftUpdate",
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData(this),
                    success: function(data) {
                        let retJson = JSON.parse(data);
                        if (retJson.status == "OK") {
                            // Generate Evaluation Report
                            window.location.href =
                                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailEvaReportTemplate" +
                                "&schemeNo=" + $("#schemeNo").val();
                            $(this).attr("disabled", false);
                        } else {
                            // error message
                            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson.retMessage);
                        }
                    }
                }).fail(function(event, jqXHR, settings, thrownError) {
                    if (event.status != 440) {
                        showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
                    }
                }).always(function(data) {
                    $("#loading-modal").modal("hide");
                });
            } else if ($(this).find("input[type=submit]:focus" ).val() == 'Generate Re-Site Walk Evaluation Report') {

                $(this).attr("disabled", true);

                let errorMessage = "";
                let i = 1;

                let result = validateEmpty("#reEvaReportIssueDate", "Re-Site Walk Evaluation Report Issue Date", errorMessage, i);
                errorMessage = result[0]; i = result[1];

                result = validateEmpty("#reEvaReportFaxRefNo", "Re-Site Walk Evaluation Report Fax Reference No.", errorMessage, i);
                errorMessage = result[0]; i = result[1];

                result = validateDateOnlyFormat("#reEvaReportIssueDate", "Re-Site Walk Evaluation Report Issue Date", errorMessage, i);
                errorMessage = result[0]; i = result[1];

                if (!(errorMessage == "")) {
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
                    return false;
                }

                if (!validateDraftInput()) {
                    return;
                }

                $("#loading-modal").modal("show");

                $.ajax({
                    url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxPostPlanningAheadProjectDetailDraftUpdate",
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData(this),
                    success: function(data) {
                        let retJson = JSON.parse(data);
                        if (retJson.status == "OK") {
                            // Generate Evaluation Report
                            window.location.href =
                                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailReEvaReportTemplate" +
                                "&schemeNo=" + $("#schemeNo").val();
                            $(this).attr("disabled", false);
                        } else {
                            // error message
                            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson.retMessage);
                        }
                    }
                }).fail(function(event, jqXHR, settings, thrownError) {
                    if (event.status != 440) {
                        showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
                    }
                }).always(function(data) {
                    $("#loading-modal").modal("hide");
                });
            } else if ($(this).find("input[type=submit]:focus" ).val() == 'Back') {
                showConfirmation("<i class=\"fas fa-exclamation-circle\"></i> ", "Confirmation",
                    "Please save before leave",
                    function() {
                        window.location.href = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadInfoSearch";
                    },
                    function() {});
            }
        });

        <?php if (($this->viewbag['state']=="WAITING_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="COMPLETED_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_MEETING_ACK") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        $("#standLetterIssueDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#genStandLetterBtn").on("click", function() {

            let errorMessage = "";
            let i = 1;

            let result = validateEmpty("#standLetterIssueDate", "Standard Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#standLetterFaxRefNo", "Standard Letter Fax Ref No.", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#standLetterIssueDate", "Standard Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            if (errorMessage != "") {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
                return;
            }

            $(this).attr("disabled", true);
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailStandardLetterTemplate" +
                "&standLetterIssueDate=" + $("#standLetterIssueDate").val() + "&standLetterFaxRefNo=" + $("#standLetterFaxRefNo").val() +
                "&schemeNo=" + $("#schemeNo").val() + "&projectTypeId=" + $("#typeOfProject").val();
            $(this).attr("disabled", false);
        });
        <?php } ?>

        <?php if (($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_MEETING_ACK") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        $('#replySlipBmsServerCentralComputer').val("<?php echo $this->viewbag['replySlipBmsServerCentralComputer']; ?>");
        $('#replySlipBmsDdc').val("<?php echo $this->viewbag['replySlipBmsDdc']; ?>");
        $('#replySlipChangeoverSchemeControl').val("<?php echo $this->viewbag['replySlipChangeoverSchemeControl']; ?>");
        $('#replySlipChangeoverSchemeUv').val("<?php echo $this->viewbag['replySlipChangeoverSchemeUv']; ?>");
        $('#replySlipChillerPlantAhuControl').val("<?php echo $this->viewbag['replySlipChillerPlantAhuControl']; ?>");
        $('#replySlipChillerPlantAhuStartup').val("<?php echo $this->viewbag['replySlipChillerPlantAhuStartup']; ?>");
        $('#replySlipChillerPlantVsd').val("<?php echo $this->viewbag['replySlipChillerPlantVsd']; ?>");
        $('#replySlipChillerPlantAhuChilledWater').val("<?php echo $this->viewbag['replySlipChillerPlantAhuChilledWater']; ?>");
        $('#replySlipChillerPlantStandbyAhu').val("<?php echo $this->viewbag['replySlipChillerPlantStandbyAhu']; ?>");
        $('#replySlipChillerPlantChiller').val("<?php echo $this->viewbag['replySlipChillerPlantChiller']; ?>");
        $('#replySlipEscalatorMotorStartup').val("<?php echo $this->viewbag['replySlipEscalatorMotorStartup']; ?>");
        $('#replySlipEscalatorVsdMitigation').val("<?php echo $this->viewbag['replySlipEscalatorVsdMitigation']; ?>");
        $('#replySlipEscalatorBrakingSystem').val("<?php echo $this->viewbag['replySlipEscalatorBrakingSystem']; ?>");
        $('#replySlipEscalatorControl').val("<?php echo $this->viewbag['replySlipEscalatorControl']; ?>");
        $('#replySlipHidLampMitigation').val("<?php echo $this->viewbag['replySlipHidLampMitigation']; ?>");
        $('#replySlipLiftOperation').val("<?php echo $this->viewbag['replySlipLiftOperation']; ?>");
        $('#replySlipSensitiveMachineMitigation').val("<?php echo $this->viewbag['replySlipSensitiveMachineMitigation']; ?>");
        $('#replySlipTelecomMachineServerOrComputer').val("<?php echo $this->viewbag['replySlipTelecomMachineServerOrComputer']; ?>");
        $('#replySlipTelecomMachinePeripherals').val("<?php echo $this->viewbag['replySlipTelecomMachinePeripherals']; ?>");
        $('#replySlipTelecomMachineHarmonicEmission').val("<?php echo $this->viewbag['replySlipTelecomMachineHarmonicEmission']; ?>");
        $('#replySlipAirConditionersMicb').val("<?php echo $this->viewbag['replySlipAirConditionersMicb']; ?>");
        $('#replySlipAirConditionersLoadForecasting').val("<?php echo $this->viewbag['replySlipAirConditionersLoadForecasting']; ?>");
        $('#replySlipAirConditionersType').val("<?php echo $this->viewbag['replySlipAirConditionersType']; ?>");
        $('#replySlipNonLinearLoadHarmonicEmission').val("<?php echo $this->viewbag['replySlipNonLinearLoadHarmonicEmission']; ?>");
        $('#replySlipRenewableEnergyInverterAndControls').val("<?php echo $this->viewbag['replySlipRenewableEnergyInverterAndControls']; ?>");
        $('#replySlipRenewableEnergyHarmonicEmission').val("<?php echo $this->viewbag['replySlipRenewableEnergyHarmonicEmission']; ?>");
        $('#replySlipEvChargerSystemEvCharger').val("<?php echo $this->viewbag['replySlipEvChargerSystemEvCharger']; ?>");
        $('#replySlipEvChargerSystemSmartChargingSystem').val("<?php echo $this->viewbag['replySlipEvChargerSystemSmartChargingSystem']; ?>");
        $('#replySlipEvChargerSystemHarmonicEmission').val("<?php echo $this->viewbag['replySlipEvChargerSystemHarmonicEmission']; ?>");
        $('#replySlipConsultantNameConfirmation').val("<?php echo $this->viewbag['replySlipConsultantNameConfirmation']; ?>");
        $('#replySlipConsultantCompany').val("<?php echo $this->viewbag['replySlipConsultantCompany']; ?>");
        $('#replySlipProjectOwnerNameConfirmation').val("<?php echo $this->viewbag['replySlipProjectOwnerNameConfirmation']; ?>");
        $('#replySlipProjectOwnerCompany').val("<?php echo $this->viewbag['replySlipProjectOwnerCompany']; ?>");

        $("#meetingFirstPreferMeetingDate").datetimepicker({
            timepicker: true,
            format: 'Y-m-d H:i',
            scrollInput: false
        });

        $("#meetingSecondPreferMeetingDate").datetimepicker({
            timepicker: true,
            format: 'Y-m-d H:i',
            scrollInput: false
        });

        $("#meetingActualMeetingDate").datetimepicker({
            timepicker: true,
            format: 'Y-m-d H:i',
            scrollInput: false
        });

        $("#resendMeetingRequestBtn").on("click", function() {
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/AjaxGetResendMeetingRequestEmail&schemeNo=" + $('#schemeNo').val(),
                type: "GET",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    let retJson = JSON.parse(data);
                    if (retJson.status == "OK") {
                        // display message
                        showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info", "Request for resending Meeting Email was completed, email will be sent within 5 minutes.");
                    } else {
                        // error message
                        showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson.retMessage);
                    }
                }
            }).fail(function(event, jqXHR, settings, thrownError) {
                if (event.status != 440) {
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
                }
            }).always(function(data) {
                $("#loading-modal").modal("hide");
                $("#saveDraftBtn").attr("disabled", false);
                $("#saveProcessBtn").attr("disabled", false);
                $("#backBtn").attr("disabled", false);
            });

        });

        $("#showReplySlipDetailBtn").on("click", function() {
            if ($('#showReplySlipDetailBtn').val() == 'Show Reply Slip Detail') {
                $('#accordionDetailofReplySlip').css ("display", "block");
                $('#showReplySlipDetailBtn').val('Hide Reply Slip Detail');
            } else {
                $('#accordionDetailofReplySlip').css ("display", "none");
                $('#showReplySlipDetailBtn').val('Show Reply Slip Detail');
            }
        });

        $("#genReplySlipDetailBtn").on("click", function() {
            $(this).attr("disabled", true);
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailReplySlipTemplate" +
                "&schemeNo=" + $("#schemeNo").val();
            $(this).attr("disabled", false);
        });
        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        $('#firstInvitationLetterIssueDate').val("<?php echo $this->viewbag['firstInvitationLetterIssueDate']; ?>");
        $('#firstInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['firstInvitationLetterFaxRefNo']; ?>");
        $('#firstInvitationLetterEdmsLink').val("<?php echo $this->viewbag['firstInvitationLetterEdmsLink']; ?>");
        $('#firstInvitationLetterWalkDate').val("<?php echo $this->viewbag['firstInvitationLetterWalkDate']; ?>");

        $("#firstInvitationLetterIssueDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#firstInvitationLetterWalkDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#genFirstInvitationLetterBtn").on("click", function() {
            let errorMessage = "";
            let i = 1;

            let result = validateEmpty("#firstInvitationLetterIssueDate", "1st Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterFaxRefNo", "1st Invitiation Letter Fax Ref No.", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            if (errorMessage != "") {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
                return;
            }

            $(this).attr("disabled", true);
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailFirstInvitationLetterTemplate" +
                "&firstInvitationLetterIssueDate=" + $("#firstInvitationLetterIssueDate").val() +
                "&firstInvitationLetterFaxRefNo=" + $("#firstInvitationLetterFaxRefNo").val() +
                "&schemeNo=" + $("#schemeNo").val();
            $(this).attr("disabled", false);
        });

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        $('#secondInvitationLetterIssueDate').val("<?php echo $this->viewbag['secondInvitationLetterIssueDate']; ?>");
        $('#secondInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['secondInvitationLetterFaxRefNo']; ?>");
        $('#secondInvitationLetterEdmsLink').val("<?php echo $this->viewbag['secondInvitationLetterEdmsLink']; ?>");
        $('#secondInvitationLetterWalkDate').val("<?php echo $this->viewbag['secondInvitationLetterWalkDate']; ?>");

        $("#secondInvitationLetterIssueDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#secondInvitationLetterWalkDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#genSecondInvitationLetterBtn").on("click", function() {
            let errorMessage = "";
            let i = 1;

            let result = validateEmpty("#firstInvitationLetterIssueDate", "1st Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterFaxRefNo", "1st Invitiation Letter Fax Ref No.", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterIssueDate", "2nd Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterFaxRefNo", "2nd Invitiation Letter Fax Ref No.", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            if (errorMessage != "") {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
                return;
            }

            $(this).attr("disabled", true);
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailSecondInvitationLetterTemplate" +
                "&secondInvitationLetterIssueDate=" + $("#secondInvitationLetterIssueDate").val() +
                "&secondInvitationLetterFaxRefNo=" + $("#secondInvitationLetterFaxRefNo").val() +
                "&firstInvitationLetterIssueDate=" + $("#firstInvitationLetterIssueDate").val() +
                "&firstInvitationLetterFaxRefNo=" + $("#firstInvitationLetterFaxRefNo").val() +
                "&schemeNo=" + $("#schemeNo").val();
            $(this).attr("disabled", false);
        });

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        $('#thirdInvitationLetterIssueDate').val("<?php echo $this->viewbag['thirdInvitationLetterIssueDate']; ?>");
        $('#thirdInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['thirdInvitationLetterFaxRefNo']; ?>");
        $('#thirdInvitationLetterEdmsLink').val("<?php echo $this->viewbag['thirdInvitationLetterEdmsLink']; ?>");
        $('#thirdInvitationLetterWalkDate').val("<?php echo $this->viewbag['thirdInvitationLetterWalkDate']; ?>");

        $("#thirdInvitationLetterIssueDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#thirdInvitationLetterWalkDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#genThirdInvitationLetterBtn").on("click", function() {
            let errorMessage = "";
            let i = 1;

            let result = validateEmpty("#firstInvitationLetterIssueDate", "1st Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterFaxRefNo", "1st Invitiation Letter Fax Ref No.", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterIssueDate", "2nd Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterFaxRefNo", "2nd Invitiation Letter Fax Ref No.", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#thirdInvitationLetterIssueDate", "3rd Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#thirdInvitationLetterFaxRefNo", "3rd Invitiation Letter Fax Ref No.", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#thirdInvitationLetterIssueDate", "3rd Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            if (errorMessage != "") {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
                return;
            }

            $(this).attr("disabled", true);
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailThirdInvitationLetterTemplate" +
                "&thirdInvitationLetterIssueDate=" + $("#thirdInvitationLetterIssueDate").val() +
                "&thirdInvitationLetterFaxRefNo=" + $("#thirdInvitationLetterFaxRefNo").val() +
                "&secondInvitationLetterIssueDate=" + $("#secondInvitationLetterIssueDate").val() +
                "&secondInvitationLetterFaxRefNo=" + $("#secondInvitationLetterFaxRefNo").val() +
                "&firstInvitationLetterIssueDate=" + $("#firstInvitationLetterIssueDate").val() +
                "&firstInvitationLetterFaxRefNo=" + $("#firstInvitationLetterFaxRefNo").val() +
                "&schemeNo=" + $("#schemeNo").val();
            $(this).attr("disabled", false);
        });

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        $('#forthInvitationLetterIssueDate').val("<?php echo $this->viewbag['forthInvitationLetterIssueDate']; ?>");
        $('#forthInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['forthInvitationLetterFaxRefNo']; ?>");
        $('#forthInvitationLetterEdmsLink').val("<?php echo $this->viewbag['forthInvitationLetterEdmsLink']; ?>");
        $('#forthInvitationLetterWalkDate').val("<?php echo $this->viewbag['forthInvitationLetterWalkDate']; ?>");

        $("#forthInvitationLetterIssueDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#forthInvitationLetterWalkDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#genForthInvitationLetterBtn").on("click", function() {
            let errorMessage = "";
            let i = 1;

            let result = validateEmpty("#forthInvitationLetterIssueDate", "4th Invitiation Letter Issue Date", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#forthInvitationLetterFaxRefNo", "4th Invitiation Letter Fax Ref No.", errorMessage, i);
            errorMessage = result[0]; i = result[1];

            if (errorMessage != "") {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
                return;
            }

            $(this).attr("disabled", true);
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadProjectDetailForthInvitationLetterTemplate" +
                "&forthInvitationLetterIssueDate=" + $("#forthInvitationLetterIssueDate").val() +
                "&forthInvitationLetterFaxRefNo=" + $("#forthInvitationLetterFaxRefNo").val() +
                "&schemeNo=" + $("#schemeNo").val();
            $(this).attr("disabled", false);
        });

        <?php } ?>

        <?php if (($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        $('#evaReportRemark').val("<?php echo $this->viewbag['evaReportRemark']; ?>");
        $('#evaReportEdmsLink').val("<?php echo $this->viewbag['evaReportEdmsLink']; ?>");
        $('#evaReportIssueDate').val("<?php echo $this->viewbag['evaReportIssueDate']; ?>");
        $('#evaReportFaxRefNo').val("<?php echo $this->viewbag['evaReportFaxRefNo']; ?>");
        $('#evaReportScore').val("<?php echo $this->viewbag['evaReportScore']; ?>");
        $('#evaReportBmsServerCentralComputerFinding').val("<?php echo $this->viewbag['evaReportBmsServerCentralComputerFinding']; ?>");
        $('#evaReportBmsServerCentralComputerRecommend').val("<?php echo $this->viewbag['evaReportBmsServerCentralComputerRecommend']; ?>");
        $('#evaReportBmsDdcFinding').val("<?php echo $this->viewbag['evaReportBmsDdcFinding']; ?>");
        $('#evaReportBmsDdcRecommend').val("<?php echo $this->viewbag['evaReportBmsDdcRecommend']; ?>");
        $('#evaReportBmsSupplement').val("<?php echo $this->viewbag['evaReportBmsSupplement']; ?>");
        $('#evaReportChangeoverSchemeControlFinding').val("<?php echo $this->viewbag['evaReportChangeoverSchemeControlFinding']; ?>");
        $('#evaReportChangeoverSchemeControlRecommend').val("<?php echo $this->viewbag['evaReportChangeoverSchemeControlRecommend']; ?>");
        $('#evaReportChangeoverSchemeUvFinding').val("<?php echo $this->viewbag['evaReportChangeoverSchemeUvFinding']; ?>");
        $('#evaReportChangeoverSchemeUvRecommend').val("<?php echo $this->viewbag['evaReportChangeoverSchemeUvRecommend']; ?>");
        $('#evaReportChangeoverSchemeSupplement').val("<?php echo $this->viewbag['evaReportChangeoverSchemeSupplement']; ?>");
        $('#evaReportChillerPlantAhuChilledWaterFinding').val("<?php echo $this->viewbag['evaReportChillerPlantAhuChilledWaterFinding']; ?>");
        $('#evaReportChillerPlantAhuChilledWaterRecommend').val("<?php echo $this->viewbag['evaReportChillerPlantAhuChilledWaterRecommend']; ?>");
        $('#evaReportChillerPlantChillerFinding').val("<?php echo $this->viewbag['evaReportChillerPlantChillerFinding']; ?>");
        $('#evaReportChillerPlantChillerRecommend').val("<?php echo $this->viewbag['evaReportChillerPlantChillerRecommend']; ?>");
        $('#evaReportChillerPlantSupplement').val("<?php echo $this->viewbag['evaReportChillerPlantSupplement']; ?>");
        $('#evaReportEscalatorBrakingSystemFinding').val("<?php echo $this->viewbag['evaReportEscalatorBrakingSystemFinding']; ?>");
        $('#evaReportEscalatorBrakingSystemRecommend').val("<?php echo $this->viewbag['evaReportEscalatorBrakingSystemRecommend']; ?>");
        $('#evaReportEscalatorControlFinding').val("<?php echo $this->viewbag['evaReportEscalatorControlFinding']; ?>");
        $('#evaReportEscalatorControlRecommend').val("<?php echo $this->viewbag['evaReportEscalatorControlRecommend']; ?>");
        $('#evaReportEscalatorSupplement').val("<?php echo $this->viewbag['evaReportEscalatorSupplement']; ?>");
        $('#evaReportLiftOperationFinding').val("<?php echo $this->viewbag['evaReportLiftOperationFinding']; ?>");
        $('#evaReportLiftOperationRecommend').val("<?php echo $this->viewbag['evaReportLiftOperationRecommend']; ?>");
        $('#evaReportLiftMainSupplyFinding').val("<?php echo $this->viewbag['evaReportLiftMainSupplyFinding']; ?>");
        $('#evaReportLiftMainSupplyRecommend').val("<?php echo $this->viewbag['evaReportLiftMainSupplyRecommend']; ?>");
        $('#evaReportLiftSupplement').val("<?php echo $this->viewbag['evaReportLiftSupplement']; ?>");
        $('#evaReportHidLampBallastFinding').val("<?php echo $this->viewbag['evaReportHidLampBallastFinding']; ?>");
        $('#evaReportHidLampBallastRecommend').val("<?php echo $this->viewbag['evaReportHidLampBallastRecommend']; ?>");
        $('#evaReportHidLampAddonProtectFinding').val("<?php echo $this->viewbag['evaReportHidLampAddonProtectFinding']; ?>");
        $('#evaReportHidLampAddonProtectRecommend').val("<?php echo $this->viewbag['evaReportHidLampAddonProtectRecommend']; ?>");
        $('#evaReportHidLampSupplement').val("<?php echo $this->viewbag['evaReportHidLampSupplement']; ?>");
        $('#evaReportSensitiveMachineMedicalFinding').val("<?php echo $this->viewbag['evaReportSensitiveMachineMedicalFinding']; ?>");
        $('#evaReportSensitiveMachineMedicalRecommend').val("<?php echo $this->viewbag['evaReportSensitiveMachineMedicalRecommend']; ?>");
        $('#evaReportSensitiveMachineSupplement').val("<?php echo $this->viewbag['evaReportSensitiveMachineSupplement']; ?>");
        $('#evaReportTelecomMachineServerOrComputerFinding').val("<?php echo $this->viewbag['evaReportTelecomMachineServerOrComputerFinding']; ?>");
        $('#evaReportTelecomMachineServerOrComputerRecommend').val("<?php echo $this->viewbag['evaReportTelecomMachineServerOrComputerRecommend']; ?>");
        $('#evaReportTelecomMachinePeripheralsFinding').val("<?php echo $this->viewbag['evaReportTelecomMachinePeripheralsFinding']; ?>");
        $('#evaReportTelecomMachinePeripheralsRecommend').val("<?php echo $this->viewbag['evaReportTelecomMachinePeripheralsRecommend']; ?>");
        $('#evaReportTelecomMachineHarmonicEmissionFinding').val("<?php echo $this->viewbag['evaReportTelecomMachineHarmonicEmissionFinding']; ?>");
        $('#evaReportTelecomMachineHarmonicEmissionRecommend').val("<?php echo $this->viewbag['evaReportTelecomMachineHarmonicEmissionRecommend']; ?>");
        $('#evaReportTelecomMachineSupplement').val("<?php echo $this->viewbag['evaReportTelecomMachineSupplement']; ?>");
        $('#evaReportAirConditionersMicbFinding').val("<?php echo $this->viewbag['evaReportAirConditionersMicbFinding']; ?>");
        $('#evaReportAirConditionersMicbRecommend').val("<?php echo $this->viewbag['evaReportAirConditionersMicbRecommend']; ?>");
        $('#evaReportAirConditionersLoadForecastingFinding').val("<?php echo $this->viewbag['evaReportAirConditionersLoadForecastingFinding']; ?>");
        $('#evaReportAirConditionersLoadForecastingRecommend').val("<?php echo $this->viewbag['evaReportAirConditionersLoadForecastingRecommend']; ?>");
        $('#evaReportAirConditionersTypeFinding').val("<?php echo $this->viewbag['evaReportAirConditionersTypeFinding']; ?>");
        $('#evaReportAirConditionersTypeRecommend').val("<?php echo $this->viewbag['evaReportAirConditionersTypeRecommend']; ?>");
        $('#evaReportAirConditionersSupplement').val("<?php echo $this->viewbag['evaReportAirConditionersSupplement']; ?>");
        $('#evaReportNonLinearLoadHarmonicEmissionFinding').val("<?php echo $this->viewbag['evaReportNonLinearLoadHarmonicEmissionFinding']; ?>");
        $('#evaReportNonLinearLoadHarmonicEmissionRecommend').val("<?php echo $this->viewbag['evaReportNonLinearLoadHarmonicEmissionRecommend']; ?>");
        $('#evaReportNonLinearLoadSupplement').val("<?php echo $this->viewbag['evaReportNonLinearLoadSupplement']; ?>");
        $('#evaReportRenewableEnergyInverterAndControlsFinding').val("<?php echo $this->viewbag['evaReportRenewableEnergyInverterAndControlsFinding']; ?>");
        $('#evaReportRenewableEnergyInverterAndControlsRecommend').val("<?php echo $this->viewbag['evaReportRenewableEnergyInverterAndControlsRecommend']; ?>");
        $('#evaReportRenewableEnergyHarmonicEmissionFinding').val("<?php echo $this->viewbag['evaReportRenewableEnergyHarmonicEmissionFinding']; ?>");
        $('#evaReportRenewableEnergyHarmonicEmissionRecommend').val("<?php echo $this->viewbag['evaReportRenewableEnergyHarmonicEmissionRecommend']; ?>");
        $('#evaReportRenewableEnergySupplement').val("<?php echo $this->viewbag['evaReportRenewableEnergySupplement']; ?>");
        $('#evaReportEvChargerSystemEvChargerFinding').val("<?php echo $this->viewbag['evaReportEvChargerSystemEvChargerFinding']; ?>");
        $('#evaReportEvChargerSystemEvChargerRecommend').val("<?php echo $this->viewbag['evaReportEvChargerSystemEvChargerRecommend']; ?>");
        $('#evaReportEvChargerSystemHarmonicEmissionFinding').val("<?php echo $this->viewbag['evaReportEvChargerSystemHarmonicEmissionFinding']; ?>");
        $('#evaReportEvChargerSystemHarmonicEmissionRecommend').val("<?php echo $this->viewbag['evaReportEvChargerSystemHarmonicEmissionRecommend']; ?>");
        $('#evaReportEvChargerSystemSupplement').val("<?php echo $this->viewbag['evaReportEvChargerSystemSupplement']; ?>");

        $("#showEvaReportBtn").on("click", function() {
            if ($('#showEvaReportBtn').val() == 'Show Evaluation Report Detail') {
                $('#accordionDetailOfEvaluationReportDetail').css ("display", "block");
                $('#showEvaReportBtn').val('Hide Evaluation Report Detail');
            } else {
                $('#accordionDetailOfEvaluationReportDetail').css ("display", "none");
                $('#showEvaReportBtn').val('Show Evaluation Report Detail');
            }
        });

        $("#evaReportIssueDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $('input[name=evaReportBmsServerCentralComputerYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportBmsServerCentralComputerPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportBmsDdcYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportBmsDdcPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportBmsSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportBmsSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportBmsServerCentralComputerYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportBmsServerCentralComputerPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChangeoverSchemeControlYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChangeoverSchemeControlPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChangeoverSchemeUvYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChangeoverSchemeUvPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChangeoverSchemeSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChangeoverSchemeSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChillerPlantAhuChilledWaterYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChillerPlantAhuChilledWaterPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChillerPlantChillerYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChillerPlantChillerPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChillerPlantSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportChillerPlantSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEscalatorBrakingSystemYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEscalatorBrakingSystemPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEscalatorControlYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEscalatorControlPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEscalatorSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEscalatorSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportLiftOperationYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportLiftOperationPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportLiftMainSupplyYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportLiftMainSupplyPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportLiftSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportLiftSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportHidLampBallastYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportHidLampBallastPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportHidLampAddonProtectYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportHidLampAddonProtectPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportHidLampSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportHidLampSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportSensitiveMachineMedicalYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportSensitiveMachineMedicalPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportSensitiveMachineSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportSensitiveMachineSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportTelecomMachineServerOrComputerYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportTelecomMachineServerOrComputerPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportTelecomMachinePeripheralsYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportTelecomMachinePeripheralsPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportTelecomMachineHarmonicEmissionYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportTelecomMachineHarmonicEmissionPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportTelecomMachineSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportTelecomMachineSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportAirConditionersMicbYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportAirConditionersMicbPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportAirConditionersLoadForecastingYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportAirConditionersLoadForecastingPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportAirConditionersTypeYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportAirConditionersTypePass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportAirConditionersSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportAirConditionersSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportNonLinearLoadHarmonicEmissionYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportNonLinearLoadHarmonicEmissionPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportNonLinearLoadSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportNonLinearLoadSupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportRenewableEnergyInverterAndControlsYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportRenewableEnergyInverterAndControlsPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportRenewableEnergyHarmonicEmissionYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportRenewableEnergyHarmonicEmissionPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportRenewableEnergySupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportRenewableEnergySupplementPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEvChargerSystemEvChargerYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEvChargerSystemEvChargerPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEvChargerSystemHarmonicEmissionYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEvChargerSystemHarmonicEmissionPass]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEvChargerSystemSupplementYesNo]', '#detailForm').on('click', updateEvaScore);
        $('input[name=evaReportEvChargerSystemSupplementPass]', '#detailForm').on('click', updateEvaScore);

        function updateEvaScore() {

            let itemsCount = 0.0;
            let passCount = 0.0;

            let result = calReportScore('evaReportBmsServerCentralComputerYesNo', 'evaReportBmsServerCentralComputerPass', 'evaReportBmsYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportBmsDdcYesNo', 'evaReportBmsDdcPass', 'evaReportBmsYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportBmsSupplementYesNo', 'evaReportBmsSupplementPass', 'evaReportBmsYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportChangeoverSchemeControlYesNo', 'evaReportChangeoverSchemeControlPass', 'evaReportChangeoverSchemeYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportChangeoverSchemeUvYesNo', 'evaReportChangeoverSchemeUvPass', 'evaReportChangeoverSchemeYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportChangeoverSchemeSupplementYesNo', 'evaReportChangeoverSchemeSupplementPass','evaReportChangeoverSchemeYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportChillerPlantAhuChilledWaterYesNo', 'evaReportChillerPlantAhuChilledWaterPass', 'evaReportChillerPlantYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportChillerPlantChillerYesNo', 'evaReportChillerPlantChillerPass', 'evaReportChillerPlantYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportChillerPlantSupplementYesNo', 'evaReportChillerPlantSupplementPass', 'evaReportChillerPlantYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportEscalatorBrakingSystemYesNo', 'evaReportEscalatorBrakingSystemPass', 'evaReportEscalatorYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportEscalatorControlYesNo', 'evaReportEscalatorControlPass', 'evaReportEscalatorYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportEscalatorSupplementYesNo', 'evaReportEscalatorSupplementPass', 'evaReportEscalatorYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportLiftOperationYesNo', 'evaReportLiftOperationPass', 'evaReportLiftYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportLiftMainSupplyYesNo', 'evaReportLiftMainSupplyPass', 'evaReportLiftYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportLiftSupplementYesNo', 'evaReportLiftSupplementPass', 'evaReportLiftYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportHidLampBallastYesNo', 'evaReportHidLampBallastPass', 'evaReportHidLampYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportHidLampAddonProtectYesNo', 'evaReportHidLampAddonProtectPass', 'evaReportHidLampYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportHidLampSupplementYesNo', 'evaReportHidLampSupplementPass', 'evaReportHidLampYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportSensitiveMachineMedicalYesNo', 'evaReportSensitiveMachineMedicalPass', 'evaReportSensitiveMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportSensitiveMachineSupplementYesNo', 'evaReportSensitiveMachineSupplementPass', 'evaReportSensitiveMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportTelecomMachineServerOrComputerYesNo', 'evaReportTelecomMachineServerOrComputerPass', 'evaReportTelecomMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportTelecomMachinePeripheralsYesNo', 'evaReportTelecomMachinePeripheralsPass', 'evaReportTelecomMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportTelecomMachineHarmonicEmissionYesNo', 'evaReportTelecomMachineHarmonicEmissionPass', 'evaReportTelecomMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportTelecomMachineSupplementYesNo', 'evaReportTelecomMachineSupplementPass', 'evaReportTelecomMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportAirConditionersMicbYesNo', 'evaReportAirConditionersMicbPass', 'evaReportAirConditionersYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportAirConditionersLoadForecastingYesNo', 'evaReportAirConditionersLoadForecastingPass', 'evaReportAirConditionersYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportAirConditionersTypeYesNo', 'evaReportAirConditionersTypePass', 'evaReportAirConditionersYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportAirConditionersSupplementYesNo', 'evaReportAirConditionersSupplementPass', 'evaReportAirConditionersYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportNonLinearLoadHarmonicEmissionYesNo', 'evaReportNonLinearLoadHarmonicEmissionPass', 'evaReportNonLinearLoadYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportNonLinearLoadSupplementYesNo', 'evaReportNonLinearLoadSupplementPass', 'evaReportNonLinearLoadYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportRenewableEnergyInverterAndControlsYesNo', 'evaReportRenewableEnergyInverterAndControlsPass', 'evaReportRenewableEnergyYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportRenewableEnergyHarmonicEmissionYesNo', 'evaReportRenewableEnergyHarmonicEmissionPass', 'evaReportRenewableEnergyYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportRenewableEnergySupplementYesNo', 'evaReportRenewableEnergySupplementPass', 'evaReportRenewableEnergyYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportEvChargerSystemEvChargerYesNo', 'evaReportEvChargerSystemEvChargerPass', 'evaReportEvChargerSystemYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportEvChargerSystemHarmonicEmissionYesNo', 'evaReportEvChargerSystemHarmonicEmissionPass', 'evaReportEvChargerSystemYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('evaReportEvChargerSystemSupplementYesNo', 'evaReportEvChargerSystemSupplementPass', 'evaReportEvChargerSystemYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            if (itemsCount > 0) {
                let score = (passCount / itemsCount * 100).toFixed(2);
                $("#evaReportScore").val(score);
            } else {
                $("#evaReportScore").val('NA');
            }
        }

        <?php } ?>

        <?php if (($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
            ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        $('#reEvaReportRemark').val("<?php echo $this->viewbag['reEvaReportRemark']; ?>");
        $('#reEvaReportEdmsLink').val("<?php echo $this->viewbag['reEvaReportEdmsLink']; ?>");
        $('#reEvaReportIssueDate').val("<?php echo $this->viewbag['reEvaReportIssueDate']; ?>");
        $('#reEvaReportFaxRefNo').val("<?php echo $this->viewbag['reEvaReportFaxRefNo']; ?>");
        $('#reEvaReportScore').val("<?php echo $this->viewbag['reEvaReportScore']; ?>");
        $('#reEvaReportBmsServerCentralComputerFinding').val("<?php echo $this->viewbag['reEvaReportBmsServerCentralComputerFinding']; ?>");
        $('#reEvaReportBmsServerCentralComputerRecommend').val("<?php echo $this->viewbag['reEvaReportBmsServerCentralComputerRecommend']; ?>");
        $('#reEvaReportBmsDdcFinding').val("<?php echo $this->viewbag['reEvaReportBmsDdcFinding']; ?>");
        $('#reEvaReportBmsDdcRecommend').val("<?php echo $this->viewbag['reEvaReportBmsDdcRecommend']; ?>");
        $('#reEvaReportBmsSupplement').val("<?php echo $this->viewbag['reEvaReportBmsSupplement']; ?>");
        $('#reEvaReportChangeoverSchemeControlFinding').val("<?php echo $this->viewbag['reEvaReportChangeoverSchemeControlFinding']; ?>");
        $('#reEvaReportChangeoverSchemeControlRecommend').val("<?php echo $this->viewbag['reEvaReportChangeoverSchemeControlRecommend']; ?>");
        $('#reEvaReportChangeoverSchemeUvFinding').val("<?php echo $this->viewbag['reEvaReportChangeoverSchemeUvFinding']; ?>");
        $('#reEvaReportChangeoverSchemeUvRecommend').val("<?php echo $this->viewbag['reEvaReportChangeoverSchemeUvRecommend']; ?>");
        $('#reEvaReportChangeoverSchemeSupplement').val("<?php echo $this->viewbag['reEvaReportChangeoverSchemeSupplement']; ?>");
        $('#reEvaReportChillerPlantAhuChilledWaterFinding').val("<?php echo $this->viewbag['reEvaReportChillerPlantAhuChilledWaterFinding']; ?>");
        $('#reEvaReportChillerPlantAhuChilledWaterRecommend').val("<?php echo $this->viewbag['reEvaReportChillerPlantAhuChilledWaterRecommend']; ?>");
        $('#reEvaReportChillerPlantChillerFinding').val("<?php echo $this->viewbag['reEvaReportChillerPlantChillerFinding']; ?>");
        $('#reEvaReportChillerPlantChillerRecommend').val("<?php echo $this->viewbag['reEvaReportChillerPlantChillerRecommend']; ?>");
        $('#reEvaReportChillerPlantSupplement').val("<?php echo $this->viewbag['reEvaReportChillerPlantSupplement']; ?>");
        $('#reEvaReportEscalatorBrakingSystemFinding').val("<?php echo $this->viewbag['reEvaReportEscalatorBrakingSystemFinding']; ?>");
        $('#reEvaReportEscalatorBrakingSystemRecommend').val("<?php echo $this->viewbag['reEvaReportEscalatorBrakingSystemRecommend']; ?>");
        $('#reEvaReportEscalatorControlFinding').val("<?php echo $this->viewbag['reEvaReportEscalatorControlFinding']; ?>");
        $('#reEvaReportEscalatorControlRecommend').val("<?php echo $this->viewbag['reEvaReportEscalatorControlRecommend']; ?>");
        $('#reEvaReportEscalatorSupplement').val("<?php echo $this->viewbag['reEvaReportEscalatorSupplement']; ?>");
        $('#reEvaReportLiftOperationFinding').val("<?php echo $this->viewbag['reEvaReportLiftOperationFinding']; ?>");
        $('#reEvaReportLiftOperationRecommend').val("<?php echo $this->viewbag['reEvaReportLiftOperationRecommend']; ?>");
        $('#reEvaReportLiftMainSupplyFinding').val("<?php echo $this->viewbag['reEvaReportLiftMainSupplyFinding']; ?>");
        $('#reEvaReportLiftMainSupplyRecommend').val("<?php echo $this->viewbag['reEvaReportLiftMainSupplyRecommend']; ?>");
        $('#reEvaReportLiftSupplement').val("<?php echo $this->viewbag['reEvaReportLiftSupplement']; ?>");
        $('#reEvaReportHidLampBallastFinding').val("<?php echo $this->viewbag['reEvaReportHidLampBallastFinding']; ?>");
        $('#reEvaReportHidLampBallastRecommend').val("<?php echo $this->viewbag['reEvaReportHidLampBallastRecommend']; ?>");
        $('#reEvaReportHidLampAddonProtectFinding').val("<?php echo $this->viewbag['reEvaReportHidLampAddonProtectFinding']; ?>");
        $('#reEvaReportHidLampAddonProtectRecommend').val("<?php echo $this->viewbag['reEvaReportHidLampAddonProtectRecommend']; ?>");
        $('#reEvaReportHidLampSupplement').val("<?php echo $this->viewbag['reEvaReportHidLampSupplement']; ?>");
        $('#reEvaReportSensitiveMachineMedicalFinding').val("<?php echo $this->viewbag['reEvaReportSensitiveMachineMedicalFinding']; ?>");
        $('#reEvaReportSensitiveMachineMedicalRecommend').val("<?php echo $this->viewbag['reEvaReportSensitiveMachineMedicalRecommend']; ?>");
        $('#reEvaReportSensitiveMachineSupplement').val("<?php echo $this->viewbag['reEvaReportSensitiveMachineSupplement']; ?>");
        $('#reEvaReportTelecomMachineServerOrComputerFinding').val("<?php echo $this->viewbag['reEvaReportTelecomMachineServerOrComputerFinding']; ?>");
        $('#reEvaReportTelecomMachineServerOrComputerRecommend').val("<?php echo $this->viewbag['reEvaReportTelecomMachineServerOrComputerRecommend']; ?>");
        $('#reEvaReportTelecomMachinePeripheralsFinding').val("<?php echo $this->viewbag['reEvaReportTelecomMachinePeripheralsFinding']; ?>");
        $('#reEvaReportTelecomMachinePeripheralsRecommend').val("<?php echo $this->viewbag['reEvaReportTelecomMachinePeripheralsRecommend']; ?>");
        $('#reEvaReportTelecomMachineHarmonicEmissionFinding').val("<?php echo $this->viewbag['reEvaReportTelecomMachineHarmonicEmissionFinding']; ?>");
        $('#reEvaReportTelecomMachineHarmonicEmissionRecommend').val("<?php echo $this->viewbag['reEvaReportTelecomMachineHarmonicEmissionRecommend']; ?>");
        $('#reEvaReportTelecomMachineSupplement').val("<?php echo $this->viewbag['reEvaReportTelecomMachineSupplement']; ?>");
        $('#reEvaReportAirConditionersMicbFinding').val("<?php echo $this->viewbag['reEvaReportAirConditionersMicbFinding']; ?>");
        $('#reEvaReportAirConditionersMicbRecommend').val("<?php echo $this->viewbag['reEvaReportAirConditionersMicbRecommend']; ?>");
        $('#reEvaReportAirConditionersLoadForecastingFinding').val("<?php echo $this->viewbag['reEvaReportAirConditionersLoadForecastingFinding']; ?>");
        $('#reEvaReportAirConditionersLoadForecastingRecommend').val("<?php echo $this->viewbag['reEvaReportAirConditionersLoadForecastingRecommend']; ?>");
        $('#reEvaReportAirConditionersTypeFinding').val("<?php echo $this->viewbag['reEvaReportAirConditionersTypeFinding']; ?>");
        $('#reEvaReportAirConditionersTypeRecommend').val("<?php echo $this->viewbag['reEvaReportAirConditionersTypeRecommend']; ?>");
        $('#reEvaReportAirConditionersSupplement').val("<?php echo $this->viewbag['reEvaReportAirConditionersSupplement']; ?>");
        $('#reEvaReportNonLinearLoadHarmonicEmissionFinding').val("<?php echo $this->viewbag['reEvaReportNonLinearLoadHarmonicEmissionFinding']; ?>");
        $('#reEvaReportNonLinearLoadHarmonicEmissionRecommend').val("<?php echo $this->viewbag['reEvaReportNonLinearLoadHarmonicEmissionRecommend']; ?>");
        $('#reEvaReportNonLinearLoadSupplement').val("<?php echo $this->viewbag['reEvaReportNonLinearLoadSupplement']; ?>");
        $('#reEvaReportRenewableEnergyInverterAndControlsFinding').val("<?php echo $this->viewbag['reEvaReportRenewableEnergyInverterAndControlsFinding']; ?>");
        $('#reEvaReportRenewableEnergyInverterAndControlsRecommend').val("<?php echo $this->viewbag['reEvaReportRenewableEnergyInverterAndControlsRecommend']; ?>");
        $('#reEvaReportRenewableEnergyHarmonicEmissionFinding').val("<?php echo $this->viewbag['reEvaReportRenewableEnergyHarmonicEmissionFinding']; ?>");
        $('#reEvaReportRenewableEnergyHarmonicEmissionRecommend').val("<?php echo $this->viewbag['reEvaReportRenewableEnergyHarmonicEmissionRecommend']; ?>");
        $('#reEvaReportRenewableEnergySupplement').val("<?php echo $this->viewbag['reEvaReportRenewableEnergySupplement']; ?>");
        $('#reEvaReportEvChargerSystemEvChargerFinding').val("<?php echo $this->viewbag['reEvaReportEvChargerSystemEvChargerFinding']; ?>");
        $('#reEvaReportEvChargerSystemEvChargerRecommend').val("<?php echo $this->viewbag['reEvaReportEvChargerSystemEvChargerRecommend']; ?>");
        $('#reEvaReportEvChargerSystemHarmonicEmissionFinding').val("<?php echo $this->viewbag['reEvaReportEvChargerSystemHarmonicEmissionFinding']; ?>");
        $('#reEvaReportEvChargerSystemHarmonicEmissionRecommend').val("<?php echo $this->viewbag['reEvaReportEvChargerSystemHarmonicEmissionRecommend']; ?>");
        $('#reEvaReportEvChargerSystemSupplement').val("<?php echo $this->viewbag['reEvaReportEvChargerSystemSupplement']; ?>");

        $("#reEvaReportIssueDate").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        $("#showReEvaReportBtn").on("click", function() {
            if ($('#showReEvaReportBtn').val() == 'Show Evaluation Report Detail') {
                $('#accordionDetailOfReEvaluationReportDetail').css ("display", "block");
                $('#showReEvaReportBtn').val('Hide Evaluation Report Detail');
            } else {
                $('#accordionDetailOfReEvaluationReportDetail').css ("display", "none");
                $('#showReEvaReportBtn').val('Show Evaluation Report Detail');
            }
        });

        $('input[name=reEvaReportBmsServerCentralComputerYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportBmsServerCentralComputerPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportBmsDdcYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportBmsDdcPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportBmsSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportBmsSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportBmsServerCentralComputerYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportBmsServerCentralComputerPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChangeoverSchemeControlYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChangeoverSchemeControlPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChangeoverSchemeUvYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChangeoverSchemeUvPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChangeoverSchemeSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChangeoverSchemeSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChillerPlantAhuChilledWaterYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChillerPlantAhuChilledWaterPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChillerPlantChillerYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChillerPlantChillerPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChillerPlantSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportChillerPlantSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEscalatorBrakingSystemYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEscalatorBrakingSystemPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEscalatorControlYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEscalatorControlPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEscalatorSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEscalatorSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportLiftOperationYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportLiftOperationPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportLiftMainSupplyYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportLiftMainSupplyPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportLiftSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportLiftSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportHidLampBallastYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportHidLampBallastPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportHidLampAddonProtectYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportHidLampAddonProtectPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportHidLampSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportHidLampSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportSensitiveMachineMedicalYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportSensitiveMachineMedicalPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportSensitiveMachineSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportSensitiveMachineSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportTelecomMachineServerOrComputerYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportTelecomMachineServerOrComputerPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportTelecomMachinePeripheralsYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportTelecomMachinePeripheralsPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportTelecomMachineHarmonicEmissionYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportTelecomMachineHarmonicEmissionPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportTelecomMachineSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportTelecomMachineSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportAirConditionersMicbYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportAirConditionersMicbPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportAirConditionersLoadForecastingYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportAirConditionersLoadForecastingPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportAirConditionersTypeYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportAirConditionersTypePass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportAirConditionersSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportAirConditionersSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportNonLinearLoadHarmonicEmissionYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportNonLinearLoadHarmonicEmissionPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportNonLinearLoadSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportNonLinearLoadSupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportRenewableEnergyInverterAndControlsYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportRenewableEnergyInverterAndControlsPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportRenewableEnergyHarmonicEmissionYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportRenewableEnergyHarmonicEmissionPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportRenewableEnergySupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportRenewableEnergySupplementPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEvChargerSystemEvChargerYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEvChargerSystemEvChargerPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEvChargerSystemHarmonicEmissionYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEvChargerSystemHarmonicEmissionPass]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEvChargerSystemSupplementYesNo]', '#detailForm').on('click', updateReEvaScore);
        $('input[name=reEvaReportEvChargerSystemSupplementPass]', '#detailForm').on('click', updateReEvaScore);

        function updateReEvaScore() {

            let itemsCount = 0.0;
            let passCount = 0.0;

            let result = calReportScore('reEvaReportBmsServerCentralComputerYesNo', 'reEvaReportBmsServerCentralComputerPass', 'reEvaReportBmsYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportBmsDdcYesNo', 'reEvaReportBmsDdcPass', 'reEvaReportBmsYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportBmsSupplementYesNo', 'reEvaReportBmsSupplementPass', 'reEvaReportBmsYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportChangeoverSchemeControlYesNo', 'reEvaReportChangeoverSchemeControlPass', 'reEvaReportChangeoverSchemeYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportChangeoverSchemeUvYesNo', 'reEvaReportChangeoverSchemeUvPass', 'reEvaReportChangeoverSchemeYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportChangeoverSchemeSupplementYesNo', 'reEvaReportChangeoverSchemeSupplementPass', 'reEvaReportChangeoverSchemeYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportChillerPlantAhuChilledWaterYesNo', 'reEvaReportChillerPlantAhuChilledWaterPass', 'reEvaReportChillerPlantYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportChillerPlantChillerYesNo', 'reEvaReportChillerPlantChillerPass', 'reEvaReportChillerPlantYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportChillerPlantSupplementYesNo', 'reEvaReportChillerPlantSupplementPass', 'reEvaReportChillerPlantYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportEscalatorBrakingSystemYesNo', 'reEvaReportEscalatorBrakingSystemPass', 'reEvaReportEscalatorYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportEscalatorControlYesNo', 'reEvaReportEscalatorControlPass', 'reEvaReportEscalatorYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportEscalatorSupplementYesNo', 'reEvaReportEscalatorSupplementPass', 'reEvaReportEscalatorYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportLiftOperationYesNo', 'reEvaReportLiftOperationPass', 'reEvaReportLiftYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportLiftMainSupplyYesNo', 'reEvaReportLiftMainSupplyPass', 'reEvaReportLiftYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportLiftSupplementYesNo', 'reEvaReportLiftSupplementPass', 'reEvaReportLiftYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportHidLampBallastYesNo', 'reEvaReportHidLampBallastPass', 'reEvaReportHidLampYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportHidLampAddonProtectYesNo', 'reEvaReportHidLampAddonProtectPass', 'reEvaReportHidLampYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportHidLampSupplementYesNo', 'reEvaReportHidLampSupplementPass', 'reEvaReportHidLampYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportSensitiveMachineMedicalYesNo', 'reEvaReportSensitiveMachineMedicalPass', 'reEvaReportSensitiveMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportSensitiveMachineSupplementYesNo', 'reEvaReportSensitiveMachineSupplementPass', 'reEvaReportSensitiveMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportTelecomMachineServerOrComputerYesNo', 'reEvaReportTelecomMachineServerOrComputerPass', 'reEvaReportTelecomMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportTelecomMachinePeripheralsYesNo', 'reEvaReportTelecomMachinePeripheralsPass', 'reEvaReportTelecomMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportTelecomMachineHarmonicEmissionYesNo', 'reEvaReportTelecomMachineHarmonicEmissionPass', 'reEvaReportTelecomMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportTelecomMachineSupplementYesNo', 'reEvaReportTelecomMachineSupplementPass', 'reEvaReportTelecomMachineYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportAirConditionersMicbYesNo', 'reEvaReportAirConditionersMicbPass', 'reEvaReportAirConditionersYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportAirConditionersLoadForecastingYesNo', 'reEvaReportAirConditionersLoadForecastingPass', 'reEvaReportAirConditionersYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportAirConditionersTypeYesNo', 'reEvaReportAirConditionersTypePass', 'reEvaReportAirConditionersYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportAirConditionersSupplementYesNo', 'reEvaReportAirConditionersSupplementPass', 'reEvaReportAirConditionersYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportNonLinearLoadHarmonicEmissionYesNo', 'reEvaReportNonLinearLoadHarmonicEmissionPass', 'reEvaReportNonLinearLoadYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportNonLinearLoadSupplementYesNo', 'reEvaReportNonLinearLoadSupplementPass', 'reEvaReportNonLinearLoadYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportRenewableEnergyInverterAndControlsYesNo', 'reEvaReportRenewableEnergyInverterAndControlsPass', 'reEvaReportRenewableEnergyYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportRenewableEnergyHarmonicEmissionYesNo', 'reEvaReportRenewableEnergyHarmonicEmissionPass', 'reEvaReportRenewableEnergyYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportRenewableEnergySupplementYesNo', 'reEvaReportRenewableEnergySupplementPass', 'reEvaReportRenewableEnergyYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportEvChargerSystemEvChargerYesNo', 'reEvaReportEvChargerSystemEvChargerPass', 'reEvaReportEvChargerSystemYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportEvChargerSystemHarmonicEmissionYesNo', 'reEvaReportEvChargerSystemHarmonicEmissionPass', 'reEvaReportEvChargerSystemYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            result = calReportScore('reEvaReportEvChargerSystemSupplementYesNo', 'reEvaReportEvChargerSystemSupplementPass', 'reEvaReportEvChargerSystemYesNo', $(this).attr('name'));
            itemsCount = itemsCount + result[0];
            passCount = passCount + result[1];

            if (itemsCount > 0) {
                let score = (passCount / itemsCount * 100).toFixed(2);
                $("#reEvaReportScore").val(score);
            } else {
                $("#reEvaReportScore").val('NA');
            }
        }

        <?php } ?>

    });


    function validateDraftInput() {

        $("#detailForm input ").each(function(index, value) {
            $(this).removeClass("invalid");
        });

        $("#detailForm select ").each(function(index, value) {
            $(this).removeClass("invalid");
        });

        let errorMessage = "";
        let i = 1;

        let result = validateEmpty("#projectTitle", "Project Title", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#region", "Region", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#schemeNo", "Scheme No.", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#commissionDate", "Commission Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php if (($this->viewbag['state']=="WAITING_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="COMPLETED_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_MEETING_ACK") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#standLetterIssueDate", "Standard Letter", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_MEETING_ACK") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateAndTimeFormat("#meetingFirstPreferMeetingDate", "1st Preferred Meeting Date & Time", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateAndTimeFormat("#meetingSecondPreferMeetingDate", "2nd Preferred Meeting Date & Time", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateAndTimeFormat("#meetingActualMeetingDate", "Actual Meeting Date & Time", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#thirdInvitationLetterIssueDate", "3rd Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#thirdInvitationLetterWalkDate", "3rd Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#forthInvitationLetterIssueDate", "4th Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#forthInvitationLetterWalkDate", "4th Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#evaReportIssueDate", "Evaluation Report Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        if ($("#evaReportScore").val() == 'NA') {
            errorMessage = errorMessage + "Error " + i + ": At least one of the item must be checked for evaluation report<br/>";
            i = i + 1;
        }

        <?php } ?>

        <?php if (($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK")  ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#reEvaReportIssueDate", "Re-Site Walk Evaluation Report Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        if ($("#reEvaReportScore").val() == 'NA') {
            errorMessage = errorMessage + "Error " + i + ": At least one of the item must be checked for Re-Site Walk Evaluation Report<br/>";
            i = i + 1;
        }

        <?php } ?>

        if (errorMessage == "") {
            return true;
        } else {
            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
            return false;
        }
    }

    function validateProcessInput() {

        $("#detailForm input ").each(function(index, value) {
            $(this).removeClass("invalid");
        });

        $("#detailForm select ").each(function(index, value) {
            $(this).removeClass("invalid");
        });

        let errorMessage = "";
        let i = 1;

        let result = validateEmpty("#projectTitle", "Project Title", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#region", "Region", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#schemeNo", "Scheme No.", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#commissionDate", "Commission Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php
            if (isset(Yii::app()->session['tblUserDo']['roleId'])) { ?>

        result = validateSelected("#typeOfProject", "Type of Project", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateChecked("infraOpt", "Key Infrastructure", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateChecked("tempProjOpt", "Temp Project", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        <?php
            } else {?>

        //result = validateEmpty("#commissionDate", "Commission Date", errorMessage, i);
        //errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstRegionStaffName", "First Region Staff Name", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstRegionStaffPhone", "First Region Staff Contact No.", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstRegionStaffEmail", "First Region Staff Email", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateSelected("#firstConsultantTitle", "1st Consultant Title", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstConsultantSurname", "1st Consultant Surname", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstConsultantOtherName", "1st Consultant Other Name(s)", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstConsultantCompany", "1st Consultant Company", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstConsultantPhone", "1st Consultant Contact No.", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstConsultantEmail", "1st Consultant Email", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        <?php
            }?>

        <?php if (($this->viewbag['state']=="WAITING_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="COMPLETED_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateEmpty("#standLetterIssueDate", "Standard Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#standLetterFaxRefNo", "Standard Letter Fax Ref No.", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#standLetterEdmsLink", "Standard Letter EDMS link", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#standLetterIssueDate", "Standard Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];


        if (($("#standLetterLetterLoc").val() == null) || ($("#standLetterLetterLoc").val() == "")) {
            result = validateEmpty("#standSignedLetter", "Signed Standard Letter", errorMessage, i)
            errorMessage = result[0]; i = result[1];
        }

        <?php } ?>

        <?php if (($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_MEETING_ACK") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateEmpty("#meetingActualMeetingDate", "Actual Meeting Date & Time", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateAndTimeFormat("#meetingFirstPreferMeetingDate", "1st Preferred Meeting Date Time", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateAndTimeFormat("#meetingSecondPreferMeetingDate", "2nd Preferred Meeting Date Time", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateAndTimeFormat("#meetingActualMeetingDate", "Actual Meeting Date Time", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") { ?>

        result = validateEmpty("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstInvitationLetterFaxRefNo", "1st Invitation Letter Fax Reference No.", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstInvitationLetterEdmsLink", "1st Invitation Letter EDMS Link", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateChecked("firstInvitationLetterAccept", "1st Invitation Letter Acceptance", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") { ?>

        if ((($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() == null) ||
                ($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() == ""))) {

            result = validateEmpty("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterFaxRefNo", "2nd Invitation Letter Fax Reference No.", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterEdmsLink", "2nd Invitation Letter EDMS Link", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateChecked("secondInvitationLetterAccept", "2nd Invitation Letter Acceptance", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

        } else {
            result = validateEmpty("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterFaxRefNo", "1st Invitation Letter Fax Reference No.", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterEdmsLink", "1st Invitation Letter EDMS Link", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateChecked("firstInvitationLetterAccept", "1st Invitation Letter Acceptance", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];
        }

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        if ((($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() == null) ||
                ($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() == "")) &&
            (($('input[name=secondInvitationLetterAccept]:checked', '#detailForm').val() == null) ||
                ($('input[name=secondInvitationLetterAccept]:checked', '#detailForm').val() == ""))) {

            result = validateEmpty("#thirdInvitationLetterIssueDate", "3rd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#thirdInvitationLetterFaxRefNo", "3rd Invitation Letter Fax Reference No.", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#thirdInvitationLetterEdmsLink", "3rd Invitation Letter EDMS Link", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateChecked("thirdInvitationLetterAccept", "3rd Invitation Letter Acceptance", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#thirdInvitationLetterWalkDate", "3rd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#thirdInvitationLetterIssueDate", "3rd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#thirdInvitationLetterWalkDate", "3rd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

        } else if ((($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() != null) &&
                ($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() != ""))) {

            result = validateEmpty("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterFaxRefNo", "1st Invitation Letter Fax Reference No.", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterEdmsLink", "1st Invitation Letter EDMS Link", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateChecked("firstInvitationLetterAccept", "1st Invitation Letter Acceptance", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#thirdInvitationLetterIssueDate", "3rd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#thirdInvitationLetterWalkDate", "3rd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

        } else if ((($('input[name=secondInvitationLetterAccept]:checked', '#detailForm').val() != null) &&
            ($('input[name=secondInvitationLetterAccept]:checked', '#detailForm').val() != ""))) {

            result = validateEmpty("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterFaxRefNo", "2nd Invitation Letter Fax Reference No.", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterEdmsLink", "2nd Invitation Letter EDMS Link", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateChecked("secondInvitationLetterAccept", "2nd Invitation Letter Acceptance", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateEmpty("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#thirdInvitationLetterIssueDate", "3rd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#thirdInvitationLetterWalkDate", "3rd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

            result = validateDateOnlyFormat("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
            errorMessage = result[0]; i = result[1];

        }
        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER")  ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
        result = validateEmpty("#forthInvitationLetterIssueDate", "4th Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#forthInvitationLetterFaxRefNo", "4th Invitation Letter Fax Reference No.", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#forthInvitationLetterEdmsLink", "4th Invitation Letter EDMS Link", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateChecked("forthInvitationLetterAccept", "4th Invitation Letter Acceptance", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#forthInvitationLetterWalkDate", "4th Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#forthInvitationLetterIssueDate", "4th Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#forthInvitationLetterWalkDate", "4th Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];
        <?php } ?>

        <?php if (($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                    ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#evaReportIssueDate", "Evaluation Report Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#evaReportIssueDate", "Evaluation Report Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#evaReportFaxRefNo", "Evaluation Report Fax Reference Number", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        if ($("#evaReportScore").val() == 'NA') {
            errorMessage = errorMessage + "Error " + i + ": At least one of the item must be checked for evaluation report<br/>";
            i = i + 1;
        }

        <?php } ?>

        <?php if (($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                    ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>

        result = validateDateOnlyFormat("#reEvaReportIssueDate", "Re-Site Walk Evaluation Report Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#reEvaReportIssueDate", "Re-Site Walk Evaluation Report Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#reEvaReportFaxRefNo", "Re-Site Walk Evaluation Report Fax Reference Number", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        if ($("#reEvaReportScore").val() == 'NA') {
            errorMessage = errorMessage + "Error " + i + ": At least one of the item must be checked for Re-Site Walk evaluation report<br/>";
            i = i + 1;
        }

        <?php } ?>

        if ((errorMessage === "") || $('input[name="activeOpt"]:checked','#detailForm').val() == 'N') {
            return true;
        } else {
            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
            return false;
        }
    }

    <?php if (($this->viewbag['state']=="WAITING_STANDARD_LETTER") ||
                ($this->viewbag['state']=="COMPLETED_STANDARD_LETTER") ||
                ($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                ($this->viewbag['state']=="SENT_MEETING_ACK") ||
                ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                ($this->viewbag['state']=="WAITING_PQ_SITE_WALK") ||
                ($this->viewbag['state']=="NOTIFIED_PQ_SITE_WALK") ||
                ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                ($this->viewbag['state']=="COMPLETED_PQ_SITE_WALK_FAIL") ||
                ($this->viewbag['state']=="SENT_FORTH_INVITATION_LETTER") ||
                ($this->viewbag['state']=="WAITING_RE_PQ_SITE_WALK") ||
                ($this->viewbag['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                ($this->viewbag['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) { ?>
    function updateGenStandLetterButton() {
        let standLetterIssueDate = document.querySelector("#standLetterIssueDate");
        let standLetterFaxRefNo = document.querySelector("#standLetterFaxRefNo");
        let genStandLetterBtn = document.querySelector("#genStandLetterBtn");

        if ((standLetterIssueDate.value == null) || (standLetterFaxRefNo.value == null) ||
            (standLetterIssueDate.value.trim() == "") || (standLetterFaxRefNo.value.trim() == "")) {
            genStandLetterBtn.disabled = true;
        } else {
            genStandLetterBtn.disabled = false;
        }
    }
    <?php } ?>

    function cardSelected(icon) {
        let imgIcon = document.querySelector("#"+icon);
        if (imgIcon.style.transform == 'rotate(180deg)') {
            document.querySelector("#"+icon).style.transform = 'rotate(0deg)';
        } else {
            document.querySelector("#"+icon).style.transform = 'rotate(180deg)';
        }
    }

    function validateDateFormat(txtDate) {
        let regFormat = '[0-9]{4}[-][0-9]{1,2}[-][0-9]{1,2}';
        return txtDate.match(regFormat);
    }

    function validateDateTimeFormat(txtDate) {

        let regFormat = '[0-9]{4}[-][0-9]{1,2}[-][0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}';
        return txtDate.match(regFormat);
    }

    function validateDateOnlyFormat(id, name, errorMsg, i) {
        if (($(id).val() != null) && ($(id).val().trim() != "")) {
            let inputDate = $(id).val();
            if (!inputDate.match('[0-9]{4}[-][0-9]{1,2}[-][0-9]{1,2}')) {
                if (errorMsg == "")
                    $(id).focus();
                errorMsg = errorMsg + "Error " + i + ": " +  name + " format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $(id).addClass("invalid");
            }
        }
        return [errorMsg, i];
    }

    function validateDateAndTimeFormat(id, name, errorMsg, i) {
        if (($(id).val() != null) && ($(id).val().trim() != "")) {
            let inputDate = $(id).val();
            if (!inputDate.match('[0-9]{4}[-][0-9]{1,2}[-][0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}')) {
                if (errorMsg == "")
                    $(id).focus();
                errorMsg = errorMsg + "Error " + i + ": " +  name + " format is not match. It should be [YYYY-mm-dd HH:mi] <br/>";
                i = i + 1;
                $(id).addClass("invalid");
            }
        }
        return [errorMsg, i];
    }

    function validateEmpty(id, name, errorMsg, i) {
        if (($(id).val() == null) || ($(id).val().trim() == "")) {
            if (errorMsg == "")
                $(id).focus();
            errorMsg = errorMsg + "Error " + i + ": " + name + " can not be blank <br/>";
            i = i + 1;
            $(id).addClass("invalid");
        }
        return [errorMsg, i];
    }

    function validateSelected(id, name, errorMsg, i) {

        if (($(id).val() == null) || ($(id).val().trim() == "")) {
            if (errorMsg == "")
                $(id).focus();
            errorMsg = errorMsg + "Error " + i + ": " + name + " must be selected <br/>";
            i = i + 1;
            $(id).addClass("invalid");
        }
        return [errorMsg, i];
    }

    function validateChecked(id, name, errorMsg, i) {

        if (($('input[name=' + id + ']:checked', '#detailForm').val() == null) ||
            ($('input[name=' + id + ']:checked', '#detailForm').val() == "")) {
            errorMsg = errorMsg + "Error " + i + ": " + name + " must be checked <br/>";
            i = i + 1;
        }
        return [errorMsg, i];
    }

    function validateUploaded(id, name, errorMsg, i) {

        if (($(id).val() == null) || ($(id).val().trim() == "")) {
            if ($(id).get(0).files.length == 0) {
                if (errorMsg == "")
                    $(id).focus();
                errorMsg = errorMsg + "Error " + i + ": " + name + " should be uploaded <br/>";
                i = i + 1;
                $(id).addClass("invalid");
            }
        }
        return [errorMsg, i];
    }

    function calReportScore(yesNoId,passId,parentId,actionId) {
        
        if (passId == actionId) {
            if (!($('input[name=' + passId + ']:checked', '#detailForm').val() == null) &&
                !($('input[name=' + passId + ']:checked', '#detailForm').val() == "")) {
                $('#' + parentId).prop('checked', true);
                $('#' + yesNoId).prop('checked', true);
            }
        }

        if (yesNoId == actionId) {
            if (!($('input[name=' + yesNoId + ']:checked', '#detailForm').val() == null) &&
                !($('input[name=' + yesNoId + ']:checked', '#detailForm').val() == "")) {
                $('#' + parentId).prop('checked', true);
            } else {
                $('#' + passId).prop('checked', false);
            }
        }

        if (!($('input[name=' + passId + ']:checked', '#detailForm').val() == null) &&
            !($('input[name=' + passId + ']:checked', '#detailForm').val() == "")) {
            return [1.0,1.0];
        }
        if (!($('input[name=' + yesNoId + ']:checked', '#detailForm').val() == null) &&
            !($('input[name=' + yesNoId + ']:checked', '#detailForm').val() == "")) {
            return [1.0,0.0];
        } else {
            return [0.0,0.0];
        }
    }

</script>



