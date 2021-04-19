<?php 
	if(isset($_GET['menu'])){
        switch($_GET['menu']){
            case 'stats':
                include_once('ModuleCompany/listStats.php');
            break;
            case 'vacants':
                include_once('ModuleCompany/listVacants.php');
            break;
            case 'aspirants':
                include_once('ModuleCompany/listAspirants.php');
            break;
            case 'editProfile':
                include_once('ModuleCompany/editCompany.php');
            break;
            default:
                include_once('ModuleCompany/listStats.php');
            break;

        }
    }else{
        include_once('ModuleCompany/listStats.php');
    }
?>