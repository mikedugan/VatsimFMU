<?php

return array(
    'api_url_base' => $_ENV['vfmu.api_url_base'],
    'api_key' => $_ENV['vfmu.api_key'],

    /** DO NOT EDIT UNLESS YOU KNOW WHAT YOU'RE DOING **/
    'api_urls' => array(
        'GET' => array(
            'countries' => 'v1/country',
            'atc_positions_available' => 'v1/booking/facilityPosition',
            'atc_facilities_available' => 'v1/booking/facility',
            'atc_booking' => 'v1/booking/atc/{booking_atc_id}',
            'atc_bookings' => 'v1/booking/atc',
            'flight_bookings' => 'v1/booking/flight',
        ),
        "POST" => array(
            'atc_booking' => 'v1/booking/atc',
        ),
        "DELETE" => array(
            'atc_booking' => 'v1/booking/atc/{booking_atc_id}',
        )
    ),
);