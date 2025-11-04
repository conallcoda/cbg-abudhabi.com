import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['toggles'];
    toggles = [];
    items = [];

    connect() {
        const toggles = this.element.children[0].children;
        for (let i = 0; i < toggles.length; i++) {
            if (toggles[i].classList.contains('tab-toggle')) {
                this.toggles.push(toggles[i]);
            }
        }
        const items = this.element.children;

        for (let i = 0; i < items.length; i++) {
            if (items[i].classList.contains('tab-item')) {
                this.items.push(items[i]);
            }
        }

    }

    reset(e) {
        this.toggles.forEach((toggle) => {
            toggle.classList.remove('active');
        });
        this.items.forEach((item) => {
            item.classList.remove('active');
        });
    }

    toggle(e) {
        const el = e.currentTarget;
        const itemId = el.dataset.tabToggleId;

        let activeItem = null;
        this.items.forEach((item) => {
            if (item.dataset.tabItemId === itemId) {
                activeItem = item;
            }
        });

        if (activeItem) {
            this.reset();
            activeItem.classList.add('active');
            el.classList.add('active');
        }
    }
}
