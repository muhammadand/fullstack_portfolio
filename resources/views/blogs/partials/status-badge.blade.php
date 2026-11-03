@if ($blog->is_published)
<x-admin.badge color="green"><i class="fa-solid fa-circle text-[6px]"></i> Published</x-admin.badge>
@elseif ($blog->affiliate_id)
<x-admin.badge color="orange"><i class="fa-solid fa-clock text-[10px]"></i> Menunggu Review</x-admin.badge>
@else
<x-admin.badge color="slate"><i class="fa-solid fa-circle text-[6px]"></i> Draft</x-admin.badge>
@endif
