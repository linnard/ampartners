<?php

namespace App\Models\Client\Constants;

interface Status
{
    const CREATING = 'creating'; //Панель партнера. Начальный этап - указываются все свойства клиента
    const BOOKING_CONFIRMATION_EXPECTED  = 'booking_confirmation_expected'; //Панель админа. Все поля клиента заполнены. Ожидание подтверждение бронирования
    const BOOKING_CONFIRMATION_REJECTED  = 'booking_confirmation_rejected'; //Панель партнера. Возможность вновь изменить все поля
    const TICKET_EXPECTED  = 'ticket_expected'; //Панель партнера. Нужно загрузить билет
    const TICKET_CONFIRMATION_EXPECTED  = 'ticket_confirmation_expected'; //Панель админа. Ожидается проверка билета админом
    const TICKET_CONFIRMATION_REJECTED  = 'ticket_confirmation_rejected'; //Панель партнера. Возможность загрузить другой билет
    const COMPLETED = 'completed'; //Успешно завершен
}

