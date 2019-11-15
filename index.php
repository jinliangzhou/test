<?php
//公众号保存
preg_match('/MP_verify_(\w+).txt/', $_SERVER['REQUEST_URI'], $arr);
if (isset($arr[1])) {
    echo $arr[1];
    exit();
}
$path = parse_url($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$path = convertUrlQuery($path['query']);
echo json_encode($path);die;

function convertUrlQuery($query)
{
  $queryParts = explode('&', $query);
  $params = array();
  foreach ($queryParts as $param) {
    $item = explode('=', $param);
    $params[$item[0]] = $item[1];
  }
  return $params;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>苹果官方资讯</title>
</head>
<body>

<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    var query ='<?=$path['index']?>';
    var e ='<?=$path['e']?>';
    var open = "https://open.weixin.qq.com/connect/oauth2/authorize?";
    var open_end = '&response_type=code&scope=snsapi_base#wechat_redirect';
    window.onload = function () {
        var url = 'http://page.qiyizhuan.com.cn/home/entrance_api.php';
        $.ajax({
            type: "GET",
            url: url,
            dataType: "jsonp",
            jsonp: "callback",
            jsonpCallback: 'callback',
            success: function (res) {
                var redirect_uri = res.domain +'/'+query + '?e=' + e+ '&appid=' +res.app_id;
                redirect_uri = escape(redirect_uri);
                // console.log(open +'appid='+res.app_id+'&redirect_uri='+redirect_uri+open_end);
                location.href = open +'appid='+res.app_id+'&redirect_uri='+redirect_uri+open_end;
            },
            error: function (res) {
                 console.log(res)
                //alert(url);
                // location.href = 'http://qq.com';
            }
        });
    }
</script>
</body>

</html>