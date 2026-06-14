/**
 * Replace native <select> with Bootstrap dropdown on RTL pages.
 * Native selects clip Arabic option text on Windows Chrome/Edge.
 */
(function () {
    function enhanceSelect(select) {
        if (select.dataset.enhanced === '1' || select.multiple) {
            return;
        }

        var options = Array.prototype.slice.call(select.options);
        if (!options.length) {
            return;
        }

        select.dataset.enhanced = '1';

        var wrapper = document.createElement('div');
        wrapper.className = 'form-select-dropdown';

        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'form-select-dropdown-toggle';
        button.setAttribute('aria-haspopup', 'listbox');
        button.setAttribute('aria-expanded', 'false');

        var label = document.createElement('span');
        label.className = 'form-select-dropdown-label';
        button.appendChild(label);

        var menu = document.createElement('ul');
        menu.className = 'form-select-dropdown-menu';
        menu.setAttribute('role', 'listbox');

        options.forEach(function (option) {
            var item = document.createElement('li');
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'form-select-dropdown-item';
            btn.setAttribute('role', 'option');
            btn.dataset.value = option.value;
            btn.textContent = option.text;
            if (option.disabled) {
                btn.disabled = true;
            }
            item.appendChild(btn);
            menu.appendChild(item);
        });

        var parent = select.parentNode;

        select.classList.add('form-select-native-hidden');
        parent.insertBefore(wrapper, select);
        wrapper.appendChild(button);
        wrapper.appendChild(menu);
        wrapper.appendChild(select);

        function setOpen(open) {
            wrapper.classList.toggle('is-open', open);
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        function updateLabel() {
            var selected = select.options[select.selectedIndex];
            label.textContent = selected ? selected.text : '';
            menu.querySelectorAll('.form-select-dropdown-item').forEach(function (item) {
                var isSelected = item.dataset.value === select.value;
                item.classList.toggle('is-active', isSelected);
                item.setAttribute('aria-selected', isSelected ? 'true' : 'false');
            });
        }

        button.addEventListener('click', function () {
            setOpen(!wrapper.classList.contains('is-open'));
        });

        menu.addEventListener('click', function (event) {
            var item = event.target.closest('.form-select-dropdown-item');
            if (!item || item.disabled) {
                return;
            }
            select.value = item.dataset.value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
            updateLabel();
            setOpen(false);
        });

        document.addEventListener('click', function (event) {
            if (!wrapper.contains(event.target)) {
                setOpen(false);
            }
        });

        select.addEventListener('change', updateLabel);
        updateLabel();

        if (select.classList.contains('is-invalid')) {
            wrapper.classList.add('is-invalid');
        }
        if (select.classList.contains('form-select-sm')) {
            button.classList.add('form-select-sm');
        }
    }

    function init() {
        if (document.documentElement.getAttribute('dir') !== 'rtl') {
            return;
        }
        document.querySelectorAll('select.form-select').forEach(enhanceSelect);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
