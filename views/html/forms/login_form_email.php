<form action="" method="post" class="bg-<?=$bg?> p-3 rounded shadow">
    <div class="row">
        <div class="col-12 mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="col-12 mb-5">
            <label for="" class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="col-12 mb-1">
            <button type="submit" class="btn btn-<?= $btn_color ?> text-white fw-bold w-100">
                Вход
            </button>
        </div>
    </div>
</form>