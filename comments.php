<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
 
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>
 
<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div id="<?php $comments->theId(); ?>">
        <div class="comment-author">
            <?php $comments->gravatar('40', ''); ?>
            <cite class="fn"><?php $comments->author(); ?></cite>
        </div>
        <div class="comment-meta">
            <a href="<?php $comments->permalink(); ?>"><?php $comments->date('Y-m-d H:i'); ?></a>
            <span class="comment-reply"><?php $comments->reply(); ?></span>
        </div>
        <?php $comments->content(); ?>
    </div>
<?php if ($comments->children) { ?>
    <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</li>
<?php } ?>

<?php $this->comments()->to($comments); ?>
<div class="row">
    <div id="comments">

<?php if($this->allow('comment')): ?>
<div class="alert alert-info">
    <span id="commentCount"><?php $this->commentsNum(_t('还不快抢沙发'), _t('只有地板了'), _t('已有 %d 条评论')); ?></span>
</div>
<?php $comments->listComments(); ?>
<?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
<div id="<?php $this->respondId(); ?>" class="respond">
<div class="respond panel panel-default">
	<div class="panel-body">
		<div class="cancel-comment-reply"></div>
		<h3 id="response">添加新评论</h3>
		<!-- 输入表单开始 -->
		    <form method="post" action="<?php $this->commentUrl() ?>" id="comment_form" class="form-horizontal">
		        <!-- 如果当前用户已经登录 -->
		        <?php if($this->user->hasLogin()): ?>
		            <!-- 显示当前登录用户的用户名以及登出连接 -->
		            <p>Logged in as <a href="<?php $this->options->adminUrl(); ?>"><?php $this->user->screenName(); ?></a>.
		            <a href="<?php $this->options->logoutUrl(); ?>" title="Logout">Logout &raquo;</a></p>

		        <!-- 若当前用户未登录 -->
		        <?php else: ?>

		    	<div class="form-group">
		    		<label for="author" class="col-sm-2 control-label required">昵称</label>
		    		<div class="col-sm-9">
		    			<div class="form-control-wrapper">
		    				<input type="text" name="author" class="form-control text empty" size="35" value="<?php $this->remember('author'); ?>" />
		    				<span class="material-input"></span>
		    			</div>
		    		</div>
		    	</div>
				<div class="form-group">
		    		<label for="mail" class="col-sm-2 control-label required">邮箱</label>
		    		<div class="col-sm-9">
		    			<div class="form-control-wrapper">
		    				<input type="email" name="mail" class="form-control text empty" size="35" value="<?php $this->remember('mail'); ?>" />
		    				<span class="material-input"></span>
		    			</div>
		    		</div>
		    	</div>
		    	<div class="form-group">
		    		<label for="url" class="col-sm-2 control-label required">网站</label>
		    		<div class="col-sm-9">
		    			<div class="form-control-wrapper">
		    				<input type="url" name="url" class="form-control text empty" size="35" value="<?php $this->remember('url'); ?>" placeholder="http://"/>
		    				<span class="material-input"></span>
		    			</div>
		    		</div>
		    	</div>
		        <?php endif; ?>

		        <div class="form-group">
		    		<label for="textarea" class="col-sm-2 control-label required">内容</label>
		    		<div class="col-sm-9">
		    			<div class="form-control-wrapper">
		    				<textarea placeholder="我好想射点儿什么！" rows="5" cols="50" name="text" id="textarea" class="form-control textarea  empty" required=""></textarea>
		    				<span class="material-input"></span>
		    			</div>
		    		</div>
		    	</div>
		    	<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-5">
		    			<button type="submit" id="submit" class="btn btn-success btn-raised submit">来一发~</button>
		    		</div>
		    	</div>
		    </form>
	</div>
</div>
</div>
<?php else: ?>

	<div class="alert alert-warning">
	    <span id="commentCount">评论已关闭</span>
	</div>

<?php endif; ?>
</div>
</div>