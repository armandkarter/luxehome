{{-- resources/views/auth/login.blade.php --}}
@extends('welcome')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-100 px-6">
    <div class="glass p-10 rounded-[2rem] shadow-2xl w-full max-w-md border border-white/20">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900">Espace Admin</h1>
            <p class="text-slate-500 mt-2">Connectez-vous pour gérer vos biens</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif
        

        <form action="{{ route('login.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-2">Email Professionnel</label>
                <input type="email" name="email" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Mot de passe</label>
                <input type="password" name="password" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-500 outline-none transition">
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-200">
                Se connecter
            </button>
        </form>
    </div>
</div>
@endsection