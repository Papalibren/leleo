<?php
    $this -> title = 'Вопрос-ответ'
?>
<div class="container">
    <?= $this->render('/html/h1', ['h1' => $this->title]) ?>
</div>
<main class="pt-4">
    <div class="container">
        <div class="row mt-1 mb-5">
            <div class="col-12 col-md-10 col-lg-8 mx-auto">
                <div class="card bg-theme text-white text-center">
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Как осуществить покупку на сайте?
                                </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong class="text-success fs-5">
                                        Необходимо пройти регистрацию и авторизацию, затем выбрать товары и оформить заказ.
                                    </strong>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Можно ли изменить состав заказа?
                                </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong class="text-success fs-5">Да, вы можете добавить или удалить позиции в корзине заказа, после чего сумма заказа будет пересчитана.</strong>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Можно ли отследить статус заказа?
                                </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong class="text-success fs-5">Да, в личном кабинете вы можете наблюдать, как ваш заказ меняет статусы.</strong>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>