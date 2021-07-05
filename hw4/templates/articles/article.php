<div class="card">
  
  <div class="card-header">
    <a href="index.php?id_category=<?=$id_category?>"><?= $category; ?></a>
  </div>
  <div class="card-body">
    <h5 class="card-title"><?= $title; ?></h5>
    <p class="card-text"><?= $content; ?></p>
  </div>
  <div class="card-footer text-muted">
    <?= $dt_add; ?>
  </div>
</div>