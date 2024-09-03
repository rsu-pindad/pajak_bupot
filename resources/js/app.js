import './bootstrap';
import 'flowbite';
import confetti from "canvas-confetti";
import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css';
import flatpickr from "flatpickr"; 
import 'flatpickr/dist/flatpickr.min.css';
import TomSelect from "tom-select";
window.TomSelect = TomSelect;

Livewire.on('confetti', () => {
    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }
    confetti({
        angle: randomInRange(55, 125),
        spread: randomInRange(50, 70),
        particleCount: randomInRange(50, 100),
        origin: { y: 0.6 }
    });
})