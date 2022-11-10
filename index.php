<?php
ini_set('display_errors',1);
if(  $_REQUEST['googlecssurl'] and $_REQUEST['googlecssurl']!=="" ){
   
    preg_match('#family\=(.*)\:#U',$_REQUEST['googlecssurl'],$fontname);
   
    $dateiname = md5($_REQUEST['googlecssurl'])."_".$fontname[1].".css";
    if( !is_file("temp/".$dateiname) ){
         copy($_REQUEST['googlecssurl'],"temp/".$dateiname);
    }
    $font_dir = "temp/".$fontname[1];
    if( !is_dir($font_dir ) ){
        mkdir( $font_dir );
        chmod($font_dir ,0777); 
    }
  

    $inhalt = file_get_contents("temp/".$dateiname);
    preg_match_all('#url\((.*)\)#U',$inhalt,$urls);
    echo '<pre>';
    print_R($urls);
    echo '</pre>';
    foreach($urls[1] as $key => $fontfile){
        $extension = explode(".",$fontfile);
        $newfontfile = $font_dir.'/'.$fontname[1].'-'.$key.'.'.end( $extension);
        if( !is_file($newfontfile) ){
            copy($fontfile,$newfontfile); 
        }
       
        $inhalt = str_replace( $fontfile,str_replace("temp/","",$newfontfile),$inhalt );
    }
    file_put_contents( 'temp/'.$fontname[1].'.css',$inhalt );
   // echo $inhalt; exit;

}
?>
<!DOCTYPE html>
<html>
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>

<header class="w3-container w3-red">
  <h1>Google Fonts lokal einbinden</h1>
</header>


<div class="w3-container">
 <form method="post" target="_self">
    <input type="text" name="googlecssurl" placeholder="google font css url" class="w3-input"/>
    <button class="w3-button">Font laden und CSS erstellen</button>
 </form>
</div>

<footer class="w3-container w3-red w3-margin-top">
  <h5>Footer</h5>
  <p>Footer information goes here</p>
</footer>

</body>
</html>
