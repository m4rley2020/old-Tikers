<?php
header("Content-type: application/json");
include "connect.php";

if ($_REQUEST['user_id'] != '') {

    $get_query2 = "select * from challenge_type where is_hot = 'Yes' order by id desc";
    $get_query_res2 = mysqli_query($db, $get_query2) or die(mysqli_error($db));

    if (mysqli_num_rows($get_query_res2) > 0) {

        while ($get_query_date2 = mysqli_fetch_array($get_query_res2)) {
            $challenge_type_id = $get_query_date2['id'];
            $name = $get_query_date2['name'];
            $challenge_image = $get_query_date2['challenge_image'];

            if (file_exists("../challenge_image/" . $challenge_image) && $challenge_image != "") {
                $challenge_image1 = $SITE_URL . "/challenge_image/" . $challenge_image;
            } else {
                $challenge_image1 = "";
            }

            $data[] = array(
                "challenge_type_id" => $challenge_type_id,
                "name" => $name,
                "challenge_image" => $challenge_image1,
            );

        }
        $message = "Challenge type found.";
        $result = array('message' => $message, 'result' => '1', 'responseData' => $data);
    } else {
        $error = "Challenge type not found.";
        $result = array('message' => $error, 'result' => '0');
    }
} else {
    $error = "Please enter all required fields";
    $result = array('message' => $error, 'result' => '0');
}
$result = json_encode($result);
echo $result;
