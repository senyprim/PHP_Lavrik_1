<form action=<?="index.php?c=$action"?> method="post">
    <h2 class="col text-center alert alert-primary">
        <?=$title?>
    </h2>
    <input type="hidden" name="id" value="<?=$fields['id'] ?? ''?>">
    <div class="row mb-3">
        <label clas="form-label">
            Title:
            <input required class="form-control " type="text" name="title" value="<?=$fields['title'] ?? '';?>" placeholder="Введите заголовок статьи">
        </label>
        <div class="invalid-feedback">
            <?php echo $errors['title'] ?? '' ?>
        </div>
    </div>
    <div class="row mb-3">
        <label clas="form-label">
            Category:
            <select required class="form-control" name="id_category" placeholder="Введите текст статьи">
                <option value="" disabled selected>Выберите категорию статьи</option>
                <?foreach ($categories as $category): ?>
                    <option
                    value="<?=$category['id'] ?? ''?>"
                     <?=($category['id'] == ($fields['id_category'] ?? ''))
? 'selected'
: ''?>>
                        <?php echo $category['name'] ?? ''; ?>
                    </option>
                <?endforeach;?>
            </select>
        </label>
        <div class="invalid-feedback">
            <?php echo $errors['category'] ?? '' ?>
        </div>
    </div>
    <div class="row mb-3">
        <label clas="form-label">
            Content :
            <textarea required
            class="form-control"
            name="content"
            placeholder="Введите текст статьи"><?=$fields['content'] ?? ''?></textarea>
        </label>
        <div class="invalid-feedback">
            <?php echo $errors['content'] ?? '' ?>
        </div>
    </div>
    <div class="row mb-3">
        <button class="btn btn-primary"><?=$button?></button>
    </div>
</form>