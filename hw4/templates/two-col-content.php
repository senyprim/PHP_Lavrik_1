<div class="container">
    <? if (!!($notice??'')) : ?>
        <div class="alert alert-primary" role="alert">
            <?= $notice??'' ?>
        </div>
    <? endif ?>

    <div class="row">
        <div class="col-3">
            <?= $aside ?>
        </div>
        <div class="col-9">
            <?= $article ?>
        </div>
    </div>
</div>