<? $validationTitleClass =  $errors['title'] ? 'is-invalid' : ''; ?>
<? $validationCategoryClass =  $errors['category'] ? 'is-invalid' : ''; ?>
<? $validationContentClass =  $errors['content'] ? 'is-invalid' : ''; ?>

<form action=<?= "index.php?c=$action" ?> method="post">
    <h2 class="col text-center alert alert-primary">
        <?= $title ?>
    </h2>
    <input type="hidden" name="id" value="<?= $fields['id'] ?>">
    <div class="row mb-3">
        <div class="col">
            <label clas="form-label" for="title-field">
                Title:
            </label>
            <?  ?>
            <input id="title-field" required class="form-control <?= $validationTitleClass ?>" type="text" name="title" value="<?= $fields['title']; ?>" placeholder="Введите заголовок статьи" aria-describedby="title-field-validation">
            <div class="invalid-feedback" id="title-field-validation">
                <?= $errors['title']; ?>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label clas="form-label" for="category-field">
                Category:
            </label>
            <select id="category-field" required class="form-control  <?= $validationCategoryClass ?>" name="id_category" placeholder="Введите текст статьи" aria-describedby="category-field-validation">
                <option value="" disabled selected>Выберите категорию статьи</option>
                <? foreach ($categories as $category) : ?>
                    <option value="<?= $category['id']; ?>" <?= ($category['id'] == ($fields['id_category']))
                                                                ? 'selected'
                                                                : '' ?>>
                        <?php echo $category['name']; ?>
                    </option>
                <? endforeach; ?>
            </select>
            <div class="invalid-feedback" id="category-field-validation">
                <?php echo $errors['category']; ?>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label clas="form-label" for="content-field">
                Content :
            </label>
            <textarea id="content-field" required class="form-control   <?= $validationContentClass ?>" name="content" placeholder="Введите текст статьи" aria-describedby="content-field-validation"><?= $fields['content']; ?></textarea>
            </label>
            <div class="invalid-feedback" id="content-field-validation">
                <?php echo $errors['content']; ?>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <button class="btn btn-primary"><?= $button ?></button>
        </div>
    </div>
    </div>
</form>