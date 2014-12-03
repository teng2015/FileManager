<?php
/**
 * Email:   eteplus@163.com
 * Author:  eteplus
 * Date:    2014/11/22
 * Time:    13:34
 */

/**
 * 转换字节大小
 * @param  number   $size
 * @return string
 */
function transByte($size) {
    $arr = array('B' ,"KB" ,"MB" ,"GB", "TB" ,"EB");
    $i = 0;
    while($size >= 1024){
        $size /= 1024;
        $i++;
    }
    /**
     * round — 对浮点数进行四舍五入
     * float round ( float $val  int $precision = 0)
     * $val 要处理的值
     * $precission 可选的十进制小数点后数字的数目
     */
    return round($size,2).$arr[$i];
}


/**
 * 创建文件
 * @param  string $filename 文件名
 * @return string
 */
function createFile($filename) {
    //验证文件名的合法性，是否包含/,*,<>,?;
    $pattern = "/[\/,\*,<>,\?\|]/";
    /**
     * 执行一个正则表达式匹配， 返回0（不匹配）或返回1 （匹配1次）
     * preg_match(string $pattern , string $subject)
     * $pattern 要搜索的模式，字符串类型。
     * $subject 输入字符串。
     * basename(string $path) — 返回路径中的文件名部分
     */
    if(!preg_match($pattern ,basename($filename))) {
        //检测当前目录下是否包含同名文件
        if(!file_exists($filename)) {
            //通过touch($filename)来创建
            /**
             * touch — 设定文件的访问和修改时间
             * bool touch ( string $filename [, int $time = time() [, int $atime ]] )
             * 尝试将由 filename 给出的文件的访问和修改时间设定为给出的 time。
             * 注意访问时间总是会被修改的，不论有几个参数。
             * 如果文件不存在，则会被创建
             */
            if(touch($filename)) {
                return "文件创建成功";
            }
            else {
                return "文件创建失败";
            }
        }
        else {
            return "文件已存在 ，请重命名后创建";
        }
    }
    else {
        return "非法文件名";
    }
}

/**
 * 重命名文件
 * @param string $oldname 旧文件名
 * @param string $newname 新文件名
 */
function renameFile($oldname, $newname) {
    //验证文件名是否合法
    if(checkFilename($newname)) {
        //检测当前目录下是否存在同名文件
        /**
         * dirname -- 返回路径中的目录部分
         */
        $path = dirname($oldname);
        if(!file_exists($path."/".$newname)) {
            //进行重命名
            if(rename($oldname,$path."/".$newname)) {
                return "重命名成功";
            }
            else {
                return "重命名失败";
            }
        }
        else {
            return "存在同名文件，请重新命名";
        }
    }
    else {
        return "非法文件名";
    }
}

/**
 * 删除文件
 * @param  string $filename 文件名
 * @return string
 */
function delFile($filename) {
    if(unlink($filename)) {
        return "文件删除成功";
    }
    else {
        return "文件删除失败";
    }
}

/**
 * 下载文件操作
 * 2014-12-03 13:36:55
 * @param string $filename
 */
function downFile($filename) {
    header("content-disposition:attachment;filename=".basename($filename));
    header("content-length:".filesize($filename));
    readfile($filename);
}

/**
 * 验证文件名是否合法
 * 2014-12-03 13:39:47
 * @param $filename 文件名
 */
function checkFilename($filename) {
    $pattern = "/[\/,\*,<>,\?\|]/";
    if(preg_match($pattern, $filename)) {
        return false;
    }
    else {
        return true;
    }
}
