<div class="list-group">
    <? foreach ($articles as $article) : ?>
            <?=render('articles/article-small',$article);?>
    <? endforeach ?>
</div>
