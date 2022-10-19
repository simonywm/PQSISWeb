<?php

class EditControlFilter extends CFilter
{
    protected function preFilter($filterChain)
    {

        $editRight = Yii::app()->formDao->getEditRight();
        $userModel = Yii::app()->session['tblUserDo'];
        if (!($userModel['userId'] == $editRight['editRightUserId'] && $editRight['editRightOnUse'] = true)) {
            echo
            '<script>
			alert("You don\'t have Edit Right");
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
