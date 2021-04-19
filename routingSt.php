<?php 
	if(isset($_GET['menu'])){
        switch($_GET['menu']){
            case 'MyVacants':
                include_once('ModuleStudent/listMyVacants.php');
            break;   
            case 'vacants':
                include_once('ModuleStudent/listVacants.php');
            break;
            case 'EditCV':
                include_once('ModuleStudent/editCurriculumVitae.php');
            break;
            default:
                include_once('ModuleStudent/listMyVacants.php');
            break;

        }
    }else{
        include_once('ModuleStudent/listMyVacants.php');
    }
?>