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

<!-- 搜索 -->
<div class="form-div search_form_div">
    <form action="/index.php/Admin/Attribute/lst" method="GET" name="search_form">
		<p>
			属性名称：
	   		<input type="text" name="attr_name" size="30" value="<?php echo I('get.attr_name'); ?>" />
		</p>
		<p>
			属性的类型：
			<input type="radio" value="-1" name="attr_type" <?php if(I('get.attr_type', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="可选" name="attr_type" <?php if(I('get.attr_type', -1) == '可选') echo 'checked="checked"'; ?> />  
			<input type="radio" value="唯一" name="attr_type" <?php if(I('get.attr_type', -1) == '唯一') echo 'checked="checked"'; ?> />  
		</p>
		<p>
			类型：<?php $typeId = I('get.type_id'); ?>
			<select name="type_id">
				<?php foreach ($typeData as $k => $v): if($typeId == $v['id']) $select = 'selected="selected"'; else $select = ''; ?>
					<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >属性名称</th>
            <th >属性的类型</th>
            <th >属性的可选值，多个值用，隔开</th>
            <th >类型的id</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['attr_name']; ?></td>
				<td><?php echo $v['attr_type']; ?></td>
				<td><?php echo $v['attr_option_value']; ?></td>
				<td><?php echo $v['type_id']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p').'&type_id='.$typeId); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p').'&type_id='.$typeId); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>
<script>
</script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>

<div id="footer"> abc </div>
</body>
</html>