<?php
class TestController
{
    public function insert()
    {
        $conn = new  Model('post');

        for ($i = 6; $i <= 50; $i++) {
            $conn->add(array(
                    'uid' => 2,
                    'tid' => 2,
                    'title' => '测试' . $i . '测试' . $i . '测试' . $i . '测试' . $i,
                    'ctime' => time()
                )
            );
        }
    }
}