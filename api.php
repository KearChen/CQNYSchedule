<?php
$url = "http://jw.cqny.edu.cn:17231/api/mobile/loginAuth";//登录页面
$username = $_GET["username"];//用户名
$password = $_GET["password"];//密码

//post获取 回报json中accessToken
$url = $url . "?username=" . $username . "&password=" . $password;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "");
$output = curl_exec($ch);
curl_close($ch);
$output = json_decode($output, true);

$accessToken = $output["data"]["accessToken"];
// print($accessToken);
//获取本周信息
$url = "http://jw.cqny.edu.cn:17231/api/baseInfo/mobile/common/selectCurrentInfo";
// GET 取周数
// {"code":200,"data":{"currentSemesterName":"2023-2024第二学期","currentSemester":"2023-2024-2","currentWeek":"1"}}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
curl_close($ch);
$output = json_decode($output, true);
$academicYearSemester = $output["data"]["currentSemester"];
$currentWeek = $output["data"]["currentWeek"];

//获取本周课程信息
$url = "http://jw.cqny.edu.cn:17231/api/arrange/mobile/courseSchedule/courseSchedule";
// post:{"academicYearSemester":"2023-2024-2","userId":null,"userType":null,"weeks":[1]}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("academicYearSemester" => $academicYearSemester, "userId" => null, "userType" => null, "weeks" => [$currentWeek])));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'accessToken: ' .$accessToken,
));
$output = curl_exec($ch);
curl_close($ch);
echo $output;
