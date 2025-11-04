import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['days', 'hours', 'minutes', 'seconds'];

    connect() {
        this.seconds = parseInt(this.element.dataset.seconds);
        this.cancelId = requestAnimationFrame(this.update.bind(this));
    }

    update() {
        let delta = this.seconds - Math.floor(Date.now() / 1000);
        const days = Math.floor(delta / 86400);
        delta -= days * 86400;
        const hours = Math.floor(delta / 3600) % 24;
        delta -= hours * 3600;
        const minutes = Math.floor(delta / 60) % 60;
        delta -= minutes * 60;
        const seconds = delta % 60;

        this.daysTarget.innerHTML = days;
        this.hoursTarget.innerHTML = hours;
        this.minutesTarget.innerHTML = minutes;
        this.secondsTarget.innerHTML = seconds;
        this.cancelId = requestAnimationFrame(this.update.bind(this));
    }

    disconnect() {
        if (this.cancelId) {
            window.cancelAnimationFrame(this.cancelId);
        }
    }
}
