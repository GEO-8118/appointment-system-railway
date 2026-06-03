@props(['href', 'active' => false])
<a href="{{ $href }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition {{ $active ? 'border-blue-600 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }}">
    {{ $slot }}
</a>