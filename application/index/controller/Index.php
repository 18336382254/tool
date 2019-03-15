<?php
namespace app\index\controller;

class Index
{

    /**上传缩略图
     * @param $filename 上传文件名
     * @return array    返回一个数组
     */
    public function upload($filename){
        $config = [
            'size' => 10000000,
            'ext'  => 'jpg,gif,png,bmp,jpeg,JPG'
        ];
        $file = $this->request->file($filename);
        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads');
        $save_path   = '/uploads/';
        $info        = $file->validate($config)->move($upload_path);
        $image = \think\Image::open(ROOT_PATH . 'public/'.$save_path . $info->getSaveName());
        $image->thumb(750, 700,\think\Image::THUMB_CENTER)->save(ROOT_PATH . 'public/'.$save_path . $info->getSaveName());
        if ($info) {
            $result = [
                'error' => 0,
                'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
            ];
        } else {
            $result = [
                'error'   => 1,
                'message' => $file->getError()
            ];
        }
        return $result;
    }
}
