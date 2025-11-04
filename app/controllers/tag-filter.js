import { Controller } from '@hotwired/stimulus';
import Choices from 'choices.js';

export default class extends Controller {
    static targets = ['input'];
    containerId = null;

    connect() {
        this.containerId = this.element.dataset.containerId;
        const items = JSON.parse(atob(this.element.dataset.items));
        console.log(2, items);
        this.choices = new Choices(this.inputTarget, {
            items: items ?? [],
            removeItemButton: true,
        });

        this.inputTarget.addEventListener('addItem', () => {
            this.handleChange();
        });

        this.inputTarget.addEventListener('removeItem', () => {
            this.handleChange();
        });
    }

    handleChange() {
        const tags = this.getTags();
        const url = new URL(window.location.href);
        const params = new URLSearchParams();
        if (tags.length > 0) {
            tags.forEach(tag => {
                params.append('tags[]', tag);
            });
        }
        url.search = params.toString();
        this.load(url.toString());
    }

    load(url) {
        const containerId = `tag_${this.containerId}`;
        fetch(url)
            .then((r) => r.text())
            .then((html) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const element = doc.getElementById(containerId);
                document.getElementById(containerId).innerHTML = element.innerHTML;

            });
    }

    getTags() {
        return this.choices.getValue(true);
    }

    disconnect() {
        if (this.choices) {
            this.choices.destroy();
        }
    }
}