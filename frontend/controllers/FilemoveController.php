<?php


namespace frontend\controllers;


use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\UploadedFile;

class FilemoveController extends Controller
{
    /**
     * generate random string
     * @param int $length
     * @return false|string
     */
    public function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    public function actionMove()
    {
        // timer start
        $time_start = microtime(true);

        // directory where files uploaded.
        $directory = 'uploads/doc';

        $ids = []; // will store users id;
        $mask = []; // store id wise masked strings

        // generate ids for user
        for($x=1;$x<=2000;$x++)
            $ids[] = strval($x);

        // generate id wise mask
        foreach ($ids as $id) {
            $mask[$id] = $this->generateRandomString();
        }

        // Scan Uploaded directory
        $files = array_diff(scandir($directory), array('..', '.'));

        $dic = array(); // Store id wise file name
        $prefix = 9; // File name part without id part
        $ex = -4; // Extension length

        // Mapping filenames and ids
        foreach ($files as $file) {
            $fileID = substr($file,$prefix,$ex);
            $dic [$fileID] = $file;
        }

        // id wise move started
        foreach ($ids as $id) {
            if(array_key_exists($id,$dic)) {
                $structure = 'uploads/users/' . $id . '/'; // Location to move

                if (!file_exists($structure)) {
                    mkdir($structure, 0777, true); // Creating directory if it's not there
                }

                $form = $directory . '/' . $dic[$id]; // From where
                $p1 = substr($dic[$id],0,-4); // File name without extension
                $end = substr($dic[$id],-4); // the extension
                $to = $structure . $p1.'_'.$mask[$id].$end; // concatenate with mask and location where ti move

                if (!file_exists($to)) {
                    $status = rename($form, $to);
                }
            }
        }
        $time_end = microtime(true); // Ending timer
        $time = $time_end - $time_start; // Calculate execution time
        echo "Execution Time : $time seconds\n";
    }
}