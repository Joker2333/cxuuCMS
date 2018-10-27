<?php

namespace app\admin\controller;

use app\admin\model\Attachments;
use Request;
use app\admin\model\Settings;

class Upload extends \think\Controller
{

    protected $middleware = ['Auth'];
    static private $ext_arr = array(
        'image' => array('gif', 'jpg', 'jpeg', 'png'),
        'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
        'officefile' => array('doc', 'docx', 'xls', 'xlsx', 'ppt'),
        'otherfile' => array('htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
    );
    //static private $max_size = 2261800;
    static private $uploadsname = './uploads/';

    /*
     * 公共上传方法
     *   $file  $file = request()->file($postFile);
     *   $filename = $_FILES[$postFile]['name'];
     */

    public function upload($file, $filename)
    {
        $siteSettings = new Settings();
        $siteInfo = $siteSettings->getSiteSetting();
        $upload_size = $siteInfo['upload_size'] * 1024;
        $temp_arr = explode(".", $filename);
        $file_ext = strtolower(trim(array_pop($temp_arr))); //获取上传文件的 尾缀
        if (in_array($file_ext, self::$ext_arr['image'])) {
            $upname = self::$uploadsname . 'image/';
            $info = $file->validate(['size' => $upload_size, 'ext' => self::$ext_arr['image']])->move($upname);
            $extimg = 1;
        } elseif (in_array($file_ext, self::$ext_arr['media'])) {
            $upname = self::$uploadsname . 'media/';
            $info = $file->validate(['size' => $upload_size, 'ext' => self::$ext_arr['media']])->move($upname);
        } elseif (in_array($file_ext, self::$ext_arr['officefile'])) {
            $upname = self::$uploadsname . 'officefile/';
            $info = $file->validate(['size' => $upload_size, 'ext' => self::$ext_arr['officefile']])->move($upname);
        } elseif (in_array($file_ext, self::$ext_arr['otherfile'])) {
            $upname = self::$uploadsname . 'otherfile/';
            $info = $file->validate(['size' => $upload_size, 'ext' => self::$ext_arr['otherfile']])->move($upname);
        }

        if ($info) {
            //dump($info->getSaveName());
            $uploadurl = substr($upname, 1); //去掉第一个字符，返回正常一点的路径
            $result = str_replace('\\', '/', $info->getSaveName());
            $upcontroller = Request::param('upcontr');
            if (!empty($upcontroller)) {
                $contr = $upcontroller; //控制器和方法名
            } else {
                $contr = "未知控制器和方法名";
            }
            $attinsertDb = new Attachments;
            $attinsertDb->save([
                'filename' => $filename,
                'fileurl' => $uploadurl . $result,
                'controller' => $contr,
                'updatetime' => time()
            ]);
            $data = [];
            $data['url'] = $uploadurl . $result;
            $data['ext'] = isset($extimg) ? 1 : 0;
            $data['filename'] = $filename;
            return $data;
        } else {
            return false;
        }
    }


    /*
     * webuploader 插件 上传方法
     *  */

    public function uploadWebuploader()
    {
        $file = request()->file("image");
        $filename = $_FILES['image']['name'];
        $url = $this->upload($file, $filename);
        if ($url) {
            echo json_encode(array("url" => $url['url']));
        } else {
            echo json_encode(array("url" => "上传错误"));
        }
    }

    /*
     * kindeditor  编辑器使用上传方法
     *  */

    public function uploadKindeditor()
    {
        $file = request()->file("imgFile");
        $filename = $_FILES['imgFile']['name'];
        $url = $this->upload($file, $filename);
        if ($url) {
            header('Content-type: text/html; charset=UTF-8');
            echo json_encode(array('error' => 0, "url" => $url['url']));
            exit;
        } else {
            header('Content-type: text/html; charset=UTF-8');
            echo json_encode(array('error' => 1, 'message' => "上传失败！"));
            exit;
        }
    }

    /*
     * summernote  编辑器使用上传方法
     *  */

    public function uploadSummernote()
    {
        $file = request()->file("file");
        $filename = $_FILES['file']['name'];
        $url = $this->upload($file, $filename);
        if ($url) {
            echo json_encode(array('url' => $url['url'], 'ext' => $url['ext'], 'filename' => $url['filename']));
        } else {
            echo "上传错误";
        }
    }


}
