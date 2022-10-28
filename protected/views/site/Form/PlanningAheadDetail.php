<?php
    /* @var $this FirstFormController */
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
                <div class="input-group-prepend">
                    <span class="input-group-text">Project Title: </span>
                </div>
                <input id="projectTitle" name="projectTitle" type="text"
                       class="form-control"
                       oninvalid="this.setCustomValidity('Project Title is required!')"
                       oninput="this.setCustomValidity('')"
                       autocomplete="off">
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-6">
                <div class="input-group-prepend">
                    <span class="input-group-text">Scheme No.: </span>
                </div>
                <input id="schemeNo" name="schemeNo" type="text"
                       class="form-control"
                       autocomplete="off">
            </div>
            <div class="input-group col-6">
                <div class="input-group-prepend">
                    <span class="input-group-text">Project Region: </span>
                </div>
                <select id="region" name="region" class="form-control">
                    <?php foreach($this->viewbag['regionList'] as $regionList){
                        if ($regionList['regionId'] == $this->viewbag['regionId']) {?>
                            <option value="<?php echo $regionList['regionId']?>" selected>
                                <?php echo $regionList['regionShortName']?>
                            </option>
                        <?php } else { ?>
                            <option value="<?php echo $regionList['regionId']?>">
                                <?php echo $regionList['regionShortName']?>
                            </option>
                    <?php
                        }
                    } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-6">
                <div class="input-group-prepend">
                    <span class="input-group-text">Type of Project: </span>
                </div>
                <select id="typeOfProject" name="typeOfProject" class="form-control">
                    <option value="0" selected disabled>------</option>
                    <?php foreach($this->viewbag['projectTypeList'] as $projectTypeList){
                        if ($projectTypeList['projectTypeId'] == $this->viewbag['projectTypeId']) {?>
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
            <div class="input-group col-6">
                <div class="input-group-prepend">
                    <span class="input-group-text">Planned Commission Date: </span>
                </div>
                <input id="commissionDate" name="commissionDate" type="text" placeholder="YYYY-mm-dd"
                       class="form-control" autocomplete="off">
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-12">
                <div class="input-group-prepend">
                    <span class="input-group-text">Key Infrastructure: </span>
                </div>
                <?php if ($this->viewbag['keyInfra'] == 'Y') { ?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="Y" checked>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="N">No
                        </label>
                    </div>
                <?php } else if ($this->viewbag['keyInfra'] == 'N') {?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="Y">Yes
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
                            <input type="radio" name="infraOpt" class="form-check-input" value="Y">Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="infraOpt" class="form-check-input" value="N">No
                        </label>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="form-group row">
            <div class="input-group col-12">
                <div class="input-group-prepend">
                    <span class="input-group-text">Temp Project: </span>
                </div>
                <?php if ($this->viewbag['tempProject'] == 'Y') { ?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="Y" checked>Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="N">No
                        </label>
                    </div>
                <?php } else if ($this->viewbag['tempProject'] == 'N') {?>
                    <div class="form-check-inline pl-4">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="Y">Yes
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
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="Y">Yes
                        </label>
                    </div>
                    <div class="form-check-inline pl-2">
                        <label class="form-check-label">
                            <input type="radio" name="tempProjOpt" class="form-check-input" value="N">No
                        </label>
                    </div>
                <?php }?>
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
                <div class="card-header" style="background-color: #6f42c1">
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
                                        <option value="0" selected disabled>--- Title ---</option>
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

                                    <input id="firstConsultantSurname" name="firstConsultantSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname">
                                    <input id="firstConsultantOtherName" name="firstConsultantOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s)">
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
                <div class="card-header" style="background-color: #6f42c1">
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
                                        <option value="0" selected disabled>--- Title ---</option>
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

                                    <input id="secondConsultantSurname" name="secondConsultantSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname">
                                    <input id="secondConsultantOtherName" name="secondConsultantOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s)">
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
                <div class="card-header" style="background-color: #6f42c1">
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
                                        <option value="0" selected disabled>--- Title ---</option>
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

                                    <input id="thirdConsultantSurname" name="thirdConsultantSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname">
                                    <input id="thirdConsultantOtherName" name="thirdConsultantOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s)">
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
                <div class="card-header" style="background-color: #6f42c1">
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
                                        <option value="0" selected disabled>--- Title ---</option>
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

                                    <input id="firstProjectOwnerSurname" name="firstProjectOwnerSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname">
                                    <input id="firstProjectOwnerOtherName" name="firstProjectOwnerOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s)">
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
                <div class="card-header" style="background-color: #6f42c1">
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
                                        <option value="0" selected disabled>--- Title ---</option>
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

                                    <input id="secondProjectOwnerSurname" name="secondProjectOwnerSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname">
                                    <input id="secondProjectOwnerOtherName" name="secondProjectOwnerOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s)">
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
                <div class="card-header" style="background-color: #6f42c1">
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
                                        <option value="0" selected disabled>--- Title ---</option>
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

                                    <input id="thirdProjectOwnerSurname" name="thirdProjectOwnerSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname">
                                    <input id="thirdProjectOwnerOtherName" name="thirdProjectOwnerOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s)">
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
            ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>
        <div id="accordionDetailofPQStandardLetter">
            <div class="card">
                <div class="card-header" style="background-color: #6f42c1">
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

        <?php if (($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
            ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
            ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
            ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>
        <div id="accordionDetailofMeeting">
            <div class="card">
                <div class="card-header" style="background-color: #6f42c1">
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
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Actual Meeting Date & Time:</span>
                                    </div>
                                    <input id="meetingActualMeetingDate" name="meetingActualMeetingDate" type="text"
                                           placeholder="YYYY-mm-dd hh:mi" class="form-control" autocomplete="off">
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
                <div class="card-header" style="background-color: #e88d34">
                    <a class="card-link" data-toggle="collapse" href="#detailofReplySlip" onclick="cardSelected('detailofReplySlipIcon');">
                        <div class="row">
                            <div class="col-8"><h5 class="text-light pt-2">Reply Slip Detail</h5></div>
                            <div class="col-3">
                                <input class="btn btn-warning form-control" type="button" name="genReplySlipDetail"
                                       id="genReplySlipDetailBtn" value="Generate Reply Slip (PDF)">
                            </div>
                            <div class="col-1 pt-2">
                                <img id="detailofReplySlipIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png"
                                     width="20px" style="transform: rotate(180deg);"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="detailofReplySlip" class="collapse show" data-parent="#accordionDetailofReplySlip">
                    <div class="card-body">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th style="width: 10%">&nbsp;</th>
                                    <th style="width: 30%">Equipment</th>
                                    <th style="width: 20%">Component</th>
                                    <th style="width: 40%">Actual Design Approach</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['replySlipBmsYesNo'] == 'Y') { ?>
                                        <input id="replySlipBmsYesNo" name="replySlipBmsYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                            <input id="replySlipBmsYesNo" name="replySlipBmsYesNo" type="checkbox"
                                                   class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">BMS</td>
                                    <td class="pt-3">Server or Central Computer</td>
                                    <td>
                                        <input id="replySlipBmsServerCentralComputer" name="replySlipBmsServerCentralComputer"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Distributed digitial control (DDC)</td>
                                    <td>
                                        <input id="replySlipBmsDdc" name="replySlipBmsDdc"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
                                        <?php if ($this->viewbag['replySlipChangeoverSchemeYesNo'] == 'Y') { ?>
                                        <input id="replySlipChangeoverSchemeYesNo" name="replySlipChangeoverSchemeYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px" checked>
                                        <?php } else { ?>
                                        <input id="replySlipChangeoverSchemeYesNo" name="replySlipChangeoverSchemeYesNo" type="checkbox"
                                               class="form-control" value="Y" style="width:25px; height: 25px">
                                        <?php } ?>
                                    </td>
                                    <td class="pt-3">Changeover Scheme</td>
                                    <td class="pt-3">Controls, relays, main contractor</td>
                                    <td>
                                        <input id="replySlipChangeoverSchemeControl" name="replySlipChangeoverSchemeControl"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Under-voltage (UV) relay</td>
                                    <td>
                                        <input id="replySlipChangeoverSchemeUv" name="replySlipChangeoverSchemeUv"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
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
                                    <td class="pt-3">Chiller Plant</td>
                                    <td class="pt-3">AHU, chiller water pump</td>
                                    <td>
                                        <input id="replySlipChillerPlantAhu" name="replySlipChillerPlantAhu"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Chiller</td>
                                    <td>
                                        <input id="replySlipChillerPlantChiller" name="replySlipChillerPlantChiller"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
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
                                    <td class="pt-3">Escalator</td>
                                    <td class="pt-3">Baking System</td>
                                    <td>
                                        <input id="replySlipEscalatorBrakingSystem" name="replySlipEscalatorBrakingSystem"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Controls</td>
                                    <td>
                                        <input id="replySlipEscalatorControl" name="replySlipEscalatorControl"
                                               type="text" class="form-control">
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
                                    <td class="pt-3">Ballast</td>
                                    <td>
                                        <input id="replySlipHidLampBallast" name="replySlipHidLampBallast"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Add-on protection</td>
                                    <td>
                                        <input id="replySlipHidLampAddOnProtection" name="replySlipHidLampAddOnProtection"
                                               type="text" class="form-control">
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
                                    <td class="pt-3">Control (Operation)</td>
                                    <td>
                                        <input id="replySlipLiftOperation" name="replySlipLiftOperation"
                                               type="text" class="form-control">
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
                                        <input id="replySlipSensitiveMachineMitigation"
                                               name="replySlipSensitiveMachineMitigation"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
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
                                    <td class="pt-3">Telecom, IT Equipment, Data Centre & Harmonic</td>
                                    <td class="pt-3">Server or computer</td>
                                    <td>
                                        <input id="replySlipTelecomMachineServerOrComputer"
                                               name="replySlipTelecomMachineServerOrComputer"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Peripherals such as modem, router</td>
                                    <td>
                                        <input id="replySlipTelecomMachinePeripherals"
                                               name="replySlipTelecomMachinePeripherals"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <input id="replySlipTelecomMachineHarmonicEmission"
                                               name="replySlipTelecomMachineHarmonicEmission"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
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
                                    <td class="pt-3">Air-conditioners & ACB at Residential Building</td>
                                    <td class="pt-3">Protection facilities of Main Incoming Circuit Breaker</td>
                                    <td>
                                        <input id="replySlipAirConditionersMicb"
                                               name="replySlipAirConditionersMicb"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Load forecasting for air-conditioning load</td>
                                    <td>
                                        <input id="replySlipAirConditionersLoadForecasting"
                                               name="replySlipAirConditionersLoadForecasting"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Type of Air-conditioner</td>
                                    <td>
                                        <input id="replySlipAirConditionersType"
                                               name="replySlipAirConditionersType"
                                               type="text" class="form-control">
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
                                        <input id="replySlipNonLinearLoadHarmonicEmission"
                                               name="replySlipNonLinearLoadHarmonicEmission"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
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
                                    <td class="pt-3">Renewable Energy, e.g. photovoltaic or wind energy system etc.</td>
                                    <td class="pt-3">Inventer, controls</td>
                                    <td>
                                        <input id="replySlipRenewableEnergyInverterAndControls"
                                               name="replySlipRenewableEnergyInverterAndControls"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <input id="replySlipRenewableEnergyHarmonicEmission"
                                               name="replySlipRenewableEnergyHarmonicEmission"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">
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
                                    <td class="pt-3">EV charger system</td>
                                    <td class="pt-3">EV charger</td>
                                    <td>
                                        <input id="replySlipEvChargerSystemEvCharger"
                                               name="replySlipEvChargerSystemEvCharger"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Smart charging system (e.g. load management system)</td>
                                    <td>
                                        <input id="replySlipEvChargerSystemSmartChargingSystem"
                                               name="replySlipEvChargerSystemSmartChargingSystem"
                                               type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">&nbsp;</td>
                                    <td class="pt-3">Harmonic emission</td>
                                    <td>
                                        <input id="replySlipEvChargerSystemHarmonicEmission"
                                               name="replySlipEvChargerSystemHarmonicEmission"
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
            ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>
            <div id="accordionDetailofFirstInvitation">
                <div class="card">
                    <div class="card-header" style="background-color: #6f42c1">
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
            (($this->viewbag['state']=="WAITING_PQ_SITE_WALK") && ($this->viewbag['secondInvitationLetterIssueDate']!=""))) { ?>
            <div id="accordionDetailofSecondInvitation">
                <div class="card">
                    <div class="card-header" style="background-color: #6f42c1">
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
                    (($this->viewbag['state']=="WAITING_PQ_SITE_WALK") && ($this->viewbag['thirdInvitationLetterIssueDate']!=""))) { ?>
            <div id="accordionDetailofThirdInvitation">
                <div class="card">
                    <div class="card-header" style="background-color: #6f42c1">
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

        <div class="form-group row px-3 pt-2">
            <div>
                <input class="btn btn-primary" type="submit" name="saveDraftBtn" id="saveDraftBtn" value="Save as Draft">
                <input class="btn btn-primary" type="submit" name="saveProcessBtn" id="saveProcessBtn" value="Save & Process">
            </div>
        </div>

        <input type="hidden" id="planningAheadId" name="planningAheadId" value="<?php echo $this->viewbag['planningAheadId']; ?>">
        <input type="hidden" id="standLetterLetterLoc" name="standLetterLetterLoc" value="<?php echo $this->viewbag['standLetterLetterLoc']; ?>">
        <input type="hidden" id="meetingReplySlipId" name="meetingReplySlipId" value="<?php echo $this->viewbag['meetingReplySlipId']; ?>">
        <input type="hidden" id="state" name="state" value="<?php echo $this->viewbag['state']; ?>">
        <input type="hidden" id="roleId" name="roleId" value="<?php echo Yii::app()->session['tblUserDo']['roleId']; ?>">

    </form>

</div>

<!-- Script for processing the data -->
<script>
    $(document).ready(function(){

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

        $("#detailForm").on("submit", function(e) {

            e.preventDefault();

            if ($(this).find("input[type=submit]:focus" ).val() == 'Save as Draft') {

                if (!validateDraftInput()) {
                    return;
                }

                $("#loading-modal").modal("show");
                $("#saveDraftBtn").attr("disabled", true);
                $("#saveProcessBtn").attr("disabled", true);

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
                });
            } else if ($(this).find("input[type=submit]:focus" ).val() == 'Save & Process') {

                if (!validateProcessInput()) {
                    return;
                }

                $("#loading-modal").modal("show");
                $("#saveDraftBtn").attr("disabled", true);
                $("#saveProcessBtn").attr("disabled", true);

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
                });
            }
        });

        <?php if (($this->viewbag['state']=="WAITING_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="COMPLETED_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>
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
                "&schemeNo=" + $("#schemeNo").val();
            $(this).attr("disabled", false);
        });
        <?php } ?>

        <?php if (($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>
        $('#replySlipBmsServerCentralComputer').val("<?php echo $this->viewbag['replySlipBmsServerCentralComputer']; ?>");
        $('#replySlipBmsDdc').val("<?php echo $this->viewbag['replySlipBmsDdc']; ?>");
        $('#replySlipChangeoverSchemeControl').val("<?php echo $this->viewbag['replySlipChangeoverSchemeControl']; ?>");
        $('#replySlipChangeoverSchemeUv').val("<?php echo $this->viewbag['replySlipChangeoverSchemeUv']; ?>");
        $('#replySlipChillerPlantAhu').val("<?php echo $this->viewbag['replySlipChillerPlantAhu']; ?>");
        $('#replySlipChillerPlantChiller').val("<?php echo $this->viewbag['replySlipChillerPlantChiller']; ?>");
        $('#replySlipEscalatorBrakingSystem').val("<?php echo $this->viewbag['replySlipEscalatorBrakingSystem']; ?>");
        $('#replySlipEscalatorControl').val("<?php echo $this->viewbag['replySlipEscalatorControl']; ?>");
        $('#replySlipHidLampBallast').val("<?php echo $this->viewbag['replySlipHidLampBallast']; ?>");
        $('#replySlipHidLampAddOnProtection').val("<?php echo $this->viewbag['replySlipHidLampAddOnProtection']; ?>");
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

        $("#showReplySlipDetailBtn").on("click", function() {
            if ($('#showReplySlipDetailBtn').val() == 'Show Reply Slip Detail') {
                $('#accordionDetailofReplySlip').css ("display", "block");
                $('#showReplySlipDetailBtn').val('Hide Reply Slip Detail');
            } else {
                $('#accordionDetailofReplySlip').css ("display", "none");
                $('#showReplySlipDetailBtn').val('Show Reply Slip Detail');
            }
        });
        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>
        $('#firstInvitationLetterIssueDate').val("<?php echo $this->viewbag['firstInvitationLetterIssueDate']; ?>");
        $('#firstInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['firstInvitationLetterFaxRefNo']; ?>");
        $('#firstInvitationLetterEdmsLink').val("<?php echo $this->viewbag['firstInvitationLetterEdmsLink']; ?>");
        $('#firstInvitationLetterWalkDate').val("<?php echo $this->viewbag['firstInvitationLetterWalkDate']; ?>");

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
                    (($this->viewbag['state']=="WAITING_PQ_SITE_WALK") && ($this->viewbag['secondInvitationLetterIssueDate']!=""))) { ?>
        $('#secondInvitationLetterIssueDate').val("<?php echo $this->viewbag['secondInvitationLetterIssueDate']; ?>");
        $('#secondInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['secondInvitationLetterFaxRefNo']; ?>");
        $('#secondInvitationLetterEdmsLink').val("<?php echo $this->viewbag['secondInvitationLetterEdmsLink']; ?>");
        $('#secondInvitationLetterWalkDate').val("<?php echo $this->viewbag['secondInvitationLetterWalkDate']; ?>");

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
                    (($this->viewbag['state']=="WAITING_PQ_SITE_WALK") && ($this->viewbag['thirdInvitationLetterIssueDate']!=""))) { ?>
        $('#thirdInvitationLetterIssueDate').val("<?php echo $this->viewbag['thirdInvitationLetterIssueDate']; ?>");
        $('#thirdInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['thirdInvitationLetterFaxRefNo']; ?>");
        $('#thirdInvitationLetterEdmsLink').val("<?php echo $this->viewbag['thirdInvitationLetterEdmsLink']; ?>");
        $('#thirdInvitationLetterWalkDate').val("<?php echo $this->viewbag['thirdInvitationLetterWalkDate']; ?>");

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
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>

        result = validateDateOnlyFormat("#standLetterIssueDate", "Standard Letter", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>

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
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>

        result = validateDateOnlyFormat("#firstInvitationLetterIssueDate", "1st Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#firstInvitationLetterWalkDate", "1st Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    (($this->viewbag['state']=="WAITING_PQ_SITE_WALK") && ($this->viewbag['secondInvitationLetterIssueDate']!=""))) { ?>

        result = validateDateOnlyFormat("#secondInvitationLetterIssueDate", "2nd Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#secondInvitationLetterWalkDate", "2nd Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    (($this->viewbag['state']=="WAITING_PQ_SITE_WALK") && ($this->viewbag['thirdInvitationLetterIssueDate']!=""))) { ?>

        result = validateDateOnlyFormat("#thirdInvitationLetterIssueDate", "3rd Invitation Letter Issue Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

        result = validateDateOnlyFormat("#thirdInvitationLetterWalkDate", "3rd Invitation Letter PQ Walk Date", errorMessage, i)
        errorMessage = result[0]; i = result[1];

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
            if(Yii::app()->session['tblUserDo']['roleId'] == 2) { ?>

        result = validateSelected("#typeOfProject", "Type of Project", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateChecked("infraOpt", "Key Infrastructure", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateChecked("tempProjOpt", "Temp Project", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        <?php
            } else if(Yii::app()->session['tblUserDo']['roleId'] == 3) {?>

        result = validateEmpty("#commissionDate", "Commission Date", errorMessage, i);
        errorMessage = result[0]; i = result[1];

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

        result = validateSelected("#firstProjectOwnerTitle", "1st Project Owner Title", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstProjectOwnerSurname", "1st Project Owner Surname", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstProjectOwnerOtherName", "1st Project Owner Other Name", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstProjectOwnerCompany", "1st Project Owner Company", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstProjectOwnerPhone", "1st Project Owner Phone", errorMessage, i);
        errorMessage = result[0]; i = result[1];

        result = validateEmpty("#firstProjectOwnerEmail", "1st Project Owner Email", errorMessage, i);
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
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>

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

        <?php if (($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_ACTUAL_MEETING_DATE") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="WAITING_PQ_SITE_WALK")) { ?>

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

        <?php if ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER") { ?>
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

        } else if ((($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() != null) ||
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

        } else if ((($('input[name=secondInvitationLetterAccept]:checked', '#detailForm').val() != null) ||
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

        if (errorMessage === "") {
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
                ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
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

</script>



