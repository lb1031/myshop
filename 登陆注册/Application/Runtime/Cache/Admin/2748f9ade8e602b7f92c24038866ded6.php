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

<form method="post" action="/index.php/Admin/Goods/goods_number/id/11.html" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <?php foreach ($gaData as $k => $v): ?>
                <th><?php echo $v[0]['attr_name']; ?></th>
                <?php endforeach; ?>
                <th>库存量</th>
                <th>操作</th>
            </tr>
            <?php if($gnData): ?>
            	<?php foreach ($gnData as $k0 => $v0): $_attr = explode(',', $v0['attr_list']); ?>
            		<tr>
		            	<?php foreach ($gaData as $k => $v): ?>
		                <td>
		                	<select name="gaid[]">
		                		<option value="">请选择</option>
		                		<?php foreach ($v as $k1 => $v1): if(in_array($v1['id'], $_attr)) $select = 'selected="selected"'; else $select = ''; ?>
		                		<option <?php echo $select; ?> value="<?php echo $v1['id']; ?>"><?php echo $v1['attr_value']; ?></option>
		                		<?php endforeach; ?>
		                	</select>
		                </td>
		                <?php endforeach; ?>
		                <td><input type="text" name="gn[]" value="<?php echo $v0['goods_number']; ?>" /></td>
		                <td><input onclick="addTr(this);" type="button" value="<?php echo $k0==0?'+':'-'; ?>" /></td>
		            </tr>
            	<?php endforeach; ?>
            <?php else: ?>
	            <tr>
	            	<?php foreach ($gaData as $k => $v): ?>
	                <td>
	                	<select name="gaid[]">
	                		<option value="">请选择</option>
	                		<?php foreach ($v as $k1 => $v1): ?>
	                		<option value="<?php echo $v1['id']; ?>"><?php echo $v1['attr_value']; ?></option>
	                		<?php endforeach; ?>
	                	</select>
	                </td>
	                <?php endforeach; ?>
	                <td><input type="text" name="gn[]" /></td>
	                <td><input onclick="addTr(this);" type="button" value="+" /></td>
	            </tr>
            <?php endif; ?>
        </table>
        <p><input type="submit" value="提交" /></p>
    </div>
</form>

<script>
function addTr(btn)
{
	var tr = $(btn).parent().parent();
	if($(btn).val() == '+')
	{
		var newTr = tr.clone();
		newTr.find(":button").val('-');
		$("table").append(newTr);
	}
	else
		tr.remove();
}
</script>

<div id="footer"> abc </div>
</body>
</html>