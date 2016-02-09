<?php
include(dirname(__FILE__) . "/../include/Spyc.php");

function getYAML($dir) {
    $files = glob(rtrim($dir, '/') . '/*');
    $list = array();
    foreach ($files as $file) {
        if (is_file($file) && strpos($file,".yml")!==false ) {
            $list[] = $file;
        }
        if (is_dir($file)) {
            $list = array_merge($list, getYAML($file));
        }
    }
    return $list;
}

function getFACTS($factpath){
    $json_objs = array();
    $files = glob(rtrim($factpath,'/') . '/*');
    for($i=0;$i<count($files);$i++){
        $handle = fopen($files[$i], 'r');
        $json = json_decode(fread($handle, filesize($files[$i])),true);
        $json_objs[]=$json;
    }
    return $json_objs;
}

function getPlaybook($path){
    return Spyc::YAMLLoad($path);
}

function relative_url ( $base, $target, $option = true )
{
    // 戻り値（$url）を $option に基づいて初期化
    $url = ($option) ? './': '';

    // 構成要素を '/' で分解
    $base   = explode('/', $base);
    $target = explode('/', $target);

    // 要素をはじめから順番に比較し同じ要素は排除
    do {
        $f = array_shift($base);
        $t = array_shift($target);
    } while ($f == $t);

    // 要素をひとつ捨てすぎたので配列に戻す
    array_unshift($base, $b);
    array_unshift($target, $t);

    // 残りの要素数を数える
    $bcount = count($base);
    $tcount = count($target);

    // ひとつずつしか残ってないので同じディレクトリだ！
    if ($bcount == 1 && $tcount == 1) {
        // ならばファイル名だけを $url に格納
        $url .= array_pop($target);
    } else {
        // 上位へ走査が必要な分 '../' を出力
        if($bcount > 1) {
            $url = str_repeat('../', $bcount - 1);
        }
        // $target のパスを '/' で連結して $url に格納
        $url .= implode('/', $target);
    }

    // 出来上がったところで出力
    return $url;
}

?>