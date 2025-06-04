<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;





class AdminController extends Controller
{

    // admin login



public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Find the admin by email
    $admin = Admin::where('email', $request->email)->first();

    // Check if admin exists and password is correct
    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'message' => 'Login successful',
        'admin' => $admin,
    ]);
}




    // Get admin profile
      public function getAdmin($id)
{
    $admin = Admin::find($id);

    if (!$admin) {
        return response()->json(['message' => 'Admin not found'], 404);
    }

    return response()->json($admin);
}


        // Update admin profile

        public function update(Request $request, $id)
        {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone_number' => 'nullable|string',
                'date_of_birth' => 'nullable|date',
                'country' => 'nullable|string',
                'city' => 'nullable|string',
                'postal_code' => 'nullable|string',
                // Removed picture_url validation
            ]);

            $admin = Admin::findOrFail($id);

            // Update only if the value has changed
            $fields = [
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'date_of_birth',
                'country',
                'city',
                'postal_code',
            ];

            $updated = false;

            foreach ($fields as $field) {
                if ($request->has($field) && $admin->$field !== $request->$field) {
                    $admin->$field = $request->$field;
                    $updated = true;
                }
            }

            if ($updated) {
                $admin->save();
            }

            return response()->json([
                'message' => 'Profile updated successfully.',
                'admin' => $admin,
            ]);
        }

            

    // Change admin password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        $admin = Admin::first(); // Assumes single admin

        if (!$admin || !Hash::check($request->current_password, $admin->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 403);
        }

        // Optional: prevent using same password again
        if (Hash::check($request->new_password, $admin->password)) {
            return response()->json(['message' => 'New password cannot be the same as the current password.'], 422);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    // Update admin profile picture
    public function updatePicture(Request $request, $id)
{
    $admin = Admin::findOrFail($id);

    if ($request->hasFile('picture_url')) {
        // Delete old picture if it exists
        if ($admin->picture_url) {
            Storage::delete($admin->picture_url);
        }

        // Store new picture
        $path = $request->file('picture_url')->store('admin_pictures', 'public');
        $admin->picture_url = $path;
        $admin->save();

        return response()->json(['message' => 'Profile picture updated', 'admin' => $admin]);
    }

    return response()->json(['message' => 'No picture uploaded'], 400);
}



}
