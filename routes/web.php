<?php

use App\Http\Controllers\ApprovalMaatrixController;
use App\Http\Controllers\Asset\ApprovalController;
use App\Http\Controllers\Asset\DistributionAssetController;
use App\Http\Controllers\Asset\MasterAssetController;
use App\Http\Controllers\Asset\ServiceAssetController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\HoldRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\inv\Master\MasterBrandController;
use App\Http\Controllers\inv\Master\MasterCategoryInvController;
use App\Http\Controllers\inv\Master\MasterProductInvController;
use App\Http\Controllers\Inv\Master\MasterTypeInvController;
use App\Http\Controllers\ManualWOController;
use App\Http\Controllers\MasterAspekController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterDepartementController;
use App\Http\Controllers\MasterJabatanController;
use App\Http\Controllers\MasterKantorController;
use App\Http\Controllers\MasterModuleController;
use App\Http\Controllers\MasterPriorityController;
use App\Http\Controllers\MasterSystemController;
use App\Http\Controllers\MasterTeamController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\Opex\Setting\OpexTeamController;
use App\Http\Controllers\Opex\Setting\OpexTimelineController;
use App\Http\Controllers\OPX\MasterCategoryOPXController;
use App\Http\Controllers\OPX\MasterProductOPXController;
use App\Http\Controllers\OPX\MonitoringOPXController;
use App\Http\Controllers\ProblemTypeController;
use App\Http\Controllers\ReportKPIController;
use App\Http\Controllers\RFP\RFPDetailProjectController;
use App\Http\Controllers\RFPController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Setting\MasterRoomController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\UpdateSystemController;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VCardController;
use App\Http\Controllers\WorkOrderController;
use App\Models\OPX\MasterProductOPX;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::group(['middleware' => ['auth']], function() {

    Route::group(['middleware' => ['permission:view-dashboard']], function () {
        Route::get('/', [HomeController::class, 'index'])->name('/dashboard');
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    });
    Route::group(['middleware' => ['permission:view-menus']], function () {
        Route::get('menus', [MenusController::class, 'index'])->name('menus');
    });
    Route::group(['middleware' => ['permission:view-role_permission']], function () {
        Route::get('role_permission', [RolePermissionController::class, 'index'])->name('role_permission');
    });
    Route::group(['middleware' => ['permission:view-user_setting']], function () {
        Route::get('user_setting', [UserController::class, 'index'])->name('user_setting');
    });

    Route::group(['middleware' => ['permission:view-user_access']], function () {
        Route::get('user_access', [UserAccessController::class, 'index'])->name('user_access');
    });
    Route::group(['middleware' => ['permission:view-master_priority']], function () {
        Route::get('master_priority', [MasterPriorityController::class, 'index'])->name('master_priority');
    });
    Route::group(['middleware' => ['permission:view-setting_password']], function () {
        Route::get('setting_password', [SettingController::class, 'index'])->name('setting_password');
    });
    Route::group(['middleware' => ['permission:view-master_kantor']], function () {
        Route::get('master_kantor', [MasterKantorController::class, 'index'])->name('master_kantor');
    });
    Route::group(['middleware' => ['permission:view-work_order_list']], function () {
        Route::get('work_order_list', [WorkOrderController::class, 'index'])->name('work_order_list');
    });
    Route::group(['middleware' => ['permission:view-master_category']], function () {
        Route::get('master_category', [MasterCategoryController::class, 'index'])->name('master_category');
    });
    Route::group(['middleware' => ['permission:view-problem_type']], function () {
        Route::get('problem_type', [ProblemTypeController::class, 'index'])->name('problem_type');
    });
    Route::group(['middleware' => ['permission:view-master_departement']], function () {
        Route::get('master_departement', [MasterDepartementController::class, 'index'])->name('master_departement');
    });
    Route::group(['middleware' => ['permission:view-master_jabatan']], function () {
        Route::get('master_jabatan', [MasterJabatanController::class, 'index'])->name('master_jabatan');
    });
    Route::group(['middleware' => ['permission:view-work_order_assignment']], function () {
        Route::get('work_order_assignment', [AssignmentController::class, 'index'])->name('work_order_assignment');
    });
    Route::group(['middleware' => ['permission:view-report_kpi']], function () {
        Route::get('report_kpi', [ReportKPIController::class, 'index'])->name('report_kpi');
    });
    Route::group(['middleware' => ['permission:view-ict_wo']], function () {
        Route::get('ict_wo', [ManualWOController::class, 'index'])->name('ict_wo');
    });
    Route::group(['middleware' => ['permission:view-masterTeamProject']], function () {
        Route::get('masterTeamProject', [MasterTeamController::class, 'index'])->name('masterTeamProject');
    });
    Route::group(['middleware' => ['permission:view-rfp_transaction']], function () {
        Route::get('rfp_transaction', [RFPController::class, 'index'])->name('rfp_transaction');
    });
    Route::group(['middleware' => ['permission:view-master_product_inv']], function () {
        Route::get('master_product_inv', [MasterProductInvController::class, 'index'])->name('master_product_inv');
    });
    Route::group(['middleware' => ['permission:view-monitoring_opex']], function () {
        Route::get('monitoring_opex', [MonitoringOPXController::class, 'index'])->name('monitoring_opex');
    });
    Route::group(['middleware' => ['permission:view-master_category_opex']], function () {
        Route::get('master_category_opex', [MasterCategoryOPXController::class, 'index'])->name('master_category_opex');
    });
    Route::group(['middleware' => ['permission:view-master_product_opex']], function () {
        Route::get('master_product_opex', [MasterProductOPXController::class, 'index'])->name('master_product_opex');
    });
    Route::group(['middleware' => ['permission:view-master_asset']], function () {
        Route::get('master_asset', [MasterAssetController::class, 'index'])->name('master_product_opex');
    });
    Route::group(['middleware' => ['permission:view-master_room']], function () {
        Route::get('master_room', [MasterRoomController::class, 'index'])->name('master_room');
    });
    // Menus
    Route::post('save_menus', [MenusController::class, 'save_menus'])->name('save_menus');
    Route::get('get_menus', [MenusController::class, 'get_menus'])->name('get_menus');
    Route::get('get_menus_name', [MenusController::class, 'get_menus_name'])->name('get_menus_name');
    Route::post('save_submenus', [MenusController::class, 'save_submenus'])->name('save_submenus');
    Route::get('get_submenus', [MenusController::class, 'get_submenus'])->name('get_submenus');
    Route::get('getDetailMenus', [MenusController::class, 'getDetailMenus'])->name('getDetailMenus');
    Route::post('update_menus', [MenusController::class, 'update_menus'])->name('update_menus');
    Route::get('deleteMenus', [MenusController::class, 'deleteMenus'])->name('deleteMenus');
    Route::get('deleteSubmenus', [MenusController::class, 'deleteSubmenus'])->name('deleteSubmenus');
    Route::get('getDetailSubmenus', [MenusController::class, 'getDetailSubmenus'])->name('getDetailSubmenus');
    Route::post('update_submenus', [MenusController::class, 'update_submenus'])->name('update_submenus');
    // Role & Permsision
    Route::get('get_role', [RolePermissionController::class, 'get_role'])->name('get_role');
    Route::get('get_permission', [RolePermissionController::class, 'get_permission'])->name('get_permission');
    Route::post('save_role', [RolePermissionController::class, 'save_role'])->name('save_role');
    Route::get('getDetailRoles', [RolePermissionController::class, 'getDetailRoles'])->name('getDetailRoles');
    Route::post('update_role', [RolePermissionController::class, 'update_role'])->name('update_role');
    Route::get('delete_role', [RolePermissionController::class, 'delete_role'])->name('delete_role');
    Route::get('permission_menus_name', [RolePermissionController::class, 'permission_menus_name'])->name('permission_menus_name');
    Route::post('save_permission', [RolePermissionController::class, 'save_permission'])->name('save_permission');
    Route::get('delete_permission', [RolePermissionController::class, 'delete_permission'])->name('delete_permission');
    // User Access
    Route::get('get_role_user', [UserAccessController::class, 'get_role_user'])->name('get_role_user');
    Route::get('get_username', [UserAccessController::class, 'get_username'])->name('get_username');
    Route::post('save_role_user', [UserAccessController::class, 'save_role_user'])->name('save_role_user');
    Route::get('detail_role_user', [UserAccessController::class, 'detail_role_user'])->name('detail_role_user');
    Route::post('update_roles_user', [UserAccessController::class, 'update_roles_user'])->name('update_roles_user');
    Route::get('get_permisssion', [UserAccessController::class, 'get_permisssion'])->name('get_permisssion');
    Route::post('add_role_permission', [UserAccessController::class, 'add_role_permission'])->name('add_role_permission');
    Route::get('delete_role_permission', [UserAccessController::class, 'delete_role_permission'])->name('delete_role_permission');

    // Setting User
    Route::post('update_status_user', [UserController::class, 'update_status_user'])->name('update_status_user');
    Route::get('detail_user', [UserController::class, 'detail_user'])->name('detail_user');
    Route::post('update_user_setting', [UserController::class, 'update_user_setting'])->name('update_user_setting');
    Route::post('updateJoinDateUser', [UserController::class, 'updateJoinDateUser'])->name('updateJoinDateUser');
    Route::post('durationRevision', [UserController::class, 'durationRevision'])->name('durationRevision');


    // Setting
    Route::post('update_user', [SettingController::class, 'update_user'])->name('update_user');
    Route::post('change_password', [SettingController::class, 'change_password'])->name('change_password');

    // Master Kantor 
    Route::get('get_kantor', [MasterKantorController::class, 'get_kantor'])->name('get_kantor');
    Route::get('get_province', [MasterKantorController::class, 'get_province'])->name('get_province');
    Route::get('get_regency', [MasterKantorController::class, 'get_regency'])->name('get_regency');
    Route::get('get_district', [MasterKantorController::class, 'get_district'])->name('get_district');
    Route::get('get_village', [MasterKantorController::class, 'get_village'])->name('get_village');
    Route::get('get_postal_code', [MasterKantorController::class, 'get_postal_code'])->name('get_postal_code');
    Route::post('save_kantor', [MasterKantorController::class, 'save_kantor'])->name('save_kantor');
    Route::post('update_status_kantor', [MasterKantorController::class, 'update_status_kantor'])->name('update_status_kantor');
    Route::get('detail_kantor', [MasterKantorController::class, 'detail_kantor'])->name('detail_kantor');
    Route::post('update_kantor', [MasterKantorController::class, 'update_kantor'])->name('update_kantor');
    Route::get('get_kantor_name', [MasterKantorController::class, 'get_kantor_name'])->name('get_kantor_name');

    // Master Category
    Route::post('save_categories', [MasterCategoryController::class, 'save_categories'])->name('save_categories');
    Route::get('get_categories', [MasterCategoryController::class, 'get_categories'])->name('get_categories');
    Route::post('update_status_categories', [MasterCategoryController::class, 'update_status_categories'])->name('update_status_categories');
    Route::get('detail_categories', [MasterCategoryController::class, 'detail_categories'])->name('detail_categories');
    Route::post('update_categories', [MasterCategoryController::class, 'update_categories'])->name('update_categories');
    Route::get('get_categories_id', [MasterCategoryController::class, 'get_categories_id'])->name('get_categories_id');

    // Master Problem Type
    Route::get('get_problem_type', [ProblemTypeController::class, 'get_problem_type'])->name('get_problem_type');
    Route::get('get_problem_type_name', [ProblemTypeController::class, 'get_problem_type_name'])->name('get_problem_type_name');
    Route::post('save_problem_type', [ProblemTypeController::class, 'save_problem_type'])->name('save_problem_type');
    Route::post('update_status_problem', [ProblemTypeController::class, 'update_status_problem'])->name('update_status_problem');
    Route::get('detail_problems', [ProblemTypeController::class, 'detail_problems'])->name('detail_problems');
    Route::post('update_problem', [ProblemTypeController::class, 'update_problem'])->name('update_problem');

    // Master Departement
    Route::get('get_departement', [MasterDepartementController::class, 'get_departement'])->name('get_departement');
    Route::post('save_departement', [MasterDepartementController::class, 'save_departement'])->name('save_departement');
    Route::post('update_status_departement', [MasterDepartementController::class, 'update_status_departement'])->name('update_status_departement');
    Route::get('detail_departement', [MasterDepartementController::class, 'detail_departement'])->name('detail_departement');
    Route::get('get_departement_name', [MasterDepartementController::class, 'get_departement_name'])->name('get_departement_name');
    Route::get('get_departement_name_ict', [MasterDepartementController::class, 'get_departement_name_ict'])->name('get_departement_name_ict');
    Route::post('update_departement', [MasterDepartementController::class, 'update_departement'])->name('update_departement');

    //Master jabatan

    Route::get('get_jabatan', [MasterJabatanController::class, 'get_jabatan'])->name('get_jabatan');
    Route::get('get_jabatan_name', [MasterJabatanController::class, 'get_jabatan_name'])->name('get_jabatan_name');
    Route::get('detail_jabatan', [MasterJabatanController::class, 'detail_jabatan'])->name('detail_jabatan');
    Route::post('save_jabatan', [MasterJabatanController::class, 'save_jabatan'])->name('save_jabatan');
    Route::post('update_status_jabatan', [MasterJabatanController::class, 'update_status_jabatan'])->name('update_status_jabatan');
    Route::post('update_jabatan', [MasterJabatanController::class, 'update_jabatan'])->name('update_jabatan');

    // WO List
    Route::get('get_work_order_list', [WorkOrderController::class, 'get_work_order_list'])->name('get_work_order_list');
    Route::get('getDisscuss', [WorkOrderController::class, 'getDisscuss'])->name('getDisscuss'); 
    Route::post('sendDisscuss', [WorkOrderController::class, 'sendDisscuss'])->name('sendDisscuss'); 
    Route::get('get_categories_name', [WorkOrderController::class, 'get_categories_name'])->name('get_categories_name');
    Route::post('save_wo', [WorkOrderController::class, 'save_wo'])->name('save_wo');
    Route::get('get_wo_log', [WorkOrderController::class, 'get_wo_log'])->name('get_wo_log');
    Route::post('approve_assignment_pic', [WorkOrderController::class, 'approve_assignment_pic'])->name('approve_assignment_pic');
    Route::post('manual_approve', [WorkOrderController::class, 'manual_approve'])->name('manual_approve');
    Route::post('rating_pic', [WorkOrderController::class, 'rating_pic'])->name('rating_pic');
    Route::get('getStepper', [WorkOrderController::class, 'getStepper'])->name('getStepper');
    Route::post('holdProgressRequest', [WorkOrderController::class, 'holdProgressRequest'])->name('holdProgressRequest');
    Route::post('revisiDuration', [WorkOrderController::class, 'revisiDuration'])->name('revisiDuration');
    // Report Work Order
    Route::get('printWO/{from}/{date}/{officeFilter}/{statusFilter}/{userId}',[WorkOrderController::class, 'printWO']);
    Route::get('reportDetailWO/{id}',[WorkOrderController::class, 'reportDetailWO']);
    // Report Work Order

    Route::post('manual_wo', [WorkOrderController::class, 'manual_wo'])->name('manual_wo');

    Route::get('get_assignment', [AssignmentController::class, 'get_assignment'])->name('get_assignment');
    Route::get('detail_wo', [AssignmentController::class, 'detail_wo'])->name('detail_wo');
    Route::post('approve_assignment', [AssignmentController::class, 'approve_assignment'])->name('approve_assignment');
    Route::post('updateLevel', [AssignmentController::class, 'updateLevel'])->name('updateLevel');

    // ICT Ticket

    Route::post('manual_wo', [ManualWOController::class, 'manual_wo'])->name('manual_wo');
    // Home 
    Route::get('get_wo_summary', [HomeController::class, 'get_wo_summary'])->name('get_wo_summary');
    Route::get('logRating', [HomeController::class, 'logRating'])->name('logRating');
    Route::get('getNotification', [HomeController::class, 'getNotification'])->name('getNotification');
    Route::post('updateNotif', [HomeController::class, 'updateNotif'])->name('updateNotif');
    Route::get('getRankingFilter', [HomeController::class, 'getRankingFilter'])->name('getRankingFilter');
    Route::get('getLevel2Filter', [HomeController::class, 'getLevel2Filter'])->name('getLevel2Filter');
    Route::get('percentageType', [HomeController::class, 'percentageType'])->name('percentageType');
    Route::get('getWorkOrderByStatus', [HomeController::class, 'getWorkOrderByStatus'])->name('getWorkOrderByStatus');

    // Master Priority
    Route::get('getPriority', [MasterPriorityController::class, 'getPriority'])->name('getPriority');
    Route::post('addPriority', [MasterPriorityController::class, 'addPriority'])->name('addPriority');
    Route::get('getPriorityDetail', [MasterPriorityController::class, 'getPriorityDetail'])->name('getPriorityDetail');
    Route::post('updatePriority', [MasterPriorityController::class, 'updatePriority'])->name('updatePriority');

    // KPIUSer
    Route::get('getKPIUser', [ReportKPIController::class, 'getKPIUser'])->name('getKPIUser');
    Route::get('getUserSupport', [ReportKPIController::class, 'getUserSupport'])->name('getUserSupport');
    Route::get('getKPIUserDetail', [ReportKPIController::class, 'getKPIUserDetail'])->name('getKPIUserDetail');
    Route::get('printKPIUser', [ReportKPIController::class, 'printKPIUser'])->name('printKPIUser');
    Route::get('printKPIUser/{dateFilter}/{id}',[ReportKPIController::class, 'printKPIUser']);
  
    
    // MasterTeam
    Route::get('getMasterTeam', [MasterTeamController::class, 'getMasterTeam'])->name('getMasterTeam');
    Route::get('getOpexTeam', [MasterTeamController::class, 'getOpexTeam'])->name('getOpexTeam');
    Route::post('addMasterTeam', [MasterTeamController::class, 'addMasterTeam'])->name('addMasterTeam');
    Route::get('getMasterTeamDetail', [MasterTeamController::class, 'getMasterTeamDetail'])->name('getMasterTeamDetail');
    Route::get('getDetailTeam', [MasterTeamController::class, 'getDetailTeam'])->name('getDetailTeam');
    Route::post('updateMasterTeam', [MasterTeamController::class, 'updateMasterTeam'])->name('updateMasterTeam');
    Route::post('addDetailTeam', [MasterTeamController::class, 'addDetailTeam'])->name('addDetailTeam');
    Route::post('updateDetailTeam', [MasterTeamController::class, 'updateDetailTeam'])->name('updateDetailTeam');
    
    // 
    Route::get('getrfpTransaction', [RFPController::class, 'getrfpTransaction'])->name('getrfpTransaction');
    Route::post('saveRFPTransaction', [RFPController::class, 'saveRFPTransaction'])->name('saveRFPTransaction');
    Route::get('getrfpTransactionDetail', [RFPController::class, 'getrfpTransactionDetail'])->name('getrfpTransactionDetail');
    Route::post('saveRFPDetail', [RFPController::class, 'saveRFPDetail'])->name('saveRFPDetail');
    Route::get('getRFPDetail', [RFPController::class, 'getRFPDetail'])->name('getRFPDetail');
    Route::get('editRFPDetail', [RFPController::class, 'editRFPDetail'])->name('editRFPDetail');
    Route::post('saveRFPSubDetail', [RFPController::class, 'saveRFPSubDetail'])->name('saveRFPSubDetail');
    Route::get('getRFPSubDetail', [RFPController::class, 'getRFPSubDetail'])->name('getRFPSubDetail');
    Route::get('getLogSubDetailRFP', [RFPController::class, 'getLogSubDetailRFP'])->name('getLogSubDetailRFP');
    Route::post('updateRFPDetail', [RFPController::class, 'updateRFPDetail'])->name('updateRFPDetail');
    Route::post('updateMasterRFP', [RFPController::class, 'updateMasterRFP'])->name('updateMasterRFP');
    Route::get('getSubDetailRFP', [RFPController::class, 'getSubDetailRFP'])->name('getSubDetailRFP');
    Route::post('updateRFPSubDetail', [RFPController::class, 'updateRFPSubDetail'])->name('updateRFPSubDetail');
    Route::post('updateRFPSubDetailProgress', [RFPController::class, 'updateRFPSubDetailProgress'])->name('updateRFPSubDetailProgress');

    // Hold Request Page
    Route::get('hold_request', [HoldRequestController::class, 'index'])->name('hold_request');
    Route::get('getHoldRequest', [HoldRequestController::class, 'getHoldRequest'])->name('getHoldRequest');
    Route::get('getWOActive', [HoldRequestController::class, 'getWOActive'])->name('getWOActive');
    Route::get('getWODetail', [HoldRequestController::class, 'getWODetail'])->name('getWODetail');
    Route::post('updateHoldRequest', [HoldRequestController::class, 'updateHoldRequest'])->name('updateHoldRequest');
    Route::post('updateResumeRequest', [HoldRequestController::class, 'updateResumeRequest'])->name('updateResumeRequest');
    Route::post('saveTransferPIC', [HoldRequestController::class, 'saveTransferPIC'])->name('saveTransferPIC');
    
    // Hold Request Page

    // Incident Log
        Route::get('incident_log', [IncidentController::class, 'index'])->name('incident_log');
        Route::get('getIncident', [IncidentController::class, 'getIncident'])->name('getIncident');
        Route::get('getCategoryIncident', [IncidentController::class, 'getCategoryIncident'])->name('getCategoryIncident');
        Route::get('getIncidentProblem', [IncidentController::class, 'getIncidentProblem'])->name('getIncidentProblem');
        Route::post('addIncident', [IncidentController::class, 'addIncident'])->name('addIncident');
        Route::get('getIncidentDetail', [IncidentController::class, 'getIncidentDetail'])->name('getIncidentDetail');
        Route::post('updateIncident', [IncidentController::class, 'updateIncident'])->name('updateIncident');
    // Incident Log
    // Import User from HRIS
        Route::get('getUserHris', [UserController::class, 'getUserHris'])->name('getUserHris');
    // Import User from HRIS

    // Inventory
        // Master
            // Master Type
            Route::get('master_type_inv', [MasterTypeInvController::class, 'index'])->name('master_type_inv'); 
            Route::get('getTypeInv', [MasterTypeInvController::class, 'getTypeInv'])->name('getTypeInv'); 
            Route::post('saveTypeInv', [MasterTypeInvController::class, 'saveTypeInv'])->name('saveTypeInv'); 
            Route::get('detailTypeInv', [MasterTypeInvController::class, 'detailTypeInv'])->name('detailTypeInv'); 
            Route::post('updateTypeInv', [MasterTypeInvController::class, 'updateTypeInv'])->name('updateTypeInv'); 
            // Master Type

            // Category
            
                Route::get(' master_category_inv', [MasterCategoryInvController::class, 'index'])->name(' master_category_inv'); 
                Route::get('getCategoryInv', [MasterCategoryInvController::class, 'getCategoryInv'])->name('getCategoryInv'); 
                Route::post('saveCategoryInv', [MasterCategoryInvController::class, 'saveCategoryInv'])->name('saveCategoryInv'); 
                Route::get('detailCategoryInv', [MasterCategoryInvController::class, 'detailCategoryInv'])->name('detailCategoryInv'); 
                Route::post('updateCategoryInv', [MasterCategoryInvController::class, 'updateCategoryInv'])->name('updateCategoryInv'); 
                Route::get('deleteCategoryInv', [MasterCategoryInvController::class, 'deleteCategoryInv'])->name('deleteCategoryInv'); 
                Route::post('uploadCategory', [MasterCategoryInvController::class, 'uploadCategory'])->name('uploadCategory'); 
            // Category

            // Master Brand
                Route::get('master_brand', [MasterBrandController::class, 'index'])->name('master_brand'); 
                Route::get('getBrand', [MasterBrandController::class, 'getBrand'])->name('getBrand'); 
                Route::post('addBrand', [MasterBrandController::class, 'addBrand'])->name('addBrand'); 
                Route::get('detailBrand', [MasterBrandController::class, 'detailBrand'])->name('detailBrand'); 
                Route::post('updateBrand', [MasterBrandController::class, 'updateBrand'])->name('updateBrand'); 
                Route::get('deleteBrand', [MasterBrandController::class, 'deleteBrand'])->name('deleteBrand'); 
            // Master Brand
        // Master
    // Inventory




    // RFP Kanban Mode
        
        Route::get('project/{id}',[RFPDetailProjectController::class, 'project']);
        Route::get('getSubDetailKanban',[RFPDetailProjectController::class, 'getSubDetailKanban'])->name('getSubDetailKanban');
        Route::get('getChat',[RFPDetailProjectController::class, 'getChat'])->name('getChat');
        Route::post('sendChat',[RFPDetailProjectController::class, 'sendChat'])->name('sendChat');
        Route::post('updateStatusSubDetail',[RFPDetailProjectController::class, 'updateStatusSubDetail'])->name('updateStatusSubDetail');
        // Route::get('project/getRFPDetail',[RFPDetailProjectController::class, 'getRFPDetail'])->name('project/getRFPDetail');
    // RFP Kanban Mode

    // Opex
        // Setting
            // Master Opex Team
                Route::get('master_team_opex', [OpexTeamController::class, 'index'])->name('master_team_opex'); 
                Route::get('opex_timeline', [OpexTimelineController::class, 'index'])->name('opex_timeline'); 
                Route::get('getOPex', [OpexTimelineController::class, 'getOPex'])->name('getOPex'); 
                Route::post('addHeadOpex', [OpexTimelineController::class, 'addHeadOpex'])->name('addHeadOpex'); 
                Route::get('detailHeadOpex', [OpexTimelineController::class, 'detailHeadOpex'])->name('detailHeadOpex'); 
                Route::post('updateHeadOpex', [OpexTimelineController::class, 'updateHeadOpex'])->name('updateHeadOpex'); 
             
            // Master Opex Team

            // Opex Kanban 
                Route::get('opx/{id}',[OpexTimelineController::class, 'opx']);
            // Opex Kanban

        // Setting

        // Master
            Route::get('getmasterCategoryOPX', [MasterCategoryOPXController::class, 'getmasterCategoryOPX'])->name('getmasterCategoryOPX'); 
            Route::get('getDevCategoryOPX', [MasterCategoryOPXController::class, 'getDevCategoryOPX'])->name('getDevCategoryOPX'); 
            Route::get('getActiveCategoryOPX', [MasterCategoryOPXController::class, 'getActiveCategoryOPX'])->name('getActiveCategoryOPX'); 
            Route::get('getDevCategoryOPX', [MasterCategoryOPXController::class, 'getDevCategoryOPX'])->name('getDevCategoryOPX'); 
            Route::post('addCategoryOPX', [MasterCategoryOPXController::class, 'addCategoryOPX'])->name('addCategoryOPX'); 
            Route::post('updateCategoryOPX', [MasterCategoryOPXController::class, 'updateCategoryOPX'])->name('updateCategoryOPX'); 
            Route::post('updateStatusCategoryOPX', [MasterCategoryOPXController::class, 'updateStatusCategoryOPX'])->name('updateStatusCategoryOPX'); 
            
            
            Route::get('getProductOPX', [MasterProductOPXController::class, 'getProductOPX'])->name('getProductOPX'); 
            Route::get('getProductFilter', [MasterProductOPXController::class, 'getProductFilter'])->name('getProductFilter'); 
            Route::post('addProductOPX', [MasterProductOPXController::class, 'addProductOPX'])->name('addProductOPX'); 
            Route::post('updateProductOPX', [MasterProductOPXController::class, 'updateProductOPX'])->name('updateProductOPX'); 
            Route::post('updateStatusProductOPX', [MasterProductOPXController::class, 'updateStatusProductOPX'])->name('updateStatusProductOPX'); 


        // Master
        // Monitoring OPEX
            Route::get('getOPX', [MonitoringOPXController::class, 'getOPX'])->name('getOPX'); 
            Route::get('getDetervative', [MonitoringOPXController::class, 'getDetervative'])->name('getDetervative'); 
            Route::get('detailOPX', [MonitoringOPXController::class, 'detailOPX'])->name('detailOPX'); 
            Route::get('getPOOPX', [MonitoringOPXController::class, 'getPOOPX'])->name('getPOOPX'); 
            Route::get('getISOPX', [MonitoringOPXController::class, 'getISOPX'])->name('getISOPX'); 
            Route::get('childOPXDetail', [MonitoringOPXController::class, 'childOPXDetail'])->name('childOPXDetail'); 
            Route::post('addOPX', [MonitoringOPXController::class, 'addOPX'])->name('addOPX'); 
            Route::post('addPOOPX', [MonitoringOPXController::class, 'addPOOPX'])->name('addPOOPX'); 
            Route::post('updateISOPX', [MonitoringOPXController::class, 'updateISOPX'])->name('updateISOPX'); 
            Route::post('addISOPX', [MonitoringOPXController::class, 'addISOPX'])->name('addISOPX'); 
            Route::post('updatePOOPX', [MonitoringOPXController::class, 'updatePOOPX'])->name('updatePOOPX'); 
            Route::get('/export-excel', [MonitoringOPXController::class, 'exportPivot'])->name('opx.export.excel');
        // Monitoring OPEX
        
    // Opex

    // Asset

        // Master Asset
            Route::get('getMasterAsset', [MasterAssetController::class, 'getMasterAsset'])->name('getMasterAsset'); 
            Route::get('getMasterAssetUser', [MasterAssetController::class, 'getMasterAssetUser'])->name('getMasterAssetUser'); 
            Route::get('mappingAssetUser', [MasterAssetController::class, 'mappingAssetUser'])->name('mappingAssetUser'); 
            Route::get('mappingAssetChild', [MasterAssetController::class, 'mappingAssetChild'])->name('mappingAssetChild'); 
            Route::get('getAssetCategory', [MasterAssetController::class, 'getAssetCategory'])->name('getAssetCategory'); 
            Route::get('getAssetBrand', [MasterAssetController::class, 'getAssetBrand'])->name('getAssetBrand'); 
            Route::get('getActiveParent', [MasterAssetController::class, 'getActiveParent'])->name('getActiveParent'); 
            Route::get('getUser', [MasterAssetController::class, 'getUser'])->name('getUser'); 
            Route::post('updateStatusMasterAsset', [MasterAssetController::class, 'updateStatusMasterAsset'])->name('updateStatusMasterAsset'); 
            Route::post('addMasterAsset', [MasterAssetController::class, 'addMasterAsset'])->name('addMasterAsset'); 
        // Master Asset

        // Distribution Asset
            Route::get('distribution_asset', [DistributionAssetController::class, 'index'])->name('distribution_asset'); 
            Route::get('getDistributionTicket', [DistributionAssetController::class, 'getDistributionTicket'])->name('getDistributionTicket'); 
            Route::get('getAssetUser', [DistributionAssetController::class, 'getAssetUser'])->name('getAssetUser'); 
            Route::get('getInactiveAsset', [DistributionAssetController::class, 'getInactiveAsset'])->name('getInactiveAsset'); 
            Route::get('getUserLocation', [DistributionAssetController::class, 'getUserLocation'])->name('getUserLocation'); 
            Route::post('addDistribution', [DistributionAssetController::class, 'addDistribution'])->name('addDistribution'); 
            Route::post('sendingDistribution', [DistributionAssetController::class, 'sendingDistribution'])->name('sendingDistribution'); 
            Route::get('detailDistributionTicket', [DistributionAssetController::class, 'detailDistributionTicket'])->name('detailDistributionTicket'); 
            Route::post('/incoming-progress', [DistributionAssetController::class, 'incomingProgress']); 
            
            // Approval Notification
                Route::get('getApprovalAssetNotification', [DistributionAssetController::class, 'getApprovalAssetNotification'])->name('getApprovalAssetNotification'); 
                Route::post('approvalAssetProgress', [DistributionAssetController::class, 'approvalAssetProgress'])->name('approvalAssetProgress'); 
            // Approval Notification

            // Service Asset
                Route::get('service_asset', [ServiceAssetController::class, 'index'])->name('service_asset'); 
                Route::get('getService', [ServiceAssetController::class, 'getService'])->name('getService'); 
                Route::get('getRequestCode', [ServiceAssetController::class, 'getRequestCode'])->name('getRequestCode'); 
                Route::get('detailRequestCode', [ServiceAssetController::class, 'detailRequestCode'])->name('detailRequestCode'); 
                Route::post('addService', [ServiceAssetController::class, 'addService'])->name('addService'); 
                Route::post('startService', [ServiceAssetController::class, 'startService'])->name('startService'); 
                Route::post('updateService', [ServiceAssetController::class, 'updateService'])->name('updateService'); 
            // Service Asset
            
        // Distribution Asset

        // Approval
            Route::get('approval', [ApprovalController::class, 'index'])->name('approval'); 
            Route::get('getApproval', [ApprovalController::class, 'getApproval'])->name('getApproval'); 
            Route::post('addApprovalHeader', [ApprovalController::class, 'addApprovalHeader'])->name('addApprovalHeader'); 
            Route::get('getStepApproval', [ApprovalController::class, 'getStepApproval'])->name('getStepApproval'); 
            Route::post('updateApprover', [ApprovalController::class, 'updateApprover'])->name('updateApprover'); 
            Route::get('detailMasterApproval', [ApprovalController::class, 'detailMasterApproval'])->name('detailMasterApproval'); 
            Route::post('editMasterApproval', [ApprovalController::class, 'editMasterApproval'])->name('editMasterApproval'); 
        // Approval
        
    // Asset
        
    // V Card 
        Route::get('v_card', [VCardController::class, 'index'])->name('v_card'); 
        Route::get('getCard', [VCardController::class, 'getCard'])->name('getCard'); 
        Route::get('generateCard/{id}/card', [VCardController::class, 'generateCard'])->name('generateCard'); 
    // V Card 

    // Testing Email
        Route::get('/test-auth-email', function () {
            \Illuminate\Support\Facades\Mail::raw('Test email dari Laravel Auth', function ($message) {
                $message->to('bagus.slamet@pralon.com') // ganti ke Zimbra
                        ->subject('Laravel Auth Test');
            });
        
            return 'Email auth-style terkirim!';
        });
    // Testing Email


    // Master Room
        Route::get('getRoom', [MasterRoomController::class, 'getRoom'])->name('getRoom');
        Route::post('addRoom', [MasterRoomController::class, 'addRoom'])->name('addRoom');
        Route::post('updateRoom', [MasterRoomController::class, 'updateRoom'])->name('updateRoom');
    // Master Room
    // Master Aspek
        Route::get('master_aspek', [MasterAspekController::class, 'index'])->name('master_aspek');
        Route::get('getAspek', [MasterAspekController::class, 'getAspek'])->name('getAspek');
        Route::post('addAspek', [MasterAspekController::class, 'addAspek'])->name('addAspek');
        Route::post('updateAspek', [MasterAspekController::class, 'updateAspek'])->name('updateAspek');
    // Master Aspek

    // Stock Opname
        Route::get('stock_opname', [StockOpnameController::class, 'index'])->name('stock_opname');
        Route::get('getStockOpname', [StockOpnameController::class, 'getStockOpname'])->name('getStockOpname');
        Route::get('getApprovalStockOpname', [StockOpnameController::class, 'getApprovalStockOpname'])->name('getApprovalStockOpname');
        Route::get('detailWO', [WorkOrderController::class, 'detailWO'])->name('detailWO');
        Route::post('addStockOpname', [StockOpnameController::class, 'addStockOpname'])->name('addStockOpname');
        Route::post('updateStockOpname', [StockOpnameController::class, 'updateStockOpname'])->name('updateStockOpname');
        Route::post('approveSO', [StockOpnameController::class, 'approveSO'])->name('approveSO');
    // Stock Opname

    // Master Module
         Route::get('master_module', [MasterModuleController::class, 'index'])->name('master_module');
         Route::get('getModule', [MasterModuleController::class, 'getModule'])->name('getModule');
         Route::get('moduleFilter', [MasterModuleController::class, 'moduleFilter'])->name('moduleFilter');
         Route::post('addModule', [MasterModuleController::class, 'addModule'])->name('addModule');
         Route::post('updateModule', [MasterModuleController::class, 'updateModule'])->name('updateModule');
    // Master Module


    // Master System
         Route::get('master_system', [MasterSystemController::class, 'index'])->name('master_system');
         Route::get('getSystem', [MasterSystemController::class, 'getSystem'])->name('getSystem');
         Route::get('systemFilter', [MasterSystemController::class, 'systemFilter'])->name('systemFilter');
         Route::post('addSystem', [MasterSystemController::class, 'addSystem'])->name('addSystem');
         Route::post('updateSystem', [MasterSystemController::class, 'updateSystem'])->name('updateSystem');
    // Master System

    // UpdateSystemm
        Route::get('update_system', [UpdateSystemController::class, 'index'])->name('update_system');
        Route::get('getTicketSystem', [UpdateSystemController::class, 'getTicketSystem'])->name('getTicketSystem');
        Route::get('getDetailERP', [UpdateSystemController::class, 'getDetailERP'])->name('getDetailERP');
        Route::post('upload-image', [UpdateSystemController::class, 'uploadImage'])->name('upload-image');
        Route::post('delete-image', [UpdateSystemController::class, 'deleteImage'])->name('delete-image');
        Route::post('addSystemTicket', [UpdateSystemController::class, 'addSystemTicket'])->name('addSystemTicket');
        Route::post('approvalERP', [UpdateSystemController::class, 'approvalERP'])->name('approvalERP');
        Route::post('finishTask', [UpdateSystemController::class, 'finishTask'])->name('finishTask');
        // UpdateSystemm
        
    // Approval Matrix
        Route::get('approval_matrix', [ApprovalMaatrixController::class, 'index'])->name('approval_matrix');
        Route::get('getApprovalMatrix', [ApprovalMaatrixController::class, 'getApprovalMatrix'])->name('getApprovalMatrix');
        Route::get('getApproverDetail', [ApprovalMaatrixController::class, 'getApproverDetail'])->name('getApproverDetail');
        Route::post('addApprovalMatrix', [ApprovalMaatrixController::class, 'addApprovalMatrix'])->name('addApprovalMatrix');
        Route::post('updateApproverMatrixDetail', [ApprovalMaatrixController::class, 'updateApproverMatrixDetail'])->name('updateApproverMatrixDetail');
        
    // Approval Matrix
});

