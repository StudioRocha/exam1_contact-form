@props([ 'paginator', 'align' => 'right', ]) @if($paginator->hasPages())
<div class="app-pagination app-pagination--{{ $align }}">
    {{ $paginator->links() }}
</div>
@endif
