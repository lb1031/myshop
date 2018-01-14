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


	<link href="/Public/um/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/Public/um/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/um/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/um/umeditor.min.js"></script>
    <script type="text/javascript" src="/Public/um/lang/zh-cn/zh-cn.js"></script>
    
<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front">基本信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
	    <form method="post" action="<?php echo U('edit'); ?>" enctype="multipart/form-data" >
	    	<input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
	        <table class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td class="label">主分类</td>
	                <td>
	                    <select name="cat_id">
	                    	<option value="">请选择分类</option>
	                    	<?php foreach ($catData as $k => $v): if($info['cat_id'] == $v['id']) $select = 'selected="selected"'; else $select = ''; ?>
	                    		<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*8).$v['cat_name']; ?></option>
	                    	<?php endforeach; ?>
	                    </select>
	                    <span class="require-field">*</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">扩展分类</td>
	                <td>
	                	<input onclick="addNewExtCat(this);" type="button" value="添加一个扩展分类" />
	                	<!-- 如果有扩展分类就循环，如果没有就默认显示一个 -->
	                	<?php if($ecatId): ?>
		                	<?php foreach ($ecatId as $v0): ?>
			                    <select name="ext_cat_id[]">
			                    	<option value="">请选择分类</option>
			                    	<?php foreach ($catData as $k => $v): if($v['id'] == $v0['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
			                    		<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*8).$v['cat_name']; ?></option>
			                    	<?php endforeach; ?>
			                    </select>
		                    <?php endforeach; ?>
		                <?php else: ?>
		                 	<select name="ext_cat_id[]">
			                    	<option value="">请选择分类</option>
			                    	<?php foreach ($catData as $k => $v): if($v['id'] == $v0['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
			                    		<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*8).$v['cat_name']; ?></option>
			                    	<?php endforeach; ?>
			                    </select>
		                <?php endif; ?>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">商品名称</td>
	                <td>
	                    <input type="text" name="goods_name" size="60" maxlength="60" value="<?php echo $info['goods_name']; ?>" />
	                    <span class="require-field">*</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">市场价格</td>
	                <td>
	                    <input type="text" name="market_price" value="<?php echo $info['market_price']; ?>" />
	                    <span class="require-field">*</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">本店价格</td>
	                <td>
	                    <input type="text" name="shop_price" value="<?php echo $info['shop_price']; ?>" />
	                    <span class="require-field">*</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">促销价格</td>
	                <td>
	                    ￥<input type="text" size="8" name="promote_price" value="<?php echo $info['promote_price']; ?>" />元
	                    促销开始时间 <input type="text" name="promote_start_date" value="<?php echo $info['promote_start_date']; ?>" />
	                    促销结束时间 <input type="text" name="promote_end_date" value="<?php echo $info['promote_end_date']; ?>" />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">商品LOGO</td>
	                <td>
	                    <input type="file" name="logo" /><br />
	                    <img src="<?php echo IMAGE_ROOT . $info['sm_logo']; ?>" />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否显示</td>
	                <td>
	                    <input type="radio" name="is_on_sale" value="是" <?php if($info['is_on_sale']=='是') echo 'checked="checked"'; ?> /> 是
	                    <input type="radio" name="is_on_sale" value="否" <?php if($info['is_on_sale']=='否') echo 'checked="checked"'; ?>  /> 否
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否新品</td>
	                <td>
	                    <input type="radio" name="is_new" value="是" <?php if($info['is_new'] == '是') echo 'checked="checked"'; ?> /> 是
	                    <input type="radio" name="is_new" value="否" <?php if($info['is_new'] == '否') echo 'checked="checked"'; ?>  /> 否
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否推荐</td>
	                <td>
	                    <input type="radio" name="is_rec" value="是" <?php if($info['is_rec'] == '是') echo 'checked="checked"'; ?> /> 是
	                    <input type="radio" name="is_rec" value="否" <?php if($info['is_rec'] == '否') echo 'checked="checked"'; ?> /> 否
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否热销</td>
	                <td>
	                    <input type="radio" name="is_hot" value="是" <?php if($info['is_hot'] == '是') echo 'checked="checked"'; ?> /> 是
	                    <input type="radio" name="is_hot" value="否" <?php if($info['is_hot'] == '否') echo 'checked="checked"'; ?> /> 否
	                </td>
	            </tr>
	        </table>
	        <!-- 商品描述 -->
	        <table style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td>
	                    <textarea id="goods_desc" name="goods_desc" cols="60" rows="4"><?php echo $info['goods_desc']; ?></textarea>
	                </td>
	            </tr>
	        </table>
	        <!-- 会员价格 -->
	        <table style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<?php foreach ($mlData as $k => $v): ?>
	        	<tr>
	                <td class="label"><?php echo $v['level_name']; ?></td>
	                <td>
	                	￥ <input value="<?php echo $mpData[$v['id']]; ?>" type="text" name="member_price[]" /> 元
	                	<input type="hidden" name="level_id[]" value="<?php echo $v['id']; ?>" />
	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </table>
	        <!-- 商品属性 -->
	        <table style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td class="label">类型</td>
	                <td>
	                    <select name="type_id">
	                    	<option value="">请选择类型</option>
	                    	<?php foreach ($typeData as $k => $v): if($info['type_id'] == $v['id']) $select = 'selected="selected"'; else $select = ''; ?>
	                    		<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
	                    	<?php endforeach; ?>
	                    </select>
	                    <!-- 循环每个商品属性 -->
	                    <ul id="attr_list">
	                    <?php  $attrId = array(); foreach ($attrData as $k => $v): if(in_array($v['attr_id'], $attrId)) $opt = '-'; else { $opt = '+'; $attrId[] = $v['attr_id']; } ?>
	                    	<li>
	                    		<input type="hidden" name="gaid[]" value="<?php echo $v['id']; ?>" />
		                    	<input type="hidden" name="old_attr_id[]" value="<?php echo $v['attr_id']; ?>" />
		                    	<?php if($v['attr_type'] == '可选'): ?>
		                    		<a onclick="addRow(this);" href="javascript:void(0);">[<?php echo $opt; ?>]</a>
		                    	<?php endif; ?>
		                    	<?php echo $v['attr_name']; ?> : 
		                    	<?php if($v['attr_option_value']): $_attr = explode(',', $v['attr_option_value']); ?>
		                    		<select name="old_goods_attr[]">
		                    			<option value="">请选择</option>
		                    			<?php foreach ($_attr as $k1 => $v1): if($v1 == $v['attr_value']) $select = 'selected="selected"'; else $select = ''; ?>
		                    			<option <?php echo $select; ?> value="<?php echo $v1; ?>"><?php echo $v1; ?></option>
		                    			<?php endforeach; ?>
		                    		</select>
		                    	<?php else: ?>
		                    		<input type="text" name='old_goods_attr[]' value="<?php echo $v['attr_value']; ?>" />
		                    	<?php endif; ?>
	                    	</li>
	                    <?php endforeach; ?>
	                    </ul>
	                </td>
	            </tr>
	        </table>
	        <!-- 商品相册 -->
	        <table id="table_pic_list" style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td><input id="btn_add_pic" type="button" value="添加一张" /></td>
	            </tr>
	            <tr><td>
	            <ul>
		            <?php foreach ($gpData as $k => $v): ?>
		            	<li style="float:left;margin:5px;width:150x;height:200px;overflow:hidden;list-style-type:none;">
			            	<?php showImage($v['mid_pic'], 130); ?>
			            	<br /><input pic_id="<?php echo $v['id']; ?>" class="btn_del_image" type="button" value="删除" />
		            	</li>
		            <?php endforeach; ?>
	            </ul>
	            </td></tr>
	            <tr><td><input type="file" name="pic[]" /></td></tr>
	        </table>
	        <!-- 提交按钮 -->
	        <table cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td colspan="2" align="center"><br />
	                    <input type="submit" class="button" value=" 确定 " />
	                    <input type="reset" class="button" value=" 重置 " />
	                </td>
	            </tr>
	        </table>
	    </form>
	</div>
</div>

<script>
UM.getEditor('goods_desc', {
	initialFrameWidth : "100%"
});

function addNewExtCat(btn)
{
	// 选择后面的下拉框并克隆一个
	var newSel = $(btn).next("select").clone();
	// 把新的下拉框添加到当前TD的最后
	$(btn).parent().append(newSel);
}
$("#tabbar-div p span").click(function(){
	// 获取点击的是第几个
	var i = $(this).index();
	// 先隐藏所有的table
	$(".tab_content").hide();
	// 显示第i个
	$(".tab_content").eq(i).show();
	$(".tab-front").removeClass("tab-front").addClass('tab-back');
	$(this).removeClass("tab-back").addClass('tab-front');
});

// +号的事件
function addRow(a)
{
	// 先选中所在的LI标签
	var li = $(a).parent();
	if(li.find('a').html() == '[+]')
	{
		// 克隆一个新的LI
		var newLi = li.clone();
		newLi.find("select").attr("name", 'goods_attr[]');
		newLi.find("input[name='gaid[]']").remove();
		newLi.find("input[name='old_attr_id[]']").attr("name", 'attr_id[]');
		// 变成-号
		newLi.find('a').html('[-]');
		// 新LI放到LI后面
		li.after(newLi);
	}
	else
	{
		if(confirm('确定要删除吗？'))
		{
			// 先获取要删除的商品属性的ID
			var gaid = li.find("input[name='gaid[]']").val();
			$.ajax({
				type : "GET",
				url : "<?php echo U('ajaxDelGoodsAttr', '', FALSE); ?>/gaid/"+gaid,
				success : function(data)
				{
					li.remove();
				}
			});
		}
	}
}

$("#btn_add_pic").click(function(){
	$("#table_pic_list").append('<tr><td><input type="file" name="pic[]" /></td></tr>');
});

$(".btn_del_image").click(function(){
	if(confirm('确定要删除吗？'))
	{
		var picId = $(this).attr('pic_id');
		// 先获取图片所在的LI标签
		var li = $(this).parent();
		$.ajax({
			type : "GET",
			url : "<?php echo U('ajaxDelImage', '', FALSE); ?>/pic_id/"+picId,
			success : function(data)
			{
				li.remove();
			}
		});
	}
});

</script>

<div id="footer"> abc </div>
</body>
</html>