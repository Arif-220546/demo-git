<?php
echo "<h2>File Operation Modes</h2>";
$fp=fopen("r_demo.txt","w");
fwrite($fp,"File created for r mode\n");
fclose($fp);

$fp=fopen("r_demo.txt","r");
echo "<pre>".fread($fp,filesize("r_demo.txt"))."</pre>";
fclose($fp);

$fp=fopen("w_demo.txt","w");
fwrite($fp,"Written using w mode\n");
fclose($fp);

$fp=fopen("a_demo.txt","a");
fwrite($fp,"Appended using a mode\n");
fclose($fp);

$fp=fopen("rplus_demo.txt","w");
fwrite($fp,"Initial content\n");
fclose($fp);

$fp=fopen("rplus_demo.txt","r+");
fwrite($fp,"r+ write\n");
rewind($fp);
echo "<pre>".fread($fp,filesize("rplus_demo.txt"))."</pre>";
fclose($fp);

$fp=fopen("wplus_demo.txt","w+");
fwrite($fp,"w+ write\n");
rewind($fp);
echo "<pre>".fread($fp,filesize("wplus_demo.txt"))."</pre>";
fclose($fp);

$fp=fopen("aplus_demo.txt","a+");
fwrite($fp,"a+ append\n");
rewind($fp);
echo "<pre>".fread($fp,filesize("aplus_demo.txt"))."</pre>";
fclose($fp);

if(!file_exists("x_demo.txt")){
    $fp=fopen("x_demo.txt","x");
    fwrite($fp,"Created using x mode\n");
    fclose($fp);
}

if(!file_exists("xplus_demo.txt")){
    $fp=fopen("xplus_demo.txt","x+");
    fwrite($fp,"Created using x+ mode\n");
    fclose($fp);
}
?>
