<?php
echo "<h1>File Functions</h1>";

$base=__DIR__;
$demoFile=$base."/demo.txt";
$copyFile=$base."/demo_copy.txt";
$renameFile=$base."/demo_renamed.txt";
$folder=$base."/demo_folder";

$fp=fopen($demoFile,"w");
fwrite($fp,"Hello PHP File Handling\n");
fwrite($fp,"Line 2 This is a demo file\n");
fclose($fp);

echo "<h3>File Read Write</h3>";

$fp=fopen($demoFile,"r");
$data=fread($fp,filesize($demoFile));
fclose($fp);
echo "<pre>".$data."</pre>";

$data2=file_get_contents($demoFile);
echo "<pre>".$data2."</pre>";

file_put_contents($demoFile,"Hello PHP File Handling\nLine 2 This is a demo file\nLine 3 Appended using file_put_contents\n");
echo "file_put_contents done<br>";

$lines=file($demoFile);
echo "<pre>";
foreach($lines as $i=>$line){
    echo "Line ".($i+1)." ".$line;
}
echo "</pre>";

echo "<h3>File Information</h3>";

echo "file_exists ".(file_exists($demoFile)?"YES":"NO")."<br>";
echo "filesize ".filesize($demoFile)." bytes<br>";
echo "filetype ".filetype($demoFile)."<br>";
echo "fileatime ".date("Y-m-d H:i:s",fileatime($demoFile))."<br>";
echo "filemtime ".date("Y-m-d H:i:s",filemtime($demoFile))."<br>";
echo "filectime ".date("Y-m-d H:i:s",filectime($demoFile))."<br>";
echo "fileperms ".substr(sprintf('%o',fileperms($demoFile)),-4)."<br>";
echo "fileowner ".fileowner($demoFile)."<br>";
echo "filegroup ".filegroup($demoFile)."<br>";
echo "fileinode ".fileinode($demoFile)."<br>";

echo "<h3>File and Folder Management</h3>";

if(!is_dir($folder)) mkdir($folder);

echo "is_dir ".(is_dir($folder)?"YES":"NO")."<br>";
echo "is_file ".(is_file($demoFile)?"YES":"NO")."<br>";

copy($demoFile,$copyFile);
echo "copy done<br>";

rename($copyFile,$renameFile);
echo "rename done<br>";

$temp=$folder."/temp.txt";
file_put_contents($temp,"temporary file");
unlink($temp);
echo "unlink done<br>";

echo "<h3>Directory Handling</h3>";

$list=scandir($base);
echo "<pre>";
foreach($list as $item) echo $item."\n";
echo "</pre>";

$dh=opendir($folder);
echo "<pre>";
while(($entry=readdir($dh))!==false) echo $entry."\n";
echo "</pre>";
closedir($dh);

echo "getcwd ".getcwd()."<br>";
chdir($folder);
echo "after chdir ".getcwd()."<br>";
chdir($base);
echo "back ".getcwd()."<br>";

echo "<h3>File Locking</h3>";

$lockFile=$base."/lock_demo.txt";
$fp=fopen($lockFile,"a");
if(flock($fp,LOCK_EX)){
    fwrite($fp,"locked write\n");
    flock($fp,LOCK_UN);
    echo "flock done<br>";
}else echo "lock failed<br>";
fclose($fp);

echo "<h3>rmdir Demo</h3>";

$empty=$base."/empty_folder";
if(!is_dir($empty)) mkdir($empty);
rmdir($empty);
echo "rmdir done<br>";
?>
