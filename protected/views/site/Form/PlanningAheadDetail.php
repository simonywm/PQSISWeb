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
                       class="form-control" value="<?php echo $this->viewbag['projectTitle'] ?>"
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
                       class="form-control" value="<?php echo $this->viewbag['schemeNo'] ?>"
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
                       class="form-control" value="<?php echo $this->viewbag['commissionDate'] ?>"
                       autocomplete="off">
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
                                           class="form-control" value="<?php echo $this->viewbag['firstRegionStaffName'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="firstRegionStaffPhone" name="firstRegionStaffPhone" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['firstRegionStaffPhone'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="firstRegionStaffEmail" name="firstRegionStaffEmail" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['firstRegionStaffEmail'] ?>"
                                           autocomplete="off">
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
                                           class="form-control" value="<?php echo $this->viewbag['secondRegionStaffName'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="secondRegionStaffPhone" name="secondRegionStaffPhone" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['secondRegionStaffPhone'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="secondRegionStaffEmail" name="secondRegionStaffEmail" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['secondRegionStaffEmail'] ?>"
                                           autocomplete="off">
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
                                           class="form-control" value="<?php echo $this->viewbag['thirdRegionStaffName'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="thirdRegionStaffPhone" name="thirdRegionStaffPhone" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['thirdRegionStaffPhone'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="thirdRegionStaffEmail" name="thirdRegionStaffEmail" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['thirdRegionStaffEmail'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordionContactOfConsultant">
            <div class="card">
                <div class="card-header" style="background-color: #6f42c1">
                    <a class="card-link" data-toggle="collapse" href="#contactOfConsultant" onclick="cardSelected('contactOfConsultantIcon')">
                        <div class="row">
                            <div class="col-11"><h5 class="text-light">Contact of Consultant</h5></div>
                            <div class="col-1">
                                <img id="contactOfConsultantIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="contactOfConsultant" class="collapse" data-parent="#accordionContactOfConsultant">
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
                                           class="form-control" value="<?php echo $this->viewbag['firstConsultantSurname'] ?>"
                                           autocomplete="off" placeholder="Surname">
                                    <input id="firstConsultantOtherName" name="firstConsultantOtherName" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['firstConsultantOtherName'] ?>"
                                           autocomplete="off" placeholder="Other Name(s)">
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
                                           class="form-control" value="<?php echo $this->viewbag['firstConsultantPhone'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="firstConsultantEmail" name="firstConsultantEmail" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['firstConsultantEmail'] ?>"
                                           autocomplete="off">
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
                                           class="form-control" value="<?php echo $this->viewbag['projectOwnerSurname'] ?>"
                                           autocomplete="off" placeholder="Surname">
                                    <input id="projectOwnerOtherName" name="projectOwnerOtherName" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['projectOwnerOtherName'] ?>"
                                           autocomplete="off" placeholder="Other Name(s)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Company: </span>
                                    </div>
                                    <input id="projectOwnerCompany" name="projectOwnerCompany" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['projectOwnerCompany'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact No.: </span>
                                    </div>
                                    <input id="projectOwnerPhone" name="projectOwnerPhone" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['projectOwnerPhone'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Contact Email: </span>
                                    </div>
                                    <input id="projectOwnerEmail" name="projectOwnerEmail" type="text"
                                           class="form-control" value="<?php echo $this->viewbag['projectOwnerEmail'] ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($this->viewbag['state']=="WAITING_STANDARD_LETTER") { ?>
            <div id="accordionDetailofPQStandardLetter">
                <div class="card">
                    <div class="card-header" style="background-color: #6f42c1">
                        <a class="card-link" data-toggle="collapse" href="#detailofPQStandardLetter" onclick="cardSelected('contactOfProjectOwnerIcon');">
                            <div class="row">
                                <div class="col-11"><h5 class="text-light">Details of PQ Standard Letter</h5></div>
                                <div class="col-1">
                                    <img id="contactOfProjectOwnerIcon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/expend.png" width="20px"/>
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
                                               class="form-control" value="<?php echo $this->viewbag['standLetterIssueDate'] ?>"
                                               onchange="updateGenStandLetterButton()" autocomplete="off">
                                    </div>
                                    <div class="input-group col-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fax Reference No.: </span>
                                        </div>
                                        <input id="standLetterFaxRefNo" name="standLetterFaxRefNo" type="text"
                                               class="form-control" value="<?php echo $this->viewbag['standLetterFaxRefNo'] ?>"
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
                                               class="form-control" value="<?php echo $this->viewbag['standLetterEdmsLink'] ?>"
                                               autocomplete="off">
                                    </div>
                                    <div class="input-group col-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Signed Letter: </span>
                                        </div>
                                        <input id="standLetterLetter" name="standLetterLetter" type="file"
                                               placeholder="Please upload the signed standard letter"
                                               class="form-control"
                                               autocomplete="false">
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
        <input type="hidden" id="state" name="state" value="<?php echo $this->viewbag['state']; ?>">
        <input type="hidden" id="roleId" name="roleId" value="<?php echo Yii::app()->session['tblUserDo']['roleId']; ?>">

    </form>

</div>

<!-- Script for processing the data -->
<script>
    $(document).ready(function(){

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
                    url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxPostPlanningAheadProjectDetailDraftUpdate",
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
                    url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxPostPlanningAheadProjectDetailProcessUpdate",
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

        <?php if ($this->viewbag['state']=="WAITING_STANDARD_LETTER") { ?>
        $("#genStandLetterBtn").on("click", function() {

            let errorMessage = "";
            let i = 1;

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
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadProjectDetailStandardLetterTemplate" +
                "&standLetterIssueDate=" + $("#standLetterIssueDate").val() + "&standLetterFaxRefNo=" + $("#standLetterFaxRefNo").val() +
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

        <?php if ($this->viewbag['state']=="WAITING_STANDARD_LETTER") { ?>

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

        if (errorMessage == "") {
            return true;
        } else {
            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
            return false;
        }
    }

    <?php if ($this->viewbag['state']=="WAITING_STANDARD_LETTER") { ?>
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

</script>



