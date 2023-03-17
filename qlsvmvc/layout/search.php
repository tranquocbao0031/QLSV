<form action="/" method="GET">
    <label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control"
            value="<?= $search ?>">
        <button class="btn btn-danger">Tìm</button>
    </label>
    <?php if ($c != 'student') : ?>
    <input type="hidden" name="c" value="<?= $c ?>">
    <?php endif ?>
</form>