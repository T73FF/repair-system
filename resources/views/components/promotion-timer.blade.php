@props(['promotion'])

@php
    $remainingSeconds = $promotion->getRemainingSeconds();
    $days = floor($remainingSeconds / 86400);
    $hours = floor(($remainingSeconds % 86400) / 3600);
    $minutes = floor(($remainingSeconds % 3600) / 60);
    $seconds = $remainingSeconds % 60;
@endphp

<div class="bg-gradient-to-r {{ $promotion->background_color ? 'from-' . $promotion->background_color . '/90 to-' . $promotion->background_color : 'from-indigo-500 to-purple-600' }} rounded-2xl p-6 shadow-lg mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('https://images.unsplash.com/photo-1581092160607-8e4b0c3b3e3e?w=1920'); background-size: cover; background-position: center;"></div>
    </div>
    
    <div class="relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-3xl">🎁</span>
                    <h3 class="text-2xl md:text-3xl font-bold" style="color: {{ $promotion->text_color }}">{{ $promotion->title }}</h3>
                </div>
                <p class="text-white/90 mb-2">{{ $promotion->description }}</p>
                <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm font-mono">
                    <span class="text-white">Промокод:</span>
                    <span class="font-bold text-yellow-300">{{ $promotion->code }}</span>
                </div>
            </div>
            
            <div class="text-center">
                <p class="text-white/80 text-sm mb-2">До конца акции:</p>
                <div class="flex gap-3 justify-center">
                    <div class="bg-black/30 backdrop-blur-sm rounded-xl px-3 py-2 text-center min-w-[70px]">
                        <span class="text-3xl font-bold text-white" id="days-{{ $promotion->id }}">{{ str_pad($days, 2, '0', STR_PAD_LEFT) }}</span>
                        <p class="text-white/70 text-xs">дней</p>
                    </div>
                    <div class="bg-black/30 backdrop-blur-sm rounded-xl px-3 py-2 text-center min-w-[70px]">
                        <span class="text-3xl font-bold text-white" id="hours-{{ $promotion->id }}">{{ str_pad($hours, 2, '0', STR_PAD_LEFT) }}</span>
                        <p class="text-white/70 text-xs">часов</p>
                    </div>
                    <div class="bg-black/30 backdrop-blur-sm rounded-xl px-3 py-2 text-center min-w-[70px]">
                        <span class="text-3xl font-bold text-white" id="minutes-{{ $promotion->id }}">{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}</span>
                        <p class="text-white/70 text-xs">минут</p>
                    </div>
                    <div class="bg-black/30 backdrop-blur-sm rounded-xl px-3 py-2 text-center min-w-[70px]">
                        <span class="text-3xl font-bold text-white" id="seconds-{{ $promotion->id }}">{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}</span>
                        <p class="text-white/70 text-xs">секунд</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        let remainingSeconds{{ $promotion->id }} = {{ $remainingSeconds }};
        const promotionId = {{ $promotion->id }};
        
        function updateTimer{{ $promotion->id }}() {
            if (remainingSeconds{{ $promotion->id }} <= 0) {
                document.getElementById('days-' + promotionId).innerText = '00';
                document.getElementById('hours-' + promotionId).innerText = '00';
                document.getElementById('minutes-' + promotionId).innerText = '00';
                document.getElementById('seconds-' + promotionId).innerText = '00';
                return;
            }
            
            const days = Math.floor(remainingSeconds{{ $promotion->id }} / 86400);
            const hours = Math.floor((remainingSeconds{{ $promotion->id }} % 86400) / 3600);
            const minutes = Math.floor((remainingSeconds{{ $promotion->id }} % 3600) / 60);
            const seconds = remainingSeconds{{ $promotion->id }} % 60;
            
            document.getElementById('days-' + promotionId).innerText = String(days).padStart(2, '0');
            document.getElementById('hours-' + promotionId).innerText = String(hours).padStart(2, '0');
            document.getElementById('minutes-' + promotionId).innerText = String(minutes).padStart(2, '0');
            document.getElementById('seconds-' + promotionId).innerText = String(seconds).padStart(2, '0');
            
            remainingSeconds{{ $promotion->id }}--;
        }
        
        setInterval(updateTimer{{ $promotion->id }}, 1000);
        updateTimer{{ $promotion->id }}();
    })();
</script>
@endpush