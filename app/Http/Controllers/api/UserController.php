<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddUserContactRequest;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use PubNub\PubNub;
use PubNub\Exceptions\PubNubException;
use PubNub\PNConfiguration;

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

    public function addNewContact(AddUserContactRequest $request, int $id)
    {
        $user = User::find($id)->get();

        if(!$user->isEmpty()) {
            $validated = $request->validated();

            UserContact::create([
                'user_id' => $id,
                'contact_name' => $validated['contact_name'],
                'contact_number' => $validated['contact_number'],
                'contact_role' => $validated['contact_role'],
            ]);

            return response()->json(['message' => 'Contact has been added successfully!', 'hasError' => false], 200);
        }

        return response()->json(['message' => 'User was not found', 'hasError' => true], 404);
    }

    public function sendCustomMessage(Request $request, int $id)
    {
        $user = User::find($id);
        $validated = $request->validated();

        if($user) {
            $contacts = UserContact::join('users', 'user_contacts.contact_name', '=', 'users.name')
                ->select('users.id', 'users.name', DB::raw('CONCAT(users.name, "-", users.id) as pubnub_id'))
                ->where('user_contacts.user_id', $id)
                ->get();
            $recepientIds = array_map(fn ($contact) => $contact['pubnub_id'], $contacts->toArray());

            $logger = new Logger('pubnub');
            $logger->pushHandler(new StreamHandler('php://stdout', Level::Debug));

            $pnconfig = new PNConfiguration();
            $pnconfig->setPublishKey(env('PUBNUB_PUBLISH_KEY'));
            $pnconfig->setSubscribeKey(env('PUBNUB_SUBSCRIBE_KEY'));
            $pnconfig->setSecretKey(env('PUBNUB_SECRET_KEY'));
            $pnconfig->setUserId("$user->name-$user->id");

            $pubnub = new PubNub($pnconfig);
            $pubnub->setLogger($logger);
            $pubnub->getLogger()->pushHandler(new ErrorLogHandler());

            try {
                $pubnub->publish()
                    ->channel(env('PUBNUB_CHANNEL_NAME'))
                    ->message([
                        "type" => "message",
                        "data" => [
                            "sender_name" => $user->name,
                            "message" => $validated['message'],
                            "receiver_ids" => $recepientIds,
                        ]
                    ])
                    ->sync();
            } catch(PubNubException $e) {
                return response()->json([
                    "message" => "Failed to send custom message. Reason: " . $e->getMessage(),
                    "hasError" => true,
                ], 500);
            }

            return response()->json([
                "message" => "Message has been sent successfully!",
                "hasError" => false,
            ]);
        }

        return response()->json([
            "message" => "User was not found",
            "hasError" => true,
        ], 404);
    }
}
