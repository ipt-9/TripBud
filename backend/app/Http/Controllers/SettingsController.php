<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsController
{
    public function index()
    {
        $user = Auth::user();

        // Get the temporary image if it exists in the session
        $profileImage = $user->profile_image;
        if (session()->has('temp_profile_image')) {
            $profileImage = session('temp_profile_image');
        }

        return response()->json([
            'settings' => [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'language' => $user->language,
                'theme' => $user->theme,
                'notifications' => (bool)$user->notifications,
                'profile_image' => $profileImage,
                'subscription_plan' => $user->subscription_plan,
                'payment_method' => $user->payment_method,
                'payment_method_details' => $user->payment_method_details
            ]
        ], 200);
    }

    public function updateChanges(Request $request)
    {
        $user = Auth::user();

        // Store the current settings in the session for potential cancellation
        session(['previous_settings' => [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'language' => $user->language,
            'theme' => $user->theme,
            'notifications' => $user->notifications,
            'profile_image' => $user->profile_image,
            'subscription_plan' => $user->subscription_plan,
            'payment_method' => $user->payment_method,
            'payment_method_details' => $user->payment_method_details
        ]]);

        // Update profile information if provided
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('username')) {
            $user->username = $request->username;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        // Update app settings if provided
        if ($request->has('language')) {
            $user->language = $request->language;
        }

        if ($request->has('theme')) {
            $user->theme = $request->theme;
        }

        if ($request->has('notifications')) {
            $user->notifications = $request->notifications ? 1 : 0;
        }

        // Update subscription plan if provided
        if ($request->has('subscription_plan')) {
            $validPlans = ['free', 'premium', 'business'];
            if (in_array($request->subscription_plan, $validPlans)) {
                $user->subscription_plan = $request->subscription_plan;
            }
        }

        // Update payment method if provided
        if ($request->has('payment_method')) {
            $validMethods = ['credit_card', 'paypal', 'bank_transfer'];
            if (in_array($request->payment_method, $validMethods)) {
                $user->payment_method = $request->payment_method;

                if ($request->has('payment_method_details')) {
                    $user->payment_method_details = $request->payment_method_details;
                }
            }
        }

        // Update profile image if there's a temporary one
        if (session()->has('temp_profile_image')) {
            // If there's a new image path
            $newImagePath = session('temp_profile_image');

            // If the new path is different from the old one and not default
            if ($newImagePath !== $user->profile_image && $user->profile_image !== 'default.png') {
                // Delete the old image
                Storage::disk('public')->delete($user->profile_image);
            }

            // Update to the new image
            $user->profile_image = $newImagePath;

            // Clear the temporary image
            session()->forget('temp_profile_image');

            // If there was a temporary image being deleted, forget it
            if (session()->has('temp_delete_image')) {
                session()->forget('temp_delete_image');
            }
        }
        // If the image was marked for deletion
        elseif (session()->has('temp_delete_image') && session('temp_delete_image') === true) {
            // Delete the old image if it's not the default
            if ($user->profile_image !== 'default.png') {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Reset to default
            $user->profile_image = 'default.png';

            // Clear the temporary flag
            session()->forget('temp_delete_image');
        }

        $user->save();

        return response()->json([
            'message' => 'Settings updated successfully.',
            'settings' => [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'language' => $user->language,
                'theme' => $user->theme,
                'notifications' => (bool)$user->notifications,
                'profile_image' => $user->profile_image,
                'subscription_plan' => $user->subscription_plan,
                'payment_method' => $user->payment_method,
                'payment_method_details' => $user->payment_method_details
            ]
        ], 200);
    }

    public function cancelChanges()
    {
        $user = Auth::user();

        // Check if there are previous settings stored in the session
        if (session()->has('previous_settings')) {
            $previousSettings = session('previous_settings');

            // Revert all settings to previous values
            $user->name = $previousSettings['name'];
            $user->username = $previousSettings['username'];
            $user->email = $previousSettings['email'];
            $user->language = $previousSettings['language'];
            $user->theme = $previousSettings['theme'];
            $user->notifications = $previousSettings['notifications'];
            $user->profile_image = $previousSettings['profile_image'];
            $user->subscription_plan = $previousSettings['subscription_plan'];
            $user->payment_method = $previousSettings['payment_method'];
            $user->payment_method_details = $previousSettings['payment_method_details'];

            $user->save();

            // Clear all temporary settings
            session()->forget('previous_settings');
            session()->forget('temp_profile_image');
            session()->forget('temp_delete_image');

            // If there was a temporary image that was uploaded but not saved
            if (session()->has('temp_image_path') &&
                session('temp_image_path') !== 'default.png' &&
                session('temp_image_path') !== $user->profile_image) {
                // Delete the temporary image file
                Storage::disk('public')->delete(session('temp_image_path'));
                session()->forget('temp_image_path');
            }

            return response()->json([
                'message' => 'Changes reverted successfully.',
                'settings' => [
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'language' => $user->language,
                    'theme' => $user->theme,
                    'notifications' => (bool)$user->notifications,
                    'profile_image' => $user->profile_image,
                    'subscription_plan' => $user->subscription_plan,
                    'payment_method' => $user->payment_method,
                    'payment_method_details' => $user->payment_method_details
                ]
            ], 200);
        }

        // If no previous settings, but we have a temp image, clear it
        if (session()->has('temp_profile_image') || session()->has('temp_delete_image')) {
            // Delete any temporary uploaded file
            if (session()->has('temp_image_path') &&
                session('temp_image_path') !== 'default.png' &&
                session('temp_image_path') !== $user->profile_image) {
                Storage::disk('public')->delete(session('temp_image_path'));
            }

            session()->forget('temp_profile_image');
            session()->forget('temp_delete_image');
            session()->forget('temp_image_path');

            return response()->json([
                'message' => 'Image changes reverted.',
                'settings' => [
                    'profile_image' => $user->profile_image
                ]
            ], 200);
        }

        return response()->json(['message' => 'No changes to revert.'], 400);
    }

    public function tempUpdateImage(Request $request)
    {
        if ($request->hasFile('profile_image')) {
            // Validate the uploaded file
            $request->validate([
                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $path = $request->file('profile_image')->store('profile_images', 'public');

            // Store the path as a temporary image in the session
            session(['temp_profile_image' => $path]);

            // Also store the actual path to clean up if needed
            session(['temp_image_path' => $path]);

            // Remove any delete flag
            if (session()->has('temp_delete_image')) {
                session()->forget('temp_delete_image');
            }

            return response()->json([
                'message' => 'Profile image temporarily updated. Click Save to apply changes.',
                'image' => $path
            ], 200);
        }

        return response()->json(['message' => 'No image provided.'], 400);
    }

    public function tempDeleteImage()
    {
        // Set a flag that the image should be deleted
        session(['temp_delete_image' => true]);

        // If there was a temporary image, remove it
        if (session()->has('temp_profile_image')) {
            $tempImage = session('temp_profile_image');

            // If it's a newly uploaded image (not the current one), delete the file
            if ($tempImage !== Auth::user()->profile_image && $tempImage !== 'default.png') {
                Storage::disk('public')->delete($tempImage);
            }

            session()->forget('temp_profile_image');
        }

        return response()->json([
            'message' => 'Profile image marked for deletion. Click Save to apply changes.',
            'image' => 'default.png'
        ], 200);
    }

    public function getPlans()
    {
        return response()->json([
            'available_plans' => [
                ['id' => 'free', 'name' => 'Free Plan', 'price' => '$0/month'],
                ['id' => 'premium', 'name' => 'Premium Plan', 'price' => '$9.99/month'],
                ['id' => 'business', 'name' => 'Business Plan', 'price' => '$29.99/month']
            ]
        ], 200);
    }

    public function getSupport()
    {
        return response()->json([
            'support_email' => 'support@example.com',
            'support_phone' => '+1-800-123-4567',
            'faq_url' => '/faq'
        ], 200);
    }
}
