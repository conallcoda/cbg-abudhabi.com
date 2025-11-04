import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['container', 'more'];

    connect() {
        const config = JSON.parse(
            atob(this.element.dataset.infiniteScrollConfig)
        );

        this.loading = false;
        this.id = config.id;
        this.page = config.page;
        this.total = config.total;

        const intersectionObserver = new IntersectionObserver((entries) => {
            if (entries[0].intersectionRatio <= 0) return;
            this.load();
        });
        intersectionObserver.observe(this.moreTarget);
    }
    load() {
        if (this.loading) return;
        this.loading = true;

        const url = `?infinite-scroll=1&${this.id}_page=${this.page + 1}`;
        const containerId = `scroll_${this.id}`;
        fetch(url)
            .then((r) => r.text())
            .then((html) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const element = doc.getElementById(containerId);
                this.containerTarget.insertAdjacentHTML(
                    'beforeend',
                    element.innerHTML
                );
                this.page = this.page + 1;
                if (this.page >= this.total) {
                    this.moreTarget.classList.add('hidden');
                    this.interactionObserver.unobserve(this.moreTarget);
                }
                this.loading = false;
            });
    }
    disconnect() {
        if (this.interactionObserver) {
            this.interactionObserver.unobserve(this.moreTarget);
        }
    }
}
