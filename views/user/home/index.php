        <!-- Main content -->
        <main class="col-md-9 col-lg-10 content">
            <h2>Личный кабинет заводчика</h2>
            <p>
                <span>Ваш статус - </span>
                <?=Yii::$app->user->identity->getStatusView()?>
            </p>
            <p>Добро пожаловать! Здесь вы можете управлять своими питомцами и объявлениями.</p>
        </main>