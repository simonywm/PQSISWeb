<?php

class RoleControlFilter extends CFilter
{
    protected function preFilter($filterChain)
    {

        $editRight = Yii::app()->formDao->getEditRight();
        $userModel = Yii::app()->session['tblUserDo'];
        $user = Yii::app()->commonUtil->getUser($userModel['userId']);

        if ($user['roleId']!=1) {
            echo
            '<script>
			alert("You don\'t have the Right to Access this page");
			</script>';
            return false;

        }
        return true;

    }

    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }
}
