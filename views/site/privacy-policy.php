<?php
// views/site/privacy-policy.php

use yii\helpers\Html;

$this->title = 'Политика конфиденциальности';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center mb-4 text-success"><?= Html::encode($this->title) ?></h1>

            <div class="card border-success">
                <div class="card-body">
                    <article class="policy-content">
                        <section class="mb-4">
                            <h2 class="text-success h4">1. Общие положения</h2>
                            <p>Настоящая политика конфиденциальности регулирует порядок сбора, использования и раскрытия
                            персональных данных пользователей сайта Benganelio.</p>
                        </section>

                        <section class="mb-4">
                            <h2 class="text-success h4">2. Собираемая информация</h2>
                            <p>Мы собираем следующую информацию:</p>
                            <ul>
                                <li>ФИО пользователя</li>
                                <li>Адрес электронной почты</li>
                                <li>Контактные данные (телефон, адрес)</li>
                                <li>Демографическая информация (страна, город)</li>
                                <li>Информация о животных</li>
                            </ul>
                        </section>

                        <section class="mb-4">
                            <h2 class="text-success h4">3. Использование информации</h2>
                            <p>Собранная информация используется для:</p>
                            <ul>
                                <li>Предоставления услуг питомника</li>
                                <li>Улучшения качества обслуживания</li>
                                <li>Обратной связи с пользователями</li>
                                <li>Организации выставок и мероприятий</li>
                            </ul>
                        </section>

                        <section class="mb-4">
                            <h2 class="text-success h4">4. Защита данных</h2>
                            <p>Мы принимаем все необходимые меры для защиты ваших персональных данных от
                            несанкционированного доступа, используя современные технологии шифрования.</p>
                        </section>

                        <section class="mb-4">
                            <h2 class="text-success h4">5. Cookies</h2>
                            <p>Наш сайт использует cookies для улучшения пользовательского опыта и анализа
                            трафика. Вы можете отключить cookies в настройках браузера.</p>
                        </section>

                        <section class="mb-4">
                            <h2 class="text-success h4">6. Изменения в политике</h2>
                            <p>Мы оставляем за собой право вносить изменения в настоящую политику конфиденциальности.
                            Все изменения будут опубликованы на этой странице.</p>
                        </section>

                        <section>
                            <h2 class="text-success h4">7. Контакты</h2>
                            <p>По всем вопросам касательно политики конфиденциальности обращайтесь:</p>
                            <p>
                                <strong>Email:</strong> privacy@benganelio.com<br>
                                <strong>Телефон:</strong> +7 (999) 123-45-67<br>
                                <strong>Адрес:</strong> г. Москва, ул. Примерная, д. 123
                            </p>
                        </section>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>