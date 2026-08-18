<form method="post" class="bg-<?=$bg?> p-3 rounded shadow">
    <div class="mb-2">
        <label class="form-label" for="">Имя</label>
        <input class="form-control" type="text" name="name" required>
    </div>
    <div class="mb-2">
        <label class="form-label" for="">Email</label>
        <input class="form-control" type="email" name="email" required>
    </div>
    <div class="mb-2">
        <label class="form-label" for="">Телефон</label>
        <input class="form-control" type="tel" name="phone" required>
    </div>
    <div class="mb-4">
        <label class="form-label" for="">Ваш вопрос</label>
        <textarea class="form-control" name="question" required></textarea>
    </div>
    <div class="mb-2">
        <button class="w-100 btn btn-<?=$btn_color?>" type="submit">
            Отправить
        </button>
    </div>
</form>