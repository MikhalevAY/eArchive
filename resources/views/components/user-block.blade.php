<div class="photo">
	<img src="{{ auth()->user()->photo_url }}" alt="" draggable="false">
</div>
<div class="name">{{ auth()->user()->surname }} {{ auth()->user()->name }}</div>
