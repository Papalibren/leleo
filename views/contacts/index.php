<?php
$this->title = 'Контактная информация'
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
                        <h5 class="card-title fs-3">
                            <i class="bi bi-envelope-at"></i>
                                <i class="ms-2 bi bi-telephone-outbound"></i>
                        </h5>
                        <h6 class="card-subtitle mb-5 mt-4 fs-4 lh-lg">
                            Наш онлайн магазин принимает заказы и отгружает их 24/7
                            <br>
                            без выходных и праздников
                            <br>
                            Вы можете связаться с нами по телефону или написать @email
                            <a class="text-white" href="/user/cart">Сделать заказ можно здесь</a>
                        </h6>

                        <a class="btn btn-light px-4 mx-2" href="maito:digitalmarket@mail.ru">
                            Написать нам <i class="ms-2 bi bi-envelope-at"></i>
                        </a>
                        <a class="btn btn-light px-4 mx-2" href="tel:+79900099009">Позвонить нам <i class="ms-2 bi bi-telephone-outbound"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>