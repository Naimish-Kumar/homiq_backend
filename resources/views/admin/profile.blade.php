@extends('admin.layout')

@section('page_title', 'Update Profile')

@section('content')
<div class="mb-6 max-w-2xl mx-auto relative z-10">
    <p class="text-xs text-slate-650 leading-relaxed font-semibold">
        Manage your administrator account credentials, details, and avatar image. Updates reflect immediately across the dashboard navigation bar.
    </p>
</div>

<form action="/admin/profile" method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto space-y-6 relative z-10">
    @csrf

    <!-- Account Details Panel -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm space-y-5">
        <h3 class="text-xs font-extrabold text-[#187053] uppercase tracking-widest border-b border-slate-50 pb-3">Personal Information</h3>
        
        <!-- Avatar Preview and Upload Block -->
        <div class="flex items-center gap-5 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
            <div id="avatarContainer">
                @if($user->profile_photo)
                    <img id="avatarPreview" src="{{ $user->profile_photo }}" class="h-16 w-16 rounded-full object-cover border border-slate-200 shadow-sm" alt="Current Avatar">
                @else
                    <div id="avatarPlaceholder" class="h-16 w-16 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center font-bold text-lg text-[#187053] shadow-inner uppercase">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div class="space-y-1.5 flex-1">
                <label class="block text-[9px] font-extrabold text-[#187053] uppercase tracking-widest">Upload Profile Photo</label>
                <input type="file" name="profile_photo" accept="image/*" onchange="previewImage(event)"
                       class="w-full text-xs text-slate-550 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-[10px] file:font-extrabold file:bg-emerald-50 file:text-[#187053] hover:file:bg-emerald-100 transition-colors cursor-pointer">
                <p class="text-[8px] text-slate-400">Supports JPG, PNG, GIF. Max size 2MB.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Name -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Phone -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +91 99999 99999"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>
        </div>
    </div>

    <!-- Password Updates Panel -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm space-y-5">
        <h3 class="text-xs font-extrabold text-[#187053] uppercase tracking-widest border-b border-slate-50 pb-3">Update Password (Optional)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Password -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">New Password</label>
                <input type="password" name="password" placeholder="••••••••"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>

            <!-- Password Confirmation -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Confirm New Password</label>
                <input type="password" name="password_confirmation" placeholder="••••••••"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex justify-end gap-3">
        <a href="/admin" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition">
            Cancel
        </a>
        <button type="submit" class="px-6 py-2.5 bg-[#187053] hover:bg-[#12563f] text-white text-xs font-bold rounded-xl shadow transition">
            Update Profile
        </button>
    </div>
</form>

<script>
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('avatarContainer');
                container.innerHTML = `<img id="avatarPreview" src="${e.target.result}" class="h-16 w-16 rounded-full object-cover border border-slate-200 shadow-sm" alt="Selected Avatar">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
