@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <p class="text-[11px] uppercase tracking-[0.3em] text-gold mb-3">Admin</p>
    <h1 class="font-display text-3xl text-espresso-deep mb-8">Users</h1>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-espresso-mid/20">
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Nama</th>
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Email</th>
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Role</th>
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Toko</th>
                <th class="text-right py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Bergabung</th>
            </tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b border-cream-mid hover:bg-cream-warm transition-colors">
                    <td class="py-3 font-medium text-espresso-deep">{{ $user->name }}</td>
                    <td class="py-3 text-secondary-text">{{ $user->email }}</td>
                    <td class="py-3"><span class="px-2 py-0.5 text-[9px] uppercase tracking-wider {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700' : ($user->role === 'penjual' ? 'bg-blue-50 text-blue-700' : 'bg-gray-50 text-gray-700') }}">{{ $user->role }}</span></td>
                    <td class="py-3 text-secondary-text">{{ $user->store->store_name ?? '—' }}</td>
                    <td class="py-3 text-right text-secondary-text text-[10px]">{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-8">{{ $users->links() }}</div>
</div>
@endsection
