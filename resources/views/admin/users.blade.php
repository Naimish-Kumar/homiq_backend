@extends('admin.layout')

@section('page_title', 'User Accounts')

@section('content')
<!-- Header & Actions Bar -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div class="w-full md:w-80 relative">
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input type="text" id="userSearchInput" onkeyup="filterUsers()" placeholder="Search members by name, email, plan..." 
               class="w-full pl-10 pr-4 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition shadow-2xs">
    </div>
    
    <div class="flex items-center gap-3">
        <span class="text-xs text-slate-500 font-bold bg-white px-3 py-1.5 rounded-xl border border-slate-200/80 shadow-2xs">Total Members: {{ $users->count() }}</span>
        <button onclick="openUserDrawer()" class="px-4 py-2.5 bg-[#0A2540] hover:bg-[#0F365E] text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add Member</span>
        </button>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="text-slate-400 font-extrabold border-b border-slate-200 bg-slate-50/75 uppercase text-[11px] tracking-wider">
                    <th class="py-3.5 px-4 pl-6">Member Profile</th>
                    <th class="py-3.5 px-4">Contact Info</th>
                    <th class="py-3.5 px-4">Activity Stats</th>
                    <th class="py-3.5 px-4">Subscription Plan</th>
                    <th class="py-3.5 px-4">Role</th>
                    <th class="py-3.5 px-4">KYC Status</th>
                    <th class="py-3.5 px-4 pr-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100" id="userTableBody">
                @foreach ($users as $user)
                    <tr class="text-slate-700 font-medium hover:bg-slate-50/80 transition user-row"
                        data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}"
                        data-plan="{{ $user->subscription_plan }}">
                        <td class="py-4 px-4 pl-6">
                            <div class="flex items-center gap-3">
                                @if($user->profile_photo)
                                    <img src="{{ $user->profile_photo }}" class="h-9 w-9 rounded-xl object-cover border border-slate-200 shadow-2xs" alt="avatar">
                                @else
                                    <div class="h-9 w-9 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-xs text-slate-600 uppercase shadow-2xs">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-slate-900 text-xs">{{ $user->name }}</div>
                                    <span class="text-[10px] text-slate-400 font-medium">ID: #{{ $user->id }} • Joined {{ $user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800">{{ $user->email }}</div>
                            <span class="text-[10px] text-slate-400 block mt-0.5">{{ $user->phone ?? 'No phone number' }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Listings</span>
                                    <span class="font-black text-slate-900 text-xs mt-0.5">{{ $user->properties_count }}</span>
                                </div>
                                <div class="h-6 w-px bg-slate-200"></div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Bookings</span>
                                    <span class="font-black text-slate-900 text-xs mt-0.5">{{ $user->bookings_count }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            @if ($user->is_admin)
                                <span class="text-[10px] text-slate-400 font-semibold italic">N/A (Admin)</span>
                            @else
                                <form action="/admin/users/{{ $user->id }}/change-plan" method="POST" class="m-0 flex items-center gap-1.5">
                                    @csrf
                                    <select name="subscription_plan" onchange="this.form.submit()" 
                                            class="bg-slate-50 border border-slate-200 text-slate-700 text-[10px] font-bold rounded-lg px-2.5 py-1 focus:outline-none focus:border-emerald-500 transition cursor-pointer">
                                        <option value="free" {{ $user->subscription_plan === 'free' ? 'selected' : '' }}>Free Starter</option>
                                        <option value="standard" {{ $user->subscription_plan === 'standard' ? 'selected' : '' }}>Standard (₹499)</option>
                                        <option value="unlimited" {{ $user->subscription_plan === 'unlimited' ? 'selected' : '' }}>Unlimited (₹999)</option>
                                    </select>
                                </form>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if ($user->is_admin)
                                <span class="px-2.5 py-1 bg-purple-50 text-purple-700 rounded-full font-extrabold text-[10px] uppercase border border-purple-200">Administrator</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full font-extrabold text-[10px] uppercase border border-slate-200">Member</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if ($user->kyc_status === 'verified')
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full font-extrabold text-[10px] uppercase border border-emerald-200">Verified</span>
                            @elseif ($user->kyc_status === 'pending')
                                <div class="flex flex-col gap-1">
                                    <span class="inline-block self-start px-2.5 py-1 bg-amber-50 text-amber-700 rounded-full font-extrabold text-[10px] uppercase border border-amber-200 animate-pulse">Pending</span>
                                    @if ($user->kyc_document)
                                        <div class="flex gap-1.5 items-center mt-1">
                                            <a href="{{ $user->kyc_document }}" target="_blank" class="text-[10px] text-blue-600 hover:underline font-bold">View ID</a>
                                            <span class="text-slate-300">•</span>
                                            <form action="/admin/users/{{ $user->id }}/verify-kyc" method="POST" class="inline m-0">
                                                @csrf
                                                <button type="submit" class="text-[10px] text-emerald-600 hover:text-emerald-700 font-bold">Approve</button>
                                            </form>
                                            <span class="text-slate-300">•</span>
                                            <form action="/admin/users/{{ $user->id }}/reject-kyc" method="POST" class="inline m-0">
                                                @csrf
                                                <button type="submit" class="text-[10px] text-rose-600 hover:text-rose-700 font-bold">Reject</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @elseif ($user->kyc_status === 'rejected')
                                <span class="px-2.5 py-1 bg-rose-50 text-rose-700 rounded-full font-extrabold text-[10px] uppercase border border-rose-200">Rejected</span>
                            @else
                                <span class="text-[10px] text-slate-400 font-semibold italic">Not Submitted</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 pr-6 text-right">
                            <div class="flex gap-2 justify-end items-center">
                                @if ($user->id !== Auth::id())
                                    <!-- Edit User Icon -->
                                    <button type="button" onclick="openUserDrawer({{ json_encode($user) }})" 
                                            class="p-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg border border-slate-200 transition" title="Edit Member">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <!-- Delete User Account -->
                                    <form action="/admin/users/{{ $user->id }}" method="POST" class="m-0" 
                                          onsubmit="return confirm('WARNING: Are you sure you want to permanently delete this user, their active listings, and booking history?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg border border-rose-200 transition" title="Delete Account">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] text-slate-400 font-bold italic pr-2">Current Session</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Client-side instant user search
    function filterUsers() {
        const query = document.getElementById('userSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');
        rows.forEach(row => {
            const name = row.getAttribute('data-name').toLowerCase();
            const email = row.getAttribute('data-email').toLowerCase();
            const plan = row.getAttribute('data-plan').toLowerCase();
            
            if (name.includes(query) || email.includes(query) || plan.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal Drawer logic
    function openUserDrawer(user = null) {
        const drawer = document.getElementById('userDrawer');
        const content = document.getElementById('userDrawerContent');
        const form = document.getElementById('userForm');
        const title = document.getElementById('drawerTitle');
        const passwordLabel = document.getElementById('passwordLabel');
        const passwordAlert = document.getElementById('passwordAlert');
        const passwordInput = document.getElementById('field_password');

        if (user) {
            // Edit Mode
            title.innerText = "Edit Member Info";
            form.action = `/admin/users/${user.id}`;
            document.getElementById('field_name').value = user.name;
            document.getElementById('field_email').value = user.email;
            document.getElementById('field_phone').value = user.phone || '';
            document.getElementById('field_subscription_plan').value = user.subscription_plan;
            document.getElementById('field_is_admin').value = user.is_admin ? "1" : "0";
            
            passwordLabel.innerText = "New Password";
            passwordInput.required = false;
            passwordAlert.classList.remove('hidden');
        } else {
            // Add Mode
            title.innerText = "Create New Member";
            form.action = "/admin/users";
            form.reset();
            
            passwordLabel.innerText = "Password";
            passwordInput.required = true;
            passwordAlert.classList.add('hidden');
        }

        drawer.classList.remove('hidden');
        setTimeout(() => {
            drawer.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }

    function closeUserDrawer() {
        const drawer = document.getElementById('userDrawer');
        const content = document.getElementById('userDrawerContent');

        content.classList.add('scale-95');
        drawer.classList.add('opacity-0');
        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    }

    function closeUserDrawerOutside(event) {
        if (event.target === document.getElementById('userDrawer')) {
            closeUserDrawer();
        }
    }
</script>
@endsection
