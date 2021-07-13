<?php
namespace App\Traits;
use Carbon\Carbon;
trait FormatterTrait
{

    public function getDataLogsAttribute(){

        $data = array(
            'create_details' => array(
                'user' => $this->created_by_user,
                'date_time' => array(
                    'default' => $this->attributes['created_at'],
                    'other_formats' => array(
                        'format_1' => Carbon::parse($this->attributes['created_at'])->format('F d, Y'),
                    )
                )
            ),
            'update_details' => array(
                'user' => $this->updated_by_user,
                'date_time' => array(
                    'default' => $this->attributes['updated_at'],
                    'other_formats' => array(
                        'format_1' => Carbon::parse($this->attributes['updated_at'])->format('F d, Y'),
                    )
                )
            )
        );
        return $data;
    }

    public function created_by_user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updated_by_user(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function format_amount($amount){
        $data = array(
            'default' => $amount,
            'other_formats' => array(
                'format_1' => html_entity_decode('&#8369;').' '.number_format($amount,2),
            )
        );
        return $data;
    }
    public function format_date($date){
        $data = array(
            'default' => !empty($date) ? $date : '',
            'other_formats' => array(
                'format_1' => Carbon::parse($date)->format('F d, Y'),
                'format_2' => Carbon::parse($date)->format('F Y'),
                'format_3' => Carbon::parse($date)->format('M d, Y'),
            )
        );
        return $data;
    }
    public function format_time($date){
        $data = array(
            'default' => !empty($date) ? $date : '',
            'other_formats' => array(
                'format_1' => Carbon::parse($date)->format('h:i a')
            )
        );
        return $data;
    }
    public function format_month($date){
        $data = array(
            'default' => !empty($date) ? substr($date,0,7) : '',
            'other_formats' => array(
                'format_1' => Carbon::parse($date)->format('F Y'),
            )
        );
        return $data;
    }
}