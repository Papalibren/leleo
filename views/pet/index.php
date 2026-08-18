<div class="container mt-4">
    <div class="card animal-card p-4">
        <h2 class="text-center">Имя животного</h2>
        <p><strong>Порода:</strong> Бенгальская</p>
        <p><strong>Дата рождения:</strong> 01.01.2022</p>
        <p><strong>Пол:</strong> Кот</p>
        <p><strong>Окрас:</strong> Мраморный</p>
        <p><strong>Код окраса:</strong> A1B2</p>
        <p><strong>Родословная:</strong> Документ</p>
        <p><strong>Чип:</strong> 123456789</p>
        <p><strong>Коэффициент инбридинга:</strong> 12.5%</p>
        <button class="btn btn-primary">Редактировать</button>
    </div>

    <ul class="nav nav-tabs mt-3" id="animalTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pedigree-tab" data-bs-toggle="tab" data-bs-target="#pedigree" type="button" role="tab">Родословная</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="siblings-tab" data-bs-toggle="tab" data-bs-target="#siblings" type="button" role="tab">Сибсы</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="offspring-tab" data-bs-toggle="tab" data-bs-target="#offspring" type="button" role="tab">Дети</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="html-tab" data-bs-toggle="tab" data-bs-target="#html" type="button" role="tab">HTML</button>
        </li>
    </ul>

    <div class="tab-content mt-2" id="animalTabContent">
        <div class="tab-pane fade show active" id="pedigree" role="tabpanel">
            <p>Здесь будет информация о родословной.</p>
        </div>
        <div class="tab-pane fade" id="siblings" role="tabpanel">
            <p>Здесь будут данные о сибсах.</p>
        </div>
        <div class="tab-pane fade" id="offspring" role="tabpanel">
            <p>Здесь будет список потомков.</p>
        </div>
        <div class="tab-pane fade" id="html" role="tabpanel">
            <p>Здесь будет HTML.</p>
        </div>
    </div>
</div>