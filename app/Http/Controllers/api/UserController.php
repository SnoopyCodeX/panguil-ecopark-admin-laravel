<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getContacts(int $id)
    {
        return User::find($id)->contacts()->get();
    }

    public function updateContact(Request $request, int $id, int $contactId)
    {
        $contact = UserContact::where('user_id', $id)->where('id', $contactId)->get();

        if(!$contact->isEmpty()) {
            UserContact::where('user_id', $id)
                ->where('id', $contactId)
                ->update([
                    'contact_name' => $request->input('contact_name'),
                    'contact_number' => $request->input('contact_number'),
                    'contact_role' => $request->input('contact_role'),
                ]);

            return response()->json(['message' => 'Contact has been updated successfully!']);
        }

        return response()->json(['message' => 'Contact was not found', 'hasError' => true]);
    }

    public function addNewContact(Request $request, int $id)
    {
        $user = User::find($id)->get();

        if(!$user->isEmpty()) {
            UserContact::create([
                'user_id' => $id,
                'contact_name' => $request->input('contact_name'),
                'contact_number' => $request->input('contact_number'),
                'contact_role' => $request->input('contact_role'),
            ]);

            return response()->json(['message' => 'Contact has been added successfully!', 'hasError' => false], 200);
        }

        return response()->json(['message' => 'User was not found', 'hasError' => true], 404);
    }

    public function sendCustomMessage(Request $request, int $id)
    {}
}
