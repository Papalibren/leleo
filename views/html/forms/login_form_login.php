<form action="" method="post" class="bg-<?=$bg?> p-3 rounded shadow">
    <div class="row">
        <div class="col-12 mb-3">
            <label for="" class="form-label">Логин</label>
            <input type="text" class="form-control" name="login" required>
        </div>
        <div class="col-12 mb-5">
            <label for="" class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="col-12 mb-1">
            <button type="submit" class="btn btn-<?=$btn_color?> text-white fw-bold w-100">
                Вход
            </button>
        </div>
    </div>
</form>