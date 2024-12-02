<?php
class Kilepes_Model
{
    public function get_data()
    {
        $retData['eredmény'] = "OK";
        $retData['uzenet'] = "Viszontlátásra kedves ".$_SESSION['userlastname']." ".$_SESSION['userfirstname']."!";
        $_SESSION['userid'] =  0;
        $_SESSION['userlastname'] =  "";
        $_SESSION['userfirstname'] =  "";
        $_SESSION['userlevel'] = "100"; // Alapértelmezett jogosultság látogatónak
        Menu::setMenu();
        return $retData;
    }
}
?>
