@extends('admin.layout')

@section('page_title', 'Update Profile')

@section('content')
<div class="mb-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-black text-slate-900 tracking-tight">Admin Profile Settings</h2>
    <p class="text-xs text-slate-500 mt-1 font-medium">
        Manage your administrator account credentials, details, and avatar image. Updates reflect immediately across the dashboard navigation bar.
    </p>
</div>

<form action="/admin/profile" method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto space-y-6">
    @csrf

    <!-- Account Details Panel -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-5">
        <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider border-b border-slate-100 pb-3">Personal Information</h3>
        
        <!-- Avatar Preview and Upload Block -->
        <div class="flex items-center gap-5 bg-slate-50 p-4 rounded-xl border border-slate-100">
            <div id="avatarContainer">
                @if($user->profile_photo)
                    <img id="avatarPreview" src="{{ $user->profile_photo }}" class="h-16 w-16 rounded-full object-cover border border-slate-200 shadow-xs" alt="Current Avatar">
                @else
                    <div id="avatarPlaceholder" class="h-16 w-16 rounded-full bg-gradient-to-tr from-[#0A2540] to-[#0F365E] flex items-center justify-center font-bold text-lg text-emerald-400 shadow-sm uppercase">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div class="space-y-1.5 flex-1">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Upload Profile Photo</label>
                <input type="file" name="profile_photo" accept="image/*" onchange="previewImage(event)"
                       class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                <p class="text-[10px] text-slate-400">Supports JPG, PNG, WebP. Max size 2MB.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Name -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Phone -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +91 99999 99999"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
            </div>
        </div>
    </div>

    <!-- Password Updates Panel -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-5">
        <h3 class="text-xs font-bold text-[#0A2540] uppercase tracking-wider border-b border-slate-100 pb-3">Update Password (Optional)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Password -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">New Password</label>
                <input type="password" name="password" placeholder="••••••••"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
            </div>

            <!-- Password Confirmation -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Confirm New Password</label>
                <input type="password" name="password_confirmation" placeholder="••••••••"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex justify-end gap-3">
        <a href="/admin" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition">
            Cancel
        </a>
        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition">
            Save Changes
        </button>
    </div>
</form>

<script>
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let img = document.getElementById('avatarPreview');
                const placeholder = document.getElementById('avatarPlaceholder');
                const container = document.getElementById('avatarContainer');

                if (!img) {
                    if (placeholder) placeholder.remove();
                    img = document.createElement('img');
                    img.id = 'avatarPreview';
                    img.className = 'h-16 w-16 rounded-full object-cover border border-slate-200 shadow-xs';
                    container.appendChild(img);
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
