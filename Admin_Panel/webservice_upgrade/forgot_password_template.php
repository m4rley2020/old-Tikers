<?php 
include_once 'connect.php';

 ?>
<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
<style type="text/css">
    @media screen and (max-width:600px){
    table{width: 100% !important;}
    .store-icon{background-image: none !important;}
    .store-icon img{width: 140px;}
    .box-icon{padding:0 !important;}
    .box-icon .main-spa{width: 100% !important;padding-top: 20px;}
    .box-icon .main-spa span{width: 100%;}
    .box-icon .main-spa img{display: block;margin:0 auto;}
    .main-img{width: 100% !important;text-align: center !important;}
    .main-img span{text-align: center !important;padding: 5px 0;line-height: 27px !important;}
    .name-main{font-size: 22px !important;width: 96% !important;}
    .sub-text{font-size: 18px !important;width: 96% !important;line-height: 22px !important; }
    .user-box{width: 100% !important;margin:0 auto 40px !important;}
    .shap-box{display: none !important;}
    .main-btn{padding: 0 !important;}
    .main-btn span{background:none !important;}
    .social-icon{width: 100% !important;}
    .sub-table{padding: 20px 0 !important;}
    .sub-table tr td{text-align: center !important;}
    .sub-table tr.social-icon td span,.sub-table tr td a img{float: none !important;display: inline-block !important;}
    .sub-table tr.social-icon td span{vertical-align: top;padding: 9px 0px !important;}
    .link-bo{margin-bottom: 10px;}
    .link-bo a{float: none !important;display: inline-block;margin:5px 0; }
    .link-bo span{display: none;}

    .w-100{width: 100% !important;float: left;}
    .user-img-main{text-align: center;}
    .user-img-main-dis{text-align: center;}
    .text-center{text-align: center;}
    .center-img{display: inline-block !important;}
    .main-table{padding: 0 10px !important;}
    .p-0{padding:0 5px !important;}
    .left-col{width: 100% !important;}
    .right-col{width: 100% !important;text-align: center;}
    .right-col img{width: 260px !important;}
    .bottom-logo,.bottom-logo td{width: 100% !important;text-align: center;float: left;}

    .bottom-logo img{margin:0 auto;}
    }
    @media screen and (max-width:480px){
    .store-icon a{margin:5px 0 !important;}
    }
</style>
</head>
<body style="margin:0px;padding:0px;font-family: 'Roboto', sans-serif;box-sizing: border-box;">
    
    <table class="main-table" style="font-family: 'Roboto', sans-serif;width:100%;margin: 0 auto;max-width:600px;font-size: 14px;line-height: 1;height: 100% !important;padding: 0;background-color: #f5f5f5;padding: 0 30px 30px;box-sizing: border-box;">
        <tbody>
            <tr style="padding: 0px";>
                <td style="padding: 0px";>
                    <table style="box-sizing: border-box;width: 100%;float: left;">
                        <tbody style="box-sizing: border-box;width: 100%;float: left;">
                            <tr style="box-sizing: border-box;padding: 20px 5px;width: 100%;float: left;box-sizing: border-box;text-align: center;">
                                <td style="box-sizing: border-box;float: left;width: 100%;"><a href="#"><!--<img src="[[SITE_URL]]/images/logo.png" style="width: 150px;">--></a></td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="box-sizing: border-box;width: 100%;float: left;background-color: #fff;border-radius: 5px;padding:15px 0px 20px;">
                        <tr class="p-0 left-col" style="box-sizing: border-box;width: 100%;float: left;margin-top: 0px;padding:0px 15px;">
                            <td class="text-center" style="box-sizing: border-box;font-size: 23px;font-weight: bold;color: #0077b5;line-height: 21px;margin-top:5px;width: 100%;float: left;">Login Detail</td>
                        </tr>
                        <tr class="p-0 left-col" style="box-sizing: border-box;width: 100%;float: left;margin-top: 15px;padding:0px 15px;">
                            <td class="text-center" style="box-sizing: border-box;font-size: 14px;font-weight: normal;color: #283e4a;line-height: 21px;margin-top:5px;width: 100%;float: left;">Hi <strong>[[name]],</strong>  </td>
                            <td class="text-center" style="box-sizing: border-box;font-size: 14px;font-weight: normal;color: #283e4a;line-height: 21px;margin-top:5px;width: 100%;float: left;">Your new password is: <strong>[[password]]</strong>  </td>
                            <td class="text-center" style="box-sizing: border-box;font-size: 14px;font-weight: normal;color: #283e4a;line-height: 21px;margin-top:5px;width: 100%;float: left;"> - remember You can change it in the app.<br/><br/>
                            Thanks,</strong>  </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>                
</body>
</html>