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

    
<div class="main-div">
    <form method="post" action="<?php echo U('edit'); ?>" enctype="multipart/form-data" >
    	<input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
        	<tr>
                <td class="label">上级分类</td>
                <td>
                    <select name="parent_id">
                    	<option value="0">顶级分类</option>
                    	<?php foreach ($data as $k => $v): if($v['id'] == $info['id'] || in_array($v['id'], $children)) continue ; if($info['parent_id'] == $v['id']) $select = 'selected="selected"'; else $select = ''; ?>
                    	<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*8) . $v['cat_name']; ?></option>
                    	<?php endforeach; ?>
                    </select>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">分类名称</td>
                <td>
                    <input type="text" name="cat_name" size="60" maxlength="60" value="<?php echo $info['cat_name']; ?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">是否推荐楼层</td>
                <td>
                    <input type="radio" name="is_rec" value="是" <?php if($info['is_rec'] == '是') echo 'checked="checked"'; ?> /> 推荐
                    <input type="radio" name="is_rec" value="否" <?php if($info['is_rec'] == '否') echo 'checked="checked"'; ?> /> 不推荐
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

<div id="footer"> abc </div>
</body>
</html>