<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 -  </title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $_page_btn_link?>"><?php echo $_page_btn_name?></a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title?> </span>
    <div style="clear:both"></div>
</h1>



<link href="/Public/um/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/um/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/um/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/um/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/um/lang/zh-cn/zh-cn.js"></script>
<div class="main-div">
    <form method="post" action="<?php echo U('edit') ;?>"enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $info['id']?>"/>
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">商品名称</td>
                <td>
                    <input type="text" name="goods_name" maxlength="60" value="<?php echo $info['goods_name']?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>

            <tr>
                <td class="label">市场价格</td>
                <td>
                    <input type="text" name="market_price" maxlength="60" value="<?php echo $info['market_price']?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">本店价格</td>
                <td>
                    <input type="text" name="shop_price" maxlength="60" value="<?php echo $info['shop_price']?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">商品LOGO</td>
                <td>
                    <input type="file" name="logo" />
                    <img src="<?php echo IMG_PASH . $info['sm_logo'] ;?>"/>
                </td>
            </tr>
            </tr>
            <tr>
                <td class="label">商品描述</td>
                <td>
                    <textarea id="goods_desc"  name="goods_desc" cols="60" rows="4" value="<?php echo $info['goods_desc']?>" ></textarea>
                </td>
            </tr>

            <tr>
                <td class="label">是否显示</td>
                <td>
                    <input type="radio" name="is_on_sale" value="是" <?php if($info['is_on_sale']=='是') echo 'checked="checked"';?>  /> 是
                    <input type="radio" name="is_on_sale" value="否" <?php if($info['is_on_sale']=='否') echo 'checked="checked"';?> />否
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>



<script>
//    UM.getEditor('goods_desc',
//            {initialFrameWidth:800}
//    );
</script>

<div id="footer">
    共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>