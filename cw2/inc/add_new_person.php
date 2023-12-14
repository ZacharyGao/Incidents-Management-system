<?php
// add_new_person.php
include_once 'config.php';
include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 从 POST 请求中获取数据
    $personName = $_POST['personName'];
    $licenceNum = $_POST['licenceNum'];
    // ... 其他表单字段 ...

    // 处理数据，例如添加到数据库
    $result = addPerson($db, $personName, $licenceNum,);
    
    // 根据结果返回响应
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Person added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add person']);
    }
}
