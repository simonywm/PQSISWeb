<?php

class MaintenanceController extends Controller
{
    public function filters()
    {
        return array(
            array(
                'application.filters.AccessControlFilter',
            ),
            array(
                'application.filters.RoleControlFilter',
            ),
            array(
                'application.filters.EditControlFilter + GetRequestedByForNew , GetRequestedByForUpdate,AjaxInsertRequestedBy,AjaxUpdateRequestedBy
                                                        ,GetActionByForNew , GetActionByForUpdate,AjaxInsertActionBy,AjaxUpdateActionBy
                                                        ,GetProblemTypeForNew , GetProblemTypeForUpdate,AjaxInsertProblemType,AjaxUpdateProblemType
                                                        ,GetBusinessTypeForNew , GetBusinessTypeForUpdate,AjaxInsertBusinessType,AjaxUpdateBusinessType
                                                        ,GetClpPersonDepartmentForNew , GetClpPersonDepartmentForUpdate,AjaxInsertClpPersonDepartment,AjaxUpdateClpPersonDepartment
                                                        ,GetClpReferredByForNew , GetClpReferredByForUpdate,AjaxInsertClpReferredBy,AjaxUpdateClpReferredBy
                                                        ,GetEicForNew , GetEicForUpdate,AjaxInsertEic,AjaxUpdateEic
                                                        ,GetContactPersonForNew , GetContactPersonForUpdate,AjaxInsertContactPerson,AjaxUpdateContactPerson
                                                        ,GetCustomerForNew , GetCustomerForUpdate,AjaxInsertCustomer,AjaxUpdateCustomer
                                                        ,GetMajorAffectedElementForNew , GetMajorAffectedElementForUpdate,AjaxInsertMajorAffectedElement,AjaxUpdateMajorAffectedElement
                                                        ,GetPartyToBeChargedForNew , GetPartyToBeChargedForUpdate,AjaxInsertPartyToBeCharged,AjaxUpdatePartyToBeCharged
                                                        ,GetServiceStatusForNew , GetServiceStatusForUpdate,AjaxInsertServiceStatus,AjaxUpdateServiceStatus
                                                        ,GetServiceTypeForNew , GetServiceTypeForUpdate,AjaxInsertServiceType,AjaxUpdateServiceType
                                                        ,GetPlantTypeForNew , GetPlantTypeForUpdate,AjaxInsertPlantType,AjaxUpdatePlantType
                                                        ,GetCostTypeForNew , GetCostTypeForUpdate,AjaxInsertCostType,AjaxUpdateCostType
                                                        ,GetProjectTypeForNew , GetProjectTypeForUpdate,AjaxInsertProjectType,AjaxUpdateProjectType
                                                        ,GetBuildingTypeForNew , GetBuildingTypeForUpdate,AjaxInsertBuildingType,AjaxUpdateBuildingType
                                                        ,GetProjectRegionForNew , GetProjectRegionForUpdate,AjaxInsertProjectRegion,AjaxUpdateProjectRegion
                                                        ,GetConsultantCompanyForNew , GetConsultantCompanyForUpdate,AjaxInsertConsultantCompany,AjaxUpdateConsultantCompany
                                                        ,GetPqSensitiveLoadForNew , GetPqSensitiveLoadForUpdate,AjaxInsertPqSensitiveLoad,AjaxUpdatePqSensitiveLoad
                                                        ,GetConsultantForNew , GetConsultantForUpdate,AjaxInsertConsultant,AjaxUpdateConsultant
                                                        ,GetRegionPlannerForNew , GetRegionPlannerForUpdate,AjaxInsertRegionPlanner,AjaxUpdateRegionPlanner
                                                        ,GetHolidayForNew, GetHolidayForUpdate,AjaxInsertHoliday,AjaxUpdateHoliday
                                                        ,GetConfigForUpdate,AjaxUpdateConfig
                                                        ,GetCostTypeForNew,GetCostTypeForUpdate,AjaxInsertCostType,AjaxUpdateCostType
                                                        ,GetBudgetForNew,GetBudgetForUpdate,AjaxInsertBudget,AjaxUpdateBudget 
                                                        ,GetUserForNew,GetUserForUpdate,AjaxInsertUser,AjaxUpdateUser ',
            ),
        );
    }

    
#region requestedBy
    public function actionRequestedBySearch()
    {
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByActive();
        $this->viewbag['requestedByDept'] = Yii::app()->formDao->getFormRequestedByDeptActive();
        $this->viewbag['requestedByAutoCompleteList'] = Yii::app()->formDao->getFormRequestedByAutoCompleteAll();
        $this->render("//site/Maintenance/RequestedBySearch");
    }

    public function actionGetRequestedByForNew()
    {
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByActive();
        $this->viewbag['requestedByAutoCompleteList'] = Yii::app()->formDao->getFormRequestedByAutoCompleteActive();
        $this->viewbag['requestedByDept'] = Yii::app()->formDao->getFormRequestedByDeptActive();

        $this->layout = false;
        $this->render("//site/Maintenance/RequestedByNew");
    }
    public function actionGetRequestedByForUpdate()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $requestedById = $param['requestedById'];
        $this->viewbag['requestedBy'] = Yii::app()->maintenanceDao->getRequestedByById($requestedById);
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByActive();
        $this->viewbag['requestedByAutoCompleteList'] = Yii::app()->formDao->getFormRequestedByAutoCompleteActive();
        $this->viewbag['requestedByDept'] = Yii::app()->formDao->getFormRequestedByDeptActive();
        $this->layout = false;
        $this->render("//site/Maintenance/RequestedByUpdate");

    }
    public function actionAjaxGetRequestedByTable()
    {
        $param = json_decode(file_get_contents('php://input'), true);

        $searchParam = json_decode($param['searchParam'], true);
        $start = $param['start'];
        $length = $param['length'];
        $orderColumn = $param['order'][0]['column'];
        $orderDir = $param['order'][0]['dir'];
        $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

        $List = Yii::app()->maintenanceDao->GetRequestedBySearchByPage($searchParam, $start, $length, $order);

        $recordFiltered = Yii::app()->maintenanceDao->GetRequestedBySearchResultCount($searchParam);

        $totalCount = Yii::app()->maintenanceDao->GetRequestedByRecordCount();

        $result = array('draw' => $param['draw'],
            'data' => $List,
            'recordsFiltered' => $recordFiltered,
            'recordsTotal' => $totalCount);

        echo json_encode($result);

    }


    public function actionAjaxInsertRequestedBy()
    {

        //$caseNo = isset($_POST['txCaseNo']) ? $_POST['txCaseNo'] : '';
        if ($_POST['txRequestedByName'] == '') {
            $requestedByName = null;
        } else {
            $requestedByName = trim($_POST['txRequestedByName']);
        }
        if ($_POST['txRequestedByDept'] == '') {
            $requestedByDept = null;
        } else {
            $requestedByDept = trim($_POST['txRequestedByDept']);
        }
        $active = isset($_POST['txActive']) ? trim($_POST['txActive']) : '';
        $createdBy = Yii::app()->session['tblUserDo']['username'];
        $createdTime = date("Y-m-d H:i");
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");
        $retJson['status'] = 'OK';

        try {

            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();

            //Query 1: Attempt to insert the payment record into our database.
            $sql = 'INSERT INTO "TblRequestedBy" ("requestedByName","requestedByDept","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
            $sql = $sql . " VALUES (?,?,?,?,?,?,?)";
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array(
                $requestedByName, $requestedByDept, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
            ));
            if (!$result) {
                throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

            }
            $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $stmt->execute(array(
                $lastUpdatedTime,
            )
            );

            //We've got this far without an exception, so commit the changes.
            //$pdo->commit();
            $transaction->commit();
        }
        //Our catch block will handle any exceptions that are thrown.
         catch (Exception $e) {

            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] = $e->getMessage();
            //Rollback the transaction.
            //$pdo->rollBack();
            $transaction->rollBack();
        }

        echo json_encode($retJson);
    }
    public function actionAjaxUpdateRequestedBy()
    {

        $requestedById = isset($_POST['txRequestedById']) ? $_POST['txRequestedById'] : '';

        if ($_POST['txRequestedByName'] == '') {
            $requestedByName = null;
        } else {
            $requestedByName = trim($_POST['txRequestedByName']);
        }
        if ($_POST['txRequestedByDept'] == '') {
            $requestedByDept = null;
        } else {
            $requestedByDept = trim($_POST['txRequestedByDept']);
        }
        $active = isset($_POST['txActive']) ? trim($_POST['txActive']) : '';
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");

        $retJson['status'] = 'OK';

        try {

            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();

            //Query 1: Attempt to insert the payment record into our database.
            $sql = 'UPDATE "TblRequestedBy" SET "requestedByName" =? ,"requestedByDept" =? ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
            $sql = $sql . ' WHERE "requestedById" = ?';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);

            $stmt->execute(array(
                $requestedByName, $requestedByDept, $active, $lastUpdatedBy, $lastUpdatedTime
                , $requestedById));

            $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $stmt->execute(array(
                $lastUpdatedTime,
            )
            );

            //We've got this far without an exception, so commit the changes.
            //$pdo->commit();
            $transaction->commit();
        }
        //Our catch block will handle any exceptions that are thrown.
         catch (PDOException $e) {

            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] = $e->getMessage();
            //Rollback the transaction.
            //$pdo->rollBack();
            $transaction->rollBack();
        }

        echo json_encode($retJson);
    }
#endregion requestedBy
#region actionBy
public function actionActionBySearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ActionBySearch");
}

public function actionGetActionByForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ActionBy");
    
}
public function actionGetActionByForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $actionById = $param['actionById'];
    $this->viewbag['actionBy'] = Yii::app()->maintenanceDao->getActionByById($actionById);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ActionBy");

}
public function actionAjaxGetActionByTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetActionBySearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetActionBySearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetActionByRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertActionBy()
{

    if ($_POST['actionByName'] == '') {
        $actionByName = null;
    } else {
        $actionByName = trim($_POST['actionByName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = "INSERT INTO \"TblActionBy\" (\"actionByName\",\"active\",\"createdBy\",\"createdTime\",\"lastUpdatedBy\",\"lastUpdatedTime\")";
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $actionByName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = "UPDATE \"TblEditRight\" set \"editRightLastEditTime\" = ? ";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateActionBy()
{

    $actionById = isset($_POST['actionById']) ? $_POST['actionById'] : '';

    if ($_POST['actionByName'] == '') {
        $actionByName = null;
    } else {
        $actionByName = trim($_POST['actionByName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = "UPDATE \"TblActionBy\" SET \"actionByName\" =?  ,\"active\" =? ,\"lastUpdatedBy\"=?,\"lastUpdatedTime\"=? ";
        $sql = $sql . " WHERE \"actionById\" = ?";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $actionByName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $actionById));

        $sql = "UPDATE \"TblEditRight\" set \"editRightLastEditTime\" = ? ";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion actionBy
#region problemType
public function actionProblemTypeSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ProblemTypeSearch");
}

public function actionGetProblemTypeForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ProblemType");

}
public function actionGetProblemTypeForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $problemTypeId = $param['problemTypeId'];
    $this->viewbag['problemType'] = Yii::app()->maintenanceDao->getProblemTypeById($problemTypeId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ProblemType");

}
public function actionAjaxGetProblemTypeTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetProblemTypeSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetProblemTypeSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetProblemTypeRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertProblemType()
{

    if ($_POST['problemTypeName'] == '') {
        $problemTypeName = null;
    } else {
        $problemTypeName = trim($_POST['problemTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblProblemType" ("problemTypeName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $problemTypeName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateProblemType()
{

    $problemTypeId = isset($_POST['problemTypeId']) ? $_POST['problemTypeId'] : '';

    if ($_POST['problemTypeName'] == '') {
        $problemTypeName = null;
    } else {
        $problemTypeName = trim($_POST['problemTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblProblemType" SET "problemTypeName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql .' WHERE "problemTypeId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $problemTypeName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $problemTypeId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion problemType
#region businessType
public function actionBusinessTypeSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/BusinessTypeSearch");
}

public function actionGetBusinessTypeForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/BusinessType");
    
}
public function actionGetBusinessTypeForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $businessTypeId = $param['businessTypeId'];
    $this->viewbag['businessType'] = Yii::app()->maintenanceDao->getBusinessTypeById($businessTypeId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/BusinessType");

}
public function actionAjaxGetBusinessTypeTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetBusinessTypeSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetBusinessTypeSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetBusinessTypeRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertBusinessType()
{

    if ($_POST['businessTypeName'] == '') {
        $businessTypeName = null;
    } else {
        $businessTypeName = trim($_POST['businessTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblBusinessType" ("businessTypeName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $businessTypeName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateBusinessType()
{

    $businessTypeId = isset($_POST['businessTypeId']) ? $_POST['businessTypeId'] : '';

    if ($_POST['businessTypeName'] == '') {
        $businessTypeName = null;
    } else {
        $businessTypeName = trim($_POST['businessTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblBusinessType" SET "businessTypeName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "businessTypeId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $businessTypeName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $businessTypeId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion businessType
#region clpPersonDepartment
public function actionClpPersonDepartmentSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ClpPersonDepartmentSearch");
}

public function actionGetClpPersonDepartmentForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ClpPersonDepartment");

}
public function actionGetClpPersonDepartmentForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $clpPersonDepartmentId = $param['clpPersonDepartmentId'];
    $this->viewbag['clpPersonDepartment'] = Yii::app()->maintenanceDao->getClpPersonDepartmentById($clpPersonDepartmentId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ClpPersonDepartment");

}
public function actionAjaxGetClpPersonDepartmentTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetClpPersonDepartmentSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetClpPersonDepartmentSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetClpPersonDepartmentRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertClpPersonDepartment()
{

    if ($_POST['clpPersonDepartmentName'] == '') {
        $clpPersonDepartmentName = null;
    } else {
        $clpPersonDepartmentName = trim($_POST['clpPersonDepartmentName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblClpPersonDepartment" ("clpPersonDepartmentName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $clpPersonDepartmentName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateClpPersonDepartment()
{

    $clpPersonDepartmentId = isset($_POST['clpPersonDepartmentId']) ? $_POST['clpPersonDepartmentId'] : '';

    if ($_POST['clpPersonDepartmentName'] == '') {
        $clpPersonDepartmentName = null;
    } else {
        $clpPersonDepartmentName = trim($_POST['clpPersonDepartmentName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblClpPersonDepartment" SET "clpPersonDepartmentName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "clpPersonDepartmentId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $clpPersonDepartmentName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $clpPersonDepartmentId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion clpPersonDepartment
#region clpReferredBy
public function actionClpReferredBySearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ClpReferredBySearch");
}

public function actionGetClpReferredByForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ClpReferredBy");

}
public function actionGetClpReferredByForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $clpReferredById = $param['clpReferredById'];
    $this->viewbag['clpReferredBy'] = Yii::app()->maintenanceDao->getClpReferredByById($clpReferredById);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ClpReferredBy");

}
public function actionAjaxGetClpReferredByTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetClpReferredBySearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetClpReferredBySearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetClpReferredByRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertClpReferredBy()
{

    if ($_POST['clpReferredByName'] == '') {
        $clpReferredByName = null;
    } else {
        $clpReferredByName = trim($_POST['clpReferredByName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblClpReferredBy" ("clpReferredByName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $clpReferredByName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
       //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateClpReferredBy()
{

    $clpReferredById = isset($_POST['clpReferredById']) ? $_POST['clpReferredById'] : '';

    if ($_POST['clpReferredByName'] == '') {
        $clpReferredByName = null;
    } else {
        $clpReferredByName = trim($_POST['clpReferredByName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblClpReferredBy" SET "clpReferredByName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "clpReferredById" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $clpReferredByName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $clpReferredById));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
       // $stmt = $pdo->prepare($sql);
       $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion clpReferredBy
#region eic
public function actionEicSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/EicSearch");
}

public function actionGetEicForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/Eic");

}
public function actionGetEicForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $eicId = $param['eicId'];
    $this->viewbag['eic'] = Yii::app()->maintenanceDao->getEicById($eicId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/Eic");

}
public function actionAjaxGetEicTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetEicSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetEicSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetEicRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertEic()
{

    if ($_POST['eicName'] == '') {
        $eicName = null;
    } else {
        $eicName = trim($_POST['eicName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblEic" ("eicName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $result = $stmt->execute(array(
            $eicName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateEic()
{

    $eicId = isset($_POST['eicId']) ? $_POST['eicId'] : '';

    if ($_POST['eicName'] == '') {
        $eicName = null;
    } else {
        $eicName = trim($_POST['eicName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblEic" SET "eicName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "eicId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $eicName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $eicId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion eic
#region contactPerson
public function actionContactPersonSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
    $this->render("//site/Maintenance/ContactPersonSearch");
}

public function actionGetContactPersonForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ContactPerson");

}
public function actionGetContactPersonForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $contactPersonId = $param['contactPersonId'];
    $this->viewbag['contactPerson'] = Yii::app()->maintenanceDao->getContactPersonById($contactPersonId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ContactPerson");

}
public function actionAjaxGetContactPersonTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetContactPersonSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetContactPersonSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetContactPersonRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertContactPerson()
{

    if ($_POST['contactPersonName'] == '') {
        $contactPersonName = null;
    } else {
        $contactPersonName = trim($_POST['contactPersonName']);
    }
    if ($_POST['contactPersonTitle'] == '') {
        $contactPersonTitle = null;
    } else {
        $contactPersonTitle = trim($_POST['contactPersonTitle']);
    }
    if ($_POST['contactPersonNo'] == '') {
        $contactPersonNo = null;
    } else {
        $contactPersonNo = trim($_POST['contactPersonNo']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblContactPerson" ("contactPersonName","contactPersonTitle","contactPersonNo","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $contactPersonName,$contactPersonTitle,$contactPersonNo, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateContactPerson()
{

    $contactPersonId = isset($_POST['contactPersonId']) ? $_POST['contactPersonId'] : '';

    if ($_POST['contactPersonName'] == '') {
        $contactPersonName = null;
    } else {
        $contactPersonName = trim($_POST['contactPersonName']);
    }
    if ($_POST['contactPersonTitle'] == '') {
        $contactPersonTitle = null;
    } else {
        $contactPersonTitle = trim($_POST['contactPersonTitle']);
    }
    if ($_POST['contactPersonNo'] == '') {
        $contactPersonNo = null;
    } else {
        $contactPersonNo = trim($_POST['contactPersonNo']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblContactPerson" SET "contactPersonName" =?  , "contactPersonTitle"=?, "contactPersonNo"=?,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "contactPersonId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $contactPersonName, $contactPersonTitle,$contactPersonNo,$active, $lastUpdatedBy, $lastUpdatedTime
            , $contactPersonId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion contactPerson
#region customer
public function actionCustomerSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
    $this->render("//site/Maintenance/CustomerSearch");
}

public function actionGetCustomerForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->viewbag['businessTypeList']=Yii::app()->formDao->getFormBusinessTypeActive();
    $this->render("//site/Maintenance/Customer");

}
public function actionGetCustomerForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $customerId = $param['customerId'];
    $this->viewbag['customer'] = Yii::app()->maintenanceDao->getCustomerById($customerId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->viewbag['businessTypeList']=Yii::app()->formDao->getFormBusinessTypeActive();
    $this->render("//site/Maintenance/Customer");

}
public function actionAjaxGetCustomerTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetCustomerSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetCustomerSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetCustomerRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertCustomer()
{

    if ($_POST['customerName'] == '') {
        $customerName = null;
    } else {
        $customerName = trim($_POST['customerName']);
    }
    if ($_POST['customerGroup'] == '') {
        $customerGroup = null;
    } else {
        $customerGroup = trim($_POST['customerGroup']);
    }
    if ($_POST['businessTypeId'] == '') {
        $businessTypeId = null;
    } else {
        $businessTypeId = trim($_POST['businessTypeId']);
    }
    if ($_POST['clpNetwork'] == '') {
        $clpNetwork = null;
    } else {
        $clpNetwork = trim($_POST['clpNetwork']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblCustomer" ("customerName","customerGroup","businessTypeId","clpNetwork","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $customerName,$customerGroup,$businessTypeId,$clpNetwork,$active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateCustomer()
{

    $customerId = isset($_POST['customerId']) ? $_POST['customerId'] : '';

    if ($_POST['customerName'] == '') {
        $customerName = null;
    } else {
        $customerName = trim($_POST['customerName']);
    }
    if ($_POST['customerGroup'] == '') {
        $customerGroup = null;
    } else {
        $customerGroup = trim($_POST['customerGroup']);
    }
    if ($_POST['businessTypeId'] == '') {
        $businessTypeId = null;
    } else {
        $businessTypeId = trim($_POST['businessTypeId']);
    }
    if ($_POST['clpNetwork'] == '') {
        $clpNetwork = null;
    } else {
        $clpNetwork = trim($_POST['clpNetwork']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblCustomer" SET "customerName" =?  , "customerGroup"=? ,"businessTypeId"=?,"clpNetwork"=?,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "customerId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $customerName, $customerGroup,$businessTypeId,$clpNetwork,$active, $lastUpdatedBy, $lastUpdatedTime
            , $customerId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion customer
#region majorAffectedElement
public function actionMajorAffectedElementSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/MajorAffectedElementSearch");
}

public function actionGetMajorAffectedElementForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/MajorAffectedElement");

}
public function actionGetMajorAffectedElementForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $majorAffectedElementId = $param['majorAffectedElementId'];
    $this->viewbag['majorAffectedElement'] = Yii::app()->maintenanceDao->getMajorAffectedElementById($majorAffectedElementId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/MajorAffectedElement");

}
public function actionAjaxGetMajorAffectedElementTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetMajorAffectedElementSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetMajorAffectedElementSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetMajorAffectedElementRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertMajorAffectedElement()
{

    if ($_POST['majorAffectedElementName'] == '') {
        $majorAffectedElementName = null;
    } else {
        $majorAffectedElementName = trim($_POST['majorAffectedElementName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblMajorAffectedElement" ("majorAffectedElementName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $result = $stmt->execute(array(
            $majorAffectedElementName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateMajorAffectedElement()
{

    $majorAffectedElementId = isset($_POST['majorAffectedElementId']) ? $_POST['majorAffectedElementId'] : '';

    if ($_POST['majorAffectedElementName'] == '') {
        $majorAffectedElementName = null;
    } else {
        $majorAffectedElementName = trim($_POST['majorAffectedElementName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblMajorAffectedElement" SET "majorAffectedElementName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "majorAffectedElementId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $majorAffectedElementName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $majorAffectedElementId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion majorAffectedElement
#region partyToBeCharged
public function actionPartyToBeChargedSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/PartyToBeChargedSearch");
}

public function actionGetPartyToBeChargedForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/PartyToBeCharged");

}
public function actionGetPartyToBeChargedForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $partyToBeChargedId = $param['partyToBeChargedId'];
    $this->viewbag['partyToBeCharged'] = Yii::app()->maintenanceDao->getPartyToBeChargedById($partyToBeChargedId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/PartyToBeCharged");

}
public function actionAjaxGetPartyToBeChargedTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetPartyToBeChargedSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetPartyToBeChargedSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetPartyToBeChargedRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertPartyToBeCharged()
{

    if ($_POST['partyToBeChargedName'] == '') {
        $partyToBeChargedName = null;
    } else {
        $partyToBeChargedName = trim($_POST['partyToBeChargedName']);
    }
    if ($_POST['showOrder'] == '') {
        $showOrder = null;
    } else {
        $showOrder = trim($_POST['showOrder']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblPartyToBeCharged" ("partyToBeChargedName","showOrder","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $partyToBeChargedName,$showOrder, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdatePartyToBeCharged()
{

    $partyToBeChargedId = isset($_POST['partyToBeChargedId']) ? $_POST['partyToBeChargedId'] : '';

    if ($_POST['partyToBeChargedName'] == '') {
        $partyToBeChargedName = null;
    } else {
        $partyToBeChargedName = trim($_POST['partyToBeChargedName']);
    }
    if ($_POST['showOrder'] == '') {
        $showOrder = null;
    } else {
        $showOrder = trim($_POST['showOrder']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblPartyToBeCharged" SET "partyToBeChargedName" =?  , "showOrder"=? ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "partyToBeChargedId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $partyToBeChargedName, $showOrder ,$active, $lastUpdatedBy, $lastUpdatedTime
            , $partyToBeChargedId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion partyToBeCharged
#region plantType
public function actionPlantTypeSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/PlantTypeSearch");
}

public function actionGetPlantTypeForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/PlantType");

}
public function actionGetPlantTypeForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $plantTypeId = $param['plantTypeId'];
    $this->viewbag['plantType'] = Yii::app()->maintenanceDao->getPlantTypeById($plantTypeId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/PlantType");

}
public function actionAjaxGetPlantTypeTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetPlantTypeSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetPlantTypeSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetPlantTypeRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertPlantType()
{

    if ($_POST['plantTypeName'] == '') {
        $plantTypeName = null;
    } else {
        $plantTypeName = trim($_POST['plantTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblPlantType" ("plantTypeName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $plantTypeName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdatePlantType()
{

    $plantTypeId = isset($_POST['plantTypeId']) ? $_POST['plantTypeId'] : '';

    if ($_POST['plantTypeName'] == '') {
        $plantTypeName = null;
    } else {
        $plantTypeName = trim($_POST['plantTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblPlantType" SET "plantTypeName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "plantTypeId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $plantTypeName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $plantTypeId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion plantType
#region serviceStatus
public function actionServiceStatusSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ServiceStatusSearch");
}

public function actionGetServiceStatusForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ServiceStatus");

}
public function actionGetServiceStatusForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $serviceStatusId = $param['serviceStatusId'];
    $this->viewbag['serviceStatus'] = Yii::app()->maintenanceDao->getServiceStatusById($serviceStatusId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ServiceStatus");

}
public function actionAjaxGetServiceStatusTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetServiceStatusSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetServiceStatusSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetServiceStatusRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertServiceStatus()
{

    if ($_POST['serviceStatusName'] == '') {
        $serviceStatusName = null;
    } else {
        $serviceStatusName = trim($_POST['serviceStatusName']);
    }
    if ($_POST['showOrder'] == '') {
        $showOrder = null;
    } else {
        $showOrder = trim($_POST['showOrder']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblServiceStatus" ("serviceStatusName","showOrder","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $serviceStatusName,$showOrder, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateServiceStatus()
{

    $serviceStatusId = isset($_POST['serviceStatusId']) ? $_POST['serviceStatusId'] : '';

    if ($_POST['serviceStatusName'] == '') {
        $serviceStatusName = null;
    } else {
        $serviceStatusName = trim($_POST['serviceStatusName']);
    }
    if ($_POST['showOrder'] == '') {
        $showOrder = null;
    } else {
        $showOrder = trim($_POST['showOrder']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblServiceStatus" SET "serviceStatusName" =? ,"showOrder"=? ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "serviceStatusId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $serviceStatusName,$showOrder, $active, $lastUpdatedBy, $lastUpdatedTime
            , $serviceStatusId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion serviceStatus
#region serviceType
public function actionServiceTypeSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ServiceTypeSearch");
}

public function actionGetServiceTypeForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ServiceType");

}
public function actionGetServiceTypeForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $serviceTypeId = $param['serviceTypeId'];
    $this->viewbag['serviceType'] = Yii::app()->maintenanceDao->getServiceTypeById($serviceTypeId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ServiceType");

}
public function actionAjaxGetServiceTypeTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetServiceTypeSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetServiceTypeSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetServiceTypeRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertServiceType()
{

    if ($_POST['serviceTypeName'] == '') {
        $serviceTypeName = null;
    } else {
        $serviceTypeName = trim($_POST['serviceTypeName']);
    }
    if ($_POST['showOrder'] == '') {
        $showOrder = null;
    } else {
        $showOrder = trim($_POST['showOrder']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblServiceType" ("serviceTypeName","showOrder","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $result = $stmt->execute(array(
            $serviceTypeName, $showOrder,$active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateServiceType()
{

    $serviceTypeId = isset($_POST['serviceTypeId']) ? $_POST['serviceTypeId'] : '';

    if ($_POST['serviceTypeName'] == '') {
        $serviceTypeName = null;
    } else {
        $serviceTypeName = trim($_POST['serviceTypeName']);
    }
    if ($_POST['showOrder'] == '') {
        $showOrder = null;
    } else {
        $showOrder = trim($_POST['showOrder']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblServiceType" SET "serviceTypeName" =? ,"showOrder"=? ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "serviceTypeId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $serviceTypeName, $showOrder,$active, $lastUpdatedBy, $lastUpdatedTime
            , $serviceTypeId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion serviceType
#region holiday
public function actionHolidaySearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/HolidaySearch");
}

public function actionGetHolidayForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/Holiday");
    
}
public function actionGetHolidayForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $holidayId = $param['holidayId'];
    $this->viewbag['holiday'] = Yii::app()->maintenanceDao->getHolidayById($holidayId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/Holiday");

}
public function actionAjaxGetHolidayTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetHolidaySearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetHolidaySearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetHolidayRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertHoliday()
{

    if ($_POST['txHolidayName'] == '') {
        $holidayName = null;
    } else {
        $holidayName = trim($_POST['txHolidayName']);
    }
    if ($_POST['txHolidayDate'] == '') {
        $holidayDate = null;
    } else {
        $holidayDate = trim($_POST['txHolidayDate']);
    }
    if ($_POST['txHolidayDescription'] == '') {
        $holidayDescription = null;
    } else {
        $holidayDescription = trim($_POST['txHolidayDescription']);
    }
    $active = isset($_POST['txActive']) ? trim($_POST['txActive']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = "INSERT INTO \"TblHoliday\" (\"holidayName\",\"holidayDate\",\"holidayDescription\",\"active\",\"createdBy\",\"createdTime\",\"lastUpdatedBy\",\"lastUpdatedTime\")";
        $sql = $sql . " VALUES (?,?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        
        $command = Yii::app()->db->createCommand($sql);

        $result = $command->execute(array(
            $holidayName, $holidayDate,$holidayDescription, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }

        $sql = "UPDATE \"TblEditRight\" set \"editRightLastEditTime\" = ? ";

        //$stmt = $pdo->prepare($sql);
        $command = Yii::app()->db->createCommand($sql);

        $command->execute(array(
            $lastUpdatedTime,
        )
        );


        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateHoliday()
{

    $holidayId = isset($_POST['txHolidayId']) ? $_POST['txHolidayId'] : '';

    if ($_POST['txHolidayName'] == '') {
        $holidayName = null;
    } else {
        $holidayName = trim($_POST['txHolidayName']);
    }
    if ($_POST['txHolidayDate'] == '') {
        $holidayDate = null;
    } else {
        $holidayDate = trim($_POST['txHolidayDate']);
    }
    if ($_POST['txHolidayDescription'] == '') {
        $holidayDescription = null;
    } else {
        $holidayDescription = trim($_POST['txHolidayDescription']);
    }
    $active = isset($_POST['txActive']) ? trim($_POST['txActive']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = "UPDATE \"TblHoliday\" SET \"holidayName\" =? ,\"holidayDate\" =?,\"holidayDescription\" =? ,\"active\" =? ,\"lastUpdatedBy\"=?,\"lastUpdatedTime\"=? ";
        $sql = $sql . " WHERE \"holidayId\" = ?";
        //$stmt = $pdo->prepare($sql);
        
        $stmt = Yii::app()->db->createCommand($sql);


        $stmt->execute(array(
            $holidayName, $holidayDate,$holidayDescription, $active, $lastUpdatedBy, $lastUpdatedTime
            , $holidayId));

        $sql = "UPDATE \"TblEditRight\" set \"editRightLastEditTime\" = ? ";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion holiday
#region config
public function actionConfigSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['configList'] = Yii::app()->maintenanceDao->getConfigAll();
    $this->render("//site/Maintenance/ConfigSearch");
}

public function actionGetConfigForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $configId = $param['configId'];
    $this->viewbag['config'] = Yii::app()->maintenanceDao->getConfigByConfigId($configId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/Config");

}
public function actionAjaxUpdateConfig()
{

    $configId = isset($_POST['txConfigId']) ? $_POST['txConfigId'] : '';

    if ($_POST['txConfigValue'] == '') {
        $configName = null;
    } else {
        $configName = trim($_POST['txConfigValue']);
    }
    if ($_POST['txConfigDescription'] == '') {
        $configDescription = null;
    } else {
        $configDescription = trim($_POST['txConfigDescription']);
    }
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = "UPDATE \"TblConfig\" SET \"configValue\" =?,\"configDescription\" =? ";
        $sql = $sql . " WHERE \"configId\" = ?";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $configName,$configDescription
            , $configId));

        $sql = "UPDATE \"TblEditRight\" set \"editRightLastEditTime\" = ? ";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion config
#region user
public function actionUserSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['userList'] = Yii::app()->maintenanceDao->getUserAll();
    $this->render("//site/Maintenance/UserSearch");
}
public function actionGetUserForNew()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/User");

}
public function actionGetUserForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $userId = $param['userId'];
    $this->viewbag['user'] = Yii::app()->maintenanceDao->getUserByUserId($userId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/User");

}
public function actionAjaxInsertUser()
{


    if ($_POST['txLoginId'] == '') {
        $loginId = null;
    } else {
        $loginId = trim($_POST['txLoginId']);
    } 
    if ($_POST['txPassword'] == '') {
        $pass = null;
    } else {
        $pass = trim($_POST['txPassword']);
    }
    if ($_POST['txRoleId'] == '') {
        $roleId = null;
    } else {
        $roleId = trim($_POST['txRoleId']);
    }
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = "INSERT INTO \"TblUser\" (\"loginId\",\"password\",\"roleId\") VALUES (?,?,?) ";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $loginId,$pass,$roleId
            ));

        $sql = "UPDATE \"TblEditRight\" set \"editRightLastEditTime\" = ? ";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();

    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateUser()
{

    $userId = isset($_POST['txUserId']) ? $_POST['txUserId'] : '';

 /*   if ($_POST['txLoginId'] == '') {
        $loginId = null;
    } else {
        $loginId = trim($_POST['txLoginId']);
    } */
    if ($_POST['txPassword'] == '') {
        $pass = null;
    } else {
        $pass = trim($_POST['txPassword']);
    }
    if ($_POST['txRoleId'] == '') {
        $roleId = null;
    } else {
        $roleId = trim($_POST['txRoleId']);
    }
    $active = $_POST['txActive'];
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = "UPDATE \"TblUser\" SET \"password\" =? , \"active\" =? , \"roleId\"=? ";
        $sql = $sql . " WHERE \"userId\" = ?";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $pass,$active,$roleId,$userId,
            ));

        $sql = "UPDATE \"TblEditRight\" set \"editRightLastEditTime\" = ? ";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion user
#region CostType
public function actionCostTypeSearch()
{
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
    $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
    $this->render("//site/Maintenance/CostTypeSearch");
}

public function actionGetCostTypeForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
    $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
    $this->render("//site/Maintenance/CostType");
    
}
public function actionGetCostTypeForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $costTypeId = $param['costTypeId'];
    $this->viewbag['countYearEdit'] = $countYear= $param['countYear'];
    $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
    $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
    $this->viewbag['costTypeList'] = Yii::app()->maintenanceDao->getCostTypeByYear($countYear);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/CostType");

}
public function actionAjaxGetCostTypeTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetCostTypeSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetCostTypeSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetCostTypeRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}
public function actionAjaxInsertCostType()
{
    $unitRate = isset($_POST['unitRate']) ? $_POST['unitRate'] : '';

    if ($_POST['countYear'] == '') {
        $countYear = null;
    } else {
        $countYear = trim($_POST['countYear']);
    }

    $active = 'Y';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblCostType" ("countYear","serviceTypeId","unitCost","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        foreach( $unitRate as $key => $u ){
            $result = $stmt->execute(array(
                $countYear, $key, $u, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
            ));
            if (!$result) {
                throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);
                
            }
        }

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateCostType()
{

    $unitRate = isset($_POST['unitRate']) ? $_POST['unitRate'] : '';
    if ($_POST['countYear'] == '') {
        $countYear = null;
    } else {
        $countYear = trim($_POST['countYear']);
    }

    $active = 'Y';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblCostType" SET "countYear" =? ,"serviceTypeId" =?,"unitCost" =? ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "countYear" = ? AND "serviceTypeId"=? ';
        $sqlInsert = 'INSERT INTO "TblCostType" ("countYear","serviceTypeId","unitCost","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sqlInsert = $sqlInsert . " VALUES (?,?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        //$stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert = Yii::app()->db->createCommand($sqlInsert);
        foreach( $unitRate as $key => $u ){
            $result = $stmt->execute(array(
                $countYear, $key, $u, $active, $lastUpdatedBy, $lastUpdatedTime
                , $countYear,$key));
            /*
            if (!$result) {
                throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);
                
            }
            */
            //if($stmt->rowCount()==0){
            if($result==0){
                $resultInsert = $stmtInsert->execute(array(
                    $countYear, $key, $u, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
                ));
                if (!$resultInsert) {
                    throw new Exception($stmtInsert->errorInfo()[2],$stmtInsert->errorInfo()[1]);
                    
                }
            }
        }

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion CostType
#region Budget
public function actionBudgetSearch()
{
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
    $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
    $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedActive();
    $this->render("//site/Maintenance/BudgetSearch");
}

public function actionGetBudgetForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
    $this->viewbag['countYearAvaliableForNew'] = Yii::app()->maintenanceDao->GetBudgetNewCountYear();
    $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
    $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedActive();
    $this->render("//site/Maintenance/Budget");
    
}
public function actionAjaxGetCostTypeByYear()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $countYear = $param['countYear'];
    $retJson = Yii::app()->maintenanceDao->getCostTypeByYear($countYear);

    echo json_encode($retJson);
    
}
public function actionGetBudgetForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $budgetId = $param['budgetId'];
    $this->viewbag['countYearEdit'] = $countYear= $param['countYear'];
    $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
    $this->viewbag['countYearAvaliableForNew'] = Yii::app()->maintenanceDao->GetBudgetNewCountYear();
    $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
    $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedActive();
    $this->viewbag['costTypeList'] = Yii::app()->maintenanceDao->getCostTypeByYear($countYear);
    $this->viewbag['budgetList'] = Yii::app()->maintenanceDao->getBudgetByYear($countYear);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/Budget");

}
public function actionAjaxGetBudgetTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetBudgetSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetBudgetSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetBudgetRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}
public function actionAjaxInsertBudget()
{
    $unitRate = isset($_POST['unitRate']) ? $_POST['unitRate'] : '';
    $Budget = isset($_POST['budget'])? $_POST['budget']:'';
    if ($_POST['countYear'] == '') {
        $countYear = null;
    } else {
        $countYear = trim($_POST['countYear']);
    }

    $active = 'Y';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
 
        foreach( $Budget as $key1 => $u ){
            $sql = "SELECT \"costTypeId\" FROM \"TblCostType\" WHERE \"serviceTypeId\" =".$key1." AND \"countYear\" = '".$countYear."'";
            //$result = $pdo->query($sql);
            $result = Yii::app()->db->createCommand($sql)->queryAll();;

            if (!$result) {
                throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);
                
            }
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $costTypeId = $row['costTypeId'];
            }
            foreach($u as $key2 => $val){
                $sql='INSERT INTO "TblBudget" ("partyToBeChargedId","costTypeId","budgetNumber","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime" )  VALUES (?,?,?,?,?,?,?,?);';
                //$stmt = $pdo->prepare($sql);   
                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array(
                    $key2,$costTypeId,$val,$active,$createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime
                ));
                if (!$result) {
                    throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);
                    
                }
            }
            

        }

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateBudget()
{
    $budget = isset($_POST['budget']) ? $_POST['budget'] : '';
    if ($_POST['countYear'] == '') {
        $countYear = null;
    } else {
        $countYear = trim($_POST['countYear']);
    }

    $active = 'Y';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

                //We start our transaction.
                //$pdo->beginTransaction();
                $transaction = Yii::app()->db->beginTransaction();

                $sqlUpdate = 'UPDATE "TblBudget" SET "budgetNumber" =? ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
                $sqlUpdate = $sqlUpdate . ' WHERE "partyToBeChargedId" = ? AND "costTypeId"=? ';
                $sqlInsert='INSERT INTO "TblBudget" ("partyToBeChargedId","costTypeId","budgetNumber","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime" )  VALUES (?,?,?,?,?,?,?,?);';
                //$stmtUpdate = $pdo->prepare($sqlUpdate);
                //$stmtInsert = $pdo->prepare($sqlInsert);
                $stmtUpdate = Yii::app()->db->createCommand($sqlUpdate);
                $stmtInsert = Yii::app()->db->createCommand($sqlInsert);

                foreach( $budget as $key1 => $u ){
                    $sqlSel = "SELECT \"costTypeId\" FROM \"TblCostType\" WHERE \"serviceTypeId\" =".$key1." AND \"countYear\" = '".$countYear."'";

                    /*
                    $resultSel = $pdo->query($sqlSel);
                    if (!$resultSel) {
                        throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);
                        
                    }
                    */

                    $sth = Yii::app()->db->createCommand($sqlSel);
                    $resultSel = $sth->queryAll();

                    //while ($row = $resultSel->fetch(PDO::FETCH_ASSOC)) {
                    foreach($resultSel as $row) { 
                        $costTypeId = $row['costTypeId'];
                    }
                    foreach($u as $key2 => $val){
                        $resultUpdate = $stmtUpdate->execute(array(
                             $val, $active, $lastUpdatedBy, $lastUpdatedTime
                            , $key2,$costTypeId));
                        if (!$resultUpdate) {
                            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);
                            
                        }
                        //if($stmtUpdate->rowCount()==0){
                        if($resultUpdate==0){
                            $resultInsert = $stmtInsert->execute(array(
                                $key2, $costTypeId, $val, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
                            ));
                            if (!$resultInsert) {
                                throw new Exception($stmtInsert->errorInfo()[2],$stmtInsert->errorInfo()[1]);
                                
                            }
                        }
                    }

                }

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion Budget
#region projectType
public function actionProjectTypeSearch()
{
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ProjectTypeSearch");
}

public function actionGetProjectTypeForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ProjectType");

}
public function actionGetProjectTypeForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $projectTypeId = $param['projectTypeId'];
    $this->viewbag['projectType'] = Yii::app()->maintenanceDao->getProjectTypeById($projectTypeId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ProjectType");

}
public function actionAjaxGetProjectTypeTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetProjectTypeSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetProjectTypeSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetProjectTypeRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertProjectType()
{

    if ($_POST['projectTypeName'] == '') {
        $projectTypeName = null;
    } else {
        $projectTypeName = trim($_POST['projectTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblProjectType" ("projectTypeName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $projectTypeName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateProjectType()
{

    $projectTypeId = isset($_POST['projectTypeId']) ? $_POST['projectTypeId'] : '';

    if ($_POST['projectTypeName'] == '') {
        $projectTypeName = null;
    } else {
        $projectTypeName = trim($_POST['projectTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblProjectType" SET "projectTypeName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "projectTypeId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $projectTypeName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $projectTypeId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion projectType
#region buildingType
public function actionBuildingTypeSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/BuildingTypeSearch");
}

public function actionGetBuildingTypeForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/BuildingType");

}
public function actionGetBuildingTypeForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $buildingTypeId = $param['buildingTypeId'];
    $this->viewbag['buildingType'] = Yii::app()->maintenanceDao->getBuildingTypeById($buildingTypeId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/BuildingType");

}
public function actionAjaxGetBuildingTypeTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetBuildingTypeSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetBuildingTypeSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetBuildingTypeRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertBuildingType()
{

    if ($_POST['buildingTypeName'] == '') {
        $buildingTypeName = null;
    } else {
        $buildingTypeName = trim($_POST['buildingTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblBuildingType" ("buildingTypeName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $buildingTypeName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateBuildingType()
{

    $buildingTypeId = isset($_POST['buildingTypeId']) ? $_POST['buildingTypeId'] : '';

    if ($_POST['buildingTypeName'] == '') {
        $buildingTypeName = null;
    } else {
        $buildingTypeName = trim($_POST['buildingTypeName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblBuildingType" SET "buildingTypeName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "buildingTypeId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $buildingTypeName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $buildingTypeId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion buildingType
#region projectRegion
public function actionProjectRegionSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ProjectRegionSearch");
}

public function actionGetProjectRegionForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ProjectRegion");

}
public function actionGetProjectRegionForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $projectRegionId = $param['projectRegionId'];
    $this->viewbag['projectRegion'] = Yii::app()->maintenanceDao->getProjectRegionById($projectRegionId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ProjectRegion");

}
public function actionAjaxGetProjectRegionTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetProjectRegionSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetProjectRegionSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetProjectRegionRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertProjectRegion()
{

    if ($_POST['projectRegionEngName'] == '') {
        $projectRegionEngName = null;
    } else {
        $projectRegionEngName = trim($_POST['projectRegionEngName']);
    }
    if ($_POST['projectRegionChiName'] == '') {
        $projectRegionChiName = null;
    } else {
        $projectRegionChiName = iconv("UTF-8", "big5",trim($_POST['projectRegionChiName']));
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblProjectRegion" ("projectRegionEngName","projectRegionChiName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $projectRegionEngName,$projectRegionChiName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateProjectRegion()
{

    $projectRegionId = isset($_POST['projectRegionId']) ? $_POST['projectRegionId'] : '';

    if ($_POST['projectRegionEngName'] == '') {
        $projectRegionEngName = null;
    } else {
        $projectRegionEngName = trim($_POST['projectRegionEngName']);
    }
    if ($_POST['projectRegionChiName'] == '') {
        $projectRegionChiName = null;
    } else {
        $projectRegionChiName = iconv("UTF-8", "big5",trim($_POST['projectRegionChiName']));
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblProjectRegion" SET "projectRegionEngName" =?,"projectRegionChiName"=?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "projectRegionId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $projectRegionEngName,$projectRegionChiName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $projectRegionId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion projectRegion
#region consultantCompany
public function actionConsultantCompanySearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/ConsultantCompanySearch");
}

public function actionGetConsultantCompanyForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/ConsultantCompany");

}
public function actionGetConsultantCompanyForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $consultantCompanyId = $param['consultantCompanyId'];
    $this->viewbag['consultantCompany'] = Yii::app()->maintenanceDao->getConsultantCompanyById($consultantCompanyId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/ConsultantCompany");

}
public function actionAjaxGetConsultantCompanyTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetConsultantCompanySearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetConsultantCompanySearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetConsultantCompanyRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertConsultantCompany()
{

    if ($_POST['consultantCompanyName'] == '') {
        $consultantCompanyName = null;
    } else {
        $consultantCompanyName = trim($_POST['consultantCompanyName']);
    }

    if ($_POST['consultantCompanyAddr1'] == '') {
        $consultantCompanyAddr1 = null;
    } else {
        $consultantCompanyAddr1 = trim($_POST['consultantCompanyAddr1']);
    }

    if ($_POST['consultantCompanyAddr2'] == '') {
        $consultantCompanyAddr2 = null;
    } else {
        $consultantCompanyAddr2 = trim($_POST['consultantCompanyAddr2']);
    }

    if ($_POST['consultantCompanyAddr3'] == '') {
        $consultantCompanyAddr3 = null;
    } else {
        $consultantCompanyAddr3 = trim($_POST['consultantCompanyAddr3']);
    }

    if ($_POST['consultantCompanyAddr4'] == '') {
        $consultantCompanyAddr4 = null;
    } else {
        $consultantCompanyAddr4 = trim($_POST['consultantCompanyAddr4']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblConsultantCompany" ("consultantCompanyName","addressLine1","addressLine2","addressLine3","addressLine4","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $consultantCompanyName, $consultantCompanyAddr1, $consultantCompanyAddr2, $consultantCompanyAddr3, $consultantCompanyAddr4, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateConsultantCompany()
{

    $consultantCompanyId = isset($_POST['consultantCompanyId']) ? $_POST['consultantCompanyId'] : '';

    if ($_POST['consultantCompanyName'] == '') {
        $consultantCompanyName = null;
    } else {
        $consultantCompanyName = trim($_POST['consultantCompanyName']);
    }

    if ($_POST['consultantCompanyAddr1'] == '') {
        $consultantCompanyAddr1 = null;
    } else {
        $consultantCompanyAddr1 = trim($_POST['consultantCompanyAddr1']);
    }

    if ($_POST['consultantCompanyAddr2'] == '') {
        $consultantCompanyAddr2 = null;
    } else {
        $consultantCompanyAddr2 = trim($_POST['consultantCompanyAddr2']);
    }

    if ($_POST['consultantCompanyAddr3'] == '') {
        $consultantCompanyAddr3 = null;
    } else {
        $consultantCompanyAddr3 = trim($_POST['consultantCompanyAddr3']);
    }

    if ($_POST['consultantCompanyAddr4'] == '') {
        $consultantCompanyAddr4 = null;
    } else {
        $consultantCompanyAddr4 = trim($_POST['consultantCompanyAddr4']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblConsultantCompany" SET "consultantCompanyName" =?,"addressLine1" =?,"addressLine2" =?,"addressLine3" =?,"addressLine4" =?,"active" =?,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "consultantCompanyId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $consultantCompanyName, $consultantCompanyAddr1, $consultantCompanyAddr2,
            $consultantCompanyAddr3, $consultantCompanyAddr4, $active, $lastUpdatedBy, $lastUpdatedTime
            , $consultantCompanyId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion consultantCompany
#region pqSensitiveLoad
public function actionPqSensitiveLoadSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/PqSensitiveLoadSearch");
}

public function actionGetPqSensitiveLoadForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->render("//site/Maintenance/PqSensitiveLoad");

}
public function actionGetPqSensitiveLoadForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $pqSensitiveLoadId = $param['pqSensitiveLoadId'];
    $this->viewbag['pqSensitiveLoad'] = Yii::app()->maintenanceDao->getPqSensitiveLoadById($pqSensitiveLoadId);
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/PqSensitiveLoad");

}
public function actionAjaxGetPqSensitiveLoadTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetPqSensitiveLoadSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetPqSensitiveLoadSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetPqSensitiveLoadRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertPqSensitiveLoad()
{

    if ($_POST['pqSensitiveLoadName'] == '') {
        $pqSensitiveLoadName = null;
    } else {
        $pqSensitiveLoadName = trim($_POST['pqSensitiveLoadName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblPqSensitiveLoad" ("pqSensitiveLoadName","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $result = $stmt->execute(array(
            $pqSensitiveLoadName, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdatePqSensitiveLoad()
{

    $pqSensitiveLoadId = isset($_POST['pqSensitiveLoadId']) ? $_POST['pqSensitiveLoadId'] : '';

    if ($_POST['pqSensitiveLoadName'] == '') {
        $pqSensitiveLoadName = null;
    } else {
        $pqSensitiveLoadName = trim($_POST['pqSensitiveLoadName']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblPqSensitiveLoad" SET "pqSensitiveLoadName" =?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "pqSensitiveLoadId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $pqSensitiveLoadName, $active, $lastUpdatedBy, $lastUpdatedTime
            , $pqSensitiveLoadId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion pqSensitiveLoad
#region consultant
public function actionConsultantSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
    
    $this->render("//site/Maintenance/ConsultantSearch");
}

public function actionGetConsultantForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';

    $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyActive();

    $this->render("//site/Maintenance/Consultant");

}
public function actionGetConsultantForUpdate()
{
    $this->layout = false;
    $this->viewbag['mode']='update';

    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $consultantId = $param['consultantId'];

    $this->viewbag['consultant'] = Yii::app()->maintenanceDao->getConsultantById($consultantId);
    $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyActive();
    
    $this->render("//site/Maintenance/Consultant");

}
public function actionAjaxGetConsultantTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetConsultantSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetConsultantSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetConsultantRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertConsultant()
{

    if ($_POST['consultantName'] == '') {
        $consultantName = null;
    } else {
        $consultantName = trim($_POST['consultantName']);
    }
    if ($_POST['consultantCompanyId'] == '') {
        $consultantCompanyId = null;
    } else {
        $consultantCompanyId = trim($_POST['consultantCompanyId']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblConsultant" ("consultantName","consultantCompanyId","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $result = $stmt->execute(array(
            $consultantName,$consultantCompanyId, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateConsultant()
{

    $consultantId = isset($_POST['consultantId']) ? $_POST['consultantId'] : '';

    if ($_POST['consultantName'] == '') {
        $consultantName = null;
    } else {
        $consultantName = trim($_POST['consultantName']);
    }
    if ($_POST['consultantCompanyId'] == '') {
        $consultantCompanyId = null;
    } else {
        $consultantCompanyId = trim($_POST['consultantCompanyId']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblConsultant" SET "consultantName" =?,"consultantCompanyId"=?  ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "consultantId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $consultantName,$consultantCompanyId, $active, $lastUpdatedBy, $lastUpdatedTime
            , $consultantId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion consultant
#region regionPlanner
public function actionRegionPlannerSearch()
{
    Yii::app()->commonUtil->getEditBtnRight();
    $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();

    $this->render("//site/Maintenance/RegionPlannerSearch");
}

public function actionGetRegionPlannerForNew()
{

    $this->layout = false;
    $this->viewbag['mode']='new';
    $this->viewbag['region']= Yii::app()->formDao->getPlanningAheadRegionPlannerRegionActive();
    $this->render("//site/Maintenance/RegionPlanner");

}
public function actionGetRegionPlannerForUpdate()
{
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    parse_str(parse_url($url, PHP_URL_QUERY), $param);
    $regionPlannerId = $param['regionPlannerId'];
    $this->viewbag['regionPlanner'] = Yii::app()->maintenanceDao->getRegionPlannerById($regionPlannerId);
    $this->viewbag['region']= Yii::app()->formDao->getPlanningAheadRegionPlannerRegionActive();
    $this->layout = false;
    $this->viewbag['mode']='update';
    $this->render("//site/Maintenance/RegionPlanner");

}
public function actionAjaxGetRegionPlannerTable()
{
    $param = json_decode(file_get_contents('php://input'), true);

    $searchParam = json_decode($param['searchParam'], true);
    $start = $param['start'];
    $length = $param['length'];
    $orderColumn = $param['order'][0]['column'];
    $orderDir = $param['order'][0]['dir'];
    $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

    $List = Yii::app()->maintenanceDao->GetRegionPlannerSearchByPage($searchParam, $start, $length, $order);

    $recordFiltered = Yii::app()->maintenanceDao->GetRegionPlannerSearchResultCount($searchParam);

    $totalCount = Yii::app()->maintenanceDao->GetRegionPlannerRecordCount();

    $result = array('draw' => $param['draw'],
        'data' => $List,
        'recordsFiltered' => $recordFiltered,
        'recordsTotal' => $totalCount);

    echo json_encode($result);

}


public function actionAjaxInsertRegionPlanner()
{

    if ($_POST['regionPlannerName'] == '') {
        $regionPlannerName = null;
    } else {
        $regionPlannerName = trim($_POST['regionPlannerName']);
    }
    if ($_POST['region'] == '') {
        $region = null;
    } else {
        $region = trim($_POST['region']);
    }
    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $createdBy = Yii::app()->session['tblUserDo']['username'];
    $createdTime = date("Y-m-d H:i");
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");
    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'INSERT INTO "TblRegionPlanner" ("regionPlannerName","region","active","createdBy","createdTime","lastUpdatedBy","lastUpdatedTime")';
        $sql = $sql . " VALUES (?,?,?,?,?,?,?)";
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $result = $stmt->execute(array(
            $regionPlannerName,$region, $active, $createdBy, $createdTime, $lastUpdatedBy, $lastUpdatedTime,
        ));
        if (!$result) {
            throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

        }
        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (Exception $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
public function actionAjaxUpdateRegionPlanner()
{

    $regionPlannerId = isset($_POST['regionPlannerId']) ? $_POST['regionPlannerId'] : '';

    if ($_POST['regionPlannerName'] == '') {
        $regionPlannerName = null;
    } else {
        $regionPlannerName = trim($_POST['regionPlannerName']);
    }
    if ($_POST['region'] == '') {
        $region = null;
    } else {
        $region = trim($_POST['region']);
    }

    $active = isset($_POST['active']) ? trim($_POST['active']) : '';
    $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
    $lastUpdatedTime = date("Y-m-d H:i");

    $retJson['status'] = 'OK';

    try {

        //We start our transaction.
        //$pdo->beginTransaction();
        $transaction = Yii::app()->db->beginTransaction();

        //Query 1: Attempt to insert the payment record into our database.
        $sql = 'UPDATE "TblRegionPlanner" SET "regionPlannerName" =? ,"region"=? ,"active" =? ,"lastUpdatedBy"=?,"lastUpdatedTime"=? ';
        $sql = $sql . ' WHERE "regionPlannerId" = ?';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);

        $stmt->execute(array(
            $regionPlannerName, $region, $active, $lastUpdatedBy, $lastUpdatedTime
            , $regionPlannerId));

        $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
        //$stmt = $pdo->prepare($sql);
        $stmt = Yii::app()->db->createCommand($sql);
        $stmt->execute(array(
            $lastUpdatedTime,
        )
        );

        //We've got this far without an exception, so commit the changes.
        //$pdo->commit();
        $transaction->commit();
    }
    //Our catch block will handle any exceptions that are thrown.
     catch (PDOException $e) {

        //An exception has occured, which means that one of our database queries
        //failed.
        //Print out the error message.
        $retJson['status'] = 'NOTOK';
        $retJson['retMessage'] = $e->getMessage();
        //Rollback the transaction.
        //$pdo->rollBack();
        $transaction->rollBack();
    }

    echo json_encode($retJson);
}
#endregion regionPlanner
public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }

        }
    }
}
