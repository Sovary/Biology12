<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'ExerciseOld';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Old
$route["show.php"] = "ExerciseOld/getExerciseById_Controller";
$route["index.php"] = "ExerciseOld/index";

$route["api/v1/checkupdate"] = 'api/AppInfo/getVersion_APIController';

//1.4.18.1
$route["api/v1/forsearch"] = 'api/DataForSearch/getDataForSearch_APIController';
$route["api/v1/filter"] = 'api/exercise/getExercisesByFilter_APIController';

//Exercise
$route["api/v1/exercise"] = 'api/exercise/getExercisesLatest_APIController';
$route["api/v1/exercise/(:num)"] = 'api/exercise/getExerciseById_APIController';
$route["api/v1/exercises"] = 'api/exercise/getExercisesBatchById_APIController';


//Category
$route["api/v1/cate"] = 'api/category/getCategories_APIController';
$route["api/v1/cate/(:num)"] = 'api/exercise/getExercisesByCategoryId_APIController';

//staticPage
$route["privacy"] = 'ExerciseOld/policy';
$route["termcondition"] = 'ExerciseOld/termCondition';