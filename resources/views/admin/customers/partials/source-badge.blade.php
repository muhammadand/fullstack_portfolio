@php $meta = \App\Models\Customer::SOURCE_META[$source] ?? [ucfirst((string) $source), 'slate']; @endphp
<x-admin.badge :color="$meta[1]"><i class="fa-solid fa-circle text-[6px]"></i> {{ $meta[0] }}</x-admin.badge>
