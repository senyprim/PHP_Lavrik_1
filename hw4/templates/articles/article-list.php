<div class="list-group">
    <h2><?= $title ?></h2>
    <? foreach ($articles as $article) : ?>
            <?=render('articles/article-small',$article);?>
    <? endforeach ?>
</div>
