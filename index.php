<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Language Converter</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
  </head>
  <body>
    <div class="container" style="margin:50px;">
    	<div class="row">
        <form class="form-horizontal" action="index.php" method="post">
          <div class="page-header">
          			<center><h1>Language Converter</h1></center>
          </div>
          <div class="form-group">
    			    <label for="exampleInputName2">Language 1</label>
    			    <select name="lan1" id="lan1" class="form-control" value="<?=$_POST['lan1']?>">
    			    	<option value="en">English</option>
    			    	<option value="bn">Bangladesh</option>
    			    	<option value="ar">Arabic</option>
    			    	<option value="zh">Chinese</option>
    			    	<option value="fr">French</option>
    			    	<option value="de">German</option>
    					  <option value="el">Greek</option>
    					  <option value="hi">Hindi</option>
    			    	<option value="id">Indonesian</option>
    			    	<option value="ro">Romanian</option>
    			    	<option value="es">Spanish</option>
    			    	<option value="th">Thai</option>
    			    	<option value="tr">Turkish</option>
    			    	<option value="ja">Japanese</option>
    			    </select>
    			</div>
          <center><h4>To</h4></center>
    			<div class="form-group">
    			    <label for="exampleInputName2">Language 2</label>
    			    <select name="lan2" id="lan2" class="form-control">
    			    	<option value="bn">Bangladesh</option>
    			    	<option value="ar">Arabic</option>
    			    	<option value="zh">Chinese</option>
    			    	<option value="en">English</option>
    			    	<option value="fr">French</option>
    			    	<option value="de">German</option>
    					  <option value="el">Greek</option>
    					  <option value="hi">Hindi</option>
    			    	<option value="id">Indonesian</option>
    			    	<option value="ro">Romanian</option>
    			    	<option value="es">Spanish</option>
    			    	<option value="th">Thai</option>
    			    	<option value="tr">Turkish</option>
    			    	<option value="ja">Japanese</option>
    			    </select>
    			</div>
          <div class="col-lg-6">
        			<div class="page-header">
        			  <h1>Form</h1>
        			</div>
      			  <div class="form-group">
      			    <label for="text">Text which you want to convert</label>
      			    <textarea class="form-control" name="text" rows="9" placeholder="Add Your Text !!!"></textarea>
      			  </div>
      			  <div class="form-group">
      			    <div class="">
      			      <button type="submit" class="btn btn-default">Submit</button>
      			    </div>
      			  </div>
      		</div>
        </form>
        <div class="col-lg-6">
          <div class="page-header">
            <h1>Result</h1>
          </div>
          <?php
              function curl($url,$params = array(),$is_coockie_set = false)
              {

                  if(!$is_coockie_set){
                    /* STEP 1. let’s create a cookie file */
                    $ckfile = tempnam ("/tmp", "CURLCOOKIE");

                    /* STEP 2. visit the homepage to set the cookie properly */
                    $ch = curl_init ($url);
                    curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
                    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec ($ch);
                  }

                  $str = ''; $str_arr= array();
                  foreach($params as $key => $value)
                  {
                    $str_arr[] = urlencode($key)."=".urlencode($value);
                  }
                  if(!empty($str_arr))
                  $str = '?'.implode('&',$str_arr);

                  /* STEP 3. visit cookiepage.php */

                  $Url = $url.$str;

                  $ch = curl_init ($Url);
                  curl_setopt($ch, CURLOPT_USERAGENT, 'API');
                  curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
                  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

                  $output = curl_exec ($ch);
                  return $output;
              }

              function replace($w,$chk,$rep)
              {
              	$wordlen = strlen($w);
              	for ($i=0; $i < $wordlen; $i++) {
              		if($w[$i]==$chk)
              		{
              			$w[$i]=$rep;
              		}
              	}
              	return $w;
              }

              function Translate($word,$conversion)
              {
              	$word = urlencode($word);
              	$arr_langs = explode('_to_', $conversion);

              	$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=".$arr_langs[0]."&tl=".$arr_langs[1]."&dt=t&q=".$word;

              	$name_en = curl($url);

              	$name_en = explode('"',$name_en);

              	$name_en[1] = replace($name_en[1],',','!');

                return $name_en[1];
              }
              function f($word,$lan1,$lan2)
              {
                $conversion = $_POST['lan1']."_to_".$_POST['lan2'];
                return translate($word,$conversion);
              }


              if ($_POST) {

                $lan1 = $_POST['lan1'];
                $lan2 = $_POST['lan2'];

                $text=explode("\n", $_POST['text']);

                foreach ($text as $word) {
                  echo f($word)." <br/>";
                }

              }
          ?>

        </div>
      </div>
    </div>

  </body>
</html>
