<?php

require "./Model/Model.class.php";

$conn = new  Model('post');



for($i=6;$i<=50;$i++){
    $conn->save(array(
        'uid'=>2,
        'tid'=>2,
        'title'=>'测试'.$i.'测试'.$i.'测试'.$i.'测试'.$i,
        'ctime'=>time()
        )
    );
}

