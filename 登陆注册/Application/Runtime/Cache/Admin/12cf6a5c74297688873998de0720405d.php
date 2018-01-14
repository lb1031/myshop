<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - <?php echo $_page_title; ?> </title>
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
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear:both"></div>
</h1>

<!-- 内容 -->

<div class="form-div">
	<!-- 搜索表单 -->
    <form action="<?php echo U('lst'); ?>" name="searchForm">
    	商品分类：
    				<select name="cat_id">
                    	<option value="">请选择分类</option>
                    	<?php  $catid = I('get.cat_id'); foreach ($catData as $k => $v): if($v['id'] == $catid) $select = 'selected="selected"'; else $select = ''; ?>
                    		<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*8).$v['cat_name']; ?></option>
                    	<?php endforeach; ?>
                    </select>
	    商品名称：<input type="text" name="gn" size="15" value="<?php echo I('get.gn'); ?>" />
	    商品价格：从<input type="text" name="fp" value="<?php echo I('get.fp'); ?>" />
	    		到<input type="text" name="tp" value="<?php echo I('get.tp'); ?>" />
	    是否上架：<input type="radio" name="ios" <?php if(I('get.ios', 0) == 0) echo 'checked="checked"'; ?> value="0" /> 全部
	            <input type="radio" name="ios" <?php if(I('get.ios') == '是') echo 'checked="checked"'; ?> value="是" /> 是
	            <input type="radio" name="ios" <?php if(I('get.ios') == '否') echo 'checked="checked"'; ?> value="否" /> 否
    <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>id</th>
                <th>logo</th>
                <th>商品名称</th>
                <th>市场价格</th>
                <th>本店价格</th>
                <th>是否上架</th>
                <th>操作</th>
            </tr>
            <?php foreach ($data as $k => $v): ?>
            <tr>
                <td><?php echo $v['id']; ?></td>
                <td align="center"><img src="<?php echo IMAGE_ROOT . $v['sm_logo']; ?>" /></td>
                <td align="center"><?php echo $v['goods_name']; ?></td>
                <td align="center"><?php echo $v['market_price']; ?></td>
                <td align="center"><?php echo $v['shop_price']; ?></td>
                <td align="center"><?php echo $v['is_on_sale']; ?></td>
                <td align="center">
                <a href="<?php echo U('goods_number?id='.$v['id']); ?>" title="库存量">库存量</a> |
                <a href="<?php echo U('edit?id='.$v['id']); ?>" title="编辑">编辑</a> |
                <a onclick="return confirm('确定要删除吗？');" href="<?php echo U('delete?id='.$v['id']); ?>" title="移除">移除</a> 
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td align="right" nowrap="true" colspan="7">
                    <div id="turn-page">
                       <?php echo $page; ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>

<div id="footer"> abc </div>
</body>
</html>