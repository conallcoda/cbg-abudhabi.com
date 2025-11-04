import { Controller } from '@hotwired/stimulus';
import { getViewport, debounce, getScrollTop } from './util';

export default class extends Controller {
    static targets = [
        'navOpen',
        'navClose',
        'nav',
        'menu',
        'modal',
        'modalContent',
    ];

    connect() {
        this.body = document.getElementsByTagName('body')[0];
        this.top = 0;
        this.element['burgerController'] = this;
    }

    reset() {
        this.navOpenTarget.classList.remove('active');
        this.navCloseTarget.classList.remove('active');
    }

    open(e, modal) {
        if (modal) {
            this.modalTarget.classList.remove('active');
            this.modalTarget.classList.add('active');
            this.menuTarget.classList.remove('active');
            this.navTarget.classList.remove('menu');
            this.navTarget.classList.remove('modal');
            this.navTarget.classList.add('modal');
        } else {
            this.modalTarget.classList.remove('active');
            this.navTarget.classList.remove('modal');
            this.navTarget.classList.remove('menu');
            this.navTarget.classList.add('menu');
            this.menuTarget.classList.remove('active');
            this.menuTarget.classList.add('active');
        }
        this.reset();
        this.top = getScrollTop(window);
        this.navTarget.classList.remove('active');
        this.navTarget.classList.add('active');
        this.navCloseTarget.classList.add('active');
        this.body.classList.remove('menuOpen');
        this.body.classList.add('menuOpen');
    }

    openUrl(url) {
        fetch(url)
            .then((r) => r.text())
            .then((html) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const element = doc.getElementById('modalContent');

                this.modalContentTarget.innerHTML = element.innerHTML;
                this.open(null, true);
            });
    }

    openModal(e) {
        const el = e.currentTarget;
        const url = el.getAttribute('href');
        if (!el) {
            return;
        }

        e.preventDefault();
        this.openUrl(url);
    }

    close() {
        this.reset();
        this.navTarget.classList.remove('fadeInLeft');
        this.navTarget.classList.add('fadeOutLeft');
        this.body.classList.remove('menuOpen');
        window.scroll(0, this.top);
        setTimeout(() => {
            this.navTarget.classList.remove('active');
            this.navTarget.classList.remove('fadeOutLeft');
            this.navTarget.classList.add('fadeInLeft');
            this.navTarget.classList.remove('active');
            this.navOpenTarget.classList.add('active');
        }, 250);
    }

    top() {
        let el = window;
        el.scrollTop = 0;
    }
}
