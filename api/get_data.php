<?php
header("Access-Control-Allow-Origin: *");

// URLパラメーターからURLを取得
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // JSONデータを取得
    $jsonData = file_get_contents('php://input');

    // cURLを使用して外部のURLにリクエストを送信
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // JSONデータが存在する場合はPOSTリクエストを設定
    if (!empty($jsonData)) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }

    $response = curl_exec($ch);

    // エラーチェック
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);

    // 取得したデータを出力
    echo $response;
} else {
    // 'url'パラメーターが提供されていない場合はエラーメッセージを返す
    echo 'Error: Missing "url" parameter';
}
?>
