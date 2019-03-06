<?php
		
$ip= $_GET['ip'];
$filename= $_GET['filename'];
$port= $_GET['port'];
$blockx= $_GET['block'];
$type= $_GET['type'];
$v2t= "";//$_GET['v2t'];
$v2t_text = "";//file_get_contents('http://localhost/v2t/'.$v2t);
$ref_v='';
$ref_a='';
$ref_i='images/1-p1.jpg';
if ($type=='video') {
	$ref_v="http://".$ip.":".$port."/ipfs/".$filename;
}
if ($type=='audio') {
	$ref_a="http://".$ip.":".$port."/ipfs/".$filename;
}
if ($type=='image') {
	$ref_i="http://".$ip.":".$port."/ipfs/".$filename;
}

 		 use IPFSPHP\IPFS;
		 include 'vendor/autoload.php';
		 $ipfs = new IPFS('localhost', 8080, 5001);
		// print_r($ipfs->id());		
		$obj = $ipfs->ls($filename);

		foreach ($obj as $e) {
			//echo $e['Hash']."<BR>";
			//echo $e['Size']."<BR>";
			//echo $e['Name']."<BR>";
		}

//require('./exampleBase.php');

require('../phpweb3/vendor/autoload.php');
use Web3\Web3;
$web3 = new Web3('http://localhost:8546/');

$eth = $web3->eth;

//echo 'Eth Get Account and Balance' . PHP_EOL;
$eth->accounts(function ($err, $accounts) use ($eth) {
    if ($err !== null) {
      //  echo 'Error: ' . $err->getMessage();
        return;
    }
    foreach ($accounts as $account) {
      //  echo 'Account: ' . $account . PHP_EOL;

        $eth->getBalance($account, function ($err, $balance) {
            if ($err !== null) {
               // echo 'Error: ' . $err->getMessage();
                return;
            }
            //echo 'Balance: ' . $balance . PHP_EOL;
        });
    }
});		

		
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title></title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="layout.css" rel="stylesheet" type="text/css" />

</head>

<body id="index">
	<div class="top_tall">
		<!--header -->
		<div id="header">
			<div class="main">
				<div class="logo">
					
					<img src="images/equalsmart logo2.jpg" alt="equalsmart logo2" width="100" height="50">

					<br><br><h2>下列檔案是一個<?php echo $type ?>型態檔案，經由手機上傳至行星檔案編碼服務系統，經過數位編碼後，<p>
								產生Hash數位身分證。由於檔案已完成數位資產化，並寫入區塊鏈，因此具有全球唯一性，且無法修改。<p>
								此檔案具有不可否認性，透過此技術，可運用於數位資產的保存與保值，歡迎與<a href="http://equalsmart.com">我們洽談合作</a>。</h2>
				</div>				

			</div>
		</div>
		<!--header end-->
		<div id="row1">
			<div class="main">
				<div class="main_indent">
					<div class="box">
						<div class="t">
							<div class="br">
								<div class="bl">
									<div class="tr">
										<div class="tl">
											<div class="container">
												<div class="column1">
												<?php
												   if ($type=='audio'){
													echo '<audio controls autoplay>';
													echo '<source src="'.$ref_a.'" type="audio/ogg">';
													echo '<source src="'.$ref_a.'" type="audio/mpeg">';
													echo 'Your browser does not support the'.$type.'element.';
													echo '</audio>';
												   }
												   if ($type=='video'){
													echo '<video width="400" controls>';
													echo '<source src="'.$ref_v.'" type="video/mp4">';
													echo '<source src="'.$ref_v.'" type="video/ogg">';
													echo 'Your browser does not support HTML5 video.';
													echo '</video>';
												   }
												   if ($type=='image'){
													echo '<img src="'.$ref_i.'" alt="ipfs image" width="400" height="300">';											   
												   }
												 ?>
												</div>
												<div class="column2">
													<div class="indent">
														<span class="right date"></span><h2>IPFS數位<?php echo $type ?>資產</h2>
														<div class="line">
															區塊編號:<?php echo $blockx ?>，若您使用wechat, 請選擇右下角的 '訪問原網頁'<br>
															<?php if (($type=='audio') or ($type=='video')) {
																echo "以下為影音檔案的文字內容，本文字是由AI智能語音辨識系統所產生:<BR>".$v2t_text."<BR>";
															} ?>															
														</div>														
														<a href="<?php echo $ref_a; ?>" class="button orange">IPFS</a>														
													</div>
												</div>
												<div class="clear"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		

		<!--footer -->
		<div id="footer">
			<div class="main">
				以上服務是由<a href="http://equalsmart.com">齐智(福州)科技公司</a>為您提供; 2019 | <a href="index-3.html">智恆科技園區孵化器進駐廠商</a> &nbsp;
			</div>
		</div>
		<!--footer end-->
	</div>	
		<div id="footer_row" align='left'>
			<div class="main" align='left'>

					<br><br><h2>下列資料是儲存本檔案Hash數位身分證的區塊詳細資料。</h2>			
				<?php
	require('./exampleBase.php');
	$eth = $web3->eth;
	$i=(int)$blockx;			
	$eth->getBlockByNumber($i , true, function ($err, $block){
		if ($err !== null) {
		echo 'Error: ' . $err->getMessage();
		return;
	}
	 echo "block detail:<br>";
	 if (sizeof($block->transactions)>0) {
	   $str="";
	   $trans=$block->transactions;
		$TXDetail="";
	   //echo var_dump($trans);
		foreach ($trans as $tran) {
		  $str=$str.'blockNumber= '.$tran->{'blockNumber'}.'<BR>'.PHP_EOL;
		  $str=$str.'blockHash= '.$tran->{'blockHash'}.'<BR>'.PHP_EOL;
		  $str=$str.'from= '.$tran->{'from'}.'<BR>'.PHP_EOL;
		  $str=$str.'to= '.$tran->{'to'}.'<BR>'.PHP_EOL;
		  $str=$str.'hash= '.$tran->{'hash'}.'<BR>'.PHP_EOL;
		  $str=$str.'transactionIndex= '.$tran->{'transactionIndex'}.'<BR>'.PHP_EOL;
		  $str=$str.'gas= '.hexdec($tran->{'gas'}).'<BR>'.PHP_EOL;
		  $str=$str.'gasPrice= '.hexdec($tran->{'gasPrice'}).'<BR>'.PHP_EOL;
		  $str=$str.'value= '.hexdec($tran->{'value'}).'<BR>'.PHP_EOL;
		  $str=$str.'nonce= '.$tran->{'nonce'}.'<BR>'.PHP_EOL;
		  $str=$str.'Input hex= '.$tran->{'input'}.'<BR>'.PHP_EOL;
		  $hex=$tran->{'input'};
		  // $a=hexToStr($hex);
		  $string='';
		  if (strlen($hex)>4) {
				 for ($i=0;$i<strlen($hex)-1;$i+=2){
					 if ($hex[$i+1]<>'x'){				
					$string .= chr(hexdec('0x'.$hex[$i].$hex[$i+1]));
					  }
				 }
		  }
		  $string=str_replace(",",",<BR>",$string);
		  $string=str_replace("{","<BR>{<BR>",$string);
		  $string=str_replace("}","<BR>}",$string);
		  $str=$str.'Input str= '.$string.'<BR>'.PHP_EOL;
		  //$str=$str.'v= '.$tran->{'v'}.'<BR>'.PHP_EOL;
		  //$str=$str.'r= '.$tran->{'r'}.'<BR>'.PHP_EOL;
		  //$str=$str.'s= '.$tran->{'s'}.'<BR>'.PHP_EOL;
		  $str=$str.'=============================<BR>'.PHP_EOL;
		}				
	 $TXDetail .=  $str;
	 echo $TXDetail;
	 } 
	});

?>
			</div>
		</div>
</body>

</html>