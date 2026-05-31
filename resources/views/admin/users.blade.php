@extends('admin.layout')

@section('page_title', 'User Accounts')

@section('content')
<!-- Search & Actions Bar -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative z-10">
    <div class="w-full md:w-80 relative">
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input type="text" id="userSearchInput" onkeyup="filterUsers()" placeholder="Search members by name, email, plan..." 
               class="w-full pl-10 pr-4 py-2.5 text-xs font-medium rounded-xl border border-slate-200/60 bg-white text-slate-800 focus:outline-none focus:border-[#187053] transition-colors shadow-sm">
    </div>
    
    <div class="flex items-center gap-3">
        <span class="text-[10px] text-slate-400 font-extrabold">Total Registered: {{ $users->count() }}</span>
        <button onclick="openUserDrawer()" class="px-4 py-2.5 bg-[#187053] hover:bg-[#12563f] text-white text-xs font-extrabold rounded-lg shadow transition">
            + Add User
        </button>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden relative z-10">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="text-slate-400 font-bold border-b border-slate-100 bg-slate-50/50">
                    <th class="p-4 pl-6">Name & Profile</th>
                    <th class="p-4">Contact Info</th>
                    <th class="p-4">Platform Stats</th>
                    <th class="p-4">Subscription Plan</th>
                    <th class="p-4">Access Level</th>
                    <th class="p-4 pr-6 text-right">Moderator Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100/70" id="userTableBody">
                @foreach ($users as $user)
                    <tr class="text-slate-650 font-medium hover:bg-slate-50/30 transition user-row"
                        data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}"
                        data-plan="{{ $user->subscription_plan }}">
                        <td class="p-4 pl-6">
                            <div class="flex items-center gap-3">
                                @if($user->profile_photo)
                                    <img src="{{ $user->profile_photo }}" class="h-8 w-8 rounded-lg object-cover border border-slate-200" alt="avatar">
                                @else
                                    <div class="h-8 w-8 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center font-bold text-slate-500 uppercase shadow-inner">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-extrabold text-slate-800 text-xs">{{ $user->name }}</div>
                                    <span class="text-[9px] text-slate-400">ID: #{{ $user->id }} • Joined {{ $user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-800">{{ $user->email }}</div>
                            <span class="text-[9px] text-slate-400 block mt-0.5">{{ $user->phone ?? 'No Phone' }}</span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-4">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Listings</span>
                                    <span class="font-black text-slate-800 text-xs mt-0.5">{{ $user->properties_count }}</span>
                                </div>
                                <div class="h-6 w-px bg-slate-100"></div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Bookings</span>
                                    <span class="font-black text-slate-800 text-xs mt-0.5">{{ $user->bookings_count }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            @if ($user->is_admin)
                                <span class="text-[10px] text-slate-400 font-bold italic">N/A (Admin)</span>
                            @else
                                <form action="/admin/users/{{ $user->id }}/change-plan" method="POST" class="m-0 flex items-center gap-1.5">
                                    @csrf
                                    <select name="subscription_plan" onchange="this.form.submit()" 
                                            class="bg-slate-50 border border-slate-200 text-slate-700 text-[10px] font-extrabold rounded-md px-2 py-1.5 focus:outline-none focus:border-[#187053] transition-colors">
                                        <option value="free" {{ $user->subscription_plan === 'free' ? 'selected' : '' }}>Free Starter</option>
                                        <option value="standard" {{ $user->subscription_plan === 'standard' ? 'selected' : '' }}>Standard Growth</option>
                                        <option value="unlimited" {{ $user->subscription_plan === 'unlimited' ? 'selected' : '' }}>Unlimited Pro</option>
                                    </select>
                                </form>
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($user->is_admin)
                                <span class="px-2.5 py-1 bg-violet-50 text-violet-700 rounded-full font-extrabold text-[9px] uppercase border border-violet-200/60">Administrator</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-50 text-slate-500 rounded-full font-extrabold text-[9px] uppercase border border-slate-200">Customer</span>
                            @endif
                        </td>
                        <td class="p-4 pr-6 text-right">
                            <div class="flex gap-2 justify-end items-center">
                                @if ($user->id !== Auth::id())
                                    <!-- Edit User Icon -->
                                    <button type="button" onclick="openUserDrawer({{ json_encode($user) }})" 
                                            class="p-2 bg-slate-50 hover:bg-slate-100 text-slate-650 rounded-lg border border-slate-200 transition" title="Edit Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <!-- Delete User Account -->
                                    <form action="/admin/users/{{ $user->id }}" method="POST" class="m-0" 
                                          onsubmit="return confirm('WARNING: Are you sure you want to permanently delete this user, their active listings, and booking history? This action is irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg border border-rose-200/60 transition" title="Delete User">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] text-slate-400 font-extrabold italic pr-2">Current Session</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Centered Modal HTML moved to layout.blade.php to prevent topbar/sidebar clipping -->

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
