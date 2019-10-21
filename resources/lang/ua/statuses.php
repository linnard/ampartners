<?php

use \App\Constants\Client\Status;

return [
    Status::CREATING => 'Стадія створення',
    Status::BOOKING_CONFIRMATION_EXPECTED => 'Очікує підтвердження бронювання',
    Status::BOOKING_CONFIRMATION_REJECTED => 'Повернений для редагування',
    Status::TICKET_EXPECTED => 'Очікує завантаження квитка',
    Status::TICKET_CONFIRMATION_EXPECTED => 'Очікує підтвердження квитка',
    Status::TICKET_CONFIRMATION_REJECTED => 'Повернено для завантаження квитка',
    Status::COMPLETED => 'Успішно завершений',
];
