<?php
// views/html/footer.php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-success">Benganelio</h5>
                <p>Питомник кошек и собак с любовью к животным.</p>
                <div class="social-icons">
                    <a href="#" class="text-light me-3 fs-4"><i class="bi bi-telegram"></i></a>
                    <a href="#" class="text-light me-3 fs-4"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="text-light me-3 fs-4"><i class="bi bi-envelope"></i></a>
                    <a href="#" class="text-light fs-4"><i class="bi bi-telephone"></i></a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="text-success">Разделы сайта</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-light text-decoration-none">Главная</a></li>
                    <li><a href="/cats" class="text-light text-decoration-none">Кошки</a></li>
                    <li><a href="/dogs" class="text-light text-decoration-none">Собаки</a></li>
                    <li><a href="/nursery/list" class="text-light text-decoration-none">Питомники</a></li>
                    <li><a href="/announcement" class="text-light text-decoration-none">Объявления</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="text-success">Информация</h5>
                <ul class="list-unstyled">
                    <li><a href="/privacy-policy" class="text-light text-decoration-none">Политика конфиденциальности</a></li>
                </ul>
            </div>
        </div>

        <hr class="bg-success">

        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; 2025 Benganelio. Все права защищены.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">Контакты: info@benganelio.com | +7 (999) 123-45-67</p>
            </div>
        </div>
    </div>
</footer>