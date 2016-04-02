<?php
require 'vchat/jssdk.php';


$new = new JSSDK('wx3a5aac7161b28013','d4624c36b6795d1d99dcf0547af5443d');
$signPackage = $new->getSignPackage();
?>
<?php
print_r($signPackage);
?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: '<?php echo $signPackage["timestamp"];?>',
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
        // 所有要调用的 API 都要加到这个列表中
        'checkJsApi',
        'openLocation',
        'getLocation',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ'
      ]
});
  wx.ready(function () {

    // //分享到朋友圈
    // wx.onMenuShareTimeline({
    //   title: dataForWeixin.title, // 分享标题
    //       link: dataForWeixin.url, // 分享链接
    //       imgUrl: dataForWeixin.MsgImg, // 分享图标
    //   success:function(){
    //       share_success(gid_para);
    //       }
    // });
    //分享给朋友
    wx.onMenuShareAppMessage({
        title: 'share_test',//dataForWeixin.title, // 分享标题
        link: 'http://www.baidu.com',//dataForWeixin.url, // 分享链接
        imgUrl: 'http://www.w3school.com.cn/i/eg_mouse.jpg',//dataForWeixin.MsgImg, // 分享图标
      desc: 'desc',//dataForWeixin.desc, // 分享描述
        type: '',
        dataUrl: '',
      success:function(){
          alert('share_success');
      }
    });
    // //分享到QQ好友
    // wx.onMenuShareQQ({
    //   title: dataForWeixin.title, // 分享标题
    //   desc: dataForWeixin.desc, // 分享描述
    //   link: dataForWeixin.url, // 分享链接
    //   imgUrl: dataForWeixin.MsgImg, // 分享图标
    //   success:function(){
    //       share_success(gid_para);
    //   }
    // });
    wx.checkJsApi({
    jsApiList: [
        // 'checkJsApi',
        'getLocation'
    ],
    success: function (res) {
        // alert(JSON.stringify(res));
        // alert(JSON.stringify(res.checkResult.getLocation));
        if (res.checkResult.getLocation == false) {
            alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
            return;
        }
    }
  });
    wx.getLocation({
    success: function (res) {
        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
        var speed = res.speed; // 速度，以米/每秒计
        var accuracy = res.accuracy; // 位置精度
        alert(latitude+'/'+longitude+'/'+speed+'/'+accuracy);
    },
    cancel: function (res) {
        alert('用户拒绝授权获取地理位置');
    }
  });
    wx.error(function (res) {
   alert(res.errMsg);
  });
});
</script>
