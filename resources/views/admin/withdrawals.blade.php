@extends('admin.layout')

@section('page_title', 'Referral Payouts & Withdrawals')

@section('content')
<div class="space-y-6">

    <!-- Top Header Banner -->
    <div class="bg-gradient-to-r from-[#0A2540] via-[#0F365E] to-[#0A2540] rounded-3xl p-6 lg:p-8 text-white shadow-xl shadow-slate-900/10 border border-slate-700/50 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[11px] font-extrabold uppercase tracking-wider">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span> Referral Rewards & Payout Ledger
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight font-heading">
                    Referral Payouts & Withdrawal Requests
                </h1>
                <p class="text-xs lg:text-sm text-slate-300 max-w-2xl leading-relaxed">
                    Review and process user reward disbursements for app downloads (₹5) and property listings (₹20). Payout via UPI ID or Bank Transfer with instant reconciliation.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.financials') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs rounded-xl border border-white/15 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    <span>Revenue Analytics</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Telemetry Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pending Payouts</p>
                    <h3 class="text-2xl font-extrabold text-amber-600 mt-1">{{ $pendingCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Awaiting manual approval & settlement</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Processed Payouts</p>
                    <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $approvedCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Successfully settled to user accounts</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Disbursed</p>
                    <h3 class="text-2xl font-extrabold text-[#0A2540] mt-1">₹{{ number_format($totalPaidAmount, 2) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Lifetime referral bonuses paid</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Reward Matrix</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-xs font-extrabold">₹5/App</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-800 text-xs font-extrabold">₹20/Prop</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Min withdrawal threshold: ₹50.00</p>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.withdrawals') }}" class="flex flex-wrap items-center gap-3 w-full">
            <div class="relative flex-1 min-w-[220px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, phone, UPI, account no..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white transition" />
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <select name="status" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700">
                <option value="all">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Only</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved / Paid</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <select name="method" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700">
                <option value="all">All Payout Methods</option>
                <option value="upi" {{ request('method') === 'upi' ? 'selected' : '' }}>UPI Only</option>
                <option value="bank" {{ request('method') === 'bank' ? 'selected' : '' }}>Bank Transfer</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-[#0A2540] hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'status', 'method']))
                <a href="{{ route('admin.withdrawals') }}" class="px-3 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Withdrawals Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-4 px-6">Request ID & Date</th>
                        <th class="py-4 px-6">User / Referrer</th>
                        <th class="py-4 px-6">Amount</th>
                        <th class="py-4 px-6">Payout Destination</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($withdrawals as $w)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="py-4 px-6">
                            <div class="font-extrabold text-slate-900">#WR-{{ str_pad($w->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">{{ $w->created_at->format('M d, Y • h:i A') }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-800">{{ $w->user->name ?? 'User #' . $w->user_id }}</div>
                            <div class="text-[11px] text-slate-400">{{ $w->user->email ?? '' }} • {{ $w->user->phone ?? 'N/A' }}</div>
                            <div class="text-[10px] text-emerald-600 font-bold mt-0.5">Code: {{ $w->user->referral_code ?? 'N/A' }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-black text-slate-900">₹{{ number_format($w->amount, 2) }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($w->payout_method === 'upi')
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-purple-50 border border-purple-100 text-purple-700 font-bold text-[11px]">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    <span>UPI: {{ $w->upi_id }}</span>
                                </div>
                            @else
                                <div class="space-y-0.5">
                                    <div class="font-bold text-slate-800">{{ $w->account_holder_name }}</div>
                                    <div class="text-[11px] text-slate-500 font-mono">A/C: {{ $w->account_number }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">IFSC: {{ $w->ifsc_code }} • {{ $w->bank_name ?: 'Bank' }}</div>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($w->status === 'approved')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Settled
                                </span>
                                @if($w->transaction_reference)
                                    <div class="text-[10px] text-slate-400 font-mono mt-1">Ref: {{ $w->transaction_reference }}</div>
                                @endif
                            @elseif($w->status === 'rejected')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-[11px] font-extrabold">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Rejected
                                </span>
                                @if($w->admin_notes)
                                    <div class="text-[10px] text-red-500 mt-1 max-w-xs truncate">{{ $w->admin_notes }}</div>
                                @endif
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-[11px] font-extrabold">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending Approval
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($w->status === 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Approve Button -->
                                    <button type="button" onclick="openApproveModal({{ $w->id }}, '{{ $w->amount }}', '{{ $w->user->name ?? 'User' }}', '{{ $w->payout_method }}', '{{ $w->payout_method === 'upi' ? $w->upi_id : $w->account_number }}')" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold rounded-xl text-xs transition shadow-sm">
                                        Approve / Pay
                                    </button>
                                    <!-- Reject Button -->
                                    <button type="button" onclick="openRejectModal({{ $w->id }}, '{{ $w->amount }}', '{{ $w->user->name ?? 'User' }}')" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 font-bold rounded-xl text-xs transition">
                                        Reject
                                    </button>
                                </div>
                            @else
                                <span class="text-[11px] text-slate-400 font-medium">Processed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <p class="font-bold text-slate-600">No withdrawal requests found</p>
                            <p class="text-xs text-slate-400 mt-1">Users can request withdrawals once their referral earnings reach ₹50.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($withdrawals->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $withdrawals->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal: Approve Payout -->
<div id="approveModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 transform transition-all">
        <form id="approveForm" method="POST" action="">
            @csrf
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Approve Referral Payout</h3>
                    <p class="text-xs text-slate-500">Record settlement for <span id="approveUserName" class="font-bold"></span></p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 mb-4 space-y-2">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500">Disbursement Amount:</span>
                    <span id="approveAmount" class="font-black text-emerald-600 text-sm">₹0.00</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500">Destination:</span>
                    <span id="approveDestination" class="font-bold text-slate-800"></span>
                </div>
            </div>

            <div class="space-y-3 mb-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Transaction Ref / UTR Number</label>
                    <input type="text" name="transaction_reference" placeholder="e.g. UTR1984729183" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono focus:ring-2 focus:ring-emerald-500 focus:bg-white" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Admin Notes (Optional)</label>
                    <input type="text" name="admin_notes" placeholder="e.g. Paid via GPay business" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="closeApproveModal()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold rounded-xl text-xs transition shadow-lg shadow-emerald-500/20">
                    Confirm Payout & Mark Settled
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Reject Payout -->
<div id="rejectModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 transform transition-all">
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Reject & Refund Withdrawal</h3>
                    <p class="text-xs text-slate-500">Amount will be credited back to user's wallet</p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-red-50 border border-red-100 mb-4">
                <p class="text-xs text-red-700 leading-relaxed font-medium">
                    Rejecting will immediately refund <span id="rejectAmount" class="font-bold"></span> back into the user's referral balance and notify them.
                </p>
            </div>

            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-700 mb-1">Rejection Reason *</label>
                <textarea name="admin_notes" rows="3" required placeholder="e.g. Invalid UPI ID / Incorrect Bank Account Number..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-red-500 focus:bg-white"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-xs transition shadow-lg shadow-red-500/20">
                    Reject & Refund Wallet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openApproveModal(id, amount, userName, method, dest) {
        document.getElementById('approveForm').action = '/admin/withdrawals/' + id + '/approve';
        document.getElementById('approveUserName').innerText = userName;
        document.getElementById('approveAmount').innerText = '₹' + parseFloat(amount).toFixed(2);
        document.getElementById('approveDestination').innerText = method.toUpperCase() + ': ' + dest;
        document.getElementById('approveModal').classList.remove('hidden');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }

    function openRejectModal(id, amount, userName) {
        document.getElementById('rejectForm').action = '/admin/withdrawals/' + id + '/reject';
        document.getElementById('rejectAmount').innerText = '₹' + parseFloat(amount).toFixed(2);
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endsection
