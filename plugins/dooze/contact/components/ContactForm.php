<?php namespace Dooze\Contact\Components;

use Cms\Classes\ComponentBase;
use Flash;
use Input;
use Mail;
use Validator;
use ValidationException;

class ContactForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'Contact Form',
            
            'description' => 'Four Peaks contact form'
        ];
    }

    public function onSend()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'content' => 'required',
        ];

        $vars = post();

        $validation = Validator::make($vars, $rules);

        if ($validation->fails()) {
            throw new ValidationException($validation);

        } else {
            Mail::send('dooze.contact::mail.message', $vars, function($message) {
	            //$message->to('firdausriyanto@gmail.com', 'Donna Rupp');
                $message->to('donna@fourpeaksrealestate.com.au', 'Donna Rupp');
                $message->cc('jordan@fourpeaksrealestate.com.au', 'Jordan McNamara');
                $message->subject(Input::get('subject') . ' ' . Input::get('name'));
            });

            Flash::success('Your message has been sent');
        }
    }

}