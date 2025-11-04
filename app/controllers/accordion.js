import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    items = [];

    connect() {
        const items = this.element.getElementsByClassName('accordion-item');

        for (let i = 0; i < items.length; i++) {
            this.items.push(items[i]);
        }
        console.log(items);
    }

    closeAll(e) {
        this.items.forEach((item) => {
            item.classList.remove('active');
        });
    }

    toggle(e) {
        console.log(e);
        const el = e.currentTarget,
            i = el.dataset.key,
            item = this.items[i];

        if (!item) {
            return;
        }

        let content = item.getElementsByClassName('accordion-content');
        content = content.length ? content[0] : null;
        if (!content) {
            return;
        }
        const isOpen = item.classList.contains('active');
        if (isOpen) {
            item.classList.remove('active');
        } else {
            item.classList.remove('active');
            item.classList.add('active');
        }
    }
}
