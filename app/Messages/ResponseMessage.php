<?php

namespace App\Http\Message;

class ResponseMessage{

    public static function succesfulResponse()
    {
        return response('successfull', 200);
    }

    public static function failedResponse()
    {
        return response('failure', 500);
    }

}