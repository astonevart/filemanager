<?php
function delete($dir, $file){
    $path = $dir.'/'.$file;
    if (is_dir($path)){
        $items = scandir($path);
        foreach ($items as $item){
            if ($item != '.' && $item != '..'){
                if (is_dir($path.'/'.$item)){
                    delete($path, $item);
                }
                else {
                    unlink($path . '/' . $item);
                }
            }
        }
    }
    else{
        unlink($path);
    }
}
delete($_GET['dir'], $_GET['name']);
define("ROOT", dirname(__FILE__));
if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
{
    move_uploaded_file($_FILES["filename"]["tmp_name"], $_GET['uploadnamedir'].'/'.$_FILES['filename']['name']);
}
if ($_GET['dir']){
    $files = scandir($_GET['dir']);
    $dir = $_GET['dir'];
}
else {
    $dir = ROOT.'/uploads';
    $files = scandir($dir);
}
if ($dir!=ROOT.'/uploads/') {
    $back=substr ($dir, 0, strrpos($dir, "/"));
    echo "<a href='index.php?dir=$back' style='padding: 10px; cursor: pointer; display: inline-block; background: lemonchiffon;
 border: 1px solid'>наверх</a>";
}
echo "<table style='border: 1px solid; padding:10px; background: gray; margin-bottom: 10px'><tr><th>Файлы/Папки</th></tr>";
foreach ($files as $file){
    if ($file != '.' && $file != '..'){
        if (is_dir($dir.'/'.$file)){
            $directory = $dir.'/'.$file;
            echo "<tr><td style='border: 1px solid; padding: 5px; background: lightgrey'><a href='index.php?dir=$directory'
 style='text-decoration: none; color: chocolate'>{$file}</a></td>";
            echo "<td style='border: 1px solid; padding: 5px; background: lightgrey'><a href='index.php?name=$file&dir=$dir'
 style='text-decoration: none; color: chocolate'>x</a></td></tr>";
        }
        else {
            echo "<tr><td style='border: 1px solid; padding: 5px; background: lightsteelblue'><a href='openfile.php?name=$file&dir=$dir'
 style='text-decoration: none; color: teal'>{$file}</a></td>";
            echo "<td style='border: 1px solid; padding: 5px; background: lightgrey'><a href='index.php?dir=$file&dir=$dir'
 style='text-decoration: none; color: chocolate'>x</a></td></tr>";
        }
    }
}
echo "</table>";
echo "<form action=index.php?dir=$dir&uploadnamedir=$dir method=post enctype=multipart/form-data>
<input type=file name=filename>
<input type=submit value=Загрузить></form>";