
	<style>
		.fi-simple-header-heading {
			display: none;
		}
		.fi-logo{
	height: 2rem;
    padding: 0px;
    margin: 0px;
		}
	</style>
	
	<span style="padding-left:0px;
	padding-top:8px;
	display:inline-flex;" 
	class="text-bold pl-2 pt-1">

	<img
		src="{{ asset('logo.webp') }}"
		alt="Fireflow logo"
		class="h-full w-auto brand-logo"
		style="height:1.2rem; width:auto;"
	>
	<span style="padding-left: 10px;
	padding-top: 2px;
	font-size: 1rem;
	font-family: 'Astra', 
	sans-serif;font-style: 
	oblique;" 
	class="text-bold pl-2 pt-1">
		Nordic Digital Thailand
	</span>


<style>
/* Subtle breathing glow + float animation */
@keyframes brandPulse {
	0% { transform: translateY(0) scale(1); filter: drop-shadow(0 0 0 rgba(255, 85, 0, 0)); }
	50% { transform: translateY(-1px) scale(1.02); filter: drop-shadow(0 0 6px rgba(255, 85, 0, 0.35)); }
	100% { transform: translateY(0) scale(1); filter: drop-shadow(0 0 0 rgba(255, 85, 0, 0)); }
}

.brand-logo {
	animation: brandPulse 2.8s ease-in-out infinite;
	will-change: transform, filter;
}

@media (prefers-reduced-motion: reduce) {
	.brand-logo { animation: none; }
}

div.rounded-lg.bg-gray-50 {
	background: #18181b;
}	
div.fls-display-on {
margin:13px;
}
.language-switch-trigger{
	background: #18181b;
}

</style>
