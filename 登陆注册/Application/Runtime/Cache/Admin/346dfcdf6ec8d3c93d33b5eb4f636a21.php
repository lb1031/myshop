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
	    <form method="post" action="<?php echo U('add'); ?>" enctype="multipart/form-data" >
	    	<!-- 基本信息 -->
	        <table class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td class="label">主分类</td>
	                <td>
	                    <select name="cat_id">
	                    	<option value="">请选择分类</option>
	                    	<?php foreach ($catData as $k => $v): ?>
	                    		<option value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*8).$v['cat_name']; ?></option>
	                    	<?php endforeach; ?>
	                    </select>
	                    <span class="require-field">*</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">扩展分类</td>
	                <td>
	                	<input onclick="addNewExtCat(this);" type="button" value="添加一个扩展分类" />
	                    <select name="ext_cat_id[]">
	                    	<option value="">请选择分类</option>
	                    	<?php foreach ($catData as $k => $v): ?>
	                    		<option value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*8).$v['cat_name']; ?></option>
	                    	<?php endforeach; ?>
	                    </select>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">商品名称</td>
	                <td>
	                    <input type="text" name="goods_name" size="60" maxlength="60" value="" />
	                    <span class="require-field">*</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">市场价格</td>
	                <td>
	                    <input type="text" name="market_price" />
	                    <span class="require-field">*</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">本店价格</td>
	                <td>
	                    <input type="text" name="shop_price" />
	                    <span class="require-field">*</span>
	                </td>
	            </tr>
	            <tr>
	                <td class="label">促销价格</td>
	                <td>
	                    ￥<input type="text" size="8" name="promote_price" />元
	                    促销开始时间 <input type="text" name="promote_start_date" />
	                    促销结束时间 <input type="text" name="promote_end_date" />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">商品LOGO</td>
	                <td>
	                    <input type="file" name="logo" />
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否显示</td>
	                <td>
	                    <input type="radio" name="is_on_sale" value="是" checked="checked" /> 是
	                    <input type="radio" name="is_on_sale" value="否"  /> 否
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否新品</td>
	                <td>
	                    <input type="radio" name="is_new" value="是" checked="checked" /> 是
	                    <input type="radio" name="is_new" value="否"  /> 否
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否推荐</td>
	                <td>
	                    <input type="radio" name="is_rec" value="是" checked="checked" /> 是
	                    <input type="radio" name="is_rec" value="否"  /> 否
	                </td>
	            </tr>
	            <tr>
	                <td class="label">是否热销</td>
	                <td>
	                    <input type="radio" name="is_hot" value="是" checked="checked" /> 是
	                    <input type="radio" name="is_hot" value="否"  /> 否
	                </td>
	            </tr>
	        </table>
	        <!-- 商品描述 -->
	        <table style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td><textarea id="goods_desc" name="goods_desc" cols="60" rows="4"  ></textarea></td>
	            </tr>
	        </table>
	        <!-- 会员价格 -->
	        <table style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<?php foreach ($mlData as $k => $v): ?>
	        	<tr>
	                <td class="label"><?php echo $v['level_name']; ?></td>
	                <td>
	                	￥ <input type="text" name="member_price[]" /> 元
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
	                    	<?php foreach ($typeData as $k => $v): ?>
	                    		<option value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
	                    	<?php endforeach; ?>
	                    </select>
	                    <ul id="attr_list"></ul>
	                </td>
	            </tr>
	        </table>
	        <!-- 商品相册 -->
	        <table id="table_pic_list" style="display:none;" class="tab_content" cellspacing="1" cellpadding="3" width="100%">
	        	<tr>
	                <td><input id="btn_add_pic" type="button" value="添加一张" /></td>
	            </tr>
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
// 为类型绑定change事件
$("select[name=type_id]").change(function(){
	// 先取出选择的类型ID
	var type_id = $(this).val();
	$.ajax({
		type : "GET",
		url : "<?php echo U('ajaxGetAttr', '', FALSE); ?>/type_id/"+type_id,
		dataType : "json",
		success : function(data)
		{
			// 循环服务器返回的属性数据拼成一个HTML字符串
			var html = "";
			// 循环每个属性
			$(data).each(function(k,v){
				html += "<li><input type='hidden' name='attr_id[]' value='"+v.id+"' />";
				if(v.attr_type == '可选')
					html += '<a href="javascript:void(0);" onclick="addRow(this);">[+]</a>';
				html += v.attr_name+" : ";
				if(v.attr_option_value != "")
				{
					var _arr = v.attr_option_value.split(",");
					html += "<select name='goods_attr[]'><option value=''>请选择</option>";
					for(var i=0; i<_arr.length; i++)
					{
						html += '<option value="'+_arr[i]+'">'+_arr[i]+'</option>';
					}
					html += "</select>";
				}
				else
					html += "<input type='text' name='goods_attr[]' />";
				html += "</li>";
			});
			// 把拼好的LI字符串放到页面中
			$("#attr_list").html(html);
		}
	});
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
		// 变成-号
		newLi.find('a').html('[-]');
		// 新LI放到LI后面
		li.after(newLi);
	}
	else
		li.remove();
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

$("#btn_add_pic").click(function(){
	$("#table_pic_list").append('<tr><td><input type="file" name="pic[]" /></td></tr>');
});
</script>

















<div id="footer"> abc </div>
</body>
</html>