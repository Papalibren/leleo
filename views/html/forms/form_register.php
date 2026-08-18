<form method="post" class="bg-<?=$bg?> p-3 rounded shadow">
    <div class="mb-2">
        <label class="form-label" for="">Имя</label>
        <input class="form-control" type="text" name="first_name">
    </div>
    <div class="mb-2">
        <label class="form-label" for="">Email</label>
        <input class="form-control" type="email" name="email">
    </div>
    <div class="mb-4">
        <label class="form-label" for="">Пароль</label>
        <input class="form-control" type="password" name="password">
    </div>
    <div class="mb-2">
        <button class="w-100 btn btn-<?=$btn_color?>" type="submit">
            Зарегистрировать
        </button>
    </div>
</form>