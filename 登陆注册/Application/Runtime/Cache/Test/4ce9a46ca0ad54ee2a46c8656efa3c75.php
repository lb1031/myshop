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
    <form action="/index.php/Test/Goods/lst" method="GET" name="search_form">
		<p>
			商品名称：
	   		<input type="text" name="goods_name" size="30" value="<?php echo I('get.goods_name'); ?>" />
		</p>
		<p>
			市场价格：
	   		从 <input id="market_pricefrom" type="text" name="market_pricefrom" size="15" value="<?php echo I('get.market_pricefrom'); ?>" /> 
		    到 <input id="market_priceto" type="text" name="market_priceto" size="15" value="<?php echo I('get.market_priceto'); ?>" />
		</p>
		<p>
			本店价格：
	   		从 <input id="shop_pricefrom" type="text" name="shop_pricefrom" size="15" value="<?php echo I('get.shop_pricefrom'); ?>" /> 
		    到 <input id="shop_priceto" type="text" name="shop_priceto" size="15" value="<?php echo I('get.shop_priceto'); ?>" />
		</p>
		<p>
			添加的时间：
	   		<input type="text" name="addtime" size="30" value="<?php echo I('get.addtime'); ?>" />
		</p>
		<p>
			是否上架：
			<input type="radio" value="-1" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="是" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == '是') echo 'checked="checked"'; ?> />  
			<input type="radio" value="否" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == '否') echo 'checked="checked"'; ?> />  
		</p>
		<p>
			商品描述：
	   		<input type="text" name="goods_desc" size="30" value="<?php echo I('get.goods_desc'); ?>" />
		</p>
		<p>
			主分类id：
	   		<input type="text" name="cat_id" size="30" value="<?php echo I('get.cat_id'); ?>" />
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >商品名称</th>
            <th >市场价格</th>
            <th >本店价格</th>
            <th >logo</th>
            <th >是否上架</th>
            <th >商品描述</th>
            <th >主分类id</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['goods_name']; ?></td>
				<td><?php echo $v['market_price']; ?></td>
				<td><?php echo $v['shop_price']; ?></td>
				<td><?php echo $v['logo']; ?></td>
				<td><?php echo $v['is_on_sale']; ?></td>
				<td><?php echo $v['goods_desc']; ?></td>
				<td><?php echo $v['cat_id']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p')); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
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