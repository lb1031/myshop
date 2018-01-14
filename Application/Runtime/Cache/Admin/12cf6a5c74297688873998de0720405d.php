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


<div class="form-div">
    <form action="/index.php/Admin/Goods/lst.html" name="searchForm">
    <img src="/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
    商品名称：<input type="text" name="gn" size="15" value="<?php echo I('get.gn')?>" />
    商品价格：从<input type="text" name="fg" value="<?php echo I('get.fg')?>" size="15" />到
             <input type="text" name="tg" value="<?php echo I('get.tg')?>" size="15" />
    是否上架：<input type="radio" name="is_on_sale" <?php if(I('get.is_on_sale',0) ==0 ) echo 'checked = "checked"' ;?> value="0" />全部
             <input type="radio" name="is_on_sale" <?php if(I('get.is_on_sale') =='是' ) echo 'checked = "checked"' ;?> value="是"/>是
             <input type="radio" name="is_on_sale" <?php if(I('get.is_on_sale') =='否' ) echo 'checked = "checked"' ;?> value="否"/>否
    <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>商品id</th>
                <th>商品LOGO</th>
                <th>商品名称</th>
                <th>市场价格</th>
                <th>本店价格</th>
                <th>是否上架</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $v){;?>
            <tr>
                <!--<td class="first-cell">-->
                    <!--<span style="float:right"><a href="" target="_brank"><img src="" width="16" height="16" border="0" alt="商品LOGO" /></a></span>-->
                    <!--<span></span>-->
                <!--</td>-->
                <!--<td align="center">-->
                    <!--<a href="<{$val.site_url}>" target="_brank"></a>-->
                <!--</td>-->
                <td align="center"><?php echo $v['id']?></td>
                <td align="center"><img src="<?php echo IMG_PASH.$v['sm_logo']?>"/></td>
                <td align="center"><?php echo $v['goods_name']?></td>
                <td align="center"><?php echo $v['market_price']?></td>
                <td align="center"><?php echo $v['shop_price']?></td>
                <td align="center"><?php echo $v['is_on_sale']?></td>
                <td align="center"><img src="" /></td>
                <td align="center">
                <a href="<?php echo U('edit?id='.$v['id'])?>" title="编辑">编辑</a> |
                <a onclick="confirm('你确定要删除吗？')" href="<?php echo U('delete?id='.$v['id'])?>" title="编辑">移除</a>
                </td>
            </tr>
            <?php };?>
            <tr>
                <td align="right" nowrap="true" colspan="6">
                    <?php echo $show;?>
                </td>
            </tr>
        </table>
    </div>
</form>



<div id="footer">
    共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>