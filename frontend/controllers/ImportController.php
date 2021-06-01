<?php


namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\UploadForm;


class ImportController extends Controller
{
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');
            if ($model->upload()) {
                echo "uploaded<br>";
                $inputFile = 'uploads/'.$model->excelFile;
                echo $inputFile."<br>";
                try{
                    $inputFileType = \PHPExcel_Iofactory:: identify ($inputFile);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader-> Load ($inputFile);
                }catch (Exception $e){
                    die('Error');
                }
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $data = [];
                for($row =2; $row <= $highestRow;$row++){
                    $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

                    if(!empty($rowData[0][0])) {
                        $data[] = [
                            $rowData[0][0],
                            $rowData[0][1], $rowData[0][2], $rowData[0][3], $rowData[0][4], $rowData[0][5], $rowData[0][6], $rowData[0][7], $rowData[0][8], $rowData[0][9], $rowData[0][10],
                            $rowData[0][11], $rowData[0][12], $rowData[0][13], $rowData[0][14], $rowData[0][15], $rowData[0][16], $rowData[0][17], $rowData[0][18], $rowData[0][19], $rowData[0][20],
                            $rowData[0][21], $rowData[0][22], $rowData[0][23], $rowData[0][24], $rowData[0][25], $rowData[0][26], $rowData[0][27], $rowData[0][28], $rowData[0][29], $rowData[0][30],
                            $rowData[0][31], $rowData[0][32], $rowData[0][33], $rowData[0][34], $rowData[0][35], $rowData[0][36], $rowData[0][37], $rowData[0][38], $rowData[0][39], $rowData[0][40],
                            $rowData[0][41], $rowData[0][42], $rowData[0][43], $rowData[0][44], $rowData[0][45], $rowData[0][46], $rowData[0][47], $rowData[0][48], $rowData[0][49], $rowData[0][50],
                            $rowData[0][51], $rowData[0][52], $rowData[0][53], $rowData[0][54], $rowData[0][55], $rowData[0][56], $rowData[0][57], $rowData[0][58], $rowData[0][59], $rowData[0][60],
                            $rowData[0][61], $rowData[0][62], $rowData[0][63], $rowData[0][64], $rowData[0][65], $rowData[0][66], $rowData[0][67], $rowData[0][68], $rowData[0][69], $rowData[0][70],
                            $rowData[0][71], $rowData[0][72], $rowData[0][73], $rowData[0][74], $rowData[0][75], $rowData[0][76], $rowData[0][77], $rowData[0][78], $rowData[0][79], $rowData[0][80],
                            $rowData[0][81], $rowData[0][82], $rowData[0][83], $rowData[0][84], $rowData[0][85], $rowData[0][86], $rowData[0][87], $rowData[0][88], $rowData[0][89], $rowData[0][90],
                            $rowData[0][91], $rowData[0][92], $rowData[0][93], $rowData[0][94], $rowData[0][95], $rowData[0][96], $rowData[0][97], $rowData[0][98], $rowData[0][99], $rowData[0][100],
                            $rowData[0][101], $rowData[0][102], $rowData[0][103], $rowData[0][104], $rowData[0][105], $rowData[0][106], $rowData[0][107], $rowData[0][108], $rowData[0][109], $rowData[0][110],
                            $rowData[0][111], $rowData[0][112], $rowData[0][113], $rowData[0][114], $rowData[0][115], $rowData[0][116], $rowData[0][117], $rowData[0][118], $rowData[0][119], $rowData[0][120],
                            $rowData[0][121], $rowData[0][122], $rowData[0][123], $rowData[0][124], $rowData[0][125], $rowData[0][126], $rowData[0][127], $rowData[0][128], $rowData[0][129], $rowData[0][130],
                            $rowData[0][131], $rowData[0][132], $rowData[0][133], $rowData[0][134], $rowData[0][135], $rowData[0][136], $rowData[0][137], $rowData[0][138], $rowData[0][139]
                        ];
                    }
                }
                //print_r($data);

                try {
                    Yii::$app->db->createCommand()
                        ->batchInsert('user_bo_account_info',
                            [
                                'id',
                                'user_login_id' ,
                                'application_no' ,
                                'application_date' ,
                                'bo_category' ,
                                'bo_type' ,
                                'cdbl_participant_id',
                                'bo_id' ,
                                'account_opened_date',
                                'first_acc_type' ,
                                'bank_cheque_attach' ,
                                'first_acc_holder_name_title' ,
                                'first_acc_holder_full_name' ,
                                'first_comp_contact_pers_name' ,
                                'first_contact_pers_gender' ,
                                'first_father_name' ,
                                'first_mother_name' ,
                                'first_occupation' ,
                                'address' ,
                                'city' ,
                                'country' ,
                                'state_division',
                                'post_code' ,
                                'telephone' ,
                                'fax' ,
                                'mobile_phone' ,
                                'email' ,
                                'passport_no' ,
                                'issue_place' ,
                                'issue_date',
                                'expiry_date',
                                'bank_account_number',
                                'routing_number' ,
                                'bank_name',
                                'branch_name',
                                'district_name' ,
                                'bank_identifier_code',
                                'swift_code',
                                'int_bank_ac_no',
                                'electronic_devidend_credit',
                                'tax_exemption_flag',
                                'tin_tax_id',
                                'residency_stat',
                                'nationality',
                                'date_of_birth',
                                'statement_cycle_code',
                                'statement_cycle_new_option_txt',
                                'internal_ref_no',
                                'national_id_number',
                                'comp_reg_no',
                                'comp_reg_date',
                                'jont_acc_holder_title',
                                'jont_acc_holder_full_name',
                                'jont_acc_holder_nid',
                                'create_link_exist_deposite_acc',
                                'depository_bo_acc',
                                'bo_link_acc_attach',
                                'exchange_name',
                                'trading_id',
                                'nominee_title',
                                'nominee_dob',
                                'nominee_state_division',
                                'nominee_city',
                                'nominee_country',
                                'nominee_post_code',
                                'nominee_address',
                                'nominee_full_name',
                                'nominee_nid_no',
                                'nominee_etin',
                                'nominee_fax',
                                'nominee_telephone',
                                'nominee_mobile',
                                'nominee_nationality',
                                'nominee_email',
                                'nominee_gender',
                                'nominee_percentage',
                                'nominee_residency',
                                'nominee_rel_client',
                                'nominee_passport_no',
                                'nominee_passport_avl',
                                'nominee_passport_issue_place',
                                'nominee_passport_expiry_date',
                                'nominee_passport_issue_date',
                                'nominee_photo',
                                'nominee_signature',
                                'nominee_nid_file',
                                'first_applic_photo',
                                'sec_applic_photo',
                                'sec_applic_nid_attach',
                                'comp_applic_photo',
                                'first_applic_signature',
                                'first_applic_nid_attach',
                                'sec_applic_signature',
                                'comp_applic_signature',
                                'bo_draft_status',
                                'bo_publish_staus',
                                'poa_pers_title',
                                'poa_pers_full_name',
                                'poa_pers_address',
                                'poa_pers_post_code',
                                'poa_pers_country',
                                'poa_pers_dob',
                                'poa_pers_nid',
                                'poa_pers_etin',
                                'poa_pers_nationality',
                                'poa_pers_gender',
                                'poa_pers_residency',
                                'poa_pers_percentage',
                                'poa_pers_rel_with_client',
                                'poa_pers_city',
                                'poa_pers_state_div',
                                'poa_pers_teleph',
                                'poa_pers_fax',
                                'poa_pers_mobile',
                                'poa_pers_email',
                                'poa_pers_passp_no',
                                'poa_pers_passp_issue_place' ,
                                'poa_pers_passp_issue_date' ,
                                'poa_pers_passp_exp_date' ,
                                'poa_pers_photo' ,
                                'poa_pers_signature' ,
                                'poa_pers_nid_attach' ,
                                'com_auth_pers_title' ,
                                'com_auth_pers_full_name',
                                'com_auth_pers_fath_husb' ,
                                'com_auth_pers_dob' ,
                                'com_auth_pers_gender',
                                'com_auth_pers_nationality',
                                'com_auth_pers_nid_no',
                                'com_auth_pers_address',
                                'com_auth_pers_mobile',
                                'com_auth_pers_telph',
                                'com_auth_pers_email',
                                'com_auth_pers_photo',
                                'com_auth_pers_signature',
                                'com_auth_pers_nid',
                                'approved_by',
                                'approved_date',
                                'created_at',
                                'updated_at'
                            ],
                            $data)
                        ->execute();
                } catch (Exception $e) {
                }
                die('Batch inserted!');

                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }


}