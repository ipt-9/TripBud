<?php

namespace App\Http\Controllers;

use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class SettingsConroller
{

    public function cancelChanges(){
        $user = Auth::user();

        // Check if there are previous settings stored in the session
        if (session()->has('previous_settings')) {
            // Revert settings to previous values
            $user->settings = session('previous_settings');
            $user->save();

            // Clear the previous settings from session
            session()->forget('previous_settings');
            return response()->json(['message' => 'Changes reverted successfully.', 'settings' => $user->settings], 200);
        }

        return response()->json(['message' => 'No previous changes to revert.'], 400);
    }
    public function updateChanges(Request $request){
        $user = Auth::user();

        // Store the previous settings in the session
        session(['previous_settings' => $user->settings]);

        // Update settings with new values
        $user->settings = $request->all(); // Assuming settings is an array or JSON column
        $user->save();

        return response()->json(['message' => 'Settings updated successfully.'], 200);
    }
    public function updateImage(Request $request){
        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');

            // Store previous image before replacing it
            if ($user->profile_image && $user->profile_image !== 'default.png') {
                Storage::disk('public')->delete($user->profile_image);
            }

            $user->profile_image = $path;
            $user->save();
        }

        return response()->json(['message' => 'Profile image updated.', 'image' => $path], 200);
    }
    public function deleteImage(){
        $user = Auth::user();

        // Delete old image if it's not the default
        if ($user->profile_image && $user->profile_image !== 'default.png') {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Reset to default profile image
        $user->profile_image = 'default.png';
        $user->save();

        return response()->json(['message' => 'Profile image reset to default.'], 200);
    }
    public function editMethod(Request $request){
        $user = Auth::user();

        // Ensure the payment method exists
        if (!$user->payment_method) {
            return response()->json(['message' => 'No payment method found to edit.'], 404);
        }

        // Update the payment method in the user table
        $user->payment_method = $request->payment_method;
        $user->payment_method_details = $request->payment_method_details;
        $user->save();

        return response()->json(['message' => 'Payment method updated.'], 200);
    }
    public function deleteMethod($id){
        $user = Auth::user();

        // Check if the user has a payment method to delete
        if (!$user->payment_method) {
            return response()->json(['message' => 'No payment method to delete.'], 404);
        }

        // Remove the payment method details
        $user->payment_method = null;
        $user->payment_method_details = null;
        $user->save();

        return response()->json(['message' => 'Payment method deleted successfully.'], 200);
    }
    public function changePlan(Request $request){
        $user = Auth::user();
        $validPlans = ['free', 'premium', 'business'];

        if (!in_array($request->plan, $validPlans)) {
            return response()->json(['error' => 'Invalid plan selected.'], 400);
        }

        // Update subscription plan
        $user->subscription_plan = $request->plan;
        $user->save();

        return response()->json(['message' => 'Subscription plan changed to ' . $request->plan], 200);
    }
}
