<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\Reports;
use App\Models\Ticket;

class ReportService
{
    private function checkDateFormat($date)
    {
        if(gettype($date) === 'object'){
            return $date->format("Y-m-d");
        };
        return $date;
    }

    /**
     * @param array $data   - новые данные для абонемента
     * @param $id           - id абонемента
     * @param $action       - тип действия с абонементом
     * @return void
     */
    public function ticketReport(int $userId, string $action, int $id, array $data = []): void
    {
        $reportData = [];
        $reportData['action'] = $action ?? 'Не указано действие';
        $ticket = Ticket::find($id)->toArray();
        if(count($data) > 0){
            foreach($data as $key => $value){
                $reportData['newValues'][] = [$key => $value];
                $reportData['oldValues'][] = [$key => $ticket[$key]];
            }
        } else {
            foreach($ticket as $key => $value){
                $reportData['oldValues'][] = [$key => $ticket[$key]];
            }
            $reportData['newValues'] = [];
        }

        $reports = new Reports();
        $reports->type = 'ticket';
        $reports->model_id = $id;
        $reports->user_id = $userId;
        $reports->data = json_encode($reportData);
        $reports->save();
    }

    public function balanceReport(int $userId, Profile $profile, int $amount)
    {
        $reportData['action'] = 'Изменение баланса';
        $reportData['oldValues'] = $profile->balance - $amount;
        $reportData['newValues'] = $profile->balance;
        $reports = new Reports();
        $reports->type = 'profile';
        $reports->model_id = $profile->id;
        $reports->user_id = $userId;
        $reports->data = json_encode($reportData);
        $reports->save();
    }
}
