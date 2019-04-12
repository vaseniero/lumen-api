<?php

namespace App\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //this function is used to register a new user
    public function create(Request $request)
    {
        //creating a validator
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|unique:users'
        ]);

        //if validation fails 
        if ($validator->fails()) {
            return array(
                'error' => true,
                'message' => $validator->errors()->all()
            );
        }

        //creating a new user
        $user = new User();

        //adding values to the users
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = (new BcryptHasher)->make($request->input('password'));

        //saving the user to database
        $user->save();

        //unsetting the password so that it will not be returned 
        unset($user->password);

        //returning the registered user 
        return array('error' => false, 'user' => $user);
    }

    //function for user login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return array(
                'error' => true,
                'message' => $validator->errors()->all()
            );
        }

        $user = User::where('username', $request->input('username'))->first();

        if (count($user)) {
            if (password_verify($request->input('password'), $user->password)) {
                unset($user->password);
                return array('error' => false, 'user' => $user);
            } else {
                return array('error' => true, 'message' => 'Invalid password');
            }
        } else {
            return array('error' => true, 'message' => 'User not exist');
        }
    }

    //getting the questions for a particular user 
    public function getQuestions($id)
    {
        $questions = User::find($id)->questions;
        foreach ($questions as $question) {
            $question['answercount'] = count($question->answers);
            unset($question->answers);
        }
        return array('error' => false, 'questions' => $questions);
    }
}