<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-07
 * Time: 11:58
 */

namespace Home\Controller;


use Think\Controller;

class decryptionController extends Controller{
    public function userDecryption() {
        $appid = 'wx25ea2cea38cdfd37';
        $sessionKey = 'OFUqtN1A1lLK+B99v7cyWQ==';

        $encryptedData="ZqX7XGqRvqTkinzUcY/GHpCiDNivrf1K1iY9La0ZGefCvB4CCE/KOvDXP3Hn+uQzOB92GdBIgI1D+MDXstC4GvtR4StZY7Qsb1lt1Y7BC7dovLzCSodvvX3jTW2fgkLZwlt/WDjRPo7XgM+ecVB1Q1mjHmrJs2eaB7UpG6cwzjBtDOjcdvwdM6Nxs+tAiiwwzZiZeu+Lol4bbwJci8/uF0Gc6vNkLPuVOCo1s9UrBFxfY5Kck2K0eGm5ffFoi6YkWSeigiwfhELrzr+or7GpDxqFfY0DTjiz39lM6xlBdPrtGQwmfLEi4jWv8+bmDm8mD9zZOTCD6eOmjyCpDQiAEDPKLXyhluP3fy52PiygFWpQcaUTckDmxGNDurmfkniUAnT8npUXZj48GRb7ivIDLa2VXIHQ/zgoIBnGMOlAMSUalhNSKDJpxJgQTXkMfSHNxFI1qTk6DKFTK7IOIasuFQ==";

        $iv = 'QGx4ZmWoFXEkNsOD5/J5jw==';

        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);

        if ($errCode == 0) {
            print($data . "\n");
        } else {
            print($errCode . "\n");
        }
    }
}