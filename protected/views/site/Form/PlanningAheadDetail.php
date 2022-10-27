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
                                    <select id="firstConsultantCompany" name="firstConsultantCompany" class="form-control">
                                        <option value="0" selected disabled>------</option>
                                        <?php $matchFirstConsulantCompany=false ?>
                                        <?php foreach ($this->viewbag['consultantCompanyList'] as $item) {
                                            if ($this->viewbag['firstConsultantCompanyId'] == $item['consultantCompanyId']) {
                                                $matchFirstConsulantCompany=true;?>
                                                <option value="<?php echo $item['consultantCompanyId']; ?>" selected><?php echo $item['consultantCompanyName']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $item['consultantCompanyId']; ?>"><?php echo $item['consultantCompanyName']; ?></option>
                                        <?php
                                            }
                                        }

                                        if (isset($this->viewbag['firstConsultantCompanyId']) && (!$matchFirstConsulantCompany)) {
                                        ?>
                                            <option value="<?php echo $this->viewbag['firstConsultantCompanyId'] ?>"><?php echo $this->viewbag['firstConsultantCompanyName'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
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
                                    <select id="secondConsultantCompany" name="secondConsultantCompany" class="form-control">
                                        <option value="0" selected disabled>------</option>
                                        <?php $matchSecondConsulantCompany=false ?>
                                        <?php foreach ($this->viewbag['consultantCompanyList'] as $item) {
                                            if ($this->viewbag['secondConsultantCompanyId'] == $item['consultantCompanyId']) {
                                                $matchSecondConsulantCompany=true;?>
                                                <option value="<?php echo $item['consultantCompanyId']; ?>" selected><?php echo $item['consultantCompanyName']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $item['consultantCompanyId']; ?>"><?php echo $item['consultantCompanyName']; ?></option>
                                                <?php
                                            }
                                        }

                                        if (isset($this->viewbag['secondConsultantCompanyId']) && (!$matchSecondConsulantCompany)) {
                                            ?>
                                            <option value="<?php echo $this->viewbag['secondConsultantCompanyId'] ?>"><?php echo $this->viewbag['secondConsultantCompanyName'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
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

        <div id="accordionContactOfProjectOwner">
            <div class="card">
                <div class="card-header" style="background-color: #6f42c1">
                    <a class="card-link" data-toggle="collapse" href="#contactOfProjectOwner" onclick="cardSelected('contactOfProjectOwnerIcon');">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">Contact of Project Owner</h5></div>
                            <div class="col-1">
                                <img id="contactOfProjectOwnerIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="contactOfProjectOwner" class="collapse" data-parent="#accordionContactOfProjectOwner">
                    <div class="card-body">
                        <div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name: </span>
                                    </div>
                                    <select id="projectOwnerTitle" name="projectOwnerTitle" class="form-control">
                                        <option value="0" selected disabled>--- Title ---</option>
                                        <?php if ($this->viewbag['projectOwnerTitle'] == "Mr.") { ?>
                                            <option value="Mr." selected>Mr.</option>
                                        <?php } else { ?>
                                            <option value="Mr.">Mr.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['projectOwnerTitle'] == "Mrs.") { ?>
                                            <option value="Mrs." selected>Mrs.</option>
                                        <?php } else { ?>
                                            <option value="Mrs.">Mrs.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['projectOwnerTitle'] == "Ms.") { ?>
                                            <option value="Ms." selected>Ms.</option>
                                        <?php } else { ?>
                                            <option value="Ms.">Ms.</option>
                                        <?php } ?>
                                        <?php if ($this->viewbag['projectOwnerTitle'] == "Miss") { ?>
                                            <option value="Miss" selected>Miss</option>
                                        <?php } else { ?>
                                            <option value="Miss">Miss</option>
                                        <?php } ?>
                                    </select>

                                    <input id="projectOwnerSurname" name="projectOwnerSurname" type="text"
                                           class="form-control" autocomplete="off" placeholder="Surname">
                                    <input id="projectOwnerOtherName" name="projectOwnerOtherName" type="text"
                                           class="form-control" autocomplete="off" placeholder="Other Name(s)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Company: </span>
                                    </div>
                                    <input id="projectOwnerCompany" name="projectOwnerCompany" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="projectOwnerPhone" name="projectOwnerPhone" type="text"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="projectOwnerEmail" name="projectOwnerEmail" type="text"
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
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
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
            ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
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
                                <input class="btn btn-primary form-control" type="button" name="genReplySlipDetail"
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
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
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
            ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
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

        <?php if (($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
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
        $("#firstConsultantPhone").val("<?php echo $this->viewbag['firstConsultantPhone']; ?>");
        $("#firstConsultantEmail").val("<?php echo $this->viewbag['firstConsultantEmail']; ?>");
        $("#secondConsultantSurname").val("<?php echo $this->viewbag['secondConsultantSurname']; ?>");
        $("#secondConsultantOtherName").val("<?php echo $this->viewbag['secondConsultantOtherName']; ?>");
        $("#secondConsultantPhone").val("<?php echo $this->viewbag['secondConsultantPhone']; ?>");
        $("#secondConsultantEmail").val("<?php echo $this->viewbag['secondConsultantEmail']; ?>");
        $("#projectOwnerSurname").val("<?php echo $this->viewbag['projectOwnerSurname']; ?>");
        $("#projectOwnerOtherName").val("<?php echo $this->viewbag['projectOwnerOtherName']; ?>");
        $("#projectOwnerCompany").val("<?php echo $this->viewbag['projectOwnerCompany']; ?>");
        $("#projectOwnerPhone").val("<?php echo $this->viewbag['projectOwnerPhone']; ?>");
        $("#projectOwnerEmail").val("<?php echo $this->viewbag['projectOwnerEmail']; ?>");
        $("#standLetterIssueDate").val("<?php echo $this->viewbag['standLetterIssueDate']; ?>");
        $("#standLetterFaxRefNo").val("<?php echo $this->viewbag['standLetterFaxRefNo']; ?>");
        $("#standLetterEdmsLink").val("<?php echo $this->viewbag['standLetterEdmsLink']; ?>");
        $("#meetingFirstPreferMeetingDate").val("<?php echo $this->viewbag['meetingFirstPreferMeetingDate']; ?>");
        $("#meetingSecondPreferMeetingDate").val("<?php echo $this->viewbag['meetingSecondPreferMeetingDate']; ?>");
        $("#meetingActualMeetingDate").val("<?php echo $this->viewbag['meetingActualMeetingDate']; ?>");
        $("#meetingRejReason").val("<?php echo $this->viewbag['meetingRejReason']; ?>");

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
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
        $("#genStandLetterBtn").on("click", function() {

            let errorMessage = "";
            let i = 1;

            if (($("#standLetterIssueDate").val() == null) || ($("#standLetterIssueDate").val().trim() == "")) {
                if (errorMessage == "")
                    $("#standLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Standard Letter Issue Date can not be blank <br/>";
                i = i + 1;
                $("#standLetterIssueDate").addClass("invalid");
            }

            if (($("#standLetterFaxRefNo").val() == null) || ($("#standLetterFaxRefNo").val().trim() == "")) {
                if (errorMessage == "")
                    $("#standLetterFaxRefNo").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Standard Letter Fax Ref No. can not be blank <br/>";
                i = i + 1;
                $("#standLetterFaxRefNo").addClass("invalid");
            }

            if (($("#standLetterIssueDate").val() != null) && ($("#standLetterIssueDate").val().trim() != "")) {
                let standLetterIssueDate = $("#standLetterIssueDate").val();
                if (!validateDateFormat(standLetterIssueDate)) {
                    if (errorMessage == "")
                        $("#standLetterIssueDate").focus();
                    errorMessage = errorMessage + "Error " + i + ": " + "Standard Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                    i = i + 1;
                    $("#standLetterIssueDate").addClass("invalid");
                }
            }

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
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
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
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
        $('#firstInvitationLetterIssueDate').val("<?php echo $this->viewbag['firstInvitationLetterIssueDate']; ?>");
        $('#firstInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['firstInvitationLetterFaxRefNo']; ?>");
        $('#firstInvitationLetterEdmsLink').val("<?php echo $this->viewbag['firstInvitationLetterEdmsLink']; ?>");
        $('#firstInvitationLetterWalkDate').val("<?php echo $this->viewbag['firstInvitationLetterWalkDate']; ?>");

        $("#genFirstInvitationLetterBtn").on("click", function() {
            let errorMessage = "";
            let i = 1;

            if (($("#firstInvitationLetterIssueDate").val() == null) || ($("#firstInvitationLetterIssueDate").val().trim() == "")) {
                if (errorMessage == "")
                    $("#firstInvitationLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Invitiation Letter Issue Date can not be blank <br/>";
                i = i + 1;
                $("#firstInvitationLetterIssueDate").addClass("invalid");
            }

            if (($("#firstInvitationLetterFaxRefNo").val() == null) || ($("#firstInvitationLetterFaxRefNo").val().trim() == "")) {
                if (errorMessage == "")
                    $("#firstInvitationLetterFaxRefNo").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Invitiation Letter Fax Ref No. can not be blank <br/>";
                i = i + 1;
                $("#firstInvitationLetterFaxRefNo").addClass("invalid");
            }

            if (($("#firstInvitationLetterIssueDate").val() != null) && ($("#firstInvitationLetterIssueDate").val().trim() != "")) {
                let firstInvitationLetterIssueDate = $("#firstInvitationLetterIssueDate").val();
                if (!validateDateFormat(firstInvitationLetterIssueDate)) {
                    if (errorMessage == "")
                        $("#firstInvitationLetterIssueDate").focus();
                    errorMessage = errorMessage + "Error " + i + ": " + "First Invitation Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                    i = i + 1;
                    $("#firstInvitationLetterIssueDate").addClass("invalid");
                }
            }

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
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
        $('#secondInvitationLetterIssueDate').val("<?php echo $this->viewbag['secondInvitationLetterIssueDate']; ?>");
        $('#secondInvitationLetterFaxRefNo').val("<?php echo $this->viewbag['secondInvitationLetterFaxRefNo']; ?>");
        $('#secondInvitationLetterEdmsLink').val("<?php echo $this->viewbag['secondInvitationLetterEdmsLink']; ?>");
        $('#secondInvitationLetterWalkDate').val("<?php echo $this->viewbag['secondInvitationLetterWalkDate']; ?>");

        $("#genSecondInvitationLetterBtn").on("click", function() {
            let errorMessage = "";
            let i = 1;

            if (($("#firstInvitationLetterIssueDate").val() == null) || ($("#firstInvitationLetterIssueDate").val().trim() == "")) {
                if (errorMessage == "")
                    $("#firstInvitationLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Invitiation Letter Issue Date can not be blank <br/>";
                i = i + 1;
                $("#firstInvitationLetterIssueDate").addClass("invalid");
            }

            if (($("#secondInvitationLetterIssueDate").val() == null) || ($("#secondInvitationLetterIssueDate").val().trim() == "")) {
                if (errorMessage == "")
                    $("#secondInvitationLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitiation Letter Issue Date can not be blank <br/>";
                i = i + 1;
                $("#secondInvitationLetterIssueDate").addClass("invalid");
            }

            if (($("#secondInvitationLetterFaxRefNo").val() == null) || ($("#secondInvitationLetterFaxRefNo").val().trim() == "")) {
                if (errorMessage == "")
                    $("#secondInvitationLetterFaxRefNo").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitiation Letter Fax Ref No. can not be blank <br/>";
                i = i + 1;
                $("#secondInvitationLetterFaxRefNo").addClass("invalid");
            }

            if (($("#secondInvitationLetterIssueDate").val() != null) && ($("#secondInvitationLetterIssueDate").val().trim() != "")) {
                let secondInvitationLetterIssueDate = $("#secondInvitationLetterIssueDate").val();
                if (!validateDateFormat(secondInvitationLetterIssueDate)) {
                    if (errorMessage == "")
                        $("#secondInvitationLetterIssueDate").focus();
                    errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                    i = i + 1;
                    $("#secondInvitationLetterIssueDate").addClass("invalid");
                }
            }

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

        if (($("#projectTitle").val() == null) || ($("#projectTitle").val().trim() == "")) {
            if (errorMessage == "")
                $("#projectTitle").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Project Title can not be blank <br/>";
            i = i + 1;
            $("#projectTitle").addClass("invalid");
        }

        if (($("#region").val() == null) || ($("#region").val().trim() == "")) {
            if (errorMessage == "")
                $("#region").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Region can not be blank <br/>";
            i = i + 1;
            $("#region").addClass("invalid");
        }

        if (($("#schemeNo").val() == null) || ($("#schemeNo").val().trim() == "")) {
            if (errorMessage == "")
                $("#schemeNo").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Scheme No. can not be blank <br/>";
            i = i + 1;
            $("#schemeNo").addClass("invalid");
        }

        if (($("#commissionDate").val() != null) && ($("#commissionDate").val().trim() != "")) {
            let commissionDate = $("#commissionDate").val();
            if (!validateDateFormat(commissionDate)) {
                if (errorMessage == "")
                    $("#commissionDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Commission Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#commissionDate").addClass("invalid");
            }
        }

        <?php if (($this->viewbag['state']=="WAITING_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="COMPLETED_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>

        if (($("#standLetterIssueDate").val() != null) && ($("#standLetterIssueDate").val().trim() != "")) {
            let standLetterIssueDate = $("#standLetterIssueDate").val();
            if (!validateDateFormat(standLetterIssueDate)) {
                if (errorMessage == "")
                    $("#standLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Standard Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#standLetterIssueDate").addClass("invalid");
            }
        }

        <?php } ?>

        <?php if (($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
        if (($("#meetingFirstPreferMeetingDate").val() != null) && ($("#meetingFirstPreferMeetingDate").val().trim() != "")) {
            let meetingFirstPreferMeetingDate = $("#meetingFirstPreferMeetingDate").val();
            if (!validateDateTimeFormat(meetingFirstPreferMeetingDate)) {
                if (errorMessage == "")
                    $("#meetingFirstPreferMeetingDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Preferred Meeting Date Time format is not match. It should be [YYYY-mm-dd hh:mi] <br/>";
                i = i + 1;
                $("#meetingFirstPreferMeetingDate").addClass("invalid");
            }
        }

        if (($("#meetingSecondPreferMeetingDate").val() != null) && ($("#meetingSecondPreferMeetingDate").val().trim() != "")) {
            let meetingSecondPreferMeetingDate = $("#meetingSecondPreferMeetingDate").val();
            if (!validateDateTimeFormat(meetingSecondPreferMeetingDate)) {
                if (errorMessage == "")
                    $("#meetingSecondPreferMeetingDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Preferred Meeting Date Time format is not match. It should be [YYYY-mm-dd hh:mi] <br/>";
                i = i + 1;
                $("#meetingSecondPreferMeetingDate").addClass("invalid");
            }
        }

        if (($("#meetingActualMeetingDate").val() != null) && ($("#meetingActualMeetingDate").val().trim() != "")) {
            let meetingActualMeetingDate = $("#meetingActualMeetingDate").val();
            if (!validateDateTimeFormat(meetingActualMeetingDate)) {
                if (errorMessage == "")
                    $("#meetingActualMeetingDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Actual Meeting Date Time format is not match. It should be [YYYY-mm-dd hh:mi] <br/>";
                i = i + 1;
                $("#meetingActualMeetingDate").addClass("invalid");
            }
        }
        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
        if (($("#firstInvitationLetterIssueDate").val() != null) && ($("#firstInvitationLetterIssueDate").val().trim() != "")) {
            let firstInvitationLetterIssueDate = $("#firstInvitationLetterIssueDate").val();
            if (!validateDateFormat(firstInvitationLetterIssueDate)) {
                if (errorMessage == "")
                    $("#firstInvitationLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#firstInvitationLetterIssueDate").addClass("invalid");
            }
        }
        if (($("#firstInvitationLetterWalkDate").val() != null) && ($("#firstInvitationLetterWalkDate").val().trim() != "")) {
            let firstInvitationLetterWalkDate = $("#firstInvitationLetterWalkDate").val();
            if (!validateDateFormat(firstInvitationLetterWalkDate)) {
                if (errorMessage == "")
                    $("#firstInvitationLetterWalkDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter PQ Walk Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#firstInvitationLetterWalkDate").addClass("invalid");
            }
        }
        <?php } ?>

        <?php if (($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
        if (($("#secondInvitationLetterIssueDate").val() != null) && ($("#secondInvitationLetterIssueDate").val().trim() != "")) {
            let secondInvitationLetterIssueDate = $("#secondInvitationLetterIssueDate").val();
            if (!validateDateFormat(secondInvitationLetterIssueDate)) {
                if (errorMessage == "")
                    $("#secondInvitationLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#secondInvitationLetterIssueDate").addClass("invalid");
            }
        }
        if (($("#secondInvitationLetterWalkDate").val() != null) && ($("#secondInvitationLetterWalkDate").val().trim() != "")) {
            let secondInvitationLetterWalkDate = $("#secondInvitationLetterWalkDate").val();
            if (!validateDateFormat(secondInvitationLetterWalkDate)) {
                if (errorMessage == "")
                    $("#secondInvitationLetterWalkDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter PQ Walk Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#secondInvitationLetterWalkDate").addClass("invalid");
            }
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

        if (($("#projectTitle").val() == null) || ($("#projectTitle").val().trim() == "")) {
            if (errorMessage == "")
                $("#projectTitle").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Project Title can not be blank <br/>";
            i = i + 1;
            $("#projectTitle").addClass("invalid");
        }

        if (($("#region").val() == null) || ($("#region").val().trim() == "")) {
            if (errorMessage == "")
                $("#region").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Region can not be blank <br/>";
            i = i + 1;
            $("#region").addClass("invalid");
        }

        if (($("#schemeNo").val() == null) || ($("#schemeNo").val().trim() == "")) {
            if (errorMessage == "")
                $("#schemeNo").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Scheme No. can not be blank <br/>";
            i = i + 1;
            $("#schemeNo").addClass("invalid");
        }

        if (($("#commissionDate").val() != null) && ($("#commissionDate").val().trim() != "")) {
            let commissionDate = $("#commissionDate").val();
            if (!validateDateFormat(commissionDate)) {
                if (errorMessage == "")
                    $("#commissionDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Commission Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#commissionDate").addClass("invalid");
            }
        }

        <?php
            if(Yii::app()->session['tblUserDo']['roleId'] == 2) { ?>

        if (($("#typeOfProject").val() == null) || ($("#typeOfProject").val().trim() == "")) {
            if (errorMessage == "")
                $("#typeOfProject").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Type of Project must be selected <br/>";
            i = i + 1;
            $("#typeOfProject").addClass("invalid");
        }

        if (($('input[name=infraOpt]:checked', '#detailForm').val() == null) || ($('input[name=infraOpt]:checked', '#detailForm').val() == "")) {
            errorMessage = errorMessage + "Error " + i + ": " + "Key Infrastructure must be checked <br/>";
            i = i + 1;
        }

        if (($('input[name=tempProjOpt]:checked', '#detailForm').val() == null) || ($('input[name=tempProjOpt]:checked', '#detailForm').val() == "")) {
            errorMessage = errorMessage + "Error " + i + ": " + "Temp Project must be checked <br/>";
            i = i + 1;
        }

        <?php
            } else if(Yii::app()->session['tblUserDo']['roleId'] == 3) {?>

        if (($("#commissionDate").val() == null) || ($("#commissionDate").val().trim() == "")) {
            if (errorMessage == "")
                $("#commissionDate").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Commission Date can not be blank <br/>";
            i = i + 1;
            $("#commissionDate").addClass("invalid");
        }

        if (($("#firstRegionStaffName").val() == null) || ($("#firstRegionStaffName").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstRegionStaffName").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "First Region Staff Name can not be blank <br/>";
            i = i + 1;
            $("#firstRegionStaffName").addClass("invalid");
        }

        if (($("#firstRegionStaffPhone").val() == null) || ($("#firstRegionStaffPhone").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstRegionStaffPhone").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "First Region Staff Contact No. can not be blank <br/>";
            i = i + 1;
            $("#firstRegionStaffPhone").addClass("invalid");
        }

        if (($("#firstRegionStaffEmail").val() == null) || ($("#firstRegionStaffEmail").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstRegionStaffEmail").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "First Region Staff Email can not be blank <br/>";
            i = i + 1;
            $("#firstRegionStaffEmail").addClass("invalid");
        }

        if (($("#firstConsultantTitle").val() == null) || ($("#firstConsultantTitle").val().trim() == "0")) {
            if (errorMessage == "")
                $("#firstConsultantTitle").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Consultant Title can not be blank <br/>";
            i = i + 1;
            $("#firstConsultantTitle").addClass("invalid");
        }

        if (($("#firstConsultantSurname").val() == null) || ($("#firstConsultantSurname").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstConsultantSurname").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Consultant Surname can not be blank <br/>";
            i = i + 1;
            $("#firstConsultantSurname").addClass("invalid");
        }

        if (($("#firstConsultantOtherName").val() == null) || ($("#firstConsultantOtherName").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstConsultantOtherName").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Consultant Other Name(s) can not be blank <br/>";
            i = i + 1;
            $("#firstConsultantOtherName").addClass("invalid");
        }

        if (($("#firstConsultantCompany").val() == null) || ($("#firstConsultantCompany").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstConsultantCompany").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Consultant Other Name(s) can not be blank <br/>";
            i = i + 1;
            $("#firstConsultantCompany").addClass("invalid");
        }

        if (($("#firstConsultantPhone").val() == null) || ($("#firstConsultantPhone").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstConsultantPhone").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Consultant Contact No. can not be blank <br/>";
            i = i + 1;
            $("#firstConsultantPhone").addClass("invalid");
        }

        if (($("#firstConsultantEmail").val() == null) || ($("#firstConsultantEmail").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstConsultantEmail").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Consultant Email can not be blank <br/>";
            i = i + 1;
            $("#firstConsultantEmail").addClass("invalid");
        }

        if (($("#projectOwnerTitle").val() == null) || ($("#projectOwnerTitle").val().trim() == "0")) {
            if (errorMessage == "")
                $("#projectOwnerTitle").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Project Owner Title can not be blank <br/>";
            i = i + 1;
            $("#projectOwnerTitle").addClass("invalid");
        }

        if (($("#projectOwnerSurname").val() == null) || ($("#projectOwnerSurname").val().trim() == "")) {
            if (errorMessage == "")
                $("#projectOwnerSurname").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Project Owner Surname can not be blank <br/>";
            i = i + 1;
            $("#projectOwnerSurname").addClass("invalid");
        }

        if (($("#projectOwnerOtherName").val() == null) || ($("#projectOwnerOtherName").val().trim() == "")) {
            if (errorMessage == "")
                $("#projectOwnerOtherName").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Project Owner Other Name can not be blank <br/>";
            i = i + 1;
            $("#projectOwnerOtherName").addClass("invalid");
        }

        if (($("#projectOwnerCompany").val() == null) || ($("#projectOwnerCompany").val().trim() == "")) {
            if (errorMessage == "")
                $("#projectOwnerCompany").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Project Owner Company can not be blank <br/>";
            i = i + 1;
            $("#projectOwnerCompany").addClass("invalid");
        }

        if (($("#projectOwnerPhone").val() == null) || ($("#projectOwnerPhone").val().trim() == "")) {
            if (errorMessage == "")
                $("#projectOwnerPhone").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Project Owner Phone can not be blank <br/>";
            i = i + 1;
            $("#projectOwnerPhone").addClass("invalid");
        }

        if (($("#projectOwnerEmail").val() == null) || ($("#projectOwnerEmail").val().trim() == "")) {
            if (errorMessage == "")
                $("#projectOwnerEmail").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Project Owner Email can not be blank <br/>";
            i = i + 1;
            $("#projectOwnerEmail").addClass("invalid");
        }

        <?php
            }?>

        <?php if (($this->viewbag['state']=="WAITING_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="COMPLETED_STANDARD_LETTER") ||
                    ($this->viewbag['state']=="WAITING_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>
        if (($("#standLetterIssueDate").val() == null) || ($("#standLetterIssueDate").val().trim() == "")) {
            if (errorMessage == "")
                $("#standLetterIssueDate").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Standard Letter Issue Date can not be blank <br/>";
            i = i + 1;
            $("#standLetterIssueDate").addClass("invalid");
        }
        if (($("#standLetterFaxRefNo").val() == null) || ($("#standLetterFaxRefNo").val().trim() == "")) {
            if (errorMessage == "")
                $("#standLetterFaxRefNo").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Standard Letter Fax Ref No. can not be blank <br/>";
            i = i + 1;
            $("#standLetterFaxRefNo").addClass("invalid");
        }
        if (($("#standLetterEdmsLink").val() == null) || ($("#standLetterEdmsLink").val().trim() == "")) {
            if (errorMessage == "")
                $("#standLetterEdmsLink").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Standard Letter EDMS link can not be blank <br/>";
            i = i + 1;
            $("#standLetterEdmsLink").addClass("invalid");
        }
        if (($("#standLetterIssueDate").val() != null) && ($("#standLetterIssueDate").val().trim() != "")) {
            let standLetterIssueDate = $("#standLetterIssueDate").val();
            if (!validateDateFormat(standLetterIssueDate)) {
                if (errorMessage == "")
                    $("#standLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Standard Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#standLetterIssueDate").addClass("invalid");
            }
        }
        if (($("#standLetterLetterLoc").val() == null) || ($("#standLetterLetterLoc").val().trim() == "")) {
            if ($('#standSignedLetter').get(0).files.length == 0) {
                if (errorMessage == "")
                    $("#standLetterLetterLoc").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Signed Standard Letter should be uploaded <br/>";
                i = i + 1;
                $("#standLetterLetterLoc").addClass("invalid");
            }
        }
        <?php } ?>

        <?php if (($this->viewbag['state']=="COMPLETED_CONSULTANT_MEETING_INFO") ||
                    ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") ||
                    ($this->viewbag['state']=="SENT_THIRD_INVITATION_LETTER")) { ?>

        if (($("#meetingActualMeetingDate").val() == null) || ($("#meetingActualMeetingDate").val().trim() == "")) {
            if (errorMessage == "")
                $("#meetingActualMeetingDate").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Actual Meeting Date & Time can not be blank <br/>";
            i = i + 1;
            $("#meetingActualMeetingDate").addClass("invalid");
        }

        if (($("#meetingFirstPreferMeetingDate").val() != null) && ($("#meetingFirstPreferMeetingDate").val().trim() != "")) {
            let meetingFirstPreferMeetingDate = $("#meetingFirstPreferMeetingDate").val();
            if (!validateDateTimeFormat(meetingFirstPreferMeetingDate)) {
                if (errorMessage == "")
                    $("#meetingFirstPreferMeetingDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Preferred Meeting Date Time format is not match. It should be [YYYY-mm-dd hh:mi] <br/>";
                i = i + 1;
                $("#meetingFirstPreferMeetingDate").addClass("invalid");
            }
        }

        if (($("#meetingSecondPreferMeetingDate").val() != null) && ($("#meetingSecondPreferMeetingDate").val().trim() != "")) {
            let meetingSecondPreferMeetingDate = $("#meetingSecondPreferMeetingDate").val();
            if (!validateDateTimeFormat(meetingSecondPreferMeetingDate)) {
                if (errorMessage == "")
                    $("#meetingSecondPreferMeetingDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Preferred Meeting Date Time format is not match. It should be [YYYY-mm-dd hh:mi] <br/>";
                i = i + 1;
                $("#meetingSecondPreferMeetingDate").addClass("invalid");
            }
        }

        if (($("#meetingActualMeetingDate").val() != null) && ($("#meetingActualMeetingDate").val().trim() != "")) {
            let meetingActualMeetingDate = $("#meetingActualMeetingDate").val();
            if (!validateDateTimeFormat(meetingActualMeetingDate)) {
                if (errorMessage == "")
                    $("#meetingActualMeetingDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "Actual Meeting Date Time format is not match. It should be [YYYY-mm-dd hh:mi] <br/>";
                i = i + 1;
                $("#meetingActualMeetingDate").addClass("invalid");
            }
        }
        <?php } ?>

        <?php if ($this->viewbag['state']=="SENT_FIRST_INVITATION_LETTER") { ?>
        if (($("#firstInvitationLetterIssueDate").val() == null) || ($("#firstInvitationLetterIssueDate").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstInvitationLetterIssueDate").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter Issue Date can not be blank <br/>";
            i = i + 1;
            $("#firstInvitationLetterIssueDate").addClass("invalid");
        }

        if (($("#firstInvitationLetterFaxRefNo").val() == null) || ($("#firstInvitationLetterFaxRefNo").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstInvitationLetterFaxRefNo").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter Fax Reference No. can not be blank <br/>";
            i = i + 1;
            $("#firstInvitationLetterFaxRefNo").addClass("invalid");
        }

        if (($("#firstInvitationLetterEdmsLink").val() == null) || ($("#firstInvitationLetterEdmsLink").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstInvitationLetterEdmsLink").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter EDMS Link can not be blank <br/>";
            i = i + 1;
            $("#firstInvitationLetterEdmsLink").addClass("invalid");
        }

        if (($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() == null) ||
            ($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() == "")) {
            errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter Acceptance must be checked <br/>";
            i = i + 1;
        }

        if (($("#firstInvitationLetterWalkDate").val() == null) || ($("#firstInvitationLetterWalkDate").val().trim() == "")) {
            if (errorMessage == "")
                $("#firstInvitationLetterWalkDate").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter PQ Walk Date can not be blank <br/>";
            i = i + 1;
            $("#firstInvitationLetterWalkDate").addClass("invalid");
        }

        if (($("#firstInvitationLetterIssueDate").val() != null) && ($("#firstInvitationLetterIssueDate").val().trim() != "")) {
            let firstInvitationLetterIssueDate = $("#firstInvitationLetterIssueDate").val();
            if (!validateDateFormat(firstInvitationLetterIssueDate)) {
                if (errorMessage == "")
                    $("#firstInvitationLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#firstInvitationLetterIssueDate").addClass("invalid");
            }
        }
        if (($("#firstInvitationLetterWalkDate").val() != null) && ($("#firstInvitationLetterWalkDate").val().trim() != "")) {
            let firstInvitationLetterWalkDate = $("#firstInvitationLetterWalkDate").val();
            if (!validateDateFormat(firstInvitationLetterWalkDate)) {
                if (errorMessage == "")
                    $("#firstInvitationLetterWalkDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter PQ Walk Date format is not match. It should be [YYYY-mm-dd] <br/>";
                i = i + 1;
                $("#firstInvitationLetterWalkDate").addClass("invalid");
            }
        }
        <?php } ?>

        <?php if ($this->viewbag['state']=="SENT_SECOND_INVITATION_LETTER") { ?>
        if ((($("#firstInvitationLetterWalkDate").val() == null) || ($("#firstInvitationLetterWalkDate").val().trim() == "")) ||
            (($("#firstInvitationLetterWalkDate").val() == null) || ($("#firstInvitationLetterWalkDate").val().trim() == "")) ||
            (($("#firstInvitationLetterWalkDate").val() == null) || ($("#firstInvitationLetterWalkDate").val().trim() == "")) ||
            (($("#firstInvitationLetterWalkDate").val() == null) || ($("#firstInvitationLetterWalkDate").val().trim() == "")) ||
            (($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() == null) ||
                ($('input[name=firstInvitationLetterAccept]:checked', '#detailForm').val() == ""))) {

            if (($("#secondInvitationLetterIssueDate").val() == null) || ($("#secondInvitationLetterIssueDate").val().trim() == "")) {
                if (errorMessage == "")
                    $("#secondInvitationLetterIssueDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter Issue Date can not be blank <br/>";
                i = i + 1;
                $("#secondInvitationLetterIssueDate").addClass("invalid");
            }

            if (($("#secondInvitationLetterFaxRefNo").val() == null) || ($("#secondInvitationLetterFaxRefNo").val().trim() == "")) {
                if (errorMessage == "")
                    $("#secondInvitationLetterFaxRefNo").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter Fax Reference No. can not be blank <br/>";
                i = i + 1;
                $("#secondInvitationLetterFaxRefNo").addClass("invalid");
            }

            if (($("#secondInvitationLetterEdmsLink").val() == null) || ($("#secondInvitationLetterEdmsLink").val().trim() == "")) {
                if (errorMessage == "")
                    $("#secondInvitationLetterEdmsLink").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter EDMS Link can not be blank <br/>";
                i = i + 1;
                $("#secondInvitationLetterEdmsLink").addClass("invalid");
            }

            if (($('input[name=secondInvitationLetterAccept]:checked', '#detailForm').val() == null) ||
                ($('input[name=secondInvitationLetterAccept]:checked', '#detailForm').val() == "")) {
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter Acceptance must be checked <br/>";
                i = i + 1;
            }

            if (($("#secondInvitationLetterWalkDate").val() == null) || ($("#secondInvitationLetterWalkDate").val().trim() == "")) {
                if (errorMessage == "")
                    $("#secondInvitationLetterWalkDate").focus();
                errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter PQ Walk Date can not be blank <br/>";
                i = i + 1;
                $("#secondInvitationLetterWalkDate").addClass("invalid");
            }

            if (($("#secondInvitationLetterIssueDate").val() != null) && ($("#secondInvitationLetterIssueDate").val().trim() != "")) {
                let secondInvitationLetterIssueDate = $("#secondInvitationLetterIssueDate").val();
                if (!validateDateFormat(secondInvitationLetterIssueDate)) {
                    if (errorMessage == "")
                        $("#secondInvitationLetterIssueDate").focus();
                    errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                    i = i + 1;
                    $("#secondInvitationLetterIssueDate").addClass("invalid");
                }
            }
            if (($("#secondInvitationLetterWalkDate").val() != null) && ($("#secondInvitationLetterWalkDate").val().trim() != "")) {
                let secondInvitationLetterWalkDate = $("#secondInvitationLetterWalkDate").val();
                if (!validateDateFormat(secondInvitationLetterWalkDate)) {
                    if (errorMessage == "")
                        $("#secondInvitationLetterWalkDate").focus();
                    errorMessage = errorMessage + "Error " + i + ": " + "2nd Invitation Letter PQ Walk Date format is not match. It should be [YYYY-mm-dd] <br/>";
                    i = i + 1;
                    $("#secondInvitationLetterWalkDate").addClass("invalid");
                }
            }

            if (($("#firstInvitationLetterIssueDate").val() != null) && ($("#firstInvitationLetterIssueDate").val().trim() != "")) {
                let firstInvitationLetterIssueDate = $("#firstInvitationLetterIssueDate").val();
                if (!validateDateFormat(firstInvitationLetterIssueDate)) {
                    if (errorMessage == "")
                        $("#firstInvitationLetterIssueDate").focus();
                    errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter Issue Date format is not match. It should be [YYYY-mm-dd] <br/>";
                    i = i + 1;
                    $("#firstInvitationLetterIssueDate").addClass("invalid");
                }
            }
            if (($("#firstInvitationLetterWalkDate").val() != null) && ($("#firstInvitationLetterWalkDate").val().trim() != "")) {
                let firstInvitationLetterWalkDate = $("#firstInvitationLetterWalkDate").val();
                if (!validateDateFormat(firstInvitationLetterWalkDate)) {
                    if (errorMessage == "")
                        $("#firstInvitationLetterWalkDate").focus();
                    errorMessage = errorMessage + "Error " + i + ": " + "1st Invitation Letter PQ Walk Date format is not match. It should be [YYYY-mm-dd] <br/>";
                    i = i + 1;
                    $("#firstInvitationLetterWalkDate").addClass("invalid");
                }
            }
        }

        <?php } ?>


        if (errorMessage == "") {
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

</script>



