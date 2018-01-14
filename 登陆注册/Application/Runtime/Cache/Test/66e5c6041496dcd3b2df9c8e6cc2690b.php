<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo $_page_title; ?> </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />

 	<link href="/Public/um/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/Public/um/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/um/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/um/umeditor.min.js"></script>
    <script type="text/javascript" src="/Public/um/lang/zh-cn/zh-cn.js"></script>
    
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear:both"></div>
</h1>

<!-- 内容 -->

<link href="/Public/um/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="/Public/um/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/um/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/um/lang/zh-cn/zh-cn.js"></script>

<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Test/Goods/edit/id/7.html" enctype="multipart/form-data" >
    	<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
		<input type="hidden" name="old_logo" value="<?php echo $data['logo']; ?>" />
		<input type="hidden" name="old_mid_logo" value="<?php echo $data['mid_logo']; ?>" />
		<input type="hidden" name="old_sm_logo" value="<?php echo $data['sm_logo']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">商品名称：</td>
                <td>
                    <input  type="text" name="goods_name" value="<?php echo $data['goods_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">市场价格：</td>
                <td>
                    <input  type="text" name="market_price" value="<?php echo $data['market_price']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">本店价格：</td>
                <td>
                    <input  type="text" name="shop_price" value="<?php echo $data['shop_price']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">logo：</td>
                <td>
                	<input type="file" name="logo" /><br /> 
                	<?php showImage($data['logo'], 100); ?>                </td>
            </tr>
            <tr>
                <td class="label">是否上架：</td>
                <td>
                	<input type="radio" name="is_on_sale" value="是" <?php if($data['is_on_sale'] == '是') echo 'checked="checked"'; ?> />是 
                	<input type="radio" name="is_on_sale" value="否" <?php if($data['is_on_sale'] == '否') echo 'checked="checked"'; ?> />否 
                </td>
            </tr>
            <tr>
                <td class="label">商品描述：</td>
                <td>
                	<textarea id="goods_desc" name="goods_desc"><?php echo $data['goods_desc']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="label">主分类id：</td>
                <td>
                    <input  type="text" name="cat_id" value="<?php echo $data['cat_id']; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
var um = UM.getEditor('goods_desc', {
	initialFrameWidth:"100%"
});
</script>

<div id="footer"> abc </div>
</body>
</html>