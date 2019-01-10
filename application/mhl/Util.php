<?php
namespace app\mhl;

trait Util
{
    /*
     * 输出内容
     */
    public function response($data= '', $message='操作成功', $code=200)
    {
        $result = [
            'message' => $message,
            'code' => $code,
        ];
        if ($data) {
            $result['data'] = $data;
        }
        echo json_encode($result);
    }
}








