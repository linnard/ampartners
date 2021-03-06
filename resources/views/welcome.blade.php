<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AM partners - Закрита партнерська база вакансій | Інформація</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
</head>
<body>
<div class="Wrapper Wrapper-infoPage" id="topSide">
    <header class="Header Header-infoPage">
        <a href="/" class="Logo Header_logo" title="AMpartners">
            <img src="img/logo.png" alt="Логотип" class="Logo_img">
        </a>
        <div class="MainMenu MainMenu-infoPage Header_menu">
            <ul class="MainMenu_list">
                <li class="MainMenu_item MainMenu_item-active"><label for="popupAccessDenied" class="MainMenu_link">Інформація</label></li>
                @auth
                    <li class="MainMenu_item"><a href="{{ url('/adminpanel') }}" class="MainMenu_link">Кабінет</a></li>
                @else
                    <li class="MainMenu_item"><a href="{{ route('login') }}" class="MainMenu_link">Вхід в систему</a></li>

                    @if (Route::has('register'))
                        <li class="MainMenu_item"><a href="{{ route('register') }}" class="MainMenu_link">Реєстрація</a></li>
                    @endif
                @endauth

            </ul>
        </div>
    </header>
    <main class="Main Main-infoPage">
        <div class="Container">
            <div class="WhiteBlock Article">
                <h2 class="BorderedTitle Article_subTitle">Коротко про співпрацю</h2>
                <div class="Article_text">
                    <p>Ми створили унікальний проект, який:</p>
                    <ol>
                        <li>Дозволить максимально зменшити обман в сфері працевлаштування в Україні;</li>
                        <li>Надасть можливість бізнесу та посередникам працювати тільки з перевіреними вакансіями;</li>
                        <li>Дасть можливість кожному бажаючому абсолютно безкоштовно та без фінансових вкладень всього за 1 день створити свій власний бізнес &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;та займатись працевлаштуванням;</li>
                        <li>Змусить польські, чеські та інші іноземні агенції праці пропонувати справедливі умови праці та оплати для українських заробітчан.</li>
                    </ol>
                    <p>А тепер про все по-порядку:</p>
                </div>
                <h2 class="BorderedTitle Article_subTitle">Інноваційний проект</h2>
                <div class="Article_text">
                    <p>ТОВ «<strong>Робота за кордоном від Андрія Марисюка</strong>» створила та успішно масштабувала першу в Україні унікальну систему внутрішнього партнерства, яка вже за перший місяць свого існування значно зменшила відсоток обману на ринку працевлаштування та забезпечила власним бізнесом багатьох українців.</p>
                    <p>Згідно офіційних даних, кожен 3-тій українець, який звертається за допомогою в працевлаштуванні - залишається незадоволеним наданими послугами. Кожен 5-тий потрапляє до рук шахраїв. На жаль, сама така ситуація на ринку працевлаштування існує на даний момент по всій Україні.</p>
                    <p>Ми розрахували, що вже до кінця 2020 року наша розробка безкоштовно надасть можливість декільком тисяч українців почати займатись власною справою без будь-якого попереднього досвіду роботи та без фінансових затрат. В результаті, приблизно на 11%-17% зменшиться відсоток загального шахрайства та недобросовісного надання послуг у сфері працевлаштування та візової підтримки.</p>
                </div>
                <h2 class="BorderedTitle Article_subTitle">Основні проблеми у сфері працевлаштування та візової підтримки</h2>
                <div class="Article_text">
                    <p>Основною проблемою в сфері працевлаштування є неналагоджений зв’язок між фізичними та юридичними об’єктами, які надають послуги з працевлаштування та виконавчими органами, які ці послуги контролюють. Завдяки недостатньому контролю з боку держави за діяльністю агенцій, компаній та різних посередників, які займаються працевлаштуванням, одні з них надають послуги на досить низькому рівні, а інші взагалі використовують фіктивні або напівлегальні схеми, які досить часто перекреслюють майбутнім заробітчанам їх майбутню поїздку за кордон.</p>
                    <p>На сьогоднішній день багато людей помилково вважають, що робота в сфері працевлаштування - це звичайне посередництво, тому вони стараються також увійти в цю нішу. Звичайно, при цьому вони не несуть жодної відповідальності за свої дії. В результаті ми отримуємо вищеописану статистику та десятки тисяч незадоволених або обманутих людей, які не можуть захистити свої власні права.</p>
                </div>
                <h2 class="BorderedTitle Article_subTitle">Чому так відбувається</h2>
                <div class="Article_text">
                    <p>Справа в тому, що Польща, Чехія та інші країни для розвитку власної економіки та створення найбільш сприятливого середовища для бізнесу потребують заробітчан із інших країн. Зрозуміло, що робоча сила потрібна всім, проте далеко не всі підприємства готові забезпечити нормальні умови роботи своїм працівникам або гідну оплату за їх працю. Тому, щоб набрати собі необхідний штат працівників такі недобросовісні закордонні агенції зв’язуються із українськими посередниками та невеликими компаніями та пропонують їм співпрацю. Звичайно, що для українських партнерів вони розкажуть про те, що графік роботи, умови праці та проживання у них на досить високому рівні і навіть можуть присилати фото та відео, які це будуть підтверджувати. Звичайно, що після надання таких незначних доказів (або навіть при їх відсутності) українські посередники починають пропонувати своїм клієнтам щойно запропоновані вакансії. В результаті, коли люди приїжджають на роботу, вони бачать, що все те, що було сказано - неправда. Проте, їм вже не завжди вдається змінити роботу і вони змушені залишатись. Такими та іншими шахрайськими схемами користуються закордонні агенції праці, використовуючи українських посередників для своїх цілей.</p>
                </div>
                <h2 class="BorderedTitle Article_subTitle">Вирішення проблеми</h2>
                <div class="Article_text">
                    <p>Для того, щоб захистити українських заробітчан від обману при працевлаштуванні за кордоном та дати можливість іншим партнерам й надалі займатись своєю діяльністю, ми розробили єдину базу перевірених вакансій, яка включає тільки надійних роботодавців. Всі вакансії особисто перевіряються власником та генеральним директором компанії - Андрієм Марисюком. Деякі відеоролики із того чи іншого місця роботи публікуються на основному YouTube каналі для загальної багатотисячної аудиторії. Інші ж вакансії або публікуються в закритому режимі на окремому каналі, який доступний для внутрішнього ознайомлення партнерам, або отримують одобрення без публікацій.</p>
                    <p>Таким чином, кожен партнер, використовуючи нашу систему, зможе абсолютно безкоштовно отримати доступ до загальної бази тільки надійних партнерів і пропонувати всі вакансії своїм клієнтам, при цьому знаючи і будучи впевненими, що всі навіть незначні нюанси гарантовано будуть дотримані, і в разі виникнення додаткових запитань чи побажань зі сторони клієнта, вони не будуть проігноровані.</p>
                </div>
                <h2 class="BorderedTitle Article_subTitle">Як все працює</h2>
                <div class="Article_text">
                    <img src="img/article_img.png" alt="Як все працює" class="Article_img Article_img-right Article_img-outside">
                    <p>Кожен бажаючий зможе подати заявку на доступ до єдиної бази вакансій. Користування базою повністю безкоштовне. Для подання заявки необхідно <a href="javascript:;">зареєструватись</a>. <br>у відповідь ви отримаєте посилання-анкету, яку потрібно заповнити. Звичайно, ми в першу чергу надаємо перевагу великим компаніям, які працюють по ліцензії Міністерства <br>соціальної політики України, проте якщо ви тільки хочете спробувати себе в сфері працевлаштування, і у вас немає навіть сайту - ми розглянемо вашу заявку індивідуально. Іноді, бажання працювати, старатись та розвиватись для нас грає набагато більшу роль ніж наявність ліцензії, сайту та великого офісу.</p>
                    <p>Після одобрення заявки ви отримаєте унікальні дані для входу. Всі вакансії завжди оновлюються в режимі реального часу та мають дуже детальний опис, в якому завжди прописані майже всі нюанси, які стосуються цієї роботи.</p>
                    <p>Окремої уваги заслуговує система бронювання та контролю клієнтів. Це наша особиста розробка, яка вже отримала найвищі оцінки та позитивні відгуки від існуючих партнерів.</p>
                    <p>Навіть якщо ви раніше нічим подібним не займались - всього за 15 хвилин ви повністю у всьому розберетесь, тому що крім максимально інтуїтивного інтерфейсу, над яким більше року працювали наші спеціалісти, ви також отримаєте доступ до інструкцій, в яких буде детально описано як саме працює наша закрита партнерська база вакансій.</p>
                </div>
                <h2 class="BorderedTitle Article_subTitle">Кому це вигідно</h2>
                <div class="Article_text">
                    <p>Саме ось тут полягає унікальність та логічність нашої розробки, тому що користуватись нею буде вигідно абсолютно всім!</p>
                    <p><strong>Для великого, середнього та малого бізнесу</strong></p>
                    <p>У вас буде можливість розширити свій бізнес, отримавши доступ до перевірених вакансій, в якості яких ви повністю можете бути <br>впевненими. Звичайно, що клієнти бувають різними і не всім підходять ті вакансії, які можуть бути у вашого розпорядженні. Тому, маючи якомога більше вакансій - ви зможете запропонувати кожному клієнту саме той варіант, який йому найбільше підійде. Користування базою повністю безкоштовне, а оплата за кожного кандидата розраховується індивідуально та нараховується в повністю автоматичному режимі. Таким чином, ви зможете миттєво збільшити дохід власного бізнесу та зарекомендувати себе перед клієнтами як надійна компанія з працевлаштування, яка тримає своє слово, тому що все те, що ви пообіцяєте клієнтам - їх буде очікувати на роботі за кордоном! <br>Зверніть увагу, ми побудували свою систему так, що ні ваші клієнти, ні ваші партнери не дізнаються, що ви використовуєте єдину базу. Тому, ви зможете почати розвивати свій бізнес в новому напрямку, позиціонуючи ці вакансії як власні.</p>
                    <p><strong>Для посередників, які вже займаються працевлаштуванням</strong></p>
                    <p>Умови для вас будуть такими ж як для бізнесу. Ми безкоштовно надамо вам доступ до єдиної бази та індивідувально розрахуємо винагороду за кожного клієнта. Завдяки єдиній базі вам більше не потрібно буде хвилюватись про надійність іноземних партнерів та про якість вакансій, які вони надають. Завдяки цьому ви зможете надавати своїм клієнтам тільки перевірені вакансії і таким чином завоювати репутацію надійної людини, яка займається працевлаштуванням за кордон.</p>
                    <p><strong>Для новачків, які раніше подібним не займались, але мріють мати власну справу і працювати в сфері працевлаштування</strong></p>
                    <p>Умови для вас будуть такими ж як для бізнесу та посереників. Ми безкоштовно надамо вам доступ до єдиної бази та індивідувально розрахуємо винагороду за кожного клієнта. У вас може не бути сайту, офісу, ліценії та інших обов’язкових речей. Використовуючи нашу єдину базу - вам це все не потрібно. Головне - бажання працювати та старатись. У вас була мрія почати власний бізнес? Ми даємо вам цю можливість! При цьому, для того щоб почати працювати вам не потрібно робити жодних фінансових вкладень і ваш результат та фінансовий дохід буде залежати тільки від вас самих!</p>
                    <p><strong>Для польських, чеських та інших іноземних компаній</strong></p>
                    <p>Завдяки детальній перевірці кожної вакансії - іноземні партнери більше не зможуть обманним шляхом використовувати українських посередників. Тобто, якщо вони надають гірше житло або умови праці - їм або доведеться піднімати оплату за годину, щоб конкурувати з іншими компаніями. Таким чином, кожна компанія почне пропонувати дійсно справделиві умови, для того щоб почати отримувати українських заробітчан на свої підприємства, тому що завдяки величезній конкуренції та великому вибору перевірених вакансій, у кожного клієнта буде можливість вибрати саме ту роботу, яка йому найбільше підійде. І головне, що по приїзду все буде так, як йому і обіцяли!</p>
                </div>
                <h2 class="BorderedTitle Article_subTitle">Підсумок</h2>
                <div class="Article_text">
                    <p>Над цим проектом команда компанії «Робота за кордоном від Андрія Марисюка» працювала із середини 2017 року і ми раді, що нарешті можемо представити вам нашу інноваційну розробку, яка об’єднає всі агенції, посередників та просто новачків в єдину команду, яка на найвищому рівні буде надавати послуги з працевлаштування та виготовлення документів, а всіх іноземних партнерів змусить пропонувати справедливі умови, які дійсно заслоговують українські заробітчани. Таким чином, завдяки використанню нашої розробки ми значно зменшимо рівень обману та кількість недобросовіних агенцій і забезпечимо власним бізнесом тисячі українців, які завжди мріяли мати власну справу!</p>
                    <p><a href="javascript:;">Приєднуйтесь</a> до єдиної закритої партнерської системи!</p>
                    <p>З повагою, Андрій Марисюк та команда компанії «Робота за кордоном від Андрія Марисюка».</p>
                </div>
            </div>
            <div class="PageTop">
                <a href="#topSide" class="PageTop_link">Піднятись на початок сторінки</a>
            </div>
        </div>
    </main>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
