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

        // Convert to array for manipulation
        $formattedMessages = [];

        foreach ($messages as $message) {
            $messageData = $message->toArray();

            if (isset($messageData['user']) && $messageData['user']) {
                // Make sure user has a profile_picture field
                // Even if profile_image is not set or null, we want to set a default
                $profileImage = $messageData['user']['profile_image'] ?? 'default.png';
                $messageData['user']['profile_picture'] = $this->getProfileImageUrl($profileImage);
            } else {
                // Handle case where user might be deleted but message exists
                $messageData['user'] = [
                    'id' => null,
                    'name' => 'Deleted User',
                    'username' => 'deleted',
                    'profile_picture' => $this->getProfileImageUrl('default.png')
                ];
            }

            $formattedMessages[] = $messageData;
        }

        return $formattedMessages;
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

        // Create message data with profile picture
        $messageData = $message->toArray();

        if (isset($messageData['user']) && $messageData['user']) {
            $profileImage = $messageData['user']['profile_image'] ?? 'default.png';
            $messageData['user']['profile_picture'] = $this->getProfileImageUrl($profileImage);
        }

        // Broadcast original message object for event compatibility
        broadcast(new MessageSent($user, $message))->toOthers();

        return [
            'status' => 'Message Sent!',
            'message' => $messageData
        ];
    }

    /**
     * Get profile image URL helper
     *
     * @param string|null $profileImage
     * @return string
     */
    private function getProfileImageUrl($profileImage)
    {
        // Base URL of your application
        $baseUrl = 'https://tripbud-bmsd22a.bbzwinf.ch';

        // Use default image if profile_image is null or empty
        if (!$profileImage || $profileImage === 'default') {
            return $baseUrl . '/assets/default.png';
        } elseif ($profileImage === 'default.png') {
            // This is what SettingsController uses as default
            return $baseUrl . '/assets/default.png';
        } elseif ($profileImage === 'assets/default.png') {
            return $baseUrl . '/assets/default.png';
        } elseif (strpos($profileImage, 'http') === 0) {
            return $profileImage;
        } elseif (strpos($profileImage, 'profile_images/') === 0) {
            // Match the SettingsController pattern: files stored in public disk
            return $baseUrl . '/storage/' . $profileImage;
        } else {
            return $baseUrl . '/' . ltrim($profileImage, '/');
        }
    }
}
