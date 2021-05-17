<?php

namespace App\Notifications\Vacancy;

use App\Channels\OnesignalWebPushChannel;

use App\Models\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VacancyCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $vacancy;

    public function __construct(Vacancy $vacancy)
    {
        $this->vacancy = $vacancy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            OnesignalWebPushChannel::class
        ];
    }


    public function toOnesignalWebPush($notifiable)
    {

        return [
            'contents' => 'Додана нова вакансія: '.$this->vacancy->title,
            'headings' => 'ampartners.top',
            'url' => url('controlpanel/vacancies?vacancy='.$this->vacancy->id)
        ];
    }


}
