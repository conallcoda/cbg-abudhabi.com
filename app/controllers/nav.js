import { Controller } from '@hotwired/stimulus';
import { getViewport, debounce, getScrollTop } from './util';

export default class extends Controller {
    static targets = ['navElement', 'hero', 'underlay', 'logo'];

    connect() {
        this.lastScrollTop = 0;
        if (this.element.dataset.template === 'home') {
            window.addEventListener('scroll', debounce(this.init.bind(this)), {
                passive: true,
            });
            this.init();
        }
    }

    handleScroll() {
        const scrollTop = getScrollTop(window);
        this.element.classList.remove('has-scrolled');
        if (scrollTop > 20) {
            if (!this.element.classList.contains('has-scrolled')) {
                this.element.classList.add('has-scrolled');
            }
            const navHeight = this.navElementTarget.offsetHeight;
            const heroHeight = this.heroTarget.offsetHeight;
            const totalDistance = heroHeight - navHeight;
            let opacity =
                scrollTop > totalDistance
                    ? 1
                    : (scrollTop / totalDistance).toFixed(2);

            this.underlayTarget.style.opacity = opacity;
        }
    }

    init() {
        if (getComputedStyle(this.element.parentElement).display === 'none') {
            return;
        }
        const viewport = getViewport(window);
        const scrollTop = getScrollTop(window);

        if (
            scrollTop > 0 &&
            getComputedStyle(this.logoTarget).display === 'none'
        ) {
            this.logoTarget.style.display = '';
        }

        const backgroundThreshold = 0.05;
        const backgroundTrigger =
            scrollTop / (viewport.h * backgroundThreshold);

        if (backgroundTrigger >= 1) {
            this.underlayTarget.style.opacity = 1;
            this.logoTarget.style.opacity = 1;
        } else {
            this.underlayTarget.style.opacity = backgroundTrigger;
            this.logoTarget.style.opacity = backgroundTrigger;
        }
    }

    disconnect() {
        window.removeEventListener('scroll', debounce(this.init.bind(this)));
    }
}
