<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        // Query with explicit select of profile_image field
        $messages = Message::with(['user' => function($query) {
            // Select all necessary user fields including profile_image
            $query->addSelect(['id', 'name', 'username', 'profile_image']);
        }])->get();

        // Add profile image URL for each message
        foreach ($messages as $message) {
            if ($message->user) {
                $message->user->profile_image_url = $this->getProfileImageUrl($message->user->profile_image);
            }
        }

        return $messages;
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return array
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        // Explicitly load the user with all required fields
        $message->load(['user' => function($query) {
            $query->addSelect(['id', 'name', 'username', 'profile_image']);
        }]);

        // Add profile image URL
        if ($message->user) {
            $message->user->profile_image_url = $this->getProfileImageUrl($message->user->profile_image);
        }

        broadcast(new MessageSent($user, $message))->toOthers();

        return [
            'status' => 'Message Sent!',
            'message' => $message
        ];
    }

    /**
     * Get profile image URL helper
     *
     * @param string $profileImage
     * @return string
     */
    private function getProfileImageUrl($profileImage)
    {
        // Base URL of your application
        $baseUrl = 'https://tripbud-bmsd22a.bbzwinf.ch';

        if (!$profileImage) {
            return $baseUrl . '/assets/default.png';
        } elseif ($profileImage === 'assets/default.png') {
            return $baseUrl . '/' . $profileImage;
        } elseif (strpos($profileImage, 'http') === 0) {
            return $profileImage;
        } elseif (strpos($profileImage, 'profile_images/') === 0) {
            return $baseUrl . '/api/storage/' . $profileImage;
        } else {
            return $baseUrl . '/' . ltrim($profileImage, '/');
        }
    }
}
